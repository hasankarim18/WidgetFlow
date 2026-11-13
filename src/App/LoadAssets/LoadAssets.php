<?php

namespace Hasan\Widgetflow\App\LoadAssets;

use Hasan\Widgetflow\Contracts\Module;

if (!defined('ABSPATH')) {
    exit;
}

class LoadAssets implements Module
{
    public function register(): void
    {
        /*
         * =========================================================
         * FRONTEND
         * =========================================================
         */

        // Register frontend styles
        add_action(
            'wp_enqueue_scripts',
            [$this, 'register_styles'],
            5
        );

        // Enqueue frontend JS
        add_action(
            'wp_enqueue_scripts',
            [$this, 'enqueue_frontend_scripts']
        );


        /*
         * =========================================================
         * ELEMENTOR EDITOR
         * =========================================================
         */

        // Register styles inside Elementor editor
        add_action(
            'elementor/editor/after_enqueue_styles',
            [$this, 'register_styles']
        );

        // Load JS for Elementor editor UI
        add_action(
            'elementor/editor/after_enqueue_scripts',
            [$this, 'enqueue_editor_scripts']
        );


        /*
         * =========================================================
         * ELEMENTOR PREVIEW
         * =========================================================
         *
         * The Elementor preview iframe is where the actual
         * frontend widget markup is rendered.
         */

        // Register styles inside Elementor preview
        add_action(
            'elementor/preview/enqueue_styles',
            [$this, 'register_styles']
        );

        // Load frontend JS inside Elementor preview
        add_action(
            'elementor/preview/enqueue_scripts',
            [$this, 'enqueue_frontend_scripts']
        );
    }


    /**
     * Register all Widgetflow styles.
     */
    public function register_styles(): void
    {
        /*
         * Home
         */
        wp_register_style(
            'wf-home-css',
            WIDGETFLOW_URL . 'assets/css/wf-home.css',
            [],
            '2.0'
        );


        /*
         * Single Property
         */
        wp_register_style(
            'wf-single-property',
            WIDGETFLOW_URL . 'assets/css/single-property.css',
            [],
            WIDGETFLOW_VERSION
        );


        /*
         * Home Page Property
         */
        wp_register_style(
            'wf-home-page-property',
            WIDGETFLOW_URL . 'assets/css/home-page.css',
            [],
            WIDGETFLOW_VERSION
        );
    }


    /**
     * Enqueue frontend JS.
     *
     * This is loaded on:
     * - Normal frontend
     * - Elementor preview iframe
     */
    public function enqueue_frontend_scripts(): void
    {
        wp_enqueue_script(
            'wf-home-js',
            WIDGETFLOW_URL . 'assets/js/wf-home.js',
            ['jquery'],
            WIDGETFLOW_VERSION,
            true
        );
    }


    /**
     * Enqueue Elementor editor JS.
     *
     * This is for the Elementor editor UI itself.
     */
    public function enqueue_editor_scripts(): void
    {
        wp_enqueue_script(
            'wf-editor-js',
            WIDGETFLOW_URL . 'assets/js/wf-editor.js',
            ['jquery'],
            WIDGETFLOW_VERSION,
            true
        );
    }
}