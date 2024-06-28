<?php

namespace controllers;

use Application;
use middlewares\BaseMiddleware;

class AppController {
    /**
     * @var mixed
     */
    private $request;
    protected array $middlewares = [];
    public string $layout = 'auth';



    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }


    public function renderView($view, $params = []){
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);
        return str_replace('{{content}}', $viewContent, $layoutContent);

    }

    protected function renderOnlyView($view, $params){
        $filePath = Application::$ROOT_DIR . "src/views/$view.php";
        extract($params);
        ob_start();
        if (!file_exists($filePath)) {
            echo 'File not found at: ' . $filePath;
            exit;
        }
        include_once $filePath;
        return ob_get_clean();
    }

    protected function layoutContent()
    {
        $filePath = Application::$ROOT_DIR . "src/views/layouts/$this->layout.php";
        ob_start();
        if (!file_exists($filePath)) {
            echo 'File not found at: ' . $filePath;
            exit;
        }
        include_once $filePath;
        return ob_get_clean();
    }
    public function registerMiddleware(BaseMiddleware $middleware ){
        $this->middlewares[] = $middleware;
    }

    protected function getUserId(){
        return Application::getUserId();
    }
}