<?php

namespace middlewares;

require_once __DIR__.'/BaseMiddleware.php';

class GuestMiddleware extends BaseMiddleware
{
    private array $actions;

    private \Response $response;
    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
        $this->response = new \Response();
    }

    public function execute($action){
        if(!\Application::isGuest()){
            if(empty($this->actions) || in_array($action, $this->actions)){
                return $this->response->redirect('/');
            }
        }
    }
}