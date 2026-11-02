<?php

namespace Hasan\Widgetflow\App\BasicWidget;

trait TabContentControls
{
    protected function register_content_control()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Text', 'textdomain'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Heading control
        $this->add_control(
            'more_options',
            [
                'label' => esc_html__('Options'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        // Text input control

        $this->add_control(
            'widget_title',
            [
                'label' => esc_html__('Title'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Default title'),
                'placeholder' => esc_html__('Type your title here'),
            ]
        );


        $this->end_controls_section();
    }
}