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
                'paymentMethod'    =>     Expense::selectMethodsPayment()
            ]);
        else 
            View::renderTemplate('Login/new.html');
    }


/////////////incomes////////////////////////////////////

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

        if (isset($_POST['nameCategory'])) {
  
            $income->deleteIncomeCategory();
            Flash::addMessage('Kategoria przychodu została usunięta');
            $this->redirect('/settings');

        } else {

            Flash::addMessage('Nie udało się usunąć kategorii.', FLASH::INFO);
            $this->redirect('/settings');
        }
        
    }

    public function addNewCategoryIncomeAction()
    {
        $income = new Income($_POST);

        if (isset($_POST['newNameCategory'])) {
  
            $income->addNewCategoryIncome();
            Flash::addMessage('Dodano nową kategorię przychodu');
            $this->redirect('/settings');

        } else {

            Flash::addMessage('Nie udało się dodać kategorii.', FLASH::INFO);
            $this->redirect('/settings');
        }
        
    }

/////////////////expenses/////////////////////////////////////////




    public function editCategoryExpenseAction()
    {
        $expense = new Expense($_POST);

        if (isset($_POST['newNameCategory'])) {

           if($expense->updateExpenseCategory()){

            Flash::addMessage('Nazwa kategorii wydatku została zmieniona');
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

    public function deleteCategoryExpenseAction()
    {
        $expense = new Expense($_POST);

        if (isset($_POST['nameCategory'])) {
  
            $expense->deleteExpenseCategory();
            Flash::addMessage('Kategoria wydatku została usunięta');
            $this->redirect('/settings');

        } else {

            Flash::addMessage('Nie udało się usunąć kategorii.', FLASH::INFO);
            $this->redirect('/settings');
        }
        
    }

    public function addNewCategoryExpenseAction()
    {
        $expense = new Expense($_POST);

        if (isset($_POST['newNameCategory'])) {
  
            $expense->addNewCategoryExpense();
            Flash::addMessage('Dodano nową kategorię wydatku');
            $this->redirect('/settings');

        } else {

            Flash::addMessage('Nie udało się dodać kategorii.', FLASH::INFO);
            $this->redirect('/settings');
        }
        
    }



/////////////////payment//method/////////////////////////////////////////




public function editPaymentMethodAction()
{
    $expense = new Expense($_POST);

    if (isset($_POST['newNameCategory'])) {

       if($expense->updatePaymentMethod()){

        Flash::addMessage('Nazwa metody płatności wydatku została zmieniona');
        $this->redirect('/settings');
       } else {
            Flash::addMessage('Nie udało się zmienić nazwy metody płatności, może jest już metoda płatności o tej nazwie. Metoda płatności może składać się tylko z liter i cyfr', FLASH::WARNING);
            $this->redirect('/settings');
       }

    } else {
        Flash::addMessage('Nie udało się zmienić nazwy kategorii.', FLASH::INFO);
        $this->redirect('/settings');
    }
}

public function deletePaymentMethodAction()
{
    $expense = new Expense($_POST);

    if (isset($_POST['nameCategory'])) {

        $expense->deletePaymentMethod();
        Flash::addMessage('Metoda płatności została usunięta');
        $this->redirect('/settings');

    } else {

        Flash::addMessage('Nie udało się usunąć metody płatności.', FLASH::INFO);
        $this->redirect('/settings');
    }
    
}

public function addNewPaymentMethodAction()
{
    $expense = new Expense($_POST);

    if (isset($_POST['newNameCategory'])) {

        $expense->addNewPaymentMethod();
        Flash::addMessage('Dodano nową metodę płatności');
        $this->redirect('/settings');

    } else {

        Flash::addMessage('Nie udało się dodać metody płatności.', FLASH::INFO);
        $this->redirect('/settings');
    }
    
}


}
