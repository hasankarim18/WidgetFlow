<?php

namespace Hasan\Widgetflow\App\HomePage\Hero;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) {
    exit;
}

trait TabStyleControl
{
    /**
     * Build typography defaults (desktop / tablet / mobile) so the panel
     * starts with the same values the design uses.
     *
     * $a keys: size, size_tablet, size_mobile, weight, line (em), spacing(px) [+ _tablet/_mobile], transform
     */
    protected function wf_typography_fields(array $a): array
    {
        $px = static fn($v) => ['unit' => 'px', 'size' => $v];

        $fields = [
            'typography' => ['default' => 'custom'],
            'font_size' => [
                'default' => $px($a['size']),
                'tablet_default' => $px($a['size_tablet'] ?? $a['size']),
                'mobile_default' => $px($a['size_mobile'] ?? $a['size_tablet'] ?? $a['size']),
            ],
            'font_weight' => ['default' => $a['weight']],
        ];

        if (isset($a['line'])) {
            $em = ['unit' => 'em', 'size' => $a['line']];
            $fields['line_height'] = ['default' => $em, 'tablet_default' => $em, 'mobile_default' => $em];
        }

        if (isset($a['spacing'])) {
            $fields['letter_spacing'] = [
                'default' => $px($a['spacing']),
                'tablet_default' => $px($a['spacing_tablet'] ?? $a['spacing']),
                'mobile_default' => $px($a['spacing_mobile'] ?? $a['spacing_tablet'] ?? $a['spacing']),
            ];
        }

        if (isset($a['transform'])) {
            $fields['text_transform'] = ['default' => $a['transform']];
        }

        return $fields;
    }

    protected function wf_box(int $t, int $r, int $b, int $l): array
    {
        return [
            'top' => (string) $t,
            'right' => (string) $r,
            'bottom' => (string) $b,
            'left' => (string) $l,
            'unit' => 'px',
            'isLinked' => false,
        ];
    }

    protected function register_style_controls(): void
    {
        /* ================= Eyebrow ================= */
        $this->start_controls_section('style_eyebrow', [
            'label' => esc_html__('Eyebrow', 'widgetflow'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('eyebrow_color', [
            'label' => esc_html__('Color', 'widgetflow'),
            'type' => Controls_Manager::COLOR,
            'default' => '#e8a33d',
            'selectors' => ['{{WRAPPER}} .wf-eyebrow' => 'color: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'eyebrow_typography',
            'selector' => '{{WRAPPER}} .wf-eyebrow',
            'fields_options' => $this->wf_typography_fields([
                'size' => 10,
                'weight' => '800',
                'spacing' => 1.3,
                'transform' => 'uppercase',
            ]),
        ]);

        $this->end_controls_section();

        /* ================= Title ================= */
        $this->start_controls_section('style_title', [
            'label' => esc_html__('Title', 'widgetflow'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('title_color', [
            'label' => esc_html__('Color', 'widgetflow'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => ['{{WRAPPER}} .wf-hero__title' => 'color: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'title_typography',
            'selector' => '{{WRAPPER}} .wf-hero__title',
            'fields_options' => $this->wf_typography_fields([
                'size' => 54,
                'size_tablet' => 44,
                'size_mobile' => 40,
                'weight' => '700',
                'line' => 1.03,
                'spacing' => -3,
                'spacing_tablet' => -2.2,
                'spacing_mobile' => -2,
                'transform' => 'none',
            ]),
        ]);

        $this->end_controls_section();

        /* ================= Description ================= */
        $this->start_controls_section('style_description', [
            'label' => esc_html__('Description', 'widgetflow'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('description_color', [
            'label' => esc_html__('Color', 'widgetflow'),
            'type' => Controls_Manager::COLOR,
            'default' => '#c7d7da',
            'selectors' => ['{{WRAPPER}} .wf-hero__text' => 'color: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'description_typography',
            'selector' => '{{WRAPPER}} .wf-hero__text',
            'fields_options' => $this->wf_typography_fields([
                'size' => 14,
                'size_tablet' => 14,
                'size_mobile' => 12,
                'weight' => '400',
                'line' => 1.7,
            ]),
        ]);

        $this->end_controls_section();

        /* ================= Primary button ================= */
        $this->start_controls_section('style_primary_button', [
            'label' => esc_html__('Primary Button', 'widgetflow'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'primary_typography',
            'selector' => '{{WRAPPER}} .wf-btn--primary',
            'fields_options' => $this->wf_typography_fields([
                'size' => 11,
                'weight' => '700',
                'line' => 1.2,
            ]),
        ]);

        $this->start_controls_tabs('primary_button_tabs');

        $this->start_controls_tab('primary_button_normal', [
            'label' => esc_html__('Normal', 'widgetflow'),
        ]);
        $this->add_control('primary_text_color', [
            'label' => esc_html__('Text Color', 'widgetflow'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => ['{{WRAPPER}} .wf-btn--primary' => 'color: {{VALUE}};'],
        ]);
        $this->add_control('primary_bg_color', [
            'label' => esc_html__('Background Color', 'widgetflow'),
            'type' => Controls_Manager::COLOR,
            'default' => '#0b5d6b',
            'selectors' => ['{{WRAPPER}} .wf-btn--primary' => 'background-color: {{VALUE}};'],
        ]);
        $this->end_controls_tab();

        $this->start_controls_tab('primary_button_hover', [
            'label' => esc_html__('Hover', 'widgetflow'),
        ]);
        $this->add_control('primary_text_color_hover', [
            'label' => esc_html__('Text Color', 'widgetflow'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .wf-btn--primary:hover, {{WRAPPER}} .wf-btn--primary:focus' => 'color: {{VALUE}};',
            ],
        ]);
        $this->add_control('primary_bg_color_hover', [
            'label' => esc_html__('Background Color', 'widgetflow'),
            'type' => Controls_Manager::COLOR,
            'default' => '#084b57',
            'selectors' => [
                '{{WRAPPER}} .wf-btn--primary:hover, {{WRAPPER}} .wf-btn--primary:focus' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control('primary_padding', [
            'label' => esc_html__('Padding', 'widgetflow'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'default' => $this->wf_box(10, 15, 10, 15),
            'tablet_default' => $this->wf_box(10, 15, 10, 15),
            'mobile_default' => $this->wf_box(10, 15, 10, 15),
            'selectors' => [
                '{{WRAPPER}} .wf-btn--primary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before',
        ]);

        $this->add_responsive_control('primary_radius', [
            'label' => esc_html__('Border Radius', 'widgetflow'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default' => $this->wf_box(7, 7, 7, 7),
            'tablet_default' => $this->wf_box(7, 7, 7, 7),
            'mobile_default' => $this->wf_box(7, 7, 7, 7),
            'selectors' => [
                '{{WRAPPER}} .wf-btn--primary' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('actions_gap', [
            'label' => esc_html__('Space Between Buttons', 'widgetflow'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => ['px' => ['min' => 0, 'max' => 80]],
            'default' => ['unit' => 'px', 'size' => 18],
            'tablet_default' => ['unit' => 'px', 'size' => 18],
            'mobile_default' => ['unit' => 'px', 'size' => 13],
            'selectors' => ['{{WRAPPER}} .wf-hero__actions' => 'gap: {{SIZE}}{{UNIT}};'],
        ]);

        $this->end_controls_section();

        /* ================= Secondary link ================= */
        $this->start_controls_section('style_secondary_link', [
            'label' => esc_html__('Secondary Link', 'widgetflow'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'secondary_typography',
            'selector' => '{{WRAPPER}} .wf-hero__link',
            'fields_options' => $this->wf_typography_fields([
                'size' => 11,
                'weight' => '700',
            ]),
        ]);

        $this->start_controls_tabs('secondary_link_tabs');

        $this->start_controls_tab('secondary_link_normal', [
            'label' => esc_html__('Normal', 'widgetflow'),
        ]);
        $this->add_control('secondary_color', [
            'label' => esc_html__('Color', 'widgetflow'),
            'type' => Controls_Manager::COLOR,
            'default' => '#e6f1f2',
            'selectors' => ['{{WRAPPER}} .wf-hero__link' => 'color: {{VALUE}};'],
        ]);
        $this->end_controls_tab();

        $this->start_controls_tab('secondary_link_hover', [
            'label' => esc_html__('Hover', 'widgetflow'),
        ]);
        $this->add_control('secondary_color_hover', [
            'label' => esc_html__('Color', 'widgetflow'),
            'type' => Controls_Manager::COLOR,
            'default' => '#e8a33d',
            'selectors' => [
                '{{WRAPPER}} .wf-hero__link:hover, {{WRAPPER}} .wf-hero__link:focus' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /* ================= Banner ================= */
        $this->start_controls_section('style_banner', [
            'label' => esc_html__('Banner', 'widgetflow'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('banner_height', [
            'label' => esc_html__('Height', 'widgetflow'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'vh'],
            'range' => [
                'px' => ['min' => 120, 'max' => 700],
                'vh' => ['min' => 10, 'max' => 100],
            ],
            'default' => ['unit' => 'px', 'size' => 265],
            'tablet_default' => ['unit' => 'px', 'size' => 230],
            'mobile_default' => ['unit' => 'px', 'size' => 178],
            'selectors' => ['{{WRAPPER}} .wf-art' => 'height: {{SIZE}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('banner_radius', [
            'label' => esc_html__('Border Radius', 'widgetflow'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default' => $this->wf_box(14, 14, 14, 14),
            'tablet_default' => $this->wf_box(14, 14, 14, 14),
            'mobile_default' => $this->wf_box(14, 14, 14, 14),
            'selectors' => [
                '{{WRAPPER}} .wf-art' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('banner_position', [
            'label' => esc_html__('Image Position', 'widgetflow'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'center center' => esc_html__('Center', 'widgetflow'),
                'top center' => esc_html__('Top', 'widgetflow'),
                'bottom center' => esc_html__('Bottom', 'widgetflow'),
                'left center' => esc_html__('Left', 'widgetflow'),
                'right center' => esc_html__('Right', 'widgetflow'),
            ],
            'default' => 'center center',
            'tablet_default' => 'center center',
            'mobile_default' => 'center center',
            'selectors' => ['{{WRAPPER}} .wf-art__image img' => 'object-position: {{VALUE}};'],
        ]);

        $this->end_controls_section();

        /* ================= Banner caption ================= */
        $this->start_controls_section('style_caption', [
            'label' => esc_html__('Banner Caption', 'widgetflow'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => ['show_caption' => 'yes'],
        ]);

        $this->add_control('caption_title_color', [
            'label' => esc_html__('Title Color', 'widgetflow'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => ['{{WRAPPER}} .wf-art__caption-title' => 'color: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'caption_title_typography',
            'selector' => '{{WRAPPER}} .wf-art__caption-title',
            'fields_options' => $this->wf_typography_fields([
                'size' => 13,
                'weight' => '700',
            ]),
        ]);

        $this->add_control('caption_text_color', [
            'label' => esc_html__('Text Color', 'widgetflow'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .wf-art__caption-text, {{WRAPPER}} .wf-art__caption-icon' => 'color: {{VALUE}};',
            ],
            'separator' => 'before',
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'caption_text_typography',
            'selector' => '{{WRAPPER}} .wf-art__caption-text',
            'fields_options' => $this->wf_typography_fields([
                'size' => 10,
                'weight' => '400',
            ]),
        ]);

        $this->end_controls_section();
    }
}