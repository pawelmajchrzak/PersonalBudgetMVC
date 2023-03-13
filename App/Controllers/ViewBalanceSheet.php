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
        $balance = new Balance($_POST);

        $resultPeriodTime = $balance ->periodTime();
        $startOfPeriodTime = $resultPeriodTime[0];
        $endOfPeriodTime = $resultPeriodTime[1];

        $incomeCategories = $balance -> selectIncomesCategory();
        $i=0;
		$generalSumOfIncomes = 0;
        foreach ($incomeCategories as $singleCategory)
        {
            $incomes = $balance -> selectUserIncomes($startOfPeriodTime,$endOfPeriodTime,$singleCategory['id']);
            $sumOfIncomes[$i]=0;

            foreach ($incomes as $income)
            {
                $sumOfIncomes[$i]+=$income['amount'];
            }
            $generalSumOfIncomes += $sumOfIncomes[$i];

			$i++;
        }

        $expenseCategories = $balance -> selectExpensesCategory();
        $i=0;
		$generalSumOfExpenses = 0;
        foreach ($expenseCategories as $singleCategory)
        {
            $expenses = $balance -> selectUserExpenses($startOfPeriodTime,$endOfPeriodTime,$singleCategory['id']);
            $sumOfExpenses[$i]=0;

            foreach ($expenses as $expense)
            {
                $sumOfExpenses[$i]+=$expense['amount'];
            }
            $generalSumOfExpenses += $sumOfExpenses[$i];

			$i++;
        }



        $dateObject= new DateTime($endOfPeriodTime);
        $dateObject->modify( '-1 day' );
        $workingDate = $dateObject->format('Y-m-d');

        $periodTime = $startOfPeriodTime.' -zakres czasu- '.$workingDate;

        $balance = $generalSumOfIncomes-$generalSumOfExpenses;

		if($balance >= 200)
		{
			$commentToBalance= 'Gratulacje! Dobrze gospodarujesz swoimi pieniędzmi!';
			$colorText='text-success';
            
		}
		elseif ($balance >= -200)
		{
			$commentToBalance= 'Uważaj! Jesteś na granicy płynności!';
			$colorText='text-warning';
		}
		else
		{
			$commentToBalance= 'Źle gospodarujesz swoimi pieniędzmi! Czas na zmiany...';
			$colorText='text-danger';
		}
        if ($balance >= 0)
        $balanceString = '+'.$balance;



        View::renderTemplate('ViewBalanceSheet/index.html', [
            'incomeCategories' => $incomeCategories,
            'sumOfIncomes' => $sumOfIncomes,
            'generalSumOfIncomes' => $generalSumOfIncomes,
            'expenseCategories' => $expenseCategories,
            'sumOfExpenses' => $sumOfExpenses,
            'generalSumOfExpenses' => $generalSumOfExpenses,
            'periodTime' => $periodTime,
            'balance' => $balance,
            'commentToBalance' => $commentToBalance,
            'colorText' => $colorText,

        ]);
  

    

    }



    


}
