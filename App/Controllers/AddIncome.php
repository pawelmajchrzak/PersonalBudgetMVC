<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Models\Income;
use App\Date;
use \App\Flash;

/**
 * Signup controller
 *
 * PHP version 7.0
 */
class AddIncome extends \Core\Controller
{

    /**
     * Show the signup page
     *
     * @return void
     */
    public function newAction()
    {
        if (isset($_SESSION['user_id']))
            View::renderTemplate('AddIncome/new.html', [
                'date' => Date::getCurrentDate(),
                'incomesCategory' => Income::selectIncomesCategory()
            ]);
        else 
            View::renderTemplate('Login/new.html');
    }

    
    public function createAction()
    {



        
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
        

    }

    public function successAction()
    {
        View::renderTemplate('AddIncome/success.html'); 
    }

/*
    public function activateAction()
    {
        User::activate($this->route_params['token']);

        $this->redirect('/signup/activated');        
    }


    public function activatedAction()
    {
        View::renderTemplate('Signup/activated.html');
    }
    */

}
