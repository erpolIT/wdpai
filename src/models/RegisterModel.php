<?php

namespace models;

use Exception;

class RegisterModel extends Model
{
    protected string $username = '';

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }
    protected string $email = '';
    protected string $password = '';
    protected string $confirmPassword = '';

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getConfirmPassword(): string
    {
        return $this->confirmPassword;
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        return null;
    }

    public function setProperty($property, $value) {
        // Sprawdź, czy właściwość istnieje i jest dostępna
        if (property_exists($this, $property)) {
            $this->$property = $value;
        } else {
            throw new Exception("Property {$property} does not exist or is not accessible.");
        }
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

    public function __toString(){
        return "username - $this->username";
    }
}