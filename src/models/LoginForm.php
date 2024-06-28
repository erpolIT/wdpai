<?php

namespace models;

use Exception;
use models\Model;

class LoginForm extends Model
{

    protected string $email = '';

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail($email) {
        if (empty($email)) {
            throw new \InvalidArgumentException('Email cannot be empty');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email address.');
        }

        $this->email = $email;
    }
    protected string $password = '';

    public function getPassword(): string
    {
        return $this->password;
    }
    public function setProperty($property, $value) {
        // Sprawdź, czy właściwość istnieje i jest dostępna
        if (property_exists($this, $property)) {
            $this->$property = $value;
        } else {
            throw new Exception("Property {$property} does not exist or is not accessible.");
        }
    }
    public function rules()
    {
        // TODO: Implement rules() method.
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]],
        ];
    }
}