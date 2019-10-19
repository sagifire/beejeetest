<?php

namespace app\controllers;

use app\ViewController;
use app\Application;
use Illuminate\Support\MessageBag;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Class Site
 *
 * @package app\controllers
 */
class Site extends ViewController
{

    /**
     * @var string[]
     */
    public $onlyAdminAccess = ['logout'];

    /**
     * @var string[]
     */
    public $onlyGuestAccess = ['login'];

    /**
     * @return false|string|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function login()
    {
        $this->pageTitle = 'Форма входа';

        $errors = new MessageBag();
        $formData = new ParameterBag();

        $requestService = Application::getInstance()->request;

        if ($requestService->isPost()) {
            $formData = $requestService->request;
            /** @var \Illuminate\Validation\Validator $validator */
            $validator = Application::getInstance()->validator->make($formData->all(), [
                'username' => 'required|max:255',
                'password' => 'required|max:255',
            ]);

            if ($validator->passes()) {
                if (Application::getInstance()->user->login($formData)) {
                    Application::getInstance()->session->getFlashBag()->set('success', 'Добро пожаловать Админ!');

                    return $this->redirect('/');
                } else {
                    $errors->add('password', 'Неверная комбинация имени пользователя и пароля.');
                }

            } else {
                $errors = $validator->messages();
            }
        }

        return $this->render('login', [
            'formData' => $formData,
            'errors' => $errors,
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function logout()
    {
        Application::getInstance()->user->logout();

        return $this->redirect('/');
    }
}