<?php

namespace models;

use Cassandra\Date;
use models\Model;

class UserProfile extends Model
{

    protected int $id;
    protected int $userId;

    protected string $firstName = "";

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getBirthdate(): string
    {
        return $this->birthdate;
    }

    public function setBirthdate(string $birthdate): void
    {
        $this->birthdate = $birthdate;
    }
    protected string $lastName = "";
    protected string $address = "";

    protected string $birthdate = "";

    public function __construct($firstName="", $lastName="", $birthdate="", $address=""){
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthdate = $birthdate;
        $this->address = $address;
    }
    public function rules()
    {
        return[
            'birthdate' => [[self::RULE_DATE, 'format'=> 'd-m-Y']],
        ];
    }
}