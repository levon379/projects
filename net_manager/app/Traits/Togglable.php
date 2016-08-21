<?php namespace App\Traits;

trait Togglable {
    
	/**
	 * Get toggles attributes for model
	 * @return [array] toggles attributes
	 */
    public function toggles()
    {
        // Check for overriding
        if (property_exists(__CLASS__, 'toggles') && is_array($this->toggles))
        {
            return $this->toggles;
        }
        // Default toggle attribute
        return array('active');
    }

    public function toggle($attribute)
    {

		// Toggle only if attribute is togglable
    	if ( ! in_array($attribute, $this->toggles())) return FALSE;

    	$this->$attribute = ! $this->$attribute;
    	return $this->save();
    	
    }

}
