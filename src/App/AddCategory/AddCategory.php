<?php


namespace Hasan\Widgetflow\App\AddCategory;

use Hasan\Widgetflow\Contracts\Module as ContractsModule;
use Module;

if (!defined('ABSPATH')) {
    exit;
}


class AddCategory implements ContractsModule
{
    public function register(): void
    {


        add_action(
            'elementor/elements/categories_registered',
            [$this, 'add_elementor_widget_categories'],
            0,
            1
        );
    }

    function add_elementor_widget_categories($elements_manager)
    {



        $elements_manager->add_category(
            'properties',
            [
                'title' => esc_html__('Properties', 'widgetflow'),
                'icon' => 'fa fa-plug',
            ]
        );
        $elements_manager->add_category(
            'property_home_page',
            [
                'title' => esc_html__('Propery Home Page', WF_TXT_DOMAIN),
                'icon' => 'eicon-apps',
            ]
        );
        // $elements_manager->add_category(
        // 	'second-category',
        // 	[
        // 		'title' => esc_html__( 'Second Category', 'textdomain' ),
        // 		'icon' => 'fa fa-plug',
        // 	]
        // );

    }
}