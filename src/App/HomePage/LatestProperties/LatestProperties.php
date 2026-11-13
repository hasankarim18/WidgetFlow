<?php

namespace Hasan\Widgetflow\App\HomePage\LatestProperties;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use WP_Query; // FIX 1: classes are not auto-resolved to the global namespace

if (!defined('ABSPATH')) {
    exit;
}

/** Latest properties slider: queries CPT "property" and renders ACF fields. */
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
        return ['wf-home-css', 'swiper'];
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

    /**
     * FIX 2: helpers are methods now, not functions declared inside render(),
     * so rendering the widget twice no longer causes "Cannot redeclare function".
     */

    // ACF select can return value, label or array depending on "Return Format".
    private function select_value(string $field_name, int $post_id)
    {
        $val = function_exists('get_field') ? get_field($field_name, $post_id) : '';
        if (is_array($val)) {
            return isset($val['value']) ? $val['value'] : '';
        }
        return $val;
    }

    // Deepest assigned term of property_location + its parents => ["Dhaka", "Gulshan"]
    private function get_location_chain(int $post_id): array
    {
        $terms = get_the_terms($post_id, 'property_location');
        if (empty($terms) || is_wp_error($terms)) {
            return [];
        }

        $deepest = null;
        $deepest_depth = -1;

        foreach ($terms as $term) {
            $depth = count(get_ancestors($term->term_id, 'property_location', 'taxonomy'));
            if ($depth > $deepest_depth) {
                $deepest_depth = $depth;
                $deepest = $term;
            }
        }

        if (!$deepest) {
            return [];
        }

        // get_ancestors returns nearest parent first, so reverse to get top -> bottom
        $ancestor_ids = array_reverse(get_ancestors($deepest->term_id, 'property_location', 'taxonomy'));

        $chain = [];
        foreach ($ancestor_ids as $id) {
            $t = get_term($id, 'property_location');
            if ($t && !is_wp_error($t)) {
                $chain[] = $t->name;
            }
        }
        $chain[] = $deepest->name;

        return $chain;
    }

    protected function render(): void
    {
        $properties = new WP_Query([
            'post_type' => 'property',
            'post_status' => 'publish',
            'posts_per_page' => 6, // change as needed (or take from widget settings)
            'orderby' => 'date',
            'order' => 'DESC',
        ]);

        $status_labels = [
            'for_sale' => 'For Sale',
            'for_rent' => 'For Rent',
            'sold' => 'Sold',
            'rented' => 'Rented',
        ];
        $status_classes = [
            'for_sale' => 'wf-badge--sale',
            'for_rent' => 'wf-badge--rent',
            'sold' => 'wf-badge--sold',
            'rented' => 'wf-badge--rented',
        ];
        $unit_labels = [
            'sqft' => 'Sq Ft',
            'sqm' => 'Sq M',
            'acre' => 'Acre',
            'decimal' => 'Decimal',
        ];
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

                <?php if ($properties->have_posts()): ?>
                    <div class="wf-latest__slider swiper">
                        <div class="swiper-wrapper">
                            <?php
                            while ($properties->have_posts()):
                                $properties->the_post();
                                $pid = get_the_ID();

                                // ACF fields
                                $status = $this->select_value('property_status', $pid);   // for_sale|for_rent|sold|rented
                                $bedrooms = get_field('property_bedrooms', $pid);
                                $bathrooms = get_field('property_bathrooms', $pid);
                                $area = get_field('property_area', $pid);
                                $area_unit = $this->select_value('area_unit', $pid);      // sqft|sqm|acre|decimal
                                $price = get_field('property_price', $pid);
                                $price_type = $this->select_value('price_type', $pid);    // fixed|negotiable
                
                                // Taxonomies
                                $type_terms = get_the_terms($pid, 'property_type');
                                $type_name = (!empty($type_terms) && !is_wp_error($type_terms)) ? $type_terms[0]->name : '';

                                $location_chain = $this->get_location_chain($pid);

                                $badge_class = isset($status_classes[$status]) ? $status_classes[$status] : '';
                                $badge_label = isset($status_labels[$status]) ? $status_labels[$status] : '';
                                $unit_label = isset($unit_labels[$area_unit]) ? $unit_labels[$area_unit] : '';
                                $is_closed = in_array($status, ['sold', 'rented'], true);
                                $price_format = ($price !== '' && $price !== null) ? number_format_i18n((float) $price) : '';

                                $permalink = get_permalink();
                                $title = get_the_title();
                                ?>
                                <div class="swiper-slide">
                                    <article class="wf-card">
                                        <a class="wf-card__image" href="<?php echo esc_url($permalink); ?>"
                                            aria-label="<?php echo esc_attr(sprintf('View %s', $title)); ?>">

                                            <?php if (has_post_thumbnail()) {
                                                the_post_thumbnail('large', ['loading' => 'lazy']);
                                            } ?>

                                            <?php if ($badge_label): ?>
                                                <span class="wf-badge <?php echo esc_attr($badge_class); ?>">
                                                    <?php echo esc_html($badge_label); ?>
                                                </span>
                                            <?php endif; ?>

                                            <?php if ($type_name): ?>
                                                <span class="wf-card__type"><?php echo esc_html($type_name); ?></span>
                                            <?php endif; ?>
                                        </a>

                                        <div class="wf-card__body">
                                            <?php if (!empty($location_chain)): ?>
                                                <p class="wf-card__location">
                                                    <?php echo implode(' <span>·</span> ', array_map('esc_html', $location_chain)); ?>
                                                </p>
                                            <?php endif; ?>

                                            <h3 class="wf-card__title">
                                                <a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($title); ?></a>
                                            </h3>

                                            <ul class="wf-card__facts">
                                                <?php if ($bedrooms !== '' && $bedrooms !== null): ?>
                                                    <li><b><?php echo esc_html($bedrooms); ?></b> Beds</li>
                                                <?php endif; ?>
                                                <?php if ($bathrooms !== '' && $bathrooms !== null): ?>
                                                    <li><b><?php echo esc_html($bathrooms); ?></b> Baths</li>
                                                <?php endif; ?>
                                                <?php if ($area !== '' && $area !== null): ?>
                                                    <li><b><?php echo esc_html($area); ?></b> <?php echo esc_html($unit_label); ?></li>
                                                <?php endif; ?>
                                            </ul>

                                            <div class="wf-card__footer">
                                                <strong class="wf-card__price">
                                                    <?php if ($is_closed): ?>
                                                        <!-- sold / rented: label + struck-through price -->
                                                        <span class="wf-card__sold"><?php echo esc_html($badge_label); ?></span>
                                                        <?php if ($price_format): ?>
                                                            <del><span>৳ </span><span><?php echo esc_html($price_format); ?></span></del>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <?php if ($price_format): ?>
                                                            <span>৳ </span><span><?php echo esc_html($price_format); ?></span>
                                                            <?php if ('for_rent' === $status): ?>
                                                                <span>/month</span>
                                                            <?php endif; ?>
                                                        <?php endif; ?>

                                                        <?php if ('negotiable' === $price_type): ?>
                                                            <small>Negotiable</small>
                                                        <?php elseif ('fixed' === $price_type): ?>
                                                            <small>Fixed Price</small>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </strong>

                                                <a class="wf-card__link" href="<?php echo esc_url($permalink); ?>">
                                                    Details <span aria-hidden="true">→</span>
                                                </a>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                    <div class="wf-latest__dots" aria-hidden="false"></div>
                <?php else: ?>
                    <p class="wf-empty"><?php echo esc_html__('No property found'); ?></p>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}