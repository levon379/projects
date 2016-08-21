<?php namespace App\Traits;

use Symfony\Component\HttpFoundation\File\UploadedFile;

trait FileTrait {

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
        unlink($this->getAbsolutePath());
    }



    /**
     * @return Boolean
     */
    public function hasFile()
    {
        return null === $this->path ? false : true;
    }

    /**
     * File manipulating
     */

    protected function getUploadDir()
    {
    	$path = null;

    	switch (get_class($this)) {
            case 'App\Models\Video': 
                $path = 'uploads/videos';
                break;  
            case 'App\Models\Poster': 
                $path = 'uploads/posters';
                break;
            case 'App\Models\Place': 
                $path = 'uploads/places';
                break;   
            case 'App\Models\Recipe': 
            	$path = 'uploads/recipes';
            	break;                
            default: return 'uploads';
        }

        $path = $path ."/". $this->createdAt->format('Y/m/d');

		if (!is_dir($path)) mkdir($path, 0777, true);

        return $path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        return __DIR__.'/../../public/'.$this->getUploadDir();
    }

    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->id.'.'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->id.'.'.$this->path;
    }

    /**
     * Events method
     */

    public function preUpload()
    {
        if (null !== $this->getFile()) {
            $this->path = $this->getFile()->guessExtension();
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
            $this->id.'.'.$this->getFile()->guessExtension()
        );

        // If class use also ThumbTrait -> create thumbs
        if ($this->isThumbnailable()) {

            $this->makeThumb();
        }


        $this->setFile(null);
    }

    public function isSoftDeletable()
    {
        return in_array("Illuminate\Database\Eloquent\SoftDeletes", class_uses(get_class($this)));
    }

    public function isThumbnailable()
    {
        return in_array("App\Traits\ThumbTrait", class_uses(get_class($this)));
    }

    public function storeFilenameForRemove()
    {
        // If Class Uses SoftDeletes -> do not remove files!
        if (!$this->isSoftDeletable()) {
            $this->temp = $this->getAbsolutePath();
        }
    }

    public function removeUpload()
    {
        if (isset($this->temp)) {
            unlink($this->temp);
        }
    }
}