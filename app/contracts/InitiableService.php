<?php

namespace app\contracts;

/**
 * Interface InitiableService
 *
 * @package app\contracts
 */
interface InitiableService
{
    /**
     * @return void
     */
    public function init();
}