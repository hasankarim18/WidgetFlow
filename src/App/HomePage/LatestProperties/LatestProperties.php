<?php

namespace Hasan\Widgetflow\App\HomePage\LatestProperties;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;


if (!defined('ABSPATH')) {
    exit;
}

/** Minimal example: a text setting with a small set of style controls. */
class LatestProperties extends Widget_Base
{
    use TabContentControl;
    use TabStyleControl;
    public function get_name(): string
    {
        return 'wf_hp_latest_properties';
    }

    public function get_title(): string
    {
        return esc_html__('WF Hp Latest Properties');
    }

    public function get_icon(): string
    {
        return 'eicon-code';
    }

    public function get_style_depends(): array
    {
        return ['wf-home-css', 'swiper',];
    }

    public function get_script_depends()
    {
        return ['wf-home-js', 'wf-editor-js', 'swiper'];
    }

    public function get_categories(): array
    {
        return ['widgetflow', 'property_home_page'];
    }

    public function get_keywords(): array
    {
        return ['wf', 'latest properties', 'hp', 'widgetflow'];
    }


    protected function register_controls(): void
    {

        $this->register_content_controls();
        $this->register_style_controls();

    }

    protected function render(): void
    {

        ?>
        <!-- ======================= WIDGET 2: Latest properties ======================= -->
        <section class="wf-widget wf-section wf-latest" aria-labelledby="wf-latest-title">
            <div class="wf-container">
                <div class="wf-heading">
                    <div>
                        <p class="wf-kicker">A place for your next chapter</p>
                        <h2 class="wf-heading__title" id="wf-latest-title">Latest properties</h2>
                        <p class="wf-heading__desc">Recently added homes and listings to explore.</p>
                    </div>
                    <div class="wf-heading__side">
                        <div class="wf-slider-nav">
                            <button class="wf-slider-btn wf-slider-btn--prev" type="button"
                                aria-label="Previous properties">←</button>
                            <button class="wf-slider-btn wf-slider-btn--next" type="button"
                                aria-label="Next properties">→</button>
                        </div>
                        <a class="wf-link" href="/properties/">All properties <span aria-hidden="true">→</span></a>
                    </div>
                </div>

                <div class="wf-latest__slider swiper">
                    <div class="swiper-wrapper">
                        <!-- [dynamic] one .swiper-slide per property (6 by default; use a number control).
             Image modifier: wf-card__image--photo when it has a featured image (put the <img> inside),
             otherwise the drawn placeholder; optional --villa or --land variant by property type.
             Badge modifier: wf-badge--sale | --rent | --sold | --rented. -->
                        <div class="swiper-slide">
                            <article class="wf-card">
                                <a class="wf-card__image" href="/property/pr-0001/"
                                    aria-label="View Luxury 3-Bedroom Apartment in Gulshan">
                                    <span class="wf-badge wf-badge--sale">For sale</span><span
                                        class="wf-card__type">Apartment</span>
                                </a>
                                <div class="wf-card__body">
                                    <p class="wf-card__location">Dhaka <span>·</span> Gulshan</p>
                                    <h3 class="wf-card__title"><a href="/property/pr-0001/">Luxury 3-Bedroom Apartment in
                                            Gulshan</a></h3>
                                    <ul class="wf-card__facts">
                                        <li><b>3</b>Beds</li>
                                        <li><b>3</b>Baths</li>
                                        <li><b>1,850</b>Sq ft</li>
                                    </ul>
                                    <div class="wf-card__footer">
                                        <strong class="wf-card__price">৳ 1,85,00,000 <small>Negotiable</small></strong>
                                        <a class="wf-card__link" href="/property/pr-0001/">Details <span
                                                aria-hidden="true">→</span></a>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="swiper-slide">
                            <article class="wf-card">
                                <a class="wf-card__image wf-card__image--villa" href="/property/pr-0002/"
                                    aria-label="View Spacious Villa with Private Pool">
                                    <span class="wf-badge wf-badge--rent">For rent</span><span
                                        class="wf-card__type">Villa</span>
                                </a>
                                <div class="wf-card__body">
                                    <p class="wf-card__location">Sylhet <span>·</span> Sylhet City</p>
                                    <h3 class="wf-card__title"><a href="/property/pr-0002/">Spacious Villa with Private Pool</a>
                                    </h3>
                                    <ul class="wf-card__facts">
                                        <li><b>5</b>Beds</li>
                                        <li><b>4</b>Baths</li>
                                        <li><b>4,200</b>Sq ft</li>
                                    </ul>
                                    <div class="wf-card__footer">
                                        <strong class="wf-card__price">৳ 1,20,000 <small>/ month</small></strong>
                                        <a class="wf-card__link" href="/property/pr-0002/">Details <span
                                                aria-hidden="true">→</span></a>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="swiper-slide">
                            <article class="wf-card">
                                <a class="wf-card__image wf-card__image--land" href="/property/pr-0003/"
                                    aria-label="View Residential Plot Near Khulna City Bypass">
                                    <span class="wf-badge wf-badge--sale">For sale</span><span class="wf-card__type">Land</span>
                                </a>
                                <div class="wf-card__body">
                                    <p class="wf-card__location">Khulna <span>·</span> City Bypass</p>
                                    <h3 class="wf-card__title"><a href="/property/pr-0003/">Residential Plot Near Khulna City
                                            Bypass</a></h3>
                                    <ul class="wf-card__facts">
                                        <li><b>5</b>Decimal</li>
                                        <li><b>—</b>Roads</li>
                                        <li><b>Res.</b>Use</li>
                                    </ul>
                                    <div class="wf-card__footer">
                                        <strong class="wf-card__price">৳ 35,00,000 <small>Fixed</small></strong>
                                        <a class="wf-card__link" href="/property/pr-0003/">Details <span
                                                aria-hidden="true">→</span></a>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="swiper-slide">
                            <article class="wf-card">
                                <a class="wf-card__image" href="/property/pr-0004/"
                                    aria-label="View Modern Office Space in Dhanmondi">
                                    <span class="wf-badge wf-badge--rent">For rent</span><span
                                        class="wf-card__type">Office</span>
                                </a>
                                <div class="wf-card__body">
                                    <p class="wf-card__location">Dhaka <span>·</span> Dhanmondi</p>
                                    <h3 class="wf-card__title"><a href="/property/pr-0004/">Modern Office Space in Dhanmondi</a>
                                    </h3>
                                    <ul class="wf-card__facts">
                                        <li><b>—</b>Rooms</li>
                                        <li><b>2</b>Baths</li>
                                        <li><b>2,400</b>Sq ft</li>
                                    </ul>
                                    <div class="wf-card__footer">
                                        <strong class="wf-card__price">৳ 85,000 <small>/ month</small></strong>
                                        <a class="wf-card__link" href="/property/pr-0004/">Details <span
                                                aria-hidden="true">→</span></a>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="swiper-slide">
                            <article class="wf-card">
                                <a class="wf-card__image wf-card__image--villa" href="/property/pr-0005/"
                                    aria-label="View Family House Near Khulshi Hill">
                                    <span class="wf-badge wf-badge--sale">For sale</span><span
                                        class="wf-card__type">House</span>
                                </a>
                                <div class="wf-card__body">
                                    <p class="wf-card__location">Chittagong <span>·</span> Khulshi</p>
                                    <h3 class="wf-card__title"><a href="/property/pr-0005/">Family House Near Khulshi Hill</a>
                                    </h3>
                                    <ul class="wf-card__facts">
                                        <li><b>4</b>Beds</li>
                                        <li><b>3</b>Baths</li>
                                        <li><b>2,900</b>Sq ft</li>
                                    </ul>
                                    <div class="wf-card__footer">
                                        <strong class="wf-card__price">৳ 2,40,00,000 <small>Negotiable</small></strong>
                                        <a class="wf-card__link" href="/property/pr-0005/">Details <span
                                                aria-hidden="true">→</span></a>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="swiper-slide">
                            <article class="wf-card">
                                <a class="wf-card__image" href="/property/pr-0006/"
                                    aria-label="View Bright 2-Bedroom Apartment in Uttara">
                                    <span class="wf-badge wf-badge--rent">For rent</span><span
                                        class="wf-card__type">Apartment</span>
                                </a>
                                <div class="wf-card__body">
                                    <p class="wf-card__location">Dhaka <span>·</span> Uttara</p>
                                    <h3 class="wf-card__title"><a href="/property/pr-0006/">Bright 2-Bedroom Apartment in
                                            Uttara</a></h3>
                                    <ul class="wf-card__facts">
                                        <li><b>2</b>Beds</li>
                                        <li><b>2</b>Baths</li>
                                        <li><b>1,100</b>Sq ft</li>
                                    </ul>
                                    <div class="wf-card__footer">
                                        <strong class="wf-card__price">৳ 38,000 <small>/ month</small></strong>
                                        <a class="wf-card__link" href="/property/pr-0006/">Details <span
                                                aria-hidden="true">→</span></a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
                <div class="wf-latest__dots" aria-hidden="false"></div>
            </div>
        </section>
        <?php
    }
}