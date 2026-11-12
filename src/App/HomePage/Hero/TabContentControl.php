<?php

namespace Hasan\Widgetflow\App\HomePage\Hero;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

if (!defined('ABSPATH')) {
    exit;
}

trait TabContentControl
{
    protected function register_content_control(): void
    {
        /* ---------- Hero text ---------- */
        $this->start_controls_section('content_section', [
            'label' => esc_html__('Hero Content', 'widgetflow'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('eyebrow', [
            'label' => esc_html__('Eyebrow', 'widgetflow'),
            'type' => Controls_Manager::TEXT,
            'dynamic' => ['active' => true],
            'default' => esc_html__('Property Directory · Bangladesh', 'widgetflow'),
            'label_block' => true,
        ]);

        $this->add_control('title', [
            'label' => esc_html__('Title', 'widgetflow'),
            'type' => Controls_Manager::TEXT,
            'dynamic' => ['active' => true],
            'default' => esc_html__('Find a place to call home', 'widgetflow'),
            'label_block' => true,
        ]);

        $this->add_control('title_tag', [
            'label' => esc_html__('Title HTML Tag', 'widgetflow'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'h1' => 'H1',
                'h2' => 'H2',
                'h3' => 'H3',
                'div' => 'div',
                'p' => 'p',
            ],
            'default' => 'h1',
        ]);

        $this->add_control('description', [
            'label' => esc_html__('Description', 'widgetflow'),
            'type' => Controls_Manager::TEXTAREA,
            'dynamic' => ['active' => true],
            'rows' => 4,
            'default' => esc_html__('Explore homes, apartments, land, and commercial properties in the places you want to live and work.', 'widgetflow'),
        ]);

        $this->end_controls_section();

        /* ---------- Buttons ---------- */
        $this->start_controls_section('buttons_section', [
            'label' => esc_html__('Buttons', 'widgetflow'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('primary_text', [
            'label' => esc_html__('Primary Button Text', 'widgetflow'),
            'type' => Controls_Manager::TEXT,
            'dynamic' => ['active' => true],
            'default' => esc_html__('Browse properties', 'widgetflow'),
            'label_block' => true,
        ]);

        $this->add_control('primary_link', [
            'label' => esc_html__('Primary Button Link', 'widgetflow'),
            'type' => Controls_Manager::URL,
            'dynamic' => ['active' => true],
            'placeholder' => esc_html__('https://your-link.com', 'widgetflow'),
            'default' => ['url' => '/properties/', 'is_external' => false, 'nofollow' => false],
        ]);

        $this->add_control('secondary_text', [
            'label' => esc_html__('Secondary Link Text', 'widgetflow'),
            'type' => Controls_Manager::TEXT,
            'dynamic' => ['active' => true],
            'default' => esc_html__('How it works', 'widgetflow'),
            'label_block' => true,
            'separator' => 'before',
        ]);

        $this->add_control('secondary_link', [
            'label' => esc_html__('Secondary Link URL', 'widgetflow'),
            'type' => Controls_Manager::URL,
            'dynamic' => ['active' => true],
            'placeholder' => esc_html__('https://your-link.com', 'widgetflow'),
            'default' => ['url' => '#how-it-works', 'is_external' => false, 'nofollow' => false],
        ]);

        $this->end_controls_section();

        /* ---------- Banner ---------- */
        $this->start_controls_section('banner_section', [
            'label' => esc_html__('Banner', 'widgetflow'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('banner_image', [
            'label' => esc_html__('Banner Image', 'widgetflow'),
            'type' => Controls_Manager::MEDIA,
            'dynamic' => ['active' => true],
            'default' => ['url' => ''],
            'description' => esc_html__('Leave empty to show the default illustration.', 'widgetflow'),
        ]);

        $this->add_group_control(Group_Control_Image_Size::get_type(), [
            'name' => 'banner_image', // creates banner_image_size
            'default' => 'large',
            'separator' => 'none',
            'condition' => ['banner_image[url]!' => ''],
        ]);

        $this->add_control('show_caption', [
            'label' => esc_html__('Show Caption', 'widgetflow'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Show', 'widgetflow'),
            'label_off' => esc_html__('Hide', 'widgetflow'),
            'return_value' => 'yes',
            'default' => 'yes',
            'separator' => 'before',
        ]);

        $this->add_control('caption_title', [
            'label' => esc_html__('Caption Title', 'widgetflow'),
            'type' => Controls_Manager::TEXT,
            'dynamic' => ['active' => true],
            'default' => esc_html__('Homes for every next step', 'widgetflow'),
            'label_block' => true,
            'condition' => ['show_caption' => 'yes'],
        ]);

        $this->add_control('caption_text', [
            'label' => esc_html__('Caption Text', 'widgetflow'),
            'type' => Controls_Manager::TEXT,
            'dynamic' => ['active' => true],
            'default' => esc_html__('Explore listings across Bangladesh', 'widgetflow'),
            'label_block' => true,
            'condition' => ['show_caption' => 'yes'],
        ]);

        $this->end_controls_section();
    }
}