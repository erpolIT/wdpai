<?php

require_once 'Repository.php';

class ApartmentRepository extends Repository
{
    public function getAvailableApartmentsFromCity($location, $pickupDate, $returnDate)
    {
        try {
            // Zapytanie SQL do pobrania wolnych apartamentów z konkretnego miasta
            $sql = "SELECT * FROM apartments 
                WHERE location = :location 
                AND id NOT IN (
                    SELECT apartment_id 
                    FROM reservations 
                    WHERE (:start_date BETWEEN start_date AND end_date OR :end_date BETWEEN start_date AND end_date)
                )";


            // Przygotowanie zapytania
            $stmt = $this->database->connect()->prepare($sql);
            $stmt->bindParam(':location', $location, PDO::PARAM_STR);
            $stmt->bindParam(':start_date', $pickupDate->format('Y-m-d'), PDO::PARAM_STR);
            $stmt->bindParam(':end_date', $returnDate->format('Y-m-d'), PDO::PARAM_STR);
            $stmt->execute();

            // Pobranie wyników zapytania
            $apartments = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $apartments;
        } catch (PDOException $e) {
            // Obsługa błędów połączenia z bazą danych
            die("Błąd: " . $e->getMessage());
        }
    }

    public function getAllApartments(){
        $sql = 'SELECT * FROM apartments';
        $stmt = $this->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addApartment($location, $name, $price_per_night, $description, $imagePath) {
        $sql = 'INSERT INTO apartments (location, name, price_per_night, description, image_path) VALUES (:location, :name, :price_per_night, :description, :image_path)';
        $statement = $this->prepare($sql);

        try{
            $statement->bindParam(':location', $location);
            $statement->bindParam(':name', $name);
            $statement->bindParam(':price_per_night', $price_per_night);
            $statement->bindParam(':description', $description);
            $statement->bindParam(':image_path', $imagePath);

            $statement->execute();

            return true;
        }catch (\PDOException $e) {
            error_log('Błąd podczas dodawania apartamentu do bazy danych: ' . $e->getMessage());
            return false;
        }
    }
}