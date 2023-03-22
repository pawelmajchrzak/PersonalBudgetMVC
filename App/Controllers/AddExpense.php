<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Models\Expense;
use \App\Flash;
use \App\Date;


class AddExpense extends \Core\Controller
{

    public function newAction()
    {
        if (isset($_SESSION['user_id']))
        View::renderTemplate('AddExpense/new.html', [
            'date' => Date::getCurrentDate(),
            'expensesCategory' => Expense::selectExpensesCategory(),
            'methodsPayment' => Expense::selectMethodsPayment()
        ]);
    else 
        View::renderTemplate('Login/new.html');
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
