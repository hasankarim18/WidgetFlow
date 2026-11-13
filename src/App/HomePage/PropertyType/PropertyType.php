<?php

namespace Hasan\Widgetflow\App\HomePage\PropertyType;


use Elementor\Widget_Base;


if (!defined('ABSPATH')) {
    exit;
}

/** Minimal example: a text setting with a small set of style controls. */
class PropertyType extends Widget_Base
{
    use TabContentControl;
    use TabStyleControl;
    public function get_name(): string
    {
        return 'wf_hp_property_type';
    }

    public function get_title(): string
    {
        return esc_html__('WF Hp Property Types');
    }

    public function get_icon(): string
    {
        return 'eicon-editor-list-ol';
    }

    public function get_categories(): array
    {
        return ['widgetflow', 'property_home_page'];
    }

    public function get_keywords(): array
    {
        return ['wf', 'property type', 'property_type', 'wfpt', 'wf pt', 'hp', 'widgetflow', 'pt'];
    }


    protected function register_controls(): void
    {

        $this->register_content_controls();
        $this->register_style_controls();

    }

    protected function render(): void
    {
        $settings = $this->get_settings_for_display();
        $title = isset($settings['title']) ? $settings['title'] : '';

        if ('' === trim($title)) {
            return;
        }
        ?>
        <section class="wf-widget wf-section wf-types" aria-labelledby="wf-types-title">
            <div class="wf-container">
                <div class="wf-heading">
                    <div>
                        <p class="wf-kicker">Start with what you need</p>
                        <h2 class="wf-heading__title" id="wf-types-title">Browse by property type</h2>
                        <p class="wf-heading__desc">Explore the kinds of places available in the directory.</p>
                    </div>
                </div>
                <!-- property loop -->
                <?php
                $types = get_terms([
                    'taxonomy' => 'property_type',
                    'hide_empty' => false,
                    'orderby' => 'name',
                    'order' => 'ASC'
                ]);
                // Icon per term slug; anything not listed falls back to the default.
                $type_icons = array(
                    'apartment' => '⌂',
                    'villa' => '⌂',
                    'house' => '⌂',
                    'office' => '▦',
                    'commercial-building' => '▦',
                    'land' => '▱',
                );
                $default_icon = '⌂';

                ?>

                <?php
                if (!empty($types) && !is_wp_error($types)) {
                    ?>
                    <div class="wf-types__grid">
                        <?php foreach ($types as $type):
                            $link = get_term_link($type);
                            if (is_wp_error($link)) {
                                continue;
                            }
                            $icon = $type_icons[$type->slug] ?? $default_icon;
                            ?>
                            <a class="wf-type" href="<?php echo esc_url($link); ?>"><span class="wf-type__icon" aria-hidden="true">
                                    <?php echo esc_html($icon); ?>
                                </span><span class="wf-type__name">
                                    <?php echo esc_html($type->name); ?> <span aria-hidden="true">→</span></span></a>
                            <?php

                        endforeach; ?>


                    </div>
                    <?php
                }

                ?>

                <!-- property loop ends -->

            </div>
        </section>
        <?php
    }
}