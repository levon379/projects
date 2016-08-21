<?php namespace App\Http\Controllers;

use App\Booking;
use App\BookingAddon;
use App\BookingClient;
use App\BookingComment;
use App\Order;
use App\OrderBooking;
use Illuminate\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use Validator;

class OrdersController extends Controller {

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function index(){
		$mode = 'add';
        $orders = Order::paginate(10);
        return view('orders.index',compact('orders', 'mode'));
    }

    public function viewBookings($id){
        $orderId = $id;
        $order = Order::find($id);
        $bookings = $order->bookings()->paginate(10);
        return view('orders.bookings',compact('bookings','orderId','order'));
    }

    public function add(){
        $mode = 'add';
        $orders = Order::all();
        return view('orders.index',compact('orders', 'mode'));
    }

    public function postAdd(){
        $referenceNo = Input::get('reference_no');

        $order = new Order;
        $order->reference_no = $referenceNo;

        $input = Input::all();

        $rules = array(
            'reference_no' => 'required',
        );

        $messages = array(
            'reference_no.required' => 'This reference no. field is required'
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $order->save();

            if($order->id){
                return redirect("/admin/orders/")
                    ->with('success','Order successfully added');
            }
        }

        return redirect("/admin/orders")->withInput()->withErrors($validation);

    }

    public function edit($id){
        $order = Order::find($id);
		$orders = Order::all();
        $mode = 'edit';
        return view('orders.index',compact('order', 'orders', 'mode'));
    }

    public function postEdit($id){

        $referenceNo = Input::get('reference_no');

        $order = Order::find($id);
        $order->reference_no = $referenceNo;

        $input = Input::all();

        $rules = array(
            'reference_no' => 'required',
        );

        $messages = array(
            'reference_no.required' => 'This reference no. field is required'
        );


        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $order->save();

            if($order->id){
                return redirect("/admin/orders/")
                    ->with('success','Order successfully updated');
            }
        }

        return redirect("/admin/orders/")->withInput()->withErrors($validation);
    }

    public function delete($id){
        $order = Order::find($id);
        $referenceNo = $order->reference_no;

        try {

            $bookings = $order->bookings;
            foreach($bookings as $booking){
                $bookingId = $booking->id;
                OrderBooking::where('booking_id','=',$bookingId)->delete();
                BookingComment::where('booking_id','=',$bookingId)->delete();
                BookingAddon::where('booking_id','=', $bookingId)->delete();
                BookingClient::where('booking_id','=',$bookingId)->delete();
                $booking->delete();
            }
            $order->delete();

        } catch (QueryException $e) {
            return redirect('/admin/addons')->with("error","<b>$referenceNo</b> cannot be deleted it is being used by the system");
        }

        return redirect('/admin/orders')->with("success","<b>$referenceNo</b> has been deleted successfully");

    }
}