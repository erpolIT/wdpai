<?php

namespace models;

use DateTime;
use models\Model;

class SearchApartmentForm extends Model
{
    protected string $location;
    protected string $destination;

    /**
     * @param string $location
     * @param string $destination
     * @param Date $pickupDate
     * @param Date $returnDate
     */
    public function __construct(string $location="", string $destination="", Date $pickupDate=null, Date $returnDate=null)
    {
        $this->location = $location;
        $this->destination = $destination;
        $this->pickupDate = $pickupDate ?? new DateTime();
        $this->returnDate = $returnDate ?? new DateTime();
    }

    public function getDestination(): string
    {
        return $this->destination;
    }

    public function getLocation(): string
    {
        return $this->location;
    }
    protected DateTime $pickupDate;

    public function getPickupDate(): DateTime
    {
        return $this->pickupDate;
    }

    public function getReturnDate(): DateTime
    {
        return $this->returnDate;
    }
    protected DateTime $returnDate;



    public function rules()
    {
        // TODO: Implement rules() method.
        return [
            'location' => [self::RULE_REQUIRED],
            'destination' => [self::RULE_REQUIRED],
            'pickupDate' => [self::RULE_REQUIRED],
            'returnDate' => [self::RULE_REQUIRED],
        ];
    }
}