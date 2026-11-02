<?php

namespace Hasan\Widgetflow\App\ThemeBuilder;

use Hasan\Widgetflow\Contracts\Module;

if (!defined('ABSPATH')) {
    exit;
}

class AssignmentsPage implements Module
{
    private const SLUG = 'wf-theme-builder';
    private const GROUP = 'wf_theme_builder';

    private AssignmentStore $store;

    public function __construct(?AssignmentStore $store = null)
    {
        $this->store = $store ?? new AssignmentStore();
    }

    public function register(): void
    {
        add_action('admin_menu', [$this, 'add_menu']);
        add_action('admin_init', [$this, 'register_setting']);
    }

    public function add_menu(): void
    {
        add_menu_page(
            esc_html__('WF Theme Builder', 'widgetflow'),
            esc_html__('WF Theme Builder', 'widgetflow'),
            'manage_options',
            self::SLUG,
            [$this, 'render_page'],
            'dashicons-layout',
            58
        );
    }

    public function register_setting(): void
    {
        register_setting(self::GROUP, AssignmentStore::OPTION, [
            'type' => 'array',
            'sanitize_callback' => [$this->store, 'sanitize'],
            'default' => [],
        ]);
    }

    public function render_page(): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        $templates = $this->store->available_templates();
        $archive_types = $this->store->archive_post_types();
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('WF Theme Builder', 'widgetflow'); ?></h1>
            <p>
                <?php esc_html_e('Choose the Elementor templates used for each post type.', 'widgetflow'); ?>
                <a href="<?php echo esc_url(admin_url('edit.php?post_type=elementor_library')); ?>">
                    <?php esc_html_e('Manage templates', 'widgetflow'); ?>
                </a>
            </p>

            <form method="post" action="options.php">
                <?php settings_fields(self::GROUP); ?>

                <table class="widefat striped" style="max-width:900px">
                    <thead>
                        <tr>
                            <th><?php esc_html_e('Post type', 'widgetflow'); ?></th>
                            <th><?php esc_html_e('Single template', 'widgetflow'); ?></th>
                            <th><?php esc_html_e('Archive template (all posts)', 'widgetflow'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($this->store->assignable_post_types() as $slug => $object): ?>
                            <tr>
                                <td><?php echo esc_html($object->labels->singular_name); ?></td>
                                <td><?php $this->render_select($slug, 'single', $templates, true); ?></td>
                                <td>
                                    <?php
                                    $this->render_select($slug, 'archive', $templates, isset($archive_types[$slug]));
                                    if (!isset($archive_types[$slug])) {
                                        echo '<br><small>' . esc_html__('No archive: enable "has_archive" for this post type.', 'widgetflow') . '</small>';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    /**
     * One template dropdown, plus an Edit link when a template is chosen.
     */
    private function render_select(string $slug, string $type, array $templates, bool $enabled): void
    {
        $current = $this->store->template_for($slug, $type);
        $name = AssignmentStore::OPTION . '[' . $slug . '][' . $type . ']';
        ?>
        <select name="<?php echo esc_attr($name); ?>" <?php disabled(!$enabled); ?>>
            <option value="0"><?php esc_html_e('— Theme default —', 'widgetflow'); ?></option>
            <?php foreach ($templates as $template): ?>
                <option value="<?php echo esc_attr($template->ID); ?>" <?php selected($current, $template->ID); ?>>
                    <?php echo esc_html($template->post_title); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if ($current): ?>
            <a href="<?php echo esc_url(admin_url('post.php?post=' . $current . '&action=elementor')); ?>">
                <?php esc_html_e('Edit', 'widgetflow'); ?>
            </a>
        <?php endif;
    }
}