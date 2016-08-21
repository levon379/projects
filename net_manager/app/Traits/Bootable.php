<?php namespace App\Traits;

trait Bootable {

    public static function boot()
    {
        parent::boot();

        static::creating(function($model)
        {
            if ($this->isFileable()) {
                $model->preUpload();
            }

        });

        static::created(function($model)
        {
            if ($this->isFileable()) {
                $model->upload();
            }
            
        });

        static::updating(function($model)
        {
            if ($this->isFileable()) {
                $model->preUpload();
            }

        });

        static::updated(function($model)
        {
            if ($this->isFileable()) {
                $model->upload();
            }
        });
        static::deleting(function($model)
        {
            if ($this->isFileable()) {
        	   $model->storeFilenameForRemove();
            }

        });
        static::deleted(function($model)
        {
            if ($this->isFileable()) {
        	   $model->removeUpload();
            }
        });
    }

   
    public function isSoftDeletable()
    {
        return in_array(Illuminate\Database\Eloquent\SoftDeletes::class, class_uses(get_class($this)));
    }

    public function isThumbnailable()
    {
        return in_array(Thumbnailable::class, class_uses(get_class($this)));
    }

    public function isSluggable()
    {
        return in_array(Sluggable::class, class_uses(get_class($this)));
    }

    public function isFileable()
    {
        return in_array(Fileable::class, class_uses(get_class($this)));
    }
}
