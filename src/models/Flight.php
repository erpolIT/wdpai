<?php

namespace models;

use Cassandra\Date;
use DateTime;
use models\Model;

class Flight extends Model
{
    public $id;
    public int $flightNumber;

    public DateTime $arrivalTime;
    public DateTime $departureTime;
    public string $status;

    public int $arrivalAirportId;

    public int $departureAirportId;



    public function rules()
    {
        // TODO: Implement rules() method.
    }
}