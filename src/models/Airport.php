<?php

namespace models;

use models\Model;

class Airport extends Model
{

    public int $id;
    public string $name;
    public string $code;
    public string $city;
    public string $country;
    public function rules()
    {
        // TODO: Implement rules() method.
    }
}