<?php namespace App\Traits;

trait Activatable {

	public function toggleActive()
	{
		$this->active = ! $this->active;
		$this->save();
	}

    public function scopeActive($query)
    {
        return $query->where('active', TRUE);
    }

}
