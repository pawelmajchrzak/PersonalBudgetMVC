<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Models\Balance;
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

            $sumOfIncomes[$i] = number_format($sumOfIncomes[$i], 2, '.', '');
            
			$i++;
        }

        $generalSumOfIncomes = number_format($generalSumOfIncomes, 2, '.', '');

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

            $sumOfExpenses[$i] = number_format($sumOfExpenses[$i], 2, '.', '');

			$i++;
        }

        $generalSumOfExpenses = number_format($generalSumOfExpenses, 2, '.', '');

        $dateObject= new DateTime($endOfPeriodTime);
        $dateObject->modify( '-1 day' );
        $workingDate = $dateObject->format('Y-m-d');

        $periodTime = $startOfPeriodTime.' -zakres czasu- '.$workingDate;

        $balance = $generalSumOfIncomes-$generalSumOfExpenses;
        $balance = number_format($balance, 2, '.', '');

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
        $balanceSign = '';
        if ($balance >= 0)
            $balanceSign = '+';

        if (!isset($_POST['timePeriod']))
            $_POST['timePeriod']=5;


        View::renderTemplate('ViewBalanceSheet/index.html', [
            'incomeCategories' => $incomeCategories,
            'sumOfIncomes' => $sumOfIncomes,
            'generalSumOfIncomes' => $generalSumOfIncomes,
            'expenseCategories' => $expenseCategories,
            'sumOfExpenses' => $sumOfExpenses,
            'generalSumOfExpenses' => $generalSumOfExpenses,
            'periodTime' => $periodTime,
            'balance' => $balance,
            'balanceSign' => $balanceSign,
            'commentToBalance' => $commentToBalance,
            'colorText' => $colorText,
            'timePeriod' => $_POST['timePeriod'],
        ]);
  

    

    }



    


}
