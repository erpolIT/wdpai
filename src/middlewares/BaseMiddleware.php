<?php

namespace middlewares;

abstract class BaseMiddleware
{
    abstract public function execute($action);
}