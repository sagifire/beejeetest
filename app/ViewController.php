<?php

namespace app;

use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class ViewController
 *
 * @package app
 */
class ViewController
{
    const DEFAULT_PER_PAGE = 3;

    /**
     * @var string
     */
    public $layout = 'main';

    /**
     * @var string
     */
    public $pageTitle = '';

    /**
     * @var string[]
     */
    public $onlyAdminAccess = [];

    /**
     * @var string[]
     */
    public $onlyGuestAccess = [];

    /**
     * @param $action
     *
     * @return bool|RedirectResponse
     */
    public function checkAccess($action)
    {
        $user = Application::getInstance()->user;
        $status = true;
        if (in_array($action, $this->onlyAdminAccess) && $user->isGuest()) {
            $status = $this->redirect('/login');
        } elseif (in_array($action, $this->onlyGuestAccess) && $user->isAdmin()) {
            $status = $this->redirect('/');
        }

        return $status;
    }

    /**
     * @param $view
     * @param array $params
     *
     * @return false|string
     */
    public function render($view, $params = [])
    {
        $viewsDir = dirname(__DIR__) . '/views/';
        $classParts = explode('\\', get_class($this));
        $baseClassName = end($classParts);
        $viewFilePath = $viewsDir . strtolower($baseClassName) . '/' . $view . '.php';
        $content = $this->renderFile($viewFilePath, $params);
        if (!empty($this->layout)) {
            $params['content'] = $content;
            $layoutFilePath = $viewsDir . 'layout/' . $this->layout . '.php';
            $content = $this->renderFile($layoutFilePath, $params);
        }

        return $content;
    }

    /**
     * @param $url
     * @param int $code
     *
     * @return RedirectResponse
     */
    public function redirect($url, $code = 302)
    {
        return new RedirectResponse($url, $code);
    }

    /**
     * @param $filename
     * @param array $params
     *
     * @return false|string
     */
    public function renderFile($filename, $params = [])
    {
        extract($params);
        ob_start();
        require($filename);
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

}