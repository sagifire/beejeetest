<?php

namespace app;

use app\services\Database;
use app\services\Router;
use app\services\Request;
use app\services\User;
use app\services\Validator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use app\contracts\InitiableService;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class Application
 *
 * Implements observer and MVC core
 *
 * @package app
 *
 * @property Router $router
 * @property Request $request
 * @property Response $response
 * @property Validator $validator
 * @property Session $session
 * @property User $user
 */
class Application
{
    /**
     * @var string
     */
    public $name = 'Application';

    /**
     * @var string
     */
    public $language = 'ru';

    /**
     * @var array services configs
     */
    public $services = [];

    /**
     * @var array
     */
    public $bootstrap = ['db'];

    /**
     * @var array default services config
     */
    protected $_defaultServices = [
        'router'    => ['class' => services\Router::class],
        'request'   => ['class' => Request::class],
        'response'  => ['class' => Response::class],
        'db'        => ['class' => Database::class],
        'validator' => ['class' => Validator::class],
        'session'   => ['class' => Session::class],
        'user'      => ['class' => User::class],
    ];

    /**
     * @var array service objects
     */
    protected $_serviceObjects = [];

    /**
     * @var Application|null
     */
    protected static $_instance = null;

    /**
     * Application constructor.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->configure($this, $config);
        self::$_instance = $this;
        $this->services = array_merge_recursive($this->_defaultServices, $this->services);

        foreach ($this->bootstrap as $name) {
            $this->initService($name);
        }
    }

    /**
     * Return application instance if it created already
     *
     * @return Application|null
     */
    public static function getInstance()
    {
        return self::$_instance;
    }

    /**
     * Configure object public state by config array
     *
     * @param $object
     * @param $config
     */
    public function configure($object, $config)
    {
        foreach ($config as $key => $value) {
            if (property_exists($object, $key)) {
                $object->{$key} = $value;
            }
        }
    }

    /**
     * add feature to get service object by name as property
     *
     * @param $name
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        $result = null;
        if (isset($this->_serviceObjects[$name])) {
            $result = $this->_serviceObjects[$name];
        } elseif (isset($this->services[$name])) {
            $result = $this->initService($name);
        }

        return $result;
    }

    /**
     * add service property support
     *
     * @param $name
     *
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->services[$name]) || isset($this->_serviceObjects[$name]);
    }

    /**
     * create and configure application service object from config
     *
     * @param $name
     *
     * @return mixed
     */
    protected function initService($name)
    {
        $config = $this->services[$name];
        $this->_serviceObjects[$name] = new $config['class'];
        $this->configure($this->_serviceObjects[$name], $config);
        if ($this->_serviceObjects[$name] instanceof InitiableService) {
            $this->_serviceObjects[$name]->init();
        }

        return $this->_serviceObjects[$name];
    }

    /**
     * Run the application
     */
    public function run()
    {
        try {
            $routeInfo = $this->router->getDispatcher()
                ->dispatch($this->request->getMethod(), $this->request->getPathInfo());
            switch ($routeInfo[0]) {
                case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                    //todo
                    $this->response->setStatusCode(405);
                    break;
                case \FastRoute\Dispatcher::FOUND:
                    $handler = $routeInfo[1];
                    $vars = $routeInfo[2];
                    list($class, $method) = explode("/", $handler, 2);

                    $this->runController($class, $method, $vars);
                    break;
                default:
                    $this->response->setStatusCode(404);
            }
        } catch (\Throwable $e) {
            var_dump($e);
            die();
        }

        $this->response->prepare($this->request);
        $this->response->send();
    }

    /**
     * Init and run controller's action
     *
     * @param $class
     * @param $method
     * @param $vars
     */
    public function runController($class, $method, $vars)
    {
        $class = '\\app\\controllers\\' . $class;
        /** @var ViewController $controller */
        $controller = new $class;
        $result = $controller->checkAccess($method);

        if (true === $result) {
            $result = call_user_func([$controller, $method], $vars);
        }

        if ($result instanceof Response) {
            $this->response = $result;
        } else {
            $this->response->setContent($result);
        }
    }
}