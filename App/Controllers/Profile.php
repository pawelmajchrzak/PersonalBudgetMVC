<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Flash;

class Profile extends Authenticated
{


    protected function before()
    {
        parent::before();

        $this->user = Auth::getUser();
    }


    public function showAction()
    {
        View::renderTemplate('Profile/show.html', [
            'user' => $this->user
        ]);
    }


    public function editAction()
    {
        View::renderTemplate('Profile/edit.html', [
            'user' => $this->user
        ]);
    }

    public function deleteIncomesAndExpensesAction()
    {
        View::renderTemplate('Profile/deleteIncomesAndExpenses.html', [
            'user' => $this->user
        ]);
    }

    public function deleteAccountAction()
    {
        View::renderTemplate('Profile/deleteAccount.html', [
            'user' => $this->user
        ]);
    }

    public function deleteIncomesAndExpensesNowAction()
    {
        if ($this->user->deleteIncomesAndExpenses()) {

            Flash::addMessage('Usunięto przychody i wydatki');

            $this->redirect('/profile/show');

        } else {

            View::renderTemplate('Profile/deleteIncomesAndExpenses.html', [
                'user' => $this->user
            ]);

        }
        

    }

    public function deleteAccountNowAction()
    {
        if ($this->user->deleteAccount()) {

            Flash::addMessage('Usunięto konto');

            Auth::logout();

            $this->redirect('/login/show-logout-message');

            

        } else {

            View::renderTemplate('Profile/deleteAccount.html', [
                'user' => $this->user
            ]);

        }

    }


    public function updateAction()
    {
        if ($this->user->updateProfile($_POST)) {

            Flash::addMessage('Zapisano zmiany');

            $this->redirect('/profile/show');

        } else {

            View::renderTemplate('Profile/edit.html', [
                'user' => $this->user
            ]);

        }
    }
}
