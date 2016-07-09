<?php
class DatabaseSession extends Eloquent {

    protected $table = 'sessions';
    public $timestamps = false;
    
    /**-------------------------------------------------------------------------
     * updateCurrent():
     *                 Updates the session key to include user_id
     *--------------------------------------------------------------------------
     *
     * @param  int  $id
     * @return Response
     *-------------------------------------------------------------------------*/
    public static function addUserIdToSession($user_id) {
        $session = DatabaseSession::where('id', Session::getId());
        $session->update(array( 'user_id' => $user_id));
    }
    
    /**-------------------------------------------------------------------------
     * user():
     *                 Model relationship
     *--------------------------------------------------------------------------
     *
     *-------------------------------------------------------------------------*/
    public function user() {
        return $this->belongsTo('User');
    }
}
