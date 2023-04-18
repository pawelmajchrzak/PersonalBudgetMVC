<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Models\Income;
use \App\Models\Expense;
use \App\Flash;
use DateTime;

class Settings extends \Core\Controller
{
    public function indexAction()
    {
        if (isset($_SESSION['user_id']))
            View::renderTemplate('Settings/index.html',[
                'incomesCategory'   =>     Income::selectIncomesCategory(),
                'expensesCategory'  =>     Expense::selectExpensesCategory(),
                'paymentMethods'    =>     Expense::selectMethodsPayment()
            ]);
        else 
            View::renderTemplate('Login/new.html');
    }

    public function editCategoryIncomeAction()
    {
        $income = new Income($_POST);

        if (isset($_POST['newNameCategory'])) {

           if($income->updateIncomeCategory()){

            Flash::addMessage('Nazwa kategorii przychodu została zmieniona');
            $this->redirect('/settings');
           } else {

            Flash::addMessage('Nie udało się zmienić nazwy kategorii, może jest już kategoria o tej nazwie. Kategoria może składać się tylko z liter i cyfr', FLASH::WARNING);
            $this->redirect('/settings');
           }


        } else {

            Flash::addMessage('Nie udało się zmienić nazwy kategorii.', FLASH::INFO);
            $this->redirect('/settings');
        }
    }

    public function deleteCategoryIncomeAction()
    {
        $income = new Income($_POST);

        //Flash::addMessage('--'.$_POST['nameCategory'].'--'.$_POST['categoryReplace']);
        //$this->redirect('/settings');
        //exit();
        if (isset($_POST['nameCategory'])) {

            
            $xxx = $income->deleteIncomeCategory();
            Flash::addMessage('--'.$xxx.'--');
            $this->redirect('/settings');
            exit();


            Flash::addMessage('Kategoria przychodu została usunięta');
            $this->redirect('/settings');

        } else {

            Flash::addMessage('Nie udało się usunąć kategorii.', FLASH::INFO);
            $this->redirect('/settings');
        }
        
    }






    /*
    public function createIncomeAction()
    {
        $income = new Income($_GET);

        if (isset($_GET['income'])) {

            $income->insertIncomeCategory();

            Flash::addMessage('Kategoria przychodu została dodana', FLASH::INFO);

            $this->redirect('/Settings');
        } else {

            Flash::addMessage('Kategoria przychodu nie została dodana, spróbuj jeszcze raz.');

            $this->redirect('/Settings');
        }
    }
*/
    /*
    public function createAction()
    {
        if (isset($_POST['timePeriod'])||isset($_POST['startPeriod']))
        {
            $balance = new Balance($_POST);
            $balance ->periodTime();
            $balance ->setBalance();

            View::renderTemplate('ViewBalanceSheet/index.html', [
                'timePeriod' => $_POST['timePeriod'],
                'balance' => $balance
            ]);
        }
        else
        {
            View::renderTemplate('ViewBalanceSheet/index.html');
        }
    }
    */

}
