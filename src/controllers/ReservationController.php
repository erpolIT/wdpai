<?php

session_start();


use controllers\AppController;

require_once 'AppController.php';
require_once __DIR__ . '/../repository/ReservationRepository.php';

class ReservationController extends AppController
{
    /**
     * @var ReservationRepository
     */
    private ReservationRepository $reservationRepository;

    public function __construct()
    {
        $this->reservationRepository = new ReservationRepository();
        $this->layout = 'main';
    }
    public function addReservation(Request $request, Response $response){

        if($request->isPost()){
            // Sprawdzenie czy wszystkie wymagane dane zostały przekazane metodą GET
                // Pobranie danych z adresu URL
                $userId = $_SESSION['userId'] ?? null;
                $apartmentId = $_POST['apartmentId'];
                $pickupDate = $_POST['startDate'];
                $returnDate = $_POST['endDate'];
                if(isset($_POST['flightId'])){
                    $flightId = $_POST['flightId'];
                }


                if($this->reservationRepository->addReservationToDB($apartmentId, $userId, $pickupDate, $returnDate, $flightId))
                {
                    $response->withJson(['success' => true, 'redirectUrl' => '/dashboard']);
                } else {
                    echo "Wystąpił błąd. Brak wymaganych danych.11";
                }

            } else {
                echo "Wystąpił błąd. Brak wymaganych danych.";
            }
        }

        public function getReservations(Request $request, Response $response){

        $reservations = $this->reservationRepository->getAllReservations(Application::getUserId());
        if($request->isGet()){
                return $this->renderView('reservations', [
                        'reservations' => $reservations,
                    ]
                );
            }
        }

        public function deleteReservation(Request $request, Response $response, $id){
            if($request->isDelete()){
                $result = $this->reservationRepository->deleteById($id);

                if ($result) {
                    http_response_code(200);
                    $response->withJson(['success' => true, 'message' => 'Reservation deleted successfully']);
                } else {
                    http_response_code(500);
                    $response->withJson(['success' => false, 'message' => 'Failed to delete reservation']);
                }
            }
        }

}