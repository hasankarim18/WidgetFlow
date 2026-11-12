<?php

namespace Hasan\Widgetflow\App\HomePage\Hero;

if (!defined('ABSPATH')) {
    exit;
}

trait TabStyleControl
{
    protected function register_style_controls()
    {
        $this->start_controls_section('style_section', [
            'label' => esc_html__('Style'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('text_color', [
            'label' => esc_html__('Text Color'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .wf-basic-title' => 'color: {{VALUE}};'],
        ]);

        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), [
            'name' => 'typography',
            'selector' => '{{WRAPPER}} .wf-basic-title',
        ]);

        $this->end_controls_section();
    }
}