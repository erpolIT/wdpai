<?php

require_once 'Repository.php';
class ReservationRepository extends Repository
{
    public function getAllReservations($userId): array
    {
        $query = "SELECT * FROM reservation_view where user_id = :userId";
        $stmt = $this->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $reservations;
    }


    public function addReservationToDB($apartmentId, $userId, $pickupDate, $returnDate, $flightId): bool
    {
        $connection = $this->database->connect();


        try {
            // Rozpocznij transakcję
            $connection->beginTransaction();
            $now = new DateTime('now');
            $timestamp = $now->format('Y-m-d H:i:s');
            $str = "active";
            // Zapytanie SQL do wstawienia danych rezerwacji do tabeli
            $query = "INSERT INTO reservations (apartment_id, user_id, start_date, end_date, flight_id, reservation_date, status) VALUES (:apartment_id, :user_id, :start_date, :end_date, :flight_id, :reservation_date, :status)";
            $statement = $connection->prepare($query);
            $statement->bindParam(':apartment_id', $apartmentId);
            $statement->bindParam(':user_id', $userId);
            $statement->bindParam(':start_date', $pickupDate);
            $statement->bindParam(':end_date', $returnDate);
            $statement->bindParam(':flight_id', $flightId);
            $statement->bindParam(':reservation_date', $timestamp);
            $statement->bindParam(':status', $str);
            $statement->execute();

            // Zatwierdź transakcję
            $connection->commit();

            return true; // Rezerwacja została dodana pomyślnie
        } catch (PDOException $e) {
            // Jeśli wystąpił błąd, wycofaj transakcję
            $connection->rollBack();

            // Możesz obsłużyć błąd tutaj, np. zapisując log lub wyświetlając komunikat użytkownikowi
            echo "Wystąpił błąd: " . $e->getMessage();
            return false;
        }
    }
}