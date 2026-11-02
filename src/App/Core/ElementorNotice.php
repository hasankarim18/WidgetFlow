<?php

namespace Hasan\Widgetflow\App\Core;

use Hasan\Widgetflow\Contracts\Module;

if (!defined('ABSPATH')) {
    exit;
}

class ElementorNotice implements Module
{
    public function register(): void
    {
        add_action('admin_notices', [$this, 'render']);
    }


    public function render(): void
    {
        if (!current_user_can('activate_plugins')) {
            return;
        }

        echo '<div class="notice notice-warning"><p>'
            . esc_html__('Widgetflow requires Elementor to be installed and active.', 'widgetflow')
            . '</p></div>';

    }

}