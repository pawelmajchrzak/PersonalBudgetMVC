<?php

/**
 * Front controller
 *
 * PHP version 7.0
 */

/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';


/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/**
 * Sessions
 */
session_start();

/**
 * Routing
 */
$router = new Core\Router();

$router->add('api/limit/{category:[\wżźćńółęąśŻŹĆĄŚĘŁÓŃ ]+}', ['controller' => 'AddExpense', 'action' => 'limit']);
$router->add('api/limitSum/{category:[\wżźćńółęąśŻŹĆĄŚĘŁÓŃ ]+}/{date:[\d-]+}', ['controller' => 'Expense', 'action' => 'expenseMonthlySum']);

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('login', ['controller' => 'Login', 'action' => 'new']);
$router->add('logout', ['controller' => 'Login', 'action' => 'destroy']);
$router->add('password/reset/{token:[\da-f]+}', ['controller' => 'Password', 'action' => 'reset']);
$router->add('signup/activate/{token:[\da-f]+}', ['controller' => 'Signup', 'action' => 'activate']);
$router->add('addIncome', ['controller' => 'AddIncome', 'action' => 'new']);
$router->add('addExpense', ['controller' => 'AddExpense', 'action' => 'new']);
$router->add('viewBalanceSheet', ['controller' => 'ViewBalanceSheet', 'action' => 'index']);
$router->add('settings', ['controller' => 'Settings', 'action' => 'index']);
$router->add('{controller}/{action}');
    
$router->dispatch($_SERVER['QUERY_STRING']);
