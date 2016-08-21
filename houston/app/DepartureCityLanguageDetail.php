<?php namespace App;

use App\Libraries\Helpers;
use Illuminate\Database\Eloquent\Model;

class DepartureCityLanguageDetail extends Model {

    protected $fillable = [];

    public $timestamps = false;

    private static $metaData = array(
        "things-to-do-in-rome" => array(
            "title" => "Things to do in Rome",
            "description" => "Looking for extraordinary things to do in Rome? You are in the right place. We've got everything from super-technological Segway tours to relaxing day trips from Rome to hidden islands and beaches in the mediterranean. Need a Skip the Line Entrance Ticket to the Vatican or Colosseum? We've got you covered.",
            "keywords" => "Things to do in Rome, rome tours, rome city tours, rome tickets, rome transfers, rome airport transfers"
            ),
        "day-trips-from-rome" => array(
            "title" => "Day Trips from Rome",
            "description" => "Extraordinary day trips from Rome hand-crafted by the experts at EcoArt Rome Tour Operator. See Italy as few ever do!",
            "keywords" => "day trips from rome, day tours from rome, rome day trips, italy day trips"
            ),
        "rome-segway-tours" => array(
            "title" => "Rome Segway Tours",
            "description" => "Explore the beauties of Rome from aboard your very own modern “chariot”: the SegwayPT. Sightseeing has never been easier, more fun, or greener on our Rome Segway Tours!",
            "keywords" => "rome by segway, rome segway tours, segway tours of rome"
            ),
        "rome-transfers" => array(
            "title" => "Rome Transfers",
            "description" => "Need a private car transfer in the city of Rome? We can offer private Rome Airport transfers from and to Fiumicino and Ciampino airports as well as Civitavecchia port. Travel in style in comfort in our luxurious Mercedes van.",
            "keywords" => "rome city transfer, private transfers rome, rome airport transfer, private rome airport transfer"
            ),
        "rome-tickets" => array(
            "title" => "Rome Tickets",
            "description" => "Easy to book and use Skip the Line Vatican and Colosseum tickets. See the Vatican & Sistine Chapel or the Colosseum, Roman Forum and Palatine hill at your own pace and chosen time!",
            "keywords" => "colosseum tickets, vatican tickets, rome tickets",
            )
        );

    public function language()
    {
        return $this->belongsTo('App\Language','language_id');
    }

    public function departureCity()
    {
        return $this->belongsTo('App\DepartureCity','departure_city_id');
    }

    public static function getMetaData($slug){
        if(isset(DepartureCityLanguageDetail::$metaData[$slug])){
            return DepartureCityLanguageDetail::$metaData[$slug];
        }
        return null;
    }

}
