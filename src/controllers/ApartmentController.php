<?php


use controllers\AppController;
use models\Apartment;
use models\SearchApartmentForm;
use repository\FlightRepository;

require_once 'AppController.php';
require_once __DIR__ . '/../repository/ApartmentRepository.php';
require_once __DIR__ . '/../repository/FlightRepository.php';
require_once __DIR__ . '/../models/Apartment.php';
require_once __DIR__ . '/../models/SearchApartmentForm.php';


class ApartmentController extends AppController
{

    /**
     * @var ApartmentRepository
     */
    private ApartmentRepository $apartmentRepository;
    private FlightRepository $flightRepository;

    public function __construct()
    {
        $this->apartmentRepository = new ApartmentRepository();
        $this->flightRepository = new FlightRepository();
        $this->layout = 'main';
    }

    public function searchApartment(\Request $request, \Response $response)
    {

        $searchForm = new SearchApartmentForm();
        $matchingFlights = [];
        $availableApartments = [];
        if($request->isGet()){
            $searchForm->loadData($request->getBody());
            if($searchForm->validate()){
                $availableApartments = $this->apartmentRepository->getAvailableApartmentsFromCity($searchForm->getDestination(), $searchForm->getPickupDate(), $searchForm->getReturnDate());//$destinaton, $pickupDate, $returnDate);
                $matchingFlights = $this->flightRepository->getMatchingFlights($searchForm->getLocation(), $searchForm->getDestination(), $searchForm->getPickupDate(), $searchForm->getReturnDate());
            }
        }


        // Renderujemy widok z wynikami wyszukiwania
        return $this->renderView('search_results', [
                'availableApartments' => $availableApartments,
                'location' => $location,
                'destination' => $destinaton,
                'matchingFlights' => $matchingFlights[0]
            ]
        );
    }

    public function index(\Request $request, \Response $response){
        if($request->isGet()){
            $apartments = $this->apartmentRepository->getAllApartments();
            return $this->renderView('apartments', [
                'apartments' => $apartments,
                    ]
            );
        }
    }

    public function create(\Request $request, \Response $response)
    {
        $apartment = new Apartment();
        if($request->isPost()){
            $apartment->loadData($request->getBody());
            if($apartment->getImage()){
                $apartment->loadImagePath();
            }
            if($apartment->validate()){
                if($this->apartmentRepository->addApartment($apartment->getLocation(), $apartment->getName(),$apartment->getPricePerNight(),$apartment->getDescription(), $apartment->getImagePath())){
                    $data = [
                        'success' => true,
                        'message' => 'Apartment added succesfully.',
                    ];
                }else{
                    $data = [
                        'success' => false,
                    ];
                }
            }else{
                $data = [
                    'success' => false,
                    'errors' => $apartment->errors,
                ];
            }



            return $response->withJson($data);
        }
    }

}

