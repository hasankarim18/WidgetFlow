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
        add_action('wp_enqueue_scripts', [$this, 'register_styles'], 5);
        add_action('elementor/editor/after_enqueue_styles', [$this, 'register_styles']);
        add_action('elementor/preview/enqueue_styles', [$this, 'register_styles']);
    }

    public function register_styles(): void
    {
        wp_register_style(
            'wf-single-property',
            WIDGETFLOW_URL . 'assets/css/single-property.css',
            [],
            WIDGETFLOW_VERSION // or filemtime(WIDGETFLOW_PATH . 'assets/css/single-property.css')
        );

        wp_register_style(
            'wf-home-page-property',
            WIDGETFLOW_URL . 'assets/css/home-page.css',
            [],
            WIDGETFLOW_VERSION
        );
    }
}