<?php

namespace App\Models;

use PDO;
use \App\Token;
use \App\Mail;
use \Core\View;
use \App\Config;


class User extends \Core\Model
{

    public $errors = [];

    public function __construct($data = [])
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

        $this->validateStatuteAndCaptcha();

        if (empty($this->errors)) {

            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

            $token = new Token();
            $hashed_token = $token->getHash();
            $this->activation_token = $token->getValue();

            $sqlAddUser = 'INSERT INTO users (username, password, email, activation_hash)
                    VALUES (:username, :password_hash, :email, :activation_hash)';

            $sqlAddIncomesCategory = "INSERT INTO incomes_category_assigned_to_users (user_id, name)
                                        SELECT users.id, incomes_category_default.name 
                                        FROM users, incomes_category_default
                                        WHERE users.email = :email";

            $sqlAddExpensesCategory = "INSERT INTO expenses_category_assigned_to_users (user_id, name)
                                        SELECT users.id, expenses_category_default.name 
                                        FROM users, expenses_category_default
                                        WHERE users.email = :email";

            $sqlAddMethodPayments = "INSERT INTO payment_methods_assigned_to_users (user_id, name)
                                        SELECT users.id, payment_methods_default.name 
                                        FROM users, payment_methods_default
                                        WHERE users.email = :email";

            $db = static::getDB();

            $stmt = $db->prepare($sqlAddUser);

            $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
            $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':activation_hash', $hashed_token, PDO::PARAM_STR);

            $stmt->execute();

            

            $stmt_incomes = $db->prepare($sqlAddIncomesCategory);
            $stmt_incomes->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt_incomes->execute();

            $stmt_expenses = $db->prepare($sqlAddExpensesCategory);
            $stmt_expenses->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt_expenses->execute();

            $stmt_method_payments = $db->prepare($sqlAddMethodPayments);
            $stmt_method_payments->bindValue(':email', $this->email, PDO::PARAM_STR);

            return $stmt_method_payments->execute();
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
        if (static::emailExists($this->email, $this->id ?? null)) {
            $this->errors[] = 'Jest już konto z tym emailem!';
        }

        // Password
        
        if (isset($this->password)) {

            if (strlen($this->password) < 8) {
                $this->errors[] = 'Hasło musi posiadać od 8 do 20 znaków!';
            }

            if ((strlen($this->password) > 20)) {
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

    }

    public function validateStatuteAndCaptcha()
    {
        //Czy zaakceptowano regulamin?        
        if (!isset($this->statute))
		{
            $this->errors[] = 'Potwierdź akceptację regulaminu!';
		}	
        
        //Bot or not? Oto jest pytanie!
        
        $secretKey = Config::CAPTCHA_SECRET_KEY;
		$checkCaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$this->{'g-recaptcha-response'});
		$answerCaptcha = json_decode($checkCaptcha);
        if ($answerCaptcha->success==false)
        {
            $this->errors[] = 'Potwierdź że nie jesteś botem';
		}
        
    }


    /**
     * See if a user record already exists with the specified email
     *
     * @param string $email email address to search for
     *
     * @return boolean  True if a record already exists with the specified email, false otherwise
     */
    public static function emailExists($email, $ignore_id = null)
    {
        $user = static::findByEmail($email);

        if ($user) {
            if ($user->id != $ignore_id) {
                return true;
            }
        }

        return false;
    }


    /**
     * Find a user model by email address
     *
     * @param string $email email address to search for
     *
     * @return mixed User object if found, false otherwise
     */
    public static function findByEmail($email)
    {
        $sql = 'SELECT * FROM users WHERE email = :email';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * Authenticate a user by email and password.
     *
     * @param string $email email address
     * @param string $password password
     *
     * @return mixed  The user object or false if authentication fails
     */
    public static function authenticate($email, $password)
    {
        $user = static::findByEmail($email);

        if ($user && $user->is_active) {
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }

        return false;
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

    /**
     * Remember the login by inserting a new unique token into the remembered_logins table
     * for this user record
     *
     * @return boolean  True if the login was remembered successfully, false otherwise
     */
    public function rememberLogin()
    {
        $token = new Token();
        $hashed_token = $token->getHash();
        $this->remember_token = $token->getValue();

        $this->expiry_timestamp = time() + 60 * 60 * 24 * 30;  // 30 days from now

        $sql = 'INSERT INTO remembered_logins (token_hash, user_id, expires_at)
                VALUES (:token_hash, :user_id, :expires_at)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $this->expiry_timestamp), PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * Send password reset instructions to the user specified
     *
     * @param string $email The email address
     *
     * @return void
     */
    public static function sendPasswordReset($email)
    {
        
        $user = static::findByEmail($email);

        if ($user) {

            if ($user->startPasswordReset()) {

                $user->sendPasswordResetEmail();

            }
        }
        
    }

    /**
     * Start the password reset process by generating a new token and expiry
     *
     * @return void
     */
    protected function startPasswordReset()
    {
        $token = new Token();
        $hashed_token = $token->getHash();
        $this->password_reset_token = $token->getValue();

        $expiry_timestamp = time() + 60 * 60 * 2;  // 2 hours from now

        $sql = 'UPDATE users
                SET password_reset_hash = :token_hash,
                    password_reset_expires_at = :expires_at
                WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
        $stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $expiry_timestamp), PDO::PARAM_STR);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Send password reset instructions in an email to the user
     *
     * @return void
     */
    protected function sendPasswordResetEmail()
    {
        $url = 'http://' . $_SERVER['HTTP_HOST'] . '/password/reset/' . $this->password_reset_token;

        $text = View::getTemplate('Password/reset_email.txt', ['url' => $url]);
        $html = View::getTemplate('Password/reset_email.html', ['url' => $url]);

        Mail::send($this->email, 'Budżet osobisty - resetowanie hasła', $text, $html);
    }

    /**
     * Find a user model by password reset token and expiry
     *
     * @param string $token Password reset token sent to user
     *
     * @return mixed User object if found and the token hasn't expired, null otherwise
     */
    public static function findByPasswordReset($token)
    {
        $token = new Token($token);
        $hashed_token = $token->getHash();

        $sql = 'SELECT * FROM users
                WHERE password_reset_hash = :token_hash';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        $user = $stmt->fetch();

        if ($user) {

            // Check password reset token hasn't expired
            if (strtotime($user->password_reset_expires_at) > time()) {

                return $user;
            }
        }
    }

    /**
     * Reset the password
     *
     * @param string $password The new password
     *
     * @return boolean  True if the password was updated successfully, false otherwise
     */
    public function resetPassword($password)
    {
        $this->password = $password;

        $this->validate();

        if (empty($this->errors)) {

            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

            $sql = 'UPDATE users
                    SET password = :password_hash,
                        password_reset_hash = NULL,
                        password_reset_expires_at = NULL
                    WHERE id = :id';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
            $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);

            return $stmt->execute();
        }

        return false;
    }

    /**
     * Send an email to the user containing the activation link
     *
     * @return void
     */
    public function sendActivationEmail()
    {
        $url = 'http://' . $_SERVER['HTTP_HOST'] . '/signup/activate/' . $this->activation_token;

        $text = View::getTemplate('Signup/activation_email.txt', ['url' => $url]);
        $html = View::getTemplate('Signup/activation_email.html', ['url' => $url]);

        Mail::send($this->email, 'Budżet osobisty - Aktywacja konta', $text, $html);
    }

    /**
     * Activate the user account with the specified activation token
     *
     * @param string $value Activation token from the URL
     *
     * @return void
     */
    public static function activate($value)
    {
        $token = new Token($value);
        $hashed_token = $token->getHash();

        $sql = 'UPDATE users
                SET is_active = 1,
                    activation_hash = null
                WHERE activation_hash = :hashed_token';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':hashed_token', $hashed_token, PDO::PARAM_STR);

        $stmt->execute();                
    }

    /**
     * Update the user's profile
     *
     * @param array $data Data from the edit profile form
     *
     * @return boolean  True if the data was updated, false otherwise
     */
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

    public function deleteAccount()
    {

        if (empty($this->errors)) {
            
            $sql = 'UPDATE users
                    SET is_active = "false"  
                    WHERE id = :id';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

            return $stmt->execute();
        }

        return false;
    }

    public function deleteIncomesAndExpenses()
    {

        if (empty($this->errors)) {
            
            $sql = 'DELETE i, e FROM incomes AS i, expenses AS e
                    WHERE i.user_id = :id AND e.user_id = :id';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

            return $stmt->execute();
        }

        return false;
    }


}
