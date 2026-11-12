<?php
namespace Hasan\Widgetflow;

use Hasan\Widgetflow\App\AddCategory\AddCategory;
use Hasan\Widgetflow\App\BasicWidget\BasicWidget;
use Hasan\Widgetflow\App\Core\ElementorNotice;
use Hasan\Widgetflow\App\Core\WidgetRegistrar;
use Hasan\Widgetflow\App\HeadingWidget\HeadingWidget;
use Hasan\Widgetflow\App\HomePage\HomePage;
use Hasan\Widgetflow\App\LoadAssets\LoadAssets;
use Hasan\Widgetflow\App\ThemeBuilder\ArchiveTemplateLoader;
use Hasan\Widgetflow\App\ThemeBuilder\AssignmentsPage;
use Hasan\Widgetflow\App\ThemeBuilder\SingleTemplateLoader;
use Hasan\Widgetflow\Trait\Singleton;


if (!defined('ABSPATH')) {
    exit;
}


class Main
{
    use Singleton;

    public function init()
    {
        add_action('plugins_loaded', [$this, 'boot']);

        // add category

        // load_assets

    }


    public function boot()
    {


        foreach ($this->modules() as $module_class) {
            (new $module_class())->register();
        }

        //  add_action('elementor/widgets/register', [$this, 'register_new_widgets']);

    }

    private function modules(): array
    {
        if (!defined('ELEMENTOR_VERSION')) {
            return [
                ElementorNotice::class
            ];
        }

        return [
            LoadAssets::class,
            AddCategory::class,
            WidgetRegistrar::class,
            SingleTemplateLoader::class,
            AssignmentsPage::class,
            ArchiveTemplateLoader::class,
            HomePage::class
        ];
    }


}