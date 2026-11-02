<?php
if (!defined('ABSPATH')) {
    exit;
}

$template_id = (int) get_query_var('wf_template_id');

get_header();

while (have_posts()) {
    the_post();

    echo '<div class="wf-single-template">';
    echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display($template_id, true); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo '</div>';
}

get_footer();