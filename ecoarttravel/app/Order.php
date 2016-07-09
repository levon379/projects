<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {

	protected $fillable = [];


    public function getBookingCount(){
        $booking = OrderBooking::where('order_id','=',$this->id)->count();
        return $booking;
    }

    public function bookings(){
        return $this->belongsToMany('App\Booking','order_bookings','order_id', 'booking_id');
    }

    public function getOrderName(){
        return "Order #$this->id";
    }

}
