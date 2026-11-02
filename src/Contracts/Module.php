<?php

namespace Hasan\Widgetflow\Contracts;



if (!defined('ABSPATH')) {
    exit;
}

interface Module
{
    /**
     * Attach this module's hooks to WordPress.
     */
    public function register(): void;
}
