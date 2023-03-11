<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
//use \App\Models\ViewBalanceSheet;
use App\Date;
use \App\Flash;

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

    /*
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

    */


}
