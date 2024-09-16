<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/UserProfile.php';

use controllers\AppController;
use middlewares\AuthMiddleware;
use models\UserProfile;


class ProfileController extends AppController
{
    private \UserRepository $userRepository;

    public function __construct(){
        $this->userRepository = new \UserRepository();
        $this->registerMiddleware(new AuthMiddleware());
        $this->layout = 'main';
    }
    public function index(Request $request, Response $response){
        if($request->isGet()){
            $userDetails = $this->userRepository->getUserDetails(\Application::getUserId());
            $date = $userDetails->getBirthdate();
            $dateTime = DateTime::createFromFormat('Y-m-d', $date);
            if ($dateTime) {
                // Konwersja daty do formatu 'Y-m-d' (lub inny wymagany format)
                $formattedDate = $dateTime->format('d-m-Y');

                $userDetails->setBirthdate($formattedDate);
            } else {
                // Obsługa błędu, jeśli data nie jest poprawna
                throw new Exception('Nieprawidłowy format daty');
            }

            return $this->renderView('profile', [
                'userDetails' => $userDetails
            ]);
        }


    }

    public function updateProfile(\Request $request, \Response $response) {

        $userProfile = new UserProfile();
        if ($request->isPost()) {
            $userProfile->loadData($request->getBody());
            $userProfile->setUserId($this->getUserId());

            if ($userProfile->validate() && $this->userRepository->updateUser($userProfile)) {
                return $response->withJson(['success' => true]);
            } else {
                return $response->withJson(['success' => false, 'message' => 'Error updating profile', 'errors' => $userProfile->errors]);
            }
        }
    }
}