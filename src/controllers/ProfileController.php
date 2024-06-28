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
            if ($this->userRepository->updateUser($userProfile)) {
                return $response->withJson(['success' => true]);
            } else {
                return $response->withJson(['success' => false, 'message' => 'Error updating profile']);
            }
        }
    }
}