<?php namespace App\Traits;

use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Image\Point;
use Imagine\Gd\Imagine;

use App;

trait ThumbTrait {

    /**
     * Thumbnails dimensions
     */
    protected $dimensions = array(
		            'normal' => array(
		                'width' => 200,
		                'height' => 200
		            ), 
		            'thumb' => array(
		                'width' => 100,
		                'height' => 100
		            ),
		            'portrait' => array(
		                'width' => 330,
		                'height' => 420
		            ),
                    'tiny' => array(
                        'width' => 100,
                        'height' => 133
                    )
		        );


	/**
     * Check for watermarkable!
     */
    public function isMarkable()
    {
    	(property_exists(__CLASS__, 'markable') && $this->markable) ? true : false;
    }

    /**
     * Thumbnails types
     */
    public function getMeasures()
    {
    	// Check for overriding
    	if (property_exists(__CLASS__, 'measures'))
    	{
    		return $this->measures;
    	}
    	// Default measures
    	return array('normal', 'thumb');
    }

    public function makeThumb()
    {
    	// Check is trait used correct!
    	if (!property_exists(__CLASS__, 'file')) throw new \Exception(__CLASS__ . " not supporting files", 1); 

    	$imagine = new Imagine();

		if ($this->isMarkable())
		{
			// Get watermark image
			$watermark = $imagine->open(public_path().App::make('host')->watermark);
			$image     = $imagine->open($this->getAbsolutePath());
			$size      = $image->getSize();
			$wSize     = $watermark->getSize();
			
			// $bottomRight = new Point(0,0);
			// $image->paste($watermark, $bottomRight);
			
			$bottomRight = new Point($size->getWidth() - $wSize->getWidth(), $size->getHeight() - $wSize->getHeight());
			$image->paste($watermark, $bottomRight);

			// Create the new file.
            $filepath = "{$this->getUploadRootDir()}/{$this->id}.watermark.{$this->path}";
            $image->save($filepath);

		}
		else
		{
			// If watermarkable is false create thumbs from original image.
			$filepath = $this->getAbsolutePath();
		}


        $measures = $this->getMeasures();
        // Create thumbs for all measures
        foreach ($measures as $measure) {

            $size = new Box($this->dimensions[$measure]['width'], $this->dimensions[$measure]['height']);
            $thumbnail = $imagine->open($filepath)->thumbnail($size, ImageInterface::THUMBNAIL_OUTBOUND);

            $destination = "{$this->id}.{$measure}.{$this->path}";
            $thumbnail->save("{$this->getUploadRootDir()}/{$destination}");

        }
    }

    public function getThumbnail($format = 'normal')
    {
    	$file = "{$this->getUploadRootDir()}/{$this->id}.{$format}.{$this->path}";

    	if (file_exists($file)) {
    		return "{$this->getUploadDir()}/{$this->id}.{$format}.{$this->path}";
    	}

    	return "File with {$format} format is missing!";
    }

}