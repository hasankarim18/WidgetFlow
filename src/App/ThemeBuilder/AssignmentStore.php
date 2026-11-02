<?php

namespace Hasan\Widgetflow\App\ThemeBuilder;

if (!defined('ABSPATH')) {
    exit;
}

class AssignmentStore
{
    public const OPTION = 'wf_template_assignments';
    public const TYPES = ['single', 'archive'];

    /**
     * All assignments as ['post_type' => ['single' => id, 'archive' => id]].
     * Old data saved as ['post_type' => id] is converted automatically.
     */
    public function all(): array
    {
        $value = get_option(self::OPTION, []);

        if (!is_array($value)) {
            return [];
        }

        $result = [];

        foreach ($value as $post_type => $entry) {
            if (is_array($entry)) {
                $result[$post_type] = [
                    'single' => (int) ($entry['single'] ?? 0),
                    'archive' => (int) ($entry['archive'] ?? 0),
                ];
            } else {
                $result[$post_type] = ['single' => (int) $entry, 'archive' => 0];
            }
        }

        return $result;
    }

    /**
     * Template ID for a post type and type ('single' or 'archive'), or 0.
     */
    public function template_for(string $post_type, string $type): int
    {
        $all = $this->all();

        return $all[$post_type][$type] ?? 0;
    }

    /**
     * Post types that can receive a single template.
     */
    public function assignable_post_types(): array
    {
        $types = get_post_types(['public' => true], 'objects');
        unset($types['attachment'], $types['elementor_library']);

        return $types;
    }

    /**
     * Post types that also have an archive page.
     */
    public function archive_post_types(): array
    {
        return array_filter(
            $this->assignable_post_types(),
            static fn($object) => 'post' === $object->name || !empty($object->has_archive)
        );
    }

    /**
     * Elementor library templates that can be assigned.
     */
    public function available_templates(): array
    {
        return get_posts([
            'post_type' => 'elementor_library',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' => [
                [
                    'key' => '_elementor_template_type',
                    'value' => ['page', 'container'],
                    'compare' => 'IN',
                ],
            ],
        ]);
    }

    /**
     * Clean submitted form data before it is saved.
     */
    public function sanitize($input): array
    {
        $clean = [];

        if (!is_array($input)) {
            return $clean;
        }

        $single_types = $this->assignable_post_types();
        $archive_types = $this->archive_post_types();

        foreach ($single_types as $slug => $object) {
            $entry = isset($input[$slug]) && is_array($input[$slug]) ? $input[$slug] : [];
            $row = ['single' => 0, 'archive' => 0];

            foreach (self::TYPES as $type) {
                $id = absint($entry[$type] ?? 0);

                if ('archive' === $type && !isset($archive_types[$slug])) {
                    continue;
                }

                if ($id && 'elementor_library' === get_post_type($id)) {
                    $row[$type] = $id;
                }
            }

            if ($row['single'] || $row['archive']) {
                $clean[$slug] = $row;
            }
        }

        return $clean;
    }
}