<?php

namespace Hasan\Widgetflow\App\ThemeBuilder;

if (!defined('ABSPATH')) {
    exit;
}

class TemplateGuard
{
    /**
     * Is it safe to replace the theme's template on this request?
     */
    public static function can_override(): bool
    {
        if (!class_exists('\Elementor\Plugin')) {
            return false;
        }

        // Block themes don't use get_header() / get_footer().
        if (wp_is_block_theme()) {
            return false;
        }

        // Leave Elementor's own editor and preview alone.
        if (\Elementor\Plugin::$instance->preview->is_preview_mode()) {
            return false;
        }

        return true;
    }

    /**
     * Is this a real, published Elementor template?
     */
    public static function is_usable(int $template_id): bool
    {
        return $template_id
            && 'elementor_library' === get_post_type($template_id)
            && 'publish' === get_post_status($template_id);
    }
}