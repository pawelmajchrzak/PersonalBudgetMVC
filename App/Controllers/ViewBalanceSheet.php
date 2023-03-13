<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Models\Balance;
use App\Date;
use \App\Flash;
use DateTime;

/**
 * Signup controller
 *
 * PHP version 7.0
 */
class ViewBalanceSheet extends \Core\Controller
{

    /**
     * Show the signup page
     *
     * @return void
     */
    public function indexAction()
    {
        if (isset($_SESSION['user_id']))
            View::renderTemplate('ViewBalanceSheet/index.html');
        else 
            View::renderTemplate('Login/new.html');
    }


    
    public function createAction()
    {
        /*
        if (!isset($_POST['timePeriod']))
        {
            $_POST['timePeriod']=5;
        }
    
        $fr_period=$_POST['timePeriod'];
    
        if($_POST['timePeriod']==1)
        {
            $startOfPeriodTime = date('Y-m-01');
            $endOfPeriodTime = date('Y-m-01',strtotime('+1 month',time()));
        }
        elseif ($_POST['timePeriod']==2)
        {
            $startOfPeriodTime = date('Y-m-01',strtotime('-1 month',time()));
            $endOfPeriodTime = date('Y-m-01');
        }
        elseif ($_POST['timePeriod']==3)
        {
            $startOfPeriodTime = date('Y-01-01');
            $endOfPeriodTime = date('Y-01-01',strtotime('+1 Year',time()));
        }
        elseif ($_POST['timePeriod']==4)
        {
            $startOfPeriodTime = date('Y-01-01',strtotime('-1 Year',time()));
            $endOfPeriodTime = date('Y-01-01');
        }
        elseif ($_POST['timePeriod']==5)
        {
            $startOfPeriodTime=$_POST['startPeriod'];
            $endOfPeriodTime=$_POST['endPeriod'];
            $dateObject= new DateTime($endOfPeriodTime);
            $dateObject->modify( '+1 day' );
            $endOfPeriodTime = $dateObject->format('Y-m-d');
            
        }
        */
        $balance = new Balance($_POST);

        $resultPeriodTime = $balance ->periodTime();
        $startOfPeriodTime = $resultPeriodTime[0];
        $endOfPeriodTime = $resultPeriodTime[1];

        $categories = $balance -> selectIncomesCategory();

        $i=0;
		$generalSumOfIncomes = 0;
        foreach ($categories as $singleCategory)
        {
            $incomes = $balance -> selectUserIncomes($startOfPeriodTime,$endOfPeriodTime,$singleCategory['id']);
            $sumOfIncomes[$i]=0;
            
            
            //echo $singleCategory['name'] . '<br>';
            foreach ($incomes as $income)
            {
                //echo $income['amount'] . '<br>';
                $sumOfIncomes[$i]+=$income['amount'];
                
            }
            $generalSumOfIncomes += $sumOfIncomes[$i];

            //echo $singleCategory['name'] . '<br>';
            //echo $sumOfIncomes[$i] . '<br>';

			$i++;
        }
        //echo $generalSumOfIncomes . '<br>';
        

        View::renderTemplate('ViewBalanceSheet/index.html', [
            'categories' => $categories,
            'sumOfIncomes' => $sumOfIncomes,
            'generalSumOfIncomes' => $generalSumOfIncomes
        ]);
/*
        
        $income = new Income($_POST);
        

        if ($income ->save()) {

            

            header('Location://'.$_SERVER['HTTP_HOST'].'/addIncome/success', true, 303);
            Flash::addMessage('Dodano nowy przychód');
            exit();


        } else {

            View::renderTemplate('AddIncome/new.html', [
                'income' => $income
            ]);

        }
*/       

    

    }



    


}
