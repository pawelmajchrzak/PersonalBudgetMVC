<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;

/**
 * Signup controller
 *
 * PHP version 7.0
 */
class Signup extends \Core\Controller
{

    /**
     * Show the signup page
     *
     * @return void
     */
    public function newAction()
    {
        View::renderTemplate('Signup/new.html');
    }


    /**
     * Sign up the new user
     *
     * @return void
     */
    public function createAction()
    {
        $user = new User($_POST);


		//$secretKey = "6LeQ1OQjAAAAAAS2VjtWBMwrNIM_uL9U5YHAwgml";
		//$checkCaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g-recaptcha-response']);
		//$answerCaptcha = json_decode($checkCaptcha);

        //if ($answerCaptcha->success==true) 
        //{

            if ($user ->save()) {

                $user->sendActivationEmail();

                header('Location://'.$_SERVER['HTTP_HOST'].'/signup/success', true, 303);
                exit();


            } else {

                View::renderTemplate('Signup/new.html', [
                    'user' => $user
                ]);

            }
        
        //} else 
        //{

        //    View::renderTemplate('Signup/new.html', [
        //    'user' => $user
        //    ]);
        //}
    }

    public function successAction()
    {
        View::renderTemplate('Signup/success.html'); 
    }

    /**
     * Activate a new account
     *
     * @return void
     */
    public function activateAction()
    {
        User::activate($this->route_params['token']);

        $this->redirect('/signup/activated');        
    }

    /**
     * Show the activation success page
     *
     * @return void
     */
    public function activatedAction()
    {
        View::renderTemplate('Signup/activated.html');
    }
}
