<?php

namespace Hasan\Widgetflow\App\HeadingWidget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    exit;
}

class HeadingWidget extends Widget_Base
{
    public function get_name(): string
    {
        return 'wf_heading';
    }

    public function get_title(): string
    {
        return esc_html__('WFS Heading', 'widgetflow');
    }

    public function get_icon(): string
    {
        return 'eicon-heading';
    }

    public function get_categories(): array
    {
        return ['basic', 'properties', 'general'];
    }

    public function get_keywords(): array
    {
        return ['heading', 'title', 'text', 'wf', 'widgetflow'];
    }

    protected function register_controls(): void
    {
        $this->start_controls_section('content_section', [
            'label' => esc_html__('Heading', 'widgetflow'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('title', [
            'label' => esc_html__('Title', 'widgetflow'),
            'type' => Controls_Manager::TEXT,
            'dynamic' => ['active' => true],
            'default' => esc_html__('Add Your Heading Text Here', 'widgetflow'),
            'placeholder' => esc_html__('Enter your heading', 'widgetflow'),
            'label_block' => true,
        ]);

        $this->add_control('html_tag', [
            'label' => esc_html__('HTML Tag', 'widgetflow'),
            'type' => Controls_Manager::SELECT,
            'default' => 'h2',
            'options' => [
                'h1' => 'H1',
                'h2' => 'H2',
                'h3' => 'H3',
                'h4' => 'H4',
                'h5' => 'H5',
                'h6' => 'H6',
                'div' => 'div',
                'span' => 'span',
                'p' => 'p',
            ],
        ]);

        $this->add_responsive_control('alignment', [
            'label' => esc_html__('Alignment', 'widgetflow'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => ['title' => esc_html__('Left', 'widgetflow'), 'icon' => 'eicon-text-align-left'],
                'center' => ['title' => esc_html__('Center', 'widgetflow'), 'icon' => 'eicon-text-align-center'],
                'right' => ['title' => esc_html__('Right', 'widgetflow'), 'icon' => 'eicon-text-align-right'],
                'justify' => ['title' => esc_html__('Justified', 'widgetflow'), 'icon' => 'eicon-text-align-justify'],
            ],
            'selectors' => ['{{WRAPPER}} .wf-heading-title' => 'text-align: {{VALUE}};'],
        ]);

        $this->add_control('link', [
            'label' => esc_html__('Link', 'widgetflow'),
            'type' => Controls_Manager::URL,
            'dynamic' => ['active' => true],
            'placeholder' => 'https://example.com',
            'options' => ['url', 'is_external', 'nofollow'],
            'separator' => 'before',
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_section', [
            'label' => esc_html__('Style', 'widgetflow'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('text_color', [
            'label' => esc_html__('Text Color', 'widgetflow'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .wf-heading-title' => 'color: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'typography',
            'selector' => '{{WRAPPER}} .wf-heading-title',
        ]);

        $this->add_group_control(Group_Control_Text_Stroke::get_type(), [
            'name' => 'text_stroke',
            'selector' => '{{WRAPPER}} .wf-heading-title',
        ]);

        $this->add_group_control(Group_Control_Text_Shadow::get_type(), [
            'name' => 'text_shadow',
            'selector' => '{{WRAPPER}} .wf-heading-title',
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'background',
            'types' => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .wf-heading-title',
            'separator' => 'before',
        ]);

        $this->add_responsive_control('padding', [
            'label' => esc_html__('Padding', 'widgetflow'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em', 'rem', 'custom'],
            'selectors' => ['{{WRAPPER}} .wf-heading-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'border',
            'selector' => '{{WRAPPER}} .wf-heading-title',
        ]);

        $this->add_responsive_control('border_radius', [
            'label' => esc_html__('Border Radius', 'widgetflow'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em', 'rem', 'custom'],
            'selectors' => ['{{WRAPPER}} .wf-heading-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'box_shadow',
            'selector' => '{{WRAPPER}} .wf-heading-title',
        ]);

        $this->add_control('blend_mode', [
            'label' => esc_html__('Blend Mode', 'widgetflow'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                '' => esc_html__('Normal', 'widgetflow'),
                'multiply' => 'Multiply',
                'screen' => 'Screen',
                'overlay' => 'Overlay',
                'darken' => 'Darken',
                'lighten' => 'Lighten',
                'color-dodge' => 'Color Dodge',
                'color-burn' => 'Color Burn',
                'difference' => 'Difference',
                'exclusion' => 'Exclusion',
                'hue' => 'Hue',
                'saturation' => 'Saturation',
                'color' => 'Color',
                'luminosity' => 'Luminosity',
            ],
            'selectors' => ['{{WRAPPER}} .wf-heading-title' => 'mix-blend-mode: {{VALUE}};'],
        ]);

        $this->add_responsive_control('margin', [
            'label' => esc_html__('Margin', 'widgetflow'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em', 'rem', 'custom'],
            'selectors' => ['{{WRAPPER}} .wf-heading-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
            'separator' => 'before',
        ]);

        $this->end_controls_section();
    }

    protected function render(): void
    {
        $settings = $this->get_settings_for_display();
        $tag = isset($settings['html_tag']) ? $settings['html_tag'] : 'h2';
        $allowed_tags = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'span', 'p'];
        if (!in_array($tag, $allowed_tags, true)) {
            $tag = 'h2';
        }

        $title = isset($settings['title']) ? $settings['title'] : '';
        $has_link = !empty($settings['link']['url']);
        $this->add_render_attribute('heading', 'class', 'wf-heading-title');
        if ($has_link) {
            $this->add_link_attributes('heading_link', $settings['link']);
        }
        ?>
        <<?php echo esc_attr($tag); ?>         <?php $this->print_render_attribute_string('heading'); ?>>
            <?php if ($has_link): ?>
                <a <?php $this->print_render_attribute_string('heading_link'); ?>><?php echo esc_html($title); ?></a>
            <?php else: ?>
                <?php echo esc_html($title); ?>
            <?php endif; ?>
        </<?php echo esc_attr($tag); ?>>
        <?php
    }
}
