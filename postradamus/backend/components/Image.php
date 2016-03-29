<?php

namespace backend\components;

use yii\base\Object;

class Image extends Object {

    public $prop1;
    public $prop2;

    public function __construct(/*$param1, $param2, */$config = [])
    {
        // ... initialization before configuration is applied

        parent::__construct($config);
    }

    public function init()
    {
        parent::init();

        // ... initialization after configuration is applied
    }

    public function move_uploaded_file($file, $destination)
    {
        if($file['error'] == 0)
        {
            $allowedExts = array("gif", "jpeg", "jpg", "png");
            $temp = explode(".", $file["name"]);
            $extension = end($temp);
            if ((($file["type"] == "image/gif")
                    || ($file["type"] == "image/jpeg")
                    || ($file["type"] == "image/jpg")
                    || ($file["type"] == "image/pjpeg")
                    || ($file["type"] == "image/x-png")
                || ($file["type"] == "image/png")
                || ($file["type"] == "video/mp4"))
                /*&& in_array(strtolower($extension), $allowedExts)*/)
            {

                //now is the time to modify the future file name and validate the file
                $new_file_name = substr(md5(uniqid(mt_rand(), true)), 0, 5) . '-' . $this->sanitize($file['name'], true); //rename file
                if($file['size'] > (1024000*6)) //can't be larger than 2 MB
                {
                    $valid_file = false;
                    $error = 'Oops! Your image\'s size is too large.';
                } else {
                    //move it to where we want it to be
                    @mkdir($destination, 0777, true);
                    move_uploaded_file((isset($file['tmp_name']) ? $file['tmp_name'] : $file['tempName']), $destination . $new_file_name);
                    return $new_file_name;
                }
            }
            else
            {
                $error = "Invalid file type.";
            }
        }
        //if there is an error...
        else
        {
            $errors = array(
                0=>"There is no error, the file uploaded with success",
                1=>"The uploaded file exceeds the upload_max_filesize directive in php.ini",
                2=>"The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
                3=>"The uploaded file was only partially uploaded",
                4=>"No file was uploaded",
                6=>"Missing a temporary folder"
            );
            //set that to be the returned message
            $error = 'Oops! Your upload triggered the following error:  '.$errors[$file['error']];
        }
        print_r($error);
        die();
        return false;
    }

    public function createThumbnail($destination, $filename, $width = 200, $height = 200)
    {
        //create thumb
        $image = new \Imagick($destination . $filename);
        $image->resizeImage ( 200, 200, \Imagick::FILTER_LANCZOS, 1, TRUE);
        $image->writeImages($destination . 'thumb-' . $filename, true);
    }

    /**
     * Convert a string to the file/URL safe "slug" form
     *
     * @param string $string the string to clean
     * @param bool $is_filename TRUE will allow additional filename characters
     * @return string
     */
    public function sanitize($string = '', $is_filename = FALSE)
    {
        // Replace all weird characters with dashes
        $string = preg_replace('/[^\w\-'. ($is_filename ? '~_\.' : ''). ']+/u', '-', $string);

        // Only allow one dash separator at a time (and make string lowercase)
        return mb_strtolower(preg_replace('/--+/u', '-', $string), 'UTF-8');
    }

    /* downloads image URL stream to local temp file */
    public function download_image($url, $destination)
    {
        if($url && $destination)
        {
            //TODO check for bad image extensions
            if(substr($url, 0, 2) == '//')
            {
                $url = 'http:' . $url;
            }

            $arrContextOptions=array(
                "ssl"=>array(
                    "allow_self_signed"=>true,
                    "verify_peer"=>false,
                ),
            );

            //$image_contents = $this->get_fcontent($url);
            //if (!$image_contents) { return false; }
            //had to revert back to this function because "Duplicate List" would not copy images correctly
            $image_contents = file_get_contents($url, false, stream_context_create($arrContextOptions));

            $extension = pathinfo($url, PATHINFO_EXTENSION);
            $extension = explode('?', $extension); $extension = $extension[0];
            if($extension == '' || ($extension != '.jpg' || $extension != '.jpeg' || $extension != '.gif' || $extension != '.png'))
            {
                $size=@getimagesize($url);
                switch($size["mime"]){
                    case "image/jpeg":
                        $extension = 'jpg';
                        break;
                    case "image/gif":
                        $extension = 'gif';
                        break;
                    case "image/png":
                        $extension = 'png';
                        break;
                    default:
                        $extension = 'jpg';
                        break;
                }
            }
            $filename = $destination . md5(rand(1,9999999)) . '.' . $extension;
            @mkdir($destination, 0777, true);
            if(file_put_contents($filename, $image_contents))
                return $filename;
            else
                return false;
        }
        return false;
    }

    function get_fcontent($url) {
        $url = str_replace( "&amp;", "&", urldecode(trim($url)) );
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );    # required for https urls
        try {
            curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
            $content = curl_exec( $ch );
            curl_close ( $ch );
            return $content;
        } catch (\Exception $ex) {
            return false;
        }
    }
    
    public function open_image ($file)
    {
        $size=getimagesize($file);
        switch($size["mime"]){
            case "image/jpeg":
                $im = imagecreatefromjpeg($file); //jpeg file
                break;
            case "image/gif":
                $im = imagecreatefromgif($file); //gif file
                break;
            case "image/png":
                $im = imagecreatefrompng($file); //png file
                break;
            default:
                $im=false;
                break;
        }
        return array($im, $size);
    }

    public function save_image ($im, $file, $size)
    {
        switch($size["mime"]){
            case "image/jpeg":
                imagejpeg($im, $file, 100); //jpeg file
                break;
            case "image/gif":
                imagegif($im, $file); //gif file
                break;
            case "image/png":
                imagepng($im, $file, 9); //png file
                break;
            default:
                break;
        }
    }

    public function get_remote_image_dimensions($url){
        $headers = array(
            "Range: bytes=0-32768"
        );

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        curl_close($curl);
        $im = imagecreatefromstring($data);
        $width = imagesx($im);
        $height = imagesy($im);
        return ['width' => $width, 'height' => $height];
    }

    public function generate_watermarked_image($originalFilename, $watermarkFilename, $destX = 'center', $destY = 'top') {
        $watermarkFileLocation = $watermarkFilename;
        $watermarkImage = $this->open_image($watermarkFileLocation);
        $watermarkWidth = @imagesx($watermarkImage[0]);
        $watermarkHeight = @imagesy($watermarkImage[0]);

        $originalImage = $this->open_image($originalFilename);
        $originalWidth = @imagesx($originalImage[0]);
        $originalHeight = @imagesy($originalImage[0]);

        if($destX == 'center')
        {
            //center = original_image width / 2 - watermarkWidth / 2
            $destX = ($originalWidth / 2) - ($watermarkWidth / 2);
        }

        if($destY == 'top')
        {
            $destY = 0;
        }
        elseif($destY == 'bottom')
        {
            $destY = $originalHeight - $watermarkHeight;
        }

        // creating a cut resource
        $cut = @imagecreatetruecolor($watermarkWidth, $watermarkHeight);

        // copying that section of the background to the cut
        @imagecopy($cut, $originalImage[0], 0, 0, $destX, $destY, $watermarkWidth, $watermarkHeight);

        // placing the watermark now
        @imagecopy($cut, $watermarkImage[0], 0, 0, 0, 0, $watermarkWidth, $watermarkHeight);

        // merging both of the images
        @imagecopymerge($originalImage[0], $cut, $destX, $destY, 0, 0, $watermarkWidth, $watermarkHeight, 100);

        $this->save_image($originalImage[0], $originalFilename, $originalImage[1]);
    }

}