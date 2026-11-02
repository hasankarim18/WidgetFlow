<?php

namespace Hasan\Widgetflow\App\ThemeBuilder;

use Hasan\Widgetflow\Contracts\Module;

if (!defined('ABSPATH')) {
    exit;
}

class ArchiveTemplateLoader implements Module
{
    private AssignmentStore $store;

    public function __construct(?AssignmentStore $store = null)
    {
        $this->store = $store ?? new AssignmentStore();
    }

    public function register(): void
    {
        add_filter('template_include', [$this, 'maybe_use_template'], 99);
    }

    public function maybe_use_template($template)
    {
        // 1. Not safe to override? Change nothing.
        if (!TemplateGuard::can_override()) {
            return $template;
        }

        // 2. Is this a list page? Which post type is it for?
        $post_type = $this->current_archive_post_type();

        if ('' === $post_type) {
            return $template;
        }

        // 3. Which archive template did the admin choose for this post type?
        $template_id = $this->store->template_for($post_type, 'archive');

        // 4. None chosen, or it was deleted or unpublished? Use the theme's file.
        if (!TemplateGuard::is_usable($template_id)) {
            return $template;
        }

        // 5. Pass the ID to our file, and hand WordPress our file instead.
        set_query_var('wf_template_id', $template_id);

        return WIDGETFLOW_PATH . 'src/Templates/archive-loader.php';
    }

    /**
     * The post type of the list page being viewed, or '' if this is not
     * a list page.
     */
    private function current_archive_post_type(): string
    {
        if (is_post_type_archive()) {
            $object = get_queried_object();

            return ($object instanceof \WP_Post_Type) ? $object->name : '';
        }

        // The blog posts page is not a "post type archive" in WordPress.
        if (is_home() && !is_front_page()) {
            return 'post';
        }

        return '';
    }
}