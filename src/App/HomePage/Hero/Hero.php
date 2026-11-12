<?php

namespace Hasan\Widgetflow\App\HomePage\Hero;

use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    exit;
}

/** Property hero: editable text, buttons and banner image + (static) search form. */
class Hero extends Widget_Base
{
    use TabContentControl;
    use TabStyleControl;

    public function get_name(): string
    {
        return 'wf_propery_hero';
    }

    public function get_title(): string
    {
        return esc_html__('WF Property Hero hp', 'widgetflow');
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

    protected function register_controls(): void
    {
        $this->register_content_control();
        $this->register_style_controls();
    }

    protected function render(): void
    {
        $s = $this->get_settings_for_display();

        $eyebrow       = trim((string) ($s['eyebrow'] ?? ''));
        $title         = trim((string) ($s['title'] ?? ''));
        $title_tag     = Utils::validate_html_tag($s['title_tag'] ?? 'h1');
        $description   = trim((string) ($s['description'] ?? ''));
        $primary_text  = trim((string) ($s['primary_text'] ?? ''));
        $second_text   = trim((string) ($s['secondary_text'] ?? ''));
        $show_caption  = 'yes' === ($s['show_caption'] ?? '');
        $caption_title = trim((string) ($s['caption_title'] ?? ''));
        $caption_text  = trim((string) ($s['caption_text'] ?? ''));
        $title_id      = 'wf-hero-title-' . $this->get_id();

        $has_image  = !empty($s['banner_image']['url']);
        $image_html = $has_image ? Group_Control_Image_Size::get_attachment_image_html($s, 'banner_image') : '';

        if (!empty($s['primary_link']['url'])) {
            $this->add_link_attributes('primary_link', $s['primary_link']);
        }
        $this->add_render_attribute('primary_link', 'class', ['wf-btn', 'wf-btn--primary']);

        if (!empty($s['secondary_link']['url'])) {
            $this->add_link_attributes('secondary_link', $s['secondary_link']);
        }
        $this->add_render_attribute('secondary_link', 'class', 'wf-hero__link');
        ?>
        <div class="rp_home_page_widget_wrapper">
            <section class="wf-widget wf-hero"<?php echo '' !== $title ? ' aria-labelledby="' . esc_attr($title_id) . '"' : ''; ?>>
                <div class="wf-container wf-hero__grid">
                    <div class="wf-hero__content">
                        <?php if ('' !== $eyebrow) : ?>
                            <p class="wf-eyebrow"><?php echo esc_html($eyebrow); ?></p>
                        <?php endif; ?>

                        <?php if ('' !== $title) : ?>
                            <<?php echo esc_attr($title_tag); ?> class="wf-hero__title" id="<?php echo esc_attr($title_id); ?>"><?php echo esc_html($title); ?></<?php echo esc_attr($title_tag); ?>>
                        <?php endif; ?>

                        <?php if ('' !== $description) : ?>
                            <p class="wf-hero__text"><?php echo wp_kses_post($description); ?></p>
                        <?php endif; ?>

                        <?php if ('' !== $primary_text || '' !== $second_text) : ?>
                            <div class="wf-hero__actions">
                                <?php if ('' !== $primary_text) : ?>
                                    <a <?php $this->print_render_attribute_string('primary_link'); ?>><?php echo esc_html($primary_text); ?> <span aria-hidden="true">→</span></a>
                                <?php endif; ?>
                                <?php if ('' !== $second_text) : ?>
                                    <a <?php $this->print_render_attribute_string('secondary_link'); ?>><?php echo esc_html($second_text); ?></a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="wf-art<?php echo $has_image ? ' wf-art--has-image' : ''; ?>"<?php echo $has_image ? '' : ' role="img" aria-label="' . esc_attr__('Illustration of homes and apartments', 'widgetflow') . '"'; ?>>
                        <?php if ($has_image) : ?>
                            <div class="wf-art__image"><?php echo $image_html; // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
                        <?php else : ?>
                            <span class="wf-art__sun" aria-hidden="true"></span>
                            <span class="wf-art__tower" aria-hidden="true"></span>
                            <span class="wf-art__house" aria-hidden="true"></span>
                        <?php endif; ?>

                        <?php if ($show_caption && ('' !== $caption_title || '' !== $caption_text)) : ?>
                            <div class="wf-art__caption">
                                <div>
                                    <?php if ('' !== $caption_title) : ?>
                                        <strong class="wf-art__caption-title"><?php echo esc_html($caption_title); ?></strong>
                                    <?php endif; ?>
                                    <?php if ('' !== $caption_text) : ?>
                                        <span class="wf-art__caption-text"><?php echo esc_html($caption_text); ?></span>
                                    <?php endif; ?>
                                </div>
                                <span class="wf-art__caption-icon" aria-hidden="true">⌖</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="wf-container wf-hero__search">
                    <!-- Submits to the property archive. Field names match the archive's URL params:
         s = keyword, type[] = property_type slug, status[] = for_sale | for_rent -->
                  <form class="wf-search" action="<?php echo esc_url( home_url( '/properties/' ) ); ?>" method="get" role="search" aria-label="Search properties">
    <input type="hidden" name="post_type" value="property">

    <label class="wf-search__field" for="wf-search-location">
        <span>Property location</span>
        <select id="wf-search-location" name="location">
            <option value="">All locations</option>
            <?php
            $locations = get_terms( array(
                'taxonomy'   => 'property_location',
                'hide_empty' => true,
            ) );

            if ( ! is_wp_error( $locations ) ) :
                foreach ( $locations as $location ) :
                    ?>
                    <option value="<?php echo esc_attr( $location->slug ); ?>">
                        <?php echo esc_html( $location->name ); ?>
                    </option>
                    <?php
                endforeach;
            endif;
            ?>
        </select>
    </label>

    <label class="wf-search__field" for="wf-search-type">
        <span>Property type</span>
        <select id="wf-search-type" name="type">
            <option value="">All property types</option>
            <?php
            $types = get_terms( array(
                'taxonomy'   => 'property_type',
                'hide_empty' => true,
            ) );

            if ( ! is_wp_error( $types ) ) :
                foreach ( $types as $type ) :
                    ?>
                    <option value="<?php echo esc_attr( $type->slug ); ?>">
                        <?php echo esc_html( $type->name ); ?>
                    </option>
                    <?php
                endforeach;
            endif;
            ?>
        </select>
    </label>

    <label class="wf-search__field" for="wf-search-status">
        <span>Looking to</span>
        <select id="wf-search-status" name="status">
            <option value="">Buy or rent</option>
            <option value="for_sale">Buy</option>
            <option value="for_rent">Rent</option>
        </select>
    </label>

    <button class="wf-search__btn" type="submit">
        <span aria-hidden="true">⌕</span> Search properties
    </button>
</form>
            <!-- After submitting the form it should create a link like:
                    http://realproperty.local/properties/?status=for_sale&type=apartment&location=new-eskaton
                    and take it to the site_ur/properties page like the url
                -->
                </div>
            </section>
        </div>
        <?php
    }
}