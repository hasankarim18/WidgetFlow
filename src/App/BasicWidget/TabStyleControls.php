<?php

namespace Hasan\Widgetflow\App\BasicWidget;

if (!defined('ABSPATH')) {
    exit;
}


trait TabStyleControls
{
    protected function register_style_controls()
    {
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style', 'textdomain'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'box_style_options',
            [
                'label' => esc_html__('Text Box Styling'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'margin',
            [
                'label' => esc_html__('Padding', 'textdomain'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'em',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wf_basic_widget_title_box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // 1.2 box background color

        $this->add_control(
            'box_bg_color',
            [
                'label' => esc_html__('Background Color'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wf_basic_widget_title_box' => 'background-color: {{VALUE}}',
                ],
            ]
        );



        $this->add_control(
            'text_style_options',
            [
                'label' => esc_html__('Text Styling'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );


        // controls go here
        // #1 Color
        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Text Color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wf_basic_widget_title' => 'color: {{VALUE}}',
                ],
            ]
        );

        // #2 Typography group control
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .wf_basic_widget_title',
            ]
        );
        $this->end_controls_section();
    }
}
