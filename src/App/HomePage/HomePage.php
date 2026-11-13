<?php
namespace Hasan\Widgetflow\App\HomePage;

use Hasan\Widgetflow\App\HomePage\Hero\Hero;
use Hasan\Widgetflow\App\HomePage\LatestProperties\LatestProperties;
use Hasan\Widgetflow\Contracts\Module;

if (!defined('ABSPATH')) {
    exit;
}

class HomePage implements Module
{
    public function register(): void
    {
        add_action('elementor/widgets/register', [$this, 'register_homepage_widgets']);
    }

    public function register_homepage_widgets($widget_manager)
    {
        $widget_manager->register(new Hero());
        $widget_manager->register(new LatestProperties());
    }
}


?>