<?php

namespace App\Models;

use PDO;
use \App\Token;
use \App\Mail;
use \Core\View;
use DateTime;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class Income extends \Core\Model
{
    /**
     * Error messages
     * 
     * @var array
     */
    public $errors = [];


    /**
     * Class constructor
     * 
     * @param array $data Initial property values
     * 
     * @return void
     */
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }


    public function save()
    {
        $this->validate();

        if (empty($this->errors)) {

            echo 'Walidacja udana';
            /*
            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

            $token = new Token();
            $hashed_token = $token->getHash();
            $this->activation_token = $token->getValue();

            $sql = 'INSERT INTO users (username, password, email, activation_hash)
                    VALUES (:username, :password_hash, :email, :activation_hash)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
            $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':activation_hash', $hashed_token, PDO::PARAM_STR);

            return $stmt->execute();
            */
        }

        return false;
    }

    public function validate()
    {
        //Sprawdź poprawność kwoty
        $this->amount = str_replace(',','.',$this->amount);

        if ($this->amount == '') {
            $this->errors[] = 'Kwota jest wymagana!';
        }

        if(is_numeric($this->amount)==false) {
            $this->errors[] = 'Wpisz poprawny format liczby!';
        }
        
        $this->amount = number_format($this->amount, 2, '.', '');


        //Sprawdź poprawność daty
        if ($this->date == '') {
            $this->errors[] = 'Data jest wymagana!';
        }


		$dateObject= new DateTime($this->date);
		$day= $dateObject->format("d");
		$month= $dateObject->format("m");
		$year= $dateObject->format("Y");

		if(checkdate($month, $day, $year)==false) {
			$this->errors[] ="Wpisz poprawny format daty!";
		}

        //walidacja kategorii
        if ($this->category == '') {
            $this->errors[] = 'Kwota jest wymagana!';
        }

        if (preg_match('/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ0-9+-]*$/', $this->category) == false) {
            $this->errors[] = 'Kategoria może składać się tylko z liter i cyfr';
        }


        //walidacja komentarza
        if (isset($this->comment)) {

            if (preg_match('/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ0-9+-]*$/', $this->comment) == false) {
                $this->errors[] = 'Kategoria może składać się tylko z liter i cyfr';
            }

        }

    }



    /**
     * Find a user model by ID
     *
     * @param string $id The user ID
     *
     * @return mixed User object if found, false otherwise
     */
    public static function findByID($id)
    {
        $sql = 'SELECT * FROM users WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    /*
    public function updateProfile($data)
    {
        $this->username = $data['username'];
        $this->email = $data['email'];
        unset($this->password);
        // Only validate and update the password if a value provided
        if ($data['password'] != '') {
            $this->password = $data['password'];
        } 

        

        $this->validate();

        if (empty($this->errors)) {
            
            $sql = 'UPDATE users
                    SET username = :username,
                        email = :email';

            // Add password if it's set
            if (isset($this->password)) {
                $sql .= ', password = :password';
            }

            $sql .= "\nWHERE id = :id";


            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

            // Add password if it's set
            if (isset($this->password)) {

                $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
                $stmt->bindValue(':password', $password_hash, PDO::PARAM_STR);

            }

            return $stmt->execute();
        }

        return false;
    }
    */
}
