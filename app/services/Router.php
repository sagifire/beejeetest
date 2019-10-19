<?php

namespace app\services;

class Router {
    public $rules = [];

    protected $_dispatcher = null;

    public function getDispatcher() {
        if (is_null($this->_dispatcher)) {
            $this->_dispatcher = \FastRoute\simpleDispatcher([$this, 'processRules']);

        }
        return $this->_dispatcher;
    }

    public function processRules(\FastRoute\RouteCollector $r) {
        foreach($this->rules as $rule) {
            $r->addRoute($rule[0], $rule[1], $rule[2]);
        }
    }
}