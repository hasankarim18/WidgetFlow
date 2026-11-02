<?php
if (!defined('ABSPATH')) {
    exit;
}

$template_id = (int) get_query_var('wf_template_id');

get_header();

echo '<div class="wf-archive-template">';
echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display($template_id, true); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo '</div>';

get_footer();