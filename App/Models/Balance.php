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
class Balance extends \Core\Model
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

    public function periodTime()
    {
        if (!isset($this->timePeriod))
        {
            $this->timePeriod=5;
        }
    
        $fr_period=$this->timePeriod;
    
        if($this->timePeriod==1)
        {
            $startOfPeriodTime = date('Y-m-01');
            $endOfPeriodTime = date('Y-m-01',strtotime('+1 month',time()));
        }
        elseif ($this->timePeriod==2)
        {
            $startOfPeriodTime = date('Y-m-01',strtotime('-1 month',time()));
            $endOfPeriodTime = date('Y-m-01');
        }
        elseif ($this->timePeriod==3)
        {
            $startOfPeriodTime = date('Y-01-01');
            $endOfPeriodTime = date('Y-01-01',strtotime('+1 Year',time()));
        }
        elseif ($this->timePeriod==4)
        {
            $startOfPeriodTime = date('Y-01-01',strtotime('-1 Year',time()));
            $endOfPeriodTime = date('Y-01-01');
        }
        elseif ($this->timePeriod==5)
        {
            $startOfPeriodTime=$this->startPeriod;
            $endOfPeriodTime=$this->endPeriod;
            $dateObject= new DateTime($endOfPeriodTime);
            $dateObject->modify( '+1 day' );
            $endOfPeriodTime = $dateObject->format('Y-m-d');
            
        }

        return array($startOfPeriodTime,$endOfPeriodTime);


    }








/*
    public function save()
    {
        $this->validate();

        $id = (int)$_SESSION['user_id'];

        if (empty($this->errors)) {


            $sql = 'INSERT INTO incomes (user_id, income_category_assigned_to_user_id, amount, date_of_income, income_comment)
                    VALUES (:id, :category, :amount, :date, :comment)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            
            $stmt->bindValue(':category', $this->category, PDO::PARAM_STR);
            $stmt->bindValue(':amount', $this->amount, PDO::PARAM_STR);
            $stmt->bindValue(':date', $this->date, PDO::PARAM_STR);
            $stmt->bindValue(':comment', $this->comment, PDO::PARAM_STR);
            $stmt->bindValue(':id', $id, PDO::PARAM_STR);

            return $stmt->execute();
            
        }

        return false;
    }
*/

    





    public static function selectIncomesCategory()
    {
        $id = $_SESSION['user_id'];

        $sql = "
                SELECT id, name
                FROM incomes_category_assigned_to_users
                WHERE user_id = :id
                ";

        $db = static::getDb();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }   

    public static function selectUserIncomes($startOfPeriodTime,$endOfPeriodTime,$categoryId)
    {
        $id = $_SESSION['user_id'];

        $sql = "
                SELECT *
                FROM incomes
                WHERE user_id = :id AND date_of_income >= :startOfPeriodTime AND date_of_income < :endOfPeriodTime AND income_category_assigned_to_user_id= :categoryId
                ";


        $db = static::getDb();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':startOfPeriodTime', $startOfPeriodTime, PDO::PARAM_STR);
        $stmt->bindValue(':endOfPeriodTime', $endOfPeriodTime, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll();
    }   



}
