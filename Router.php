<?php


use controllers\AppController;
use middlewares\BaseMiddleware;

require_once 'src/controllers/DashboardController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/ApartmentController.php';
require_once 'src/controllers/ReservationController.php';
require_once 'src/controllers/ProfileController.php';
require_once 'Request.php';
require_once 'Response.php';

class Router {

    public Request $request;
    public Response $response;
    protected array $routes = [];

    /**
     * @param Request $request
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback) {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback) {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve(){
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        if($callback === false){
            $this->response->setStatusCode(404);
            return "Wrong url";
        }
//        if(is_string($callback)){
//            return $this->renderView($callback);
//        }

        if(is_array($callback)){
            /** @var AppController $controller */
            /** @var BaseMiddleware $middleware */
            $controller = new $callback[0];
            $callback[0] = $controller;
            foreach ($controller->getMiddlewares() as $middleware) {
                $middleware->execute($callback[1]);
            }
        }

        return call_user_func($callback, $this->request, $this->response);

    }


}