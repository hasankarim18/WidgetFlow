<?php

namespace Hasan\Widgetflow\App\Core;

use Hasan\Widgetflow\App\AddCategory\AddCategory;
use Hasan\Widgetflow\App\AgentProfile\AgentProfile;
use Hasan\Widgetflow\App\AllAGents\AllAGents;
use Hasan\Widgetflow\App\BasicWidget\BasicWidget;
use Hasan\Widgetflow\App\ClientsTestimonials\ClientsTestimonials;
use Hasan\Widgetflow\App\HeadingWidget\HeadingWidget;
use Hasan\Widgetflow\App\PropertyArchive\PropertyArchive;
use Hasan\Widgetflow\App\PropertySlider\PropertySlider;
use Hasan\Widgetflow\App\PropertyWidgets\PropertyTitle\PropertyTitle;
use Hasan\Widgetflow\App\SingleProperty\SingleProperty;
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
        $widget_manager->register(new SingleProperty());
        $widget_manager->register(new PropertyArchive());
        $widget_manager->register(new AgentProfile());
        $widget_manager->register(new AllAGents());
        $widget_manager->register(new PropertySlider());
        $widget_manager->register(new ClientsTestimonials());
        $widget_manager->register(new PropertyTitle());
    }
}