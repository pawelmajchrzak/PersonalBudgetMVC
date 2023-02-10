<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class User extends \Core\Model
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
    public function __construct($data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }




    /**
     * Save the user model with the current property values
     * 
     * @return void
     */
    public function save()
    {
        $this->validate();

        if (empty($this->errors)) {

            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

            $sql = 'INSERT INTO users (username, password, email)
                    VALUES (:username, :password_hash, :email)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
            $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);

            return $stmt->execute();
        }

        return false;
    }

    /**
     * Validate current property values, adding validation error messagers to the errors array property
     * 
     * @return void
     */
    public function validate()
    {
        // Name
        if ($this->username == '') {
        $this->errors[] = 'Imię jest wymagane!';
        }

        if ((strlen($this->username) < 2) || (strlen($this->username) > 20)) {
            $this->errors[] = 'Imię musi posiadać od 2 do 20 znaków!';
        }

        if (preg_match('/(*UTF8)^[A-ZŁŚ]{1}+[a-ząęółśżźćń]+$/', $this->username) == false) {
            $this->errors[] = 'Imię może zawierać tylko litery! Zacznij od wielkiej litery!';
        }

        // email address
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $this->errors[] = 'Nieprawidłowy adres email';
        }
        if ($this->emailExists($this->email)) {
            $this->errors[] = 'Jest już konto z tym emailem!';
        }

        // Password
        /** 
        *   if ($this->password != $this->passwordConfirmation) {
        *    $this->errors[] = 'Hasła są różne!';
        *   }
        */
        if ((strlen($this->password) < 8) || (strlen($this->password) > 20)) {
            $this->errors[] = 'Hasło musi posiadać od 8 do 20 znaków!';
        }

        if (preg_match('/.*[a-z]+.*/i', $this->password) == false) {
            $this->errors[] = 'Hasło musi posiadać przynajmniej jedną literę!';
        }

        if (preg_match('/.*\W+.*/i', $this->password) == false) {
            $this->errors[] = 'Hasło musi posiadać conajmniej jeden znak specjalny!';
        }

        if (preg_match('/.*[A-Z]+.*/i', $this->password) == false) {
            $this->errors[] = 'Hasło musi posiadać przynajmniej jedną wielką literę!';
        }
    }

    /**
     * See if a user record already exists with the specified email
     *
     * @param string $email email address to search for
     *
     * @return boolean  True if a record already exists with the specified email, false otherwise
     */
    protected function emailExists($email)
    {
        $sql = 'SELECT * FROM users WHERE email = :email';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetch() !== false;
    }


}
