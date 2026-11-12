<?php

namespace Hasan\Widgetflow\App\HomePage\Hero;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Hasan\Widgetflow\App\BasicWidget\TabStyleControls;

if (!defined('ABSPATH')) {
    exit;
}

/** Minimal example: a text setting with a small set of style controls. */
class Hero extends Widget_Base
{
    public function get_name(): string
    {
        return 'wf_propery_hero';
    }

    public function get_title(): string
    {
        return esc_html__('WF Property Hero hp');
    }

    public function get_style_depends(): array
    {
        return ['wf-home-page-property'];
    }

    public function get_icon(): string
    {
        return 'eicon-form-horizontal';
    }

    public function get_categories(): array
    {
        return ['widgetflow', 'property_home_page'];
    }

    public function get_keywords(): array
    {
        return ['property hero', 'home', 'hero', 'widgetflow', 'wf'];
    }

    use TabContentControl;
    use TabStyleControls;

    protected function register_controls(): void
    {

        $this->register_content_control();
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
        <div class="rp_home_page_widget_wrapper">
            <section class="wf-widget wf-hero" aria-labelledby="wf-hero-title">
                <div class="wf-container wf-hero__grid">
                    <div class="wf-hero__content">
                        <p class="wf-eyebrow">Property Directory · Bangladesh</p>
                        <h1 class="wf-hero__title" id="wf-hero-title">Find a place to call home</h1>
                        <p class="wf-hero__text">Explore homes, apartments, land, and commercial properties in the places you
                            want to live and work.</p>
                        <div class="wf-hero__actions">
                            <a class="wf-btn wf-btn--primary" href="/properties/">Browse properties <span
                                    aria-hidden="true">→</span></a>
                            <a class="wf-hero__link" href="#how-it-works">How it works</a>
                        </div>
                    </div>

                    <div class="wf-art" role="img" aria-label="Illustration of homes and apartments">
                        <span class="wf-art__sun" aria-hidden="true"></span>
                        <span class="wf-art__tower" aria-hidden="true"></span>
                        <span class="wf-art__house" aria-hidden="true"></span>
                        <div class="wf-art__caption">
                            <div><strong>Homes for every next step</strong><span>Explore listings across Bangladesh</span></div>
                            <span aria-hidden="true">⌖</span>
                        </div>
                    </div>
                </div>

                <div class="wf-container wf-hero__search">
                    <!-- Submits to the property archive. Field names match the archive's URL params:
         s = keyword, type[] = property_type slug, status[] = for_sale | for_rent -->
                    <form class="wf-search" action="/properties/" method="get" role="search" aria-label="Search properties">
                        <input type="hidden" name="post_type" value="property">

                        <label class="wf-search__field wf-search__field--wide" for="wf-search-q">
                            <span>Location</span>
                            <input id="wf-search-q" type="search" name="s" placeholder="City, area or keyword">
                        </label>

                        <label class="wf-search__field" for="wf-search-type">
                            <span>Property type</span>
                            <select id="wf-search-type" name="type[]">
                                <option value="">All property types</option>
                                <!-- [dynamic] terms of property_type: value = slug -->
                                <option value="apartment">Apartment</option>
                                <option value="villa">Villa</option>
                                <option value="house">House</option>
                                <option value="office">Office</option>
                                <option value="commercial-building">Commercial Building</option>
                                <option value="land">Land</option>
                            </select>
                        </label>

                        <label class="wf-search__field" for="wf-search-status">
                            <span>Looking to</span>
                            <select id="wf-search-status" name="status[]">
                                <option value="">Buy or rent</option>
                                <option value="for_sale">Buy</option>
                                <option value="for_rent">Rent</option>
                            </select>
                        </label>

                        <button class="wf-search__btn" type="submit"><span aria-hidden="true">⌕</span> Search
                            properties</button>
                    </form>
                </div>
            </section>
        </div>
        <?php
    }
}