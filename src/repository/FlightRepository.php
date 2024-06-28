<?php

namespace repository;

use PDO;

class FlightRepository extends \Repository
{
    public function getMatchingFlights($location, $destination, $pickupDate, $returnDate){


        $sql = "SELECT f.*, da.name AS departure_airport, aa.name AS arrival_airport
                FROM flights f
                JOIN airports da ON f.departure_airport_id = da.id
                JOIN airports aa ON f.arrival_airport_id = aa.id
                WHERE da.city = :departure_airport_city
                AND aa.city = :arrival_airport_city
                AND DATE(f.departure_time) = :departure_date
        ";


        $stmt = $this->prepare($sql);
        $stmt->bindParam(':departure_airport_city', $location, PDO::PARAM_STR);
        $stmt->bindParam(':arrival_airport_city', $destination, PDO::PARAM_STR);
        $stmt->bindParam(':departure_date', $pickupDate->format('Y-m-d'), PDO::PARAM_STR);
//        $stmt->bindParam(':arrival_date', $pickupDate, PDO::PARAM_STR);
        $stmt->execute();

        $flights = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Pobranie wyników zapytania
        return $flights;


    }
}