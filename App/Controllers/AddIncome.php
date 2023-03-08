<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Models\Income;

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
        View::renderTemplate('AddIncome/new.html');
    }

    
    public function createAction()
    {



        
        $income = new Income($_POST);
        

        if ($income ->save()) {

            

            header('Location://'.$_SERVER['HTTP_HOST'].'/signup/success', true, 303);
            exit();


        } else {

            View::renderTemplate('AddIncome/new.html', [
                'income' => $income
            ]);

        }
        

    }
/*
    public function successAction()
    {
        View::renderTemplate('Signup/success.html'); 
    }


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
