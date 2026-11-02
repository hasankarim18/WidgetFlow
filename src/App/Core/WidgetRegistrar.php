<?php

namespace Hasan\Widgetflow\App\Core;

use Hasan\Widgetflow\App\BasicWidget\BasicWidget;
use Hasan\Widgetflow\App\HeadingWidget\HeadingWidget;

use Hasan\Widgetflow\Contracts\Module;

if (!defined('ABSPATH')) {
    exit;
}

class WidgetRegistrar implements Module
{
    public function register(): void
    {
        add_action('elementor/widgets/register', [$this, 'register_new_widgets']);

    }

    public function register_new_widgets($widget_manager)
    {
        $widget_manager->register(new BasicWidget());
        $widget_manager->register(new HeadingWidget());
    }
}