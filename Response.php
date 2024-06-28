<?php

class Response
{
    private $status;
    public function setStatusCode($status){
       $this->status = $status;
    }

    public function redirect(string $url){

        $path = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$path}{$url}");
        exit();
    }

    public function withJson($data) {
        if (!headers_sent()) {
            header('Content-Type: application/json');
        }

        $json = json_encode($data);

        echo $json;

        exit;
    }
}