<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\File\UploadedFile;

trait Fileable {

  	/**
  	 * Store UploadedFile object
  	 */
    protected $file;

  	/**
  	 * Store temporary file
  	 */
  	protected $temp;

    /**
    * Model events
    */

    public static function boot()
    {
        parent::boot();

        static::creating(function($file)
        {
            $file->preUpload();
        });

        static::created(function($file)
        {
            $file->upload();
        });

        static::updating(function($file)
        {
            $file->preUpload();
        });

        static::updated(function($file)
        {
           $file->upload();
        });
        static::deleting(function($file)
        {
        	$file->storeFilenameForRemove();
        });
        static::deleted(function($file)
        {
        	$file->removeUpload();
        });
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */

    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (is_file($this->getAbsolutePath())) {
            // store the old name to delete after the update
            $this->temp = $this->getAbsolutePath();
        } else {
            $this->path = 'initial';
        }
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Remove file. For edit
     */
    public function removeFile()
    {
        // Remove file physically
        if (file_exists($this->getAbsolutePath()))
        {
            unlink($this->getAbsolutePath());
        }
        // Remove also thumbnails
        if ($this->isThumbnailable()) {
            foreach ($this->getMeasures() as $measure) {
                if ($this->getThumbnail($measure)) {
                    // Get thumbnail file
                    $file = $this->getUploadDir() .'/'. $measure .'.'. $this->path;
                    if (file_exists($file)) unlink($file);
                }
            }
        }
        // Update model column
        $this->path = null;
        return $this->save();
    }

    /**
     * File manipulating
     */
    protected function getUploadDir()
    {
        // If Trait is used in morphMany Relations
        if (!is_null($this->fileable_type) && class_exists($this->fileable_type)) {
         
            // If model override default upload dir
            if (property_exists($this->fileable_type, 'upload_dir')) {
                // Get upload dir from model
                $path = (new $this->fileable_type)->upload_dir;
            // Model not overriding upload dir -> use classname for folder
            } else {
                $class = explode("\\", $this->fileable_type);
                // $class = end($class);
                $path = 'uploads/'. strtolower(end($class));
            }

        // If Trait is used directly in Model
        } elseif (property_exists(__CLASS__, 'upload_dir')) {
            $path = $this->upload_dir;
        // Application default upload dir
        } else {
            // $class = explode("\\", get_class($this));
            // $path = 'uploads/'. strtolower(end($class));
            $path = 'uploads';
        }

		if (!is_dir($path)) mkdir($path, 0777, true);

        // dd($path);

        return $path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        return __DIR__.'/../../public/'.$this->getUploadDir();
        // return public_path();
    }

    public function getAbsolutePath()
    {
        // return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->id.'.'.$this->path;
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        // return null === $this->path ? "/no_image.jpg" : '/'. $this->getUploadDir().'/'.$this->id.'.'.$this->path;
        return null === $this->path ? "/no_image.jpg" : '/'. $this->getUploadDir().'/'.$this->path;
    }

    /**
     * Events method
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            // $this->path = $this->getFile()->guessExtension();
            $this->path = uniqid() .'.'. $this->getFile()->guessExtension();
            
        }
    }

    public function upload()
    {

        if (null === $this->getFile()) {
            return;
        }

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->temp);
            // clear the temp image path
            $this->temp = null;
        }

        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->path            
        );

        // If class use also ThumbTrait -> create thumbs
        if ($this->isThumbnailable() && $this->isImage()) {

            $this->makeThumb();
        }

        $this->setFile(null);
    }

    public function storeFilenameForRemove()
    {
        // If Class Uses SoftDeletes -> do not remove files!
        if (!$this->isSoftDeletable()) {

            $this->temp = file_exists($this->getAbsolutePath()) ? $this->getAbsolutePath() : null;
        }
    }

    public function removeUpload()
    {
        if (isset($this->temp)) unlink($this->temp);
    }

    /**
     * Helper methods
     */
    public function getHumanFileSize($decimals = 2)
    {
        if (file_exists($this->getAbsolutePath()))
        {
            $bytes = filesize($this->getAbsolutePath());
            $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
            $factor = floor((strlen($bytes) - 1) / 3);
            return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
        }
        return "File {$this->getAbsolutePath()} is missing!";
    }

    public function hasFile()
    {
        return null === $this->path ? false : true;
    }


    public function isImage()
    {
        if (file_exists($this->getAbsolutePath())) {
            return in_array(
                    exif_imagetype($this->getAbsolutePath()), 
                    array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)
                );
        }
        return NULL;
    }

    public function getFileExtension()
    {
        if ($this->hasFile() && file_exists($this->getAbsolutePath())) {
            return pathinfo($this->getAbsolutePath(), PATHINFO_EXTENSION);
        }
        return NULL;
    }

    protected function isSoftDeletable()
    {
        return in_array(Illuminate\Database\Eloquent\SoftDeletes::class, class_uses(get_class($this)));
    }

    protected function isThumbnailable()
    {
        return in_array(Thumbnailable::class, class_uses(get_class($this)));
    }

    protected function isSluggable()
    {
        return in_array(Sluggable::class, class_uses(get_class($this)));
    }
}
