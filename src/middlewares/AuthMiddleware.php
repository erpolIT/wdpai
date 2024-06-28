<?php

namespace middlewares;

use http\Env\Response;
use http\Exception;

require_once __DIR__.'/BaseMiddleware.php';

class AuthMiddleware extends BaseMiddleware
{

    /**
     * @var mixed
     */
    private array $actions;

    private \Response $response;
    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
        $this->response = new \Response();
    }

    public function execute($action){
        if(\Application::isGuest()){
            if(empty($this->actions) || in_array($action, $this->actions)){
                return $this->response->redirect('/login');
            }
        }
    }
}