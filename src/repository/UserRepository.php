<?php


use models\RegisterModel;
use models\User;
use models\UserProfile;

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../models/RegisterModel.php';


class UserRepository extends Repository
{
    public function getUser(string $email) : ?User
    {
        $stmt = $this->database->connect()->prepare('select * from users where email = :email');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user === false){
            return null;
        }

        return new User(
            $user['id'],
            $user['username'],
            $user['email'],
            $user['password']
        );
    }

    public function getUserByUsername(string $username) : ?User
    {
        $stmt = $this->database->connect()->prepare('select * from users where username = :username');
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user === false){
            return null;
        }

        return new User(
            $user['id'],
            $user['username'],
            $user['email'],
            $user['password']
        );
    }

    public function addUser(RegisterModel $user): bool
    {
        $stmt = $this->database->connect()->prepare('INSERT INTO users (username, email, password, role_id) VALUES (:username, :email, :password, :role_id)');

        $username = $user->getUsername();
        $email = $user->getEmail();
        $userRole = 2;
        $password_hash = password_hash($user->getPassword(), PASSWORD_BCRYPT);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password_hash);
        $stmt->bindParam(':role_id', $userRole);
        return $stmt->execute();
    }

    public function getUserRole($userId){
        $sql = "SELECT ur.role 
        FROM users u
        INNER JOIN user_roles ur ON u.role_id = ur.id
        WHERE u.id = :user_id";


        $stmt = $this->prepare($sql);

        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        // Pobranie wyników
        $userRole = $stmt->fetch(PDO::FETCH_ASSOC);
        return $userRole;
    }

    public function updateUser(UserProfile $userDetails): bool
    {
        $fields = [];
        $params = [];

        if (!empty($userDetails->getFirstName())) {
            $fields[] = 'first_name = :first_name';
            $params[':first_name'] = $userDetails->getFirstName();
        }

        if (!empty($userDetails->getLastName())) {
            $fields[] = 'last_name = :last_name';
            $params[':last_name'] = $userDetails->getLastName();
        }

        if (!empty($userDetails->getAddress())) {
            $fields[] = 'address = :address';
            $params[':address'] = $userDetails->getAddress();
        }
        if (!empty($userDetails->getBirthdate())) {
            $date = $userDetails->getBirthdate();
            $dateTime = DateTime::createFromFormat('d-m-Y', $date);
            if ($dateTime) {
                $formattedDate = $dateTime->format('Y-m-d'); // Konwersja do formatu Y-m-d
                //$userProfile->birthDate = $formattedDate;
            } else {
                throw new Exception('Nieprawidłowy format daty');
            }

            $fields[] = 'birthdate = :birthdate';
            $params[':birthdate'] = $formattedDate;
        }


        // Ensure there are fields to update
        if (count($fields) > 0) {
            $params[':user_id'] = $userDetails->getUserId();

            $sql = 'UPDATE user_profiles SET ' . implode(', ', $fields) . ' WHERE user_id = :user_id';
            $statement = $this->prepare($sql);

            foreach ($params as $param => $value) {
                $statement->bindValue($param, $value);
            }

            return $statement->execute();
        }

        return false; // Nothing to update
    }

    public function getUserDetails($userId){
        $sql = "SELECT * 
        FROM user_profiles
        WHERE user_id = :user_id";


        $stmt = $this->prepare($sql);

        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        // Pobranie wyników
        $userDetails = $stmt->fetch(PDO::FETCH_ASSOC);
        $userProfile = new UserProfile($userDetails['first_name'], $userDetails['last_name'], $userDetails['birthdate'], $userDetails['address']);
        return $userProfile;
    }
}