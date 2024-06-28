<?php

namespace models;

use Exception;

require_once __DIR__.'/Model.php';
class User extends Model {
    private int $id = 0;
    private $username = "";

    private $userRole = "";
    /**
     * @return mixed|null
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username) {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username cannot be empty.');
        }
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->id;
    }
    private $password = "";

    private $confirmPassword;

    private $email = "";


    public function setRole($role){
        $this->userRole = $role;
    }

    public function getUserRole(){
        return $this->userRole;
    }
    public function setProperty($property, $value) {
        // Sprawdź, czy właściwość istnieje i jest dostępna
        if (property_exists($this, $property)) {
            $this->$property = $value;
        } else {
            throw new Exception("Property {$property} does not exist or is not accessible.");
        }
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        return null;
    }

    public function getEmail()
    {
        return $this->email;
    }


    public function __construct($id=null, $username=null, $email=null, $password=null)
    {
        // TODO it should be singleton
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    public function rules() : array
    {
        // TODO: Implement rules() method.
        return [
            'username' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match'=> 'password']],
        ];
    }

    public function labels() : array
    {
        return [
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'confirmPassword' => 'Confirm Password'
        ];
    }

    public function login($email, $password): bool
    {
        if(password_verify($password, $this->password)){
            return true;
        }
        return false;
    }

    public function __toString(){
        return "username: $this->username";
    }
}