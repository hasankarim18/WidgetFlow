<?php

namespace Hasan\Widgetflow\App\HomePage\Hero;
if (!defined('ABSPATH')) {
    exit;
}

trait TabContentControl
{

    protected function register_content_control()
    {
        $this->start_controls_section('content_section', [
            'label' => esc_html__('Content'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('title', [
            'label' => esc_html__('Title'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'dynamic' => ['active' => true],
            'default' => esc_html__('This is hero widget'),
            'label_block' => true,
        ]);

        $this->end_controls_section();

    }
}

