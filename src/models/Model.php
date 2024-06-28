<?php

namespace models;

use DateTime;

abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_NUMBER = 'number';

    public const RULE_UNIQUE = 'unique';
    public const RULE_MIN_VALUE = 'minValue';
    public const RULE_IMAGE = 'image';



//    public function setProperty($property, $value) {
//        // Sprawdź, czy właściwość istnieje i jest dostępna
//        if (property_exists($this, $property)) {
//            $this->$property = $value;
//        } else {
//            throw new Exception("Property {$property} does not exist or is not accessible.");
//        }
//    }


    public function loadData($data){
        foreach ($data as $key => $value){
            if(property_exists($this, $key)){
//                if(!empty($value)){
//                    $this->{$key} = $value;
//                }
                if ($key === 'pickupDate' || $key === 'returnDate') {
                    try {
                        $this->{$key} = new DateTime($value);
                    } catch (\Exception $e) {
                        $this->{$key} = null;
                    }
                } else {
                    $this->{$key} = $value;
                }
            }
        }
    }

    public function labels(){
        return [];
    }

    public function getLabel($attribute){
        return $this->labels()[$attribute] ?? $attribute;
    }
    public array $errors = [];

    abstract public function rules();

    public function validate(): bool
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = is_string($rule) ? $rule : $rule[0];

                switch ($ruleName) {
                    case self::RULE_REQUIRED:
                        if (!$value) {
                            $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                        }
                        break;

                    case self::RULE_EMAIL:
                        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $this->addErrorForRule($attribute, self::RULE_EMAIL);
                        }
                        break;

                    case self::RULE_MIN:
                        if (strlen($value) < $rule['min']) {
                            $this->addErrorForRule($attribute, self::RULE_MIN, $rule);
                        }
                        break;

                    case self::RULE_MIN_VALUE:
                        if(filter_var($value, FILTER_VALIDATE_FLOAT)){
                            if ($value < $rule['minValue']) {
                                $this->addErrorForRule($attribute, self::RULE_MIN_VALUE, $rule);
                            }
                        }

                        break;

                    case self::RULE_MAX:
                        if (strlen($value) > $rule['max']) { // Corrected to 'max'
                            $this->addErrorForRule($attribute, self::RULE_MAX, $rule);
                        }
                        break;

                    case self::RULE_MATCH:
                        if ($value !== $this->{$rule['match']}) {
                            $this->addErrorForRule($attribute, self::RULE_MATCH, $rule);
                        }
                        break;

                    case self::RULE_NUMBER:
                        if (!filter_var($value, FILTER_VALIDATE_FLOAT)) {
                            $this->addErrorForRule($attribute, self::RULE_NUMBER);
                        }
                        break;
                    case self::RULE_UNIQUE:
                        // Assuming a unique check method or logic
                        if (!$this->isUnique($attribute, $value, $rule['class'])) {
                            $this->addErrorForRule($attribute, self::RULE_UNIQUE, ['field' => $attribute]);
                        }
                        break;
                }
            }
        }
        return empty($this->errors);
    }

    private function addErrorForRule(string $attribute, string $rule, $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }

    public function addError(string $attribute, string $message)
    {
        $this->errors[$attribute][] = $message;
    }

    private function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This is not a valid email address',
            self::RULE_MIN => 'Min length is {min}',
            self::RULE_MAX => 'Max length is {max}',
            self::RULE_MIN_VALUE => 'Min value is {minValue}',
            self::RULE_MATCH => 'This field must be the same as {match}',
            self::RULE_UNIQUE => 'User with this {field} already exists',
            self::RULE_NUMBER => 'This is not valid number',
        ];
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? '';
    }

    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? null;
    }

    // Placeholder for the unique check method
    private function isUnique($attribute, $value, $class)
    {
        // Implement your unique check logic here, e.g., querying the database
        return true;
    }


}