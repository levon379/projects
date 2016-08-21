<?php namespace App\Traits;

trait RepositoryTrait {

    public static function getRepository()
    {
        // Generate default repository class name e.g ModelRepository.
        // If not defined.
        $class = explode("\\", __CLASS__);
        $class = end($class) . 'Repository';

        // Get repository class name if defined! Else Default
        $class = property_exists(__CLASS__, 'repository') ? static::$repository : $class;

        // Generate fullpath of file.
        $file = app_path().DIRECTORY_SEPARATOR.'Repositories'.DIRECTORY_SEPARATOR.$class.'.php';

        // Greate new Instance of repository class.
        $repository = "\\App\\Repositories\\".$class;

        if (!file_exists($file) || !class_exists($repository))
        {
            throw new \Exception("File {$file} or class {$repository} not found!", 1);
        }

        return new $repository();
    }
}