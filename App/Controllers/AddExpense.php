<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Models\Expense;
use App\Date;
use \App\Flash;

/**
 * Signup controller
 *
 * PHP version 7.0
 */
class AddExpense extends \Core\Controller
{

    /**
     * Show the signup page
     *
     * @return void
     */
    public function newAction()
    {
        View::renderTemplate('AddExpense/new.html', [
            'date' => Date::getCurrentDate(),
            'expensesCategory' => Expense::selectExpensesCategory(),
            'methodsPayment' => Expense::selectMethodsPayment()
        ]);
    }

    
    public function createAction()
    {

        $expense = new Expense($_POST);
        
        if ($expense ->save()) {

            header('Location://'.$_SERVER['HTTP_HOST'].'/addExpense/success', true, 303);
            Flash::addMessage('Dodano nowy wydatek');
            exit();

        } else {

            View::renderTemplate('AddExpense/new.html', [
                'expense' => $expense
            ]);

        }
        
    }

    public function successAction()
    {
        View::renderTemplate('AddExpense/success.html'); 
    }

}
