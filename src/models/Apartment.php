<?php

namespace models;

use Application;
use models\Model;

class Apartment extends Model
{

    protected int $id = 0;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImagePath(): string
    {
        return $this->imagePath;
    }

    public function getPricePerNight(): int
    {
        return $this->pricePerNight;
    }

    public function setImagePath(string $imagePath): void
    {
        $this->imagePath = $imagePath;
    }

    public function getLocation(): string
    {
        return $this->location;
    }
    protected string $name = "";
    protected string $description = "";
    protected string $imagePath = "";
    protected float $pricePerNight = 0;

    protected string $location = "";

    protected array $image = [];

    public function getImage(): array
    {
        return $this->image;
    }

    public function loadData($data) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                if(!empty($value)){
                    $this->{$key} = $value;
                }
            }
        }

        // Obsługa przesyłanego obrazu
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $this->image = $_FILES['image'];
        }
    }

    public function loadImagePath(){
        if($this->image && $this->image['error'] === UPLOAD_ERR_OK){
            $uploadDir = Application::$ROOT_DIR . 'public/img/';
            $imageName = uniqid() . '_' . $this->image['name'];
            $targetPath = $uploadDir . $imageName;

            if (move_uploaded_file($this->image['tmp_name'], $targetPath)) {
                $this->imagePath = $targetPath; // Przypisanie ścieżki do pola imagePath
            } else {
                $this->addError('image', 'Error uploading image.');
            }
        } elseif ($this->image && $this->image['error'] !== UPLOAD_ERR_OK) {
            $this->addError('image', 'Error uploading image: ' . $this->image['error']);
        }
    }
    public function rules()
    {
        return [
            'name' => [self::RULE_REQUIRED],
            'description' => [self::RULE_REQUIRED],
            'imagePath' => [self::RULE_REQUIRED, self::RULE_IMAGE],
            'image' => [self::RULE_REQUIRED],
            'pricePerNight' => [self::RULE_REQUIRED, self::RULE_NUMBER, [self::RULE_MIN_VALUE, 'minValue' => 0]],
            'location' => [self::RULE_REQUIRED],

        ];
    }
}