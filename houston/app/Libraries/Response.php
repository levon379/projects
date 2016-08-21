<?php namespace App\Libraries;

use Illuminate\Support\Facades\Response as BaseResponse;
use Illuminate\Support\Facades\File as File;
use Intervention\Image\Facades\Image;

class Response extends BaseResponse
{

    /**
     * Create a response that will force a image to be displayed inline.
     *
     * @param string $path Path to the image
     * @param string $mime
     * @param string $type
     * @param string $name Filename
     * @param int $lifetime Lifetime in browsers cache
     * @return Response
     */
    public static function inline($path, $mime = 'image/jpeg',$type = 'default', $name = null, $lifeTime = 0)
    {
        $directory = dirname($path);
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $rawName = basename($path, ".".$ext);

        if (is_null($name)) {
            $name = $rawName."_".$type;
        }

        $fileTime = filemtime($path);
        $etag = md5($fileTime . $path);
        $time = gmdate('r', $fileTime);
        $expires = gmdate('r', $fileTime + $lifeTime);
        $length = filesize($path);

        $headers = array(
            'Content-Disposition' => 'inline; filename="' . $name . '"',
            'Last-Modified' => $time,
            'Cache-Control' => 'must-revalidate',
            'Expires' => $expires,
            'Pragma' => 'public',
            'Etag' => $etag,
            'Content-Type' => $mime
        );

        $headerTest1 = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && $_SERVER['HTTP_IF_MODIFIED_SINCE'] == $time;
        $headerTest2 = isset($_SERVER['HTTP_IF_NONE_MATCH']) && str_replace('"', '', stripslashes($_SERVER['HTTP_IF_NONE_MATCH'])) == $etag;
        if ($headerTest1 || $headerTest2) { //image is cached by the browser, we dont need to send it again
            return static::make('', 304, $headers);
        }

        $newPath = $directory."/".$rawName.".".$type.".".$ext;

        if($type == "neutral"){
            $newPath = $directory."/".$rawName.".".$ext;
        }


        switch($type){
            case 'default':
                // nothing to do here
                break;
            case 'thumb':
                if (!file_exists($newPath)) {
                    Image::make($path)->fit(120, 120, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save($newPath);
                }
                break;
            case 'preview':
                if (!file_exists($newPath)) {
                    Image::make($path)->resize(340, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save($newPath);
                }
                break;

            case 'gallery-thumb':
                if (!file_exists($newPath)) {
                    Image::make($path)->resize(168, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save($newPath);
                }
                break;

            case 'gallery-main-thumb':
                if (!file_exists($newPath)) {
                    Image::make($path)->resize(580, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save($newPath);
                }
                break;

            case 'product-list-thumb':
                if (!file_exists($newPath)) {
                    Image::make($path)->resize(308, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save($newPath);
                }
                break;
        }
        $img = File::get($newPath);
        return static::make($img, 200, $headers);

    }

    public static function error($error = 404){
        return static::make(null,$error);
    }

    public static function badrequest($error = 400){
        return static::make(null,$error);
    }

    public static function success($error = 200){
        return static::make(null,$error);
    }

}