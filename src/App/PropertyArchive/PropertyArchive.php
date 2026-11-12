<?php

namespace Hasan\Widgetflow\App\PropertyArchive;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    exit;
}

/** Minimal example: a text setting with a small set of style controls. */
class PropertyArchive extends Widget_Base
{
    public function get_name(): string
    {
        return 'wf_property_archieve';
    }

    public function get_title(): string
    {
        return esc_html__('WF Property Archieve');
    }

    public function get_icon(): string
    {
        return 'eicon-posts-justified';
    }

    public function get_categories(): array
    {
        return ['widgetflow'];
    }

    public function get_keywords(): array
    {
        return ['basic', 'text', 'widgetflow', 'wf', 'property'];
    }

    protected function register_controls(): void
    {
        $this->start_controls_section('content_section', [
            'label' => esc_html__('Content'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('title', [
            'label' => esc_html__('Title'),
            'type' => Controls_Manager::TEXT,
            'dynamic' => ['active' => true],
            'default' => esc_html__('Your title here'),
            'label_block' => true,
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_section', [
            'label' => esc_html__('Style'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('text_color', [
            'label' => esc_html__('Text Color'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .wf-basic-title' => 'color: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'typography',
            'selector' => '{{WRAPPER}} .wf-basic-title',
        ]);

        $this->end_controls_section();
    }

    protected function render(): void
    {
        $settings = $this->get_settings_for_display();
        $title = isset($settings['title']) ? $settings['title'] : '';

        if ('' === trim($title)) {
            return;
        }
        ?>
        <div class="wf-basic-widget">
            <p class="wf-basic-title"><?php echo esc_html($title); ?></p>
        </div>
        <?php
    }
}