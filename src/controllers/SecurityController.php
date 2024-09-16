<?php


use controllers\AppController;
use middlewares\BaseMiddleware;
use middlewares\GuestMiddleware;
use models\LoginForm;
use models\Model;
use models\RegisterModel;
use models\User;

require_once 'AppController.php';
require_once  __DIR__ .'/../models/User.php';
require_once __DIR__ .'/../models/LoginForm.php';
require_once __DIR__ .'/../models/RegisterModel.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__ . '/../middlewares/GuestMiddleware.php';
require_once __DIR__.'/../../Request.php';

class SecurityController extends AppController
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->registerMiddleware(new GuestMiddleware(['login', 'register']));
    }

    public function login(Request $request, Response $response){

        $registerModel = new RegisterModel();
        $loginForm= new LoginForm();
        if($request->isGet()){
             return $this->renderView('auth', [
                'registerModel' => $registerModel,
                'loginForm' => $loginForm
            ]);

        }

        //var_dump($request->getBody());
        $loginForm->loadData($request->getBody());

        if(!$loginForm->validate()){
            return $response->withJson(['success' => false, 'errors' => $loginForm->errors]);
        }

        $user = $this->userRepository->getUser($loginForm->getEmail());
        if($user){
            if(!$user->login($loginForm->getEmail(), $loginForm->getPassword())){
                $loginForm->addError('password', 'Password is incorrect');
            }else{
                $user->setRole($this->userRepository->getUserRole($user->getUserId())['role']);
                $this->createUserSession($user);

                return $response->withJson(['success' => true, 'redirectUrl' => '/dashboard']);
            }
        }else{
            $loginForm->addError('email', 'User with this email does not exist');
        }

        return $response->withJson(['success' => false, 'errors' => $loginForm->errors]);
    }

    public function register(Request $request, Response $response){

        $loginForm = new LoginForm();
        $registerModel = new RegisterModel();
        if($request->isGet()){
             return $this->renderView('auth', [
                'registerModel' => $registerModel,
                'loginForm' => $loginForm
            ]);
        }
        $registerModel->loadData($request->getBody());
        if($this->userRepository->getUser($registerModel->getEmail())){
            $registerModel->addError('email', 'User with this email already exists');
        }

        if($registerModel->validate() && $this->userRepository->addUser($registerModel)){
            return $response->withJson(['success' => true]);
        }else{
            return $response->withJson(['success' => false, 'errors' => $registerModel->errors]);
        }
    }

    public function logout(Request $request, Response $response){
        if($request->isGet()){
            return;
        }
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];

        session_destroy();

        $response->withJson(['success' => true, 'redirectUrl' => '\login']);

    }

    public function createUserSession($user){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['userId'] = $user->getUserId();
        $_SESSION['username'] = $user->getUsername();
        $_SESSION['userRole'] = trim($user->getUserRole());

    }
}
