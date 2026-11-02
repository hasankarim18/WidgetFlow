<?php

namespace Hasan\Widgetflow\App\ThemeBuilder;

use Hasan\Widgetflow\Contracts\Module;

if (!defined('ABSPATH')) {
    exit;
}

class SingleTemplateLoader implements Module
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
        // 1. Not a single page, or not safe to override? Change nothing.
        if (!is_singular() || !TemplateGuard::can_override()) {
            return $template;
        }

        // 2. Password-protected post? Keep WordPress's normal password form.
        if (post_password_required()) {
            return $template;
        }

        // 3. Which template did the admin choose for this post type?
        $template_id = $this->store->template_for((string) get_post_type(), 'single');

        // 4. None chosen, or it was deleted or unpublished? Use the theme's file.
        if (!TemplateGuard::is_usable($template_id)) {
            return $template;
        }

        // 5. Pass the ID to our file, and hand WordPress our file instead.
        set_query_var('wf_template_id', $template_id);

        return WIDGETFLOW_PATH . 'src/Templates/single-loader.php';
    }
}