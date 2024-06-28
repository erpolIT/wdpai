<?php

require_once __DIR__ . '/Request.php';
require_once __DIR__ . '/Router.php';

class Application
{
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;

    public static Application $app;
    public Response $response;


    public function __construct($rootPath)
    {
        self::$ROOT_DIR = rtrim($rootPath, DIRECTORY_SEPARATOR);
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);

    }

    public static function getUserId(){
        return $_SESSION['userId'];
    }

    public static function isGuest(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return !isset($_SESSION['userId']);
    }

    public static function isAdmin(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION['userRole'] == 'admin';
    }

    public function run(){
        echo $this->router->resolve();
    }

    public function __destruct(){

    }
}