<?php

class Session
{
    protected const FLASH_KEY = 'flash_messages';
    public function __construct(){
        session_start();
        $flashMessages = $_SESSION[self::FLASH_KEY];
        foreach ($flashMessages as $key => &$flashMessage){
            $flashMessage['remove'] = true;
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;

    }
    public function setFlash($key, $message){
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $message
        ];
    }

    public function getFlash($key){
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => &$flashMessage){
            if($flashMessage['remove']){
                unset($flashMessage[$key]);
            }
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}