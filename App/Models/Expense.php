<?php

namespace App\Models;

use PDO;
use \App\Token;
use \App\Mail;
use \Core\View;
use DateTime;


class Expense extends \Core\Model
{

    public $errors = [];

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }


    public function save()
    {
        $this->validate();

        $id = (int)$_SESSION['user_id'];

        if (empty($this->errors)) {


            $sql = 'INSERT INTO expenses (user_id, expense_category_assigned_to_user_id, payment_method_assigned_to_user_id, amount, date_of_expense, expense_comment)
                    VALUES (:id, :category, :paymentMethod, :amount, :date, :comment)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            
            $stmt->bindValue(':category', $this->category, PDO::PARAM_STR);
            $stmt->bindValue(':paymentMethod', $this->paymentMethod, PDO::PARAM_STR);
            $stmt->bindValue(':amount', $this->amount, PDO::PARAM_STR);
            $stmt->bindValue(':date', $this->date, PDO::PARAM_STR);
            $stmt->bindValue(':comment', $this->comment, PDO::PARAM_STR);
            $stmt->bindValue(':id', $id, PDO::PARAM_STR);

            return $stmt->execute();
            
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
        else if($this->amount<0) {
            $this->errors[] = 'Kwota nie może być ujemna';
        }
        else {
            $this->amount = number_format($this->amount, 2, '.', '');
        }
        
        


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
        if (!isset($this->category))
		{
            $this->errors[] = 'Wybierz kategorię!';
		}	
        else if($this->category == '') {
            $this->errors[] = 'Kategoria jest wymagana!';
        }
        else if(preg_match('/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ0-9+-]*$/', $this->category) == false) {
            $this->errors[] = 'Kategoria może składać się tylko z liter i cyfr';
        }

        //walidacja metody płatności
        if (!isset($this->paymentMethod))
		{
            $this->errors[] = 'Wybierz metodę płatności!';
		}	
        else if($this->paymentMethod == '') {
            $this->errors[] = 'Metoda płatności jest wymagana!';
        }
        else if(preg_match('/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ0-9+-]*$/', $this->paymentMethod) == false) {
            $this->errors[] = 'Metoda płatności może składać się tylko z liter i cyfr';
        }



        //walidacja komentarza
        if (isset($this->comment)) {

            if (preg_match('/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ0-9+_ -.,]*$/', $this->comment) == false) {
                $this->errors[] = 'To pole może składać się tylko z liter, cyfr, plusów, minusów oraz spacji';
            }

        }

    }


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

    public static function selectExpensesCategory()
    {
        $id = $_SESSION['user_id'];

        $sql = "
                SELECT id, name
                FROM expenses_category_assigned_to_users
                WHERE user_id = :id
                ";

        $db = static::getDb();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }   

    public static function selectMethodsPayment()
    {
        $id = $_SESSION['user_id'];

        $sql = "
                SELECT id, name
                FROM payment_methods_assigned_to_users
                WHERE user_id = :id
                ";

        $db = static::getDb();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }   

/////////////////////To Settings//////////////////////////////

////////////ExpenseCategory//////////

    public function updateExpenseCategory()
    {
        $id = $_SESSION['user_id'];

        $this->validateCategoryName();

        if (empty($this->errors))
        {

            $sql = "UPDATE `expenses_category_assigned_to_users` 
                    SET name = :newNameCategory
                    WHERE  name = :oldNameCategory AND user_id = :id";

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id',                   $id,                       PDO::PARAM_INT);
            $stmt->bindValue(':oldNameCategory',      $this->oldNameCategory,    PDO::PARAM_STR);
            $stmt->bindValue(':newNameCategory',      $this->newNameCategory,    PDO::PARAM_STR);
            return $stmt->execute();

        } else {

            return false;
        }

    }


    public function validateCategoryName()
    {
        //walidacja kategorii
        if (!isset($this->newNameCategory))
		{
            $this->errors[] = 'Wybierz kategorię!';
		}	
        else if($this->newNameCategory == '') {
            $this->errors[] = 'Kategoria jest wymagana!';
        }
        else if(preg_match('/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ0-9+ -]*$/', $this->newNameCategory) == false) {
            $this->errors[] = 'Kategoria może składać się tylko z liter i cyfr';
        }

        if (static::categoryExists($this->newNameCategory)) {
            $this->errors[] = 'Jest już kategoria o tej nazwie';
        }
    }

    public static function categoryExists($category)
    {
        $expense = static::findByCategory($category);

        if ($expense) {
            return true;
        }

        return false;
    }

    public static function findByCategory($name)
    {
        $sql = 'SELECT * FROM expenses_category_assigned_to_users WHERE LOWER(name) = :name AND user_id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name', $name,                 PDO::PARAM_STR);
        $stmt->bindValue(':id',   $_SESSION['user_id'],  PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    public function deleteExpenseCategory()
    {
        $id = $_SESSION['user_id'];

        if (empty($this->errors))
        {

            $db = static::getDB();

            $sql1 = "SELECT id FROM `expenses_category_assigned_to_users` 
                    WHERE  name = :nameCategory AND user_id = :id";

            $stmt1 = $db->prepare($sql1);
            $stmt1->bindValue(':id',            $id,                    PDO::PARAM_INT);
            $stmt1->bindValue(':nameCategory',  $this->nameCategory,    PDO::PARAM_STR);
            $stmt1->execute();

            $result = $stmt1->fetch(PDO::FETCH_ASSOC);
            $idCategory = $result['id'];
            
            
            $sql2 = "UPDATE `expenses` 
                    SET expense_category_assigned_to_user_id = :categoryReplace
                    WHERE  expense_category_assigned_to_user_id = :idCategory";

            $stmt2 = $db->prepare($sql2);
            $stmt2->bindValue(':idCategory',  $idCategory,    PDO::PARAM_STR);
            $stmt2->bindValue(':categoryReplace',  $this->categoryReplace,    PDO::PARAM_STR);
            $stmt2->execute();

            
            $sql = "DELETE FROM `expenses_category_assigned_to_users` 
                    WHERE  name = :nameCategory AND user_id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id',            $id,                    PDO::PARAM_INT);
            $stmt->bindValue(':nameCategory',  $this->nameCategory,    PDO::PARAM_STR);
            
            return $stmt->execute();
            
            
        } else {

            return false;
        }

    }


    public function addNewCategoryExpense()
    {
        $id = $_SESSION['user_id'];

        $this->validateCategoryName();

        if (empty($this->errors))
        {
            $sql = 'INSERT INTO expenses_category_assigned_to_users (user_id, name)
                    VALUES (:id, :newNameCategory)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id',                   $id,                       PDO::PARAM_INT);
            $stmt->bindValue(':newNameCategory',      $this->newNameCategory,    PDO::PARAM_STR);
            return $stmt->execute();

        } else {

            return false;
        }

    }    

////////////PaymentMethods//////////

public function updatePaymentMethod()
{
    $id = $_SESSION['user_id'];

    $this->validatePaymentMethod();

    if (empty($this->errors))
    {

        $sql = "UPDATE `payment_methods_assigned_to_users` 
                SET name = :newNameCategory
                WHERE  name = :oldNameCategory AND user_id = :id";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':id',                   $id,                       PDO::PARAM_INT);
        $stmt->bindValue(':oldNameCategory',      $this->oldNameCategory,    PDO::PARAM_STR);
        $stmt->bindValue(':newNameCategory',      $this->newNameCategory,    PDO::PARAM_STR);
        return $stmt->execute();

    } else {

        return false;
    }

}


public function validatePaymentMethod()
{
    //walidacja metody płatności
    if (!isset($this->newNameCategory))
    {
        $this->errors[] = 'Wybierz metodę płatności!';
    }	
    else if($this->newNameCategory == '') {
        $this->errors[] = 'Metoda płatności jest wymagana!';
    }
    else if(preg_match('/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ0-9+ -]*$/', $this->newNameCategory) == false) {
        $this->errors[] = 'Metoda płatności może składać się tylko z liter i cyfr';
    }

    if (static::paymentMethodExists($this->newNameCategory)) {
        $this->errors[] = 'Jest już metoda płatności o tej nazwie';
    }
}

public static function paymentMethodExists($category)
{
    $expense = static::findByMethodPayment($category);

    if ($expense) {
        return true;
    }

    return false;
}

public static function findByMethodPayment($name)
{
    $sql = 'SELECT * FROM payment_methods_assigned_to_users WHERE LOWER(name) = :name AND user_id = :id';

    $db = static::getDB();
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':name', $name,                 PDO::PARAM_STR);
    $stmt->bindValue(':id',   $_SESSION['user_id'],  PDO::PARAM_INT);

    $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

    $stmt->execute();

    return $stmt->fetch();
}

public function deletePaymentMethod()
{
    $id = $_SESSION['user_id'];

    if (empty($this->errors))
    {

        $db = static::getDB();

        $sql1 = "SELECT id FROM `payment_methods_assigned_to_users` 
                WHERE  name = :nameCategory AND user_id = :id";

        $stmt1 = $db->prepare($sql1);
        $stmt1->bindValue(':id',            $id,                    PDO::PARAM_INT);
        $stmt1->bindValue(':nameCategory',  $this->nameCategory,    PDO::PARAM_STR);
        $stmt1->execute();

        $result = $stmt1->fetch(PDO::FETCH_ASSOC);
        $idCategory = $result['id'];
        
        if($idCategory!=$this->categoryReplace)
        {
            $sql2 = "UPDATE `expenses` 
            SET payment_method_assigned_to_user_id = :categoryReplace
            WHERE  payment_method_assigned_to_user_id = :idCategory";

            $stmt2 = $db->prepare($sql2);
            $stmt2->bindValue(':idCategory',  $idCategory,    PDO::PARAM_INT);
            $stmt2->bindValue(':categoryReplace',  $this->categoryReplace,    PDO::PARAM_INT);
            $stmt2->execute();

        } else
        {
            $sql2 = "DELETE FROM `expenses` 
            WHERE  payment_method_assigned_to_user_id = :idCategory";
            $stmt2 = $db->prepare($sql2);
            $stmt2->bindValue(':idCategory',  $idCategory,    PDO::PARAM_INT);
            $stmt2->execute();
        }


        
        $sql = "DELETE FROM `payment_methods_assigned_to_users` 
                WHERE  name = :nameCategory AND user_id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id',            $id,                    PDO::PARAM_INT);
        $stmt->bindValue(':nameCategory',  $this->nameCategory,    PDO::PARAM_STR);
        
        return $stmt->execute();
        
        
    } else {

        return false;
    }

}


public function addNewPaymentMethod()
{
    $id = $_SESSION['user_id'];

    $this->validatePaymentMethod();

    if (empty($this->errors))
    {
        $sql = 'INSERT INTO payment_methods_assigned_to_users (user_id, name)
                VALUES (:id, :newNameCategory)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':id',                   $id,                       PDO::PARAM_INT);
        $stmt->bindValue(':newNameCategory',      $this->newNameCategory,    PDO::PARAM_STR);
        return $stmt->execute();

    } else {

        return false;
    }

}    

}
