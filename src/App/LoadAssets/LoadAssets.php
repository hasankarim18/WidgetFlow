<?php

namespace Hasan\Widgetflow\App\LoadAssets;

use Hasan\Widgetflow\Contracts\Module;

if (!defined('ABSPATH')) {
    exit;
}

class LoadAssets implements Module
{
    public function register(): void
    {
        error_log(WIDGETFLOW_URL . 'assets/css/single-property.css');
        add_action(
            'elementor/frontend/before_register_styles',
            [$this, 'wf_plugin_register_frontend_styles']
        );
    }

    public function wf_plugin_register_frontend_styles()
    {
        // error_log('load assets register');
        wp_register_style(
            'wf-single-property',
            WIDGETFLOW_URL . 'assets/css/single-property.css'
        );
    }
}