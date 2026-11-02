<?php

namespace Hasan\Widgetflow\Trait;

if (!defined('ABSPATH')) {
    exit;
}

trait Singleton
{
    private static $instance = null;

    public static function instance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}