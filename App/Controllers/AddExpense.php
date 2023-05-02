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
        View::renderTemplate('Home/index.html');
    }

    public function createAction()
    {
        //Limit//

        $limit = Expense::getLimit ($_POST['category']);
        //$limit = $_POST['category'];
        //$endOfMonth = Expense::getLastDayOfMonth ($_POST['date']);
        $monthlySum = Expense::getMonthlyCategoryExpense($_POST['category'],$_POST['date']);
        $monthlySumAndThis = $monthlySum+$_POST['amount'];


        header('Location://'.$_SERVER['HTTP_HOST'].'/addExpense/success', true, 303);
        Flash::addMessage('Limit dla wybranej kategorii to: '.$limit.' zł. Wykorzystano już: '.$monthlySum.' zł. Po dodaniu tego przychodu będzie: '.$monthlySumAndThis.' zł.');
        exit();

        //endLimit//




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

    public function limitAction() {

        ///ponizszyZapisOgarnac
        $category = $this->route_params['category'];
        echo json_encode(Expense::getLimit($category), JSON_UNESCAPED_UNICODE);
    }

    public function expenseMonthlySumAction() {

        ///ponizszyZapisOgarnac
        $category = $this->route_params['category'];
        $date = $this->route_params['date'];

        echo json_encode(Expense::getMonthlyCategoryExpense($category, $date), JSON_UNESCAPED_UNICODE);
    }



}
