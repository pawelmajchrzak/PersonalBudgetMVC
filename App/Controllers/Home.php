<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Models\Income;
use \App\Models\Expense;
use \App\Date;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Home extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        

        View::renderTemplate('Home/index.html'/*, [
            'date' => Date::getCurrentDate(),
            'userIncomes' => Income::selectUserIncomes()
        ]*/);




    }
}
