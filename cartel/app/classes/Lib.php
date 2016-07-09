<?php 
/* Lib: project wide utility functions */
class Lib {
  
  /**-------------------------------------------------------------------------
   * getUnviewedBids:
   *      
   *      Returns a list of bids that the user has received and has not yet
   *      looked at. Viewing the bid details marks the bid as being viewed.
   *                 
   *--------------------------------------------------------------------------
   *
   * @param  int  $user_id
   * @return Bid array
   *-------------------------------------------------------------------------*/
  public static function getUnviewedBids($user_id){
    $bids = Bid::whereRaw('product_id in (SELECT id FROM product WHERE user_id = ?) and bid_viewed = 0', array($user_id));
    return($bids);
  }
  
}
?>
