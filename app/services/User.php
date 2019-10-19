<?php

namespace app\services;

use app\Application;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Class User
 *
 * @package app\services
 */
class User {
    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $password;

    /**
     * @return bool
     */
    public function isAdmin() {
        return Application::getInstance()->session->get('is_admin', false);
    }

    /**
     * @return bool
     */
    public function isGuest() {
        return !$this->isAdmin();
    }

    /**
     * @param ParameterBag $data
     *
     * @return bool
     */
    public function login(ParameterBag $data) {
        $status = false;
        if ($data->get('password') === $this->password && $data->get('username') === $this->username) {
            $status = true;
            Application::getInstance()->session->set('is_admin', true);
        }
        return $status;
    }

    public function logout() {
        Application::getInstance()->session->remove('is_admin');
    }


}