<?php namespace App\Traits;

use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Image\Point;
use Imagine\Gd\Imagine;

use App;

trait Thumbnailable {

    /**
     * Thumbnails dimensions
     */
    protected $dimensions = array(
              'normal'    => array('width' => 195,'height' => 215),
              'thumb'     => array('width' => 100,'height' => 100),
              'portrait'  => array('width' => 140,'height' => 155),
              'slideshow'  => array('width' => 740,'height' => 450)
          );

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
      	return array('normal');
    }

    public function setDimensions($dimensions)
    {
        if (is_array($dimensions))
        {
          $this->dimensions = $dimensions;
        }
    }

    public function makeThumb()
    {

      	// Check is trait used correct!
      	if (!property_exists(__CLASS__, 'file')) throw new \Exception(__CLASS__ . " not supporting files", 1);

      	$imagine = new Imagine();
		
		    $filepath = $this->getAbsolutePath();
    		
        $measures = $this->getMeasures();
        // Create thumbs for all measures
        foreach ($measures as $measure) {

            $size = new Box($this->dimensions[$measure]['width'], $this->dimensions[$measure]['height']);
            // $thumbnail = $imagine->open($filepath)->thumbnail($size, ImageInterface::THUMBNAIL_OUTBOUND);
            $thumbnail = $imagine->open($filepath)->thumbnail($size, ImageInterface::THUMBNAIL_INSET);

            $destination = "{$measure}.{$this->path}";
            $thumbnail->save("{$this->getUploadRootDir()}/{$destination}");

        }
    }

    public function getThumbnail($format = 'normal')
    {

      	$file = "{$this->getUploadRootDir()}/{$format}.{$this->path}";

      	if (file_exists($file)) {
      		return "{$this->getUploadDir()}/{$format}.{$this->path}";
      	}

      	return NULL;
    }
}
