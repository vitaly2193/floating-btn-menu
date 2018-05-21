<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class FlBtnFrontPage {

    function __construct() {
        add_action( 'wp_enqueue_scripts', 'fl_btn_front_scripts' );
        add_action( 'wp_footer', 'fl_btn_create' );
    }

}

function fl_btn_front_scripts() {

    global $wpdb;
    $fl_btn_table_name = $wpdb->prefix . 'fl_btn';
    $icon = $wpdb->get_var("SELECT icon FROM $fl_btn_table_name WHERE id = 1");
    $plugin_url = plugins_url('floating-btn-menu');
    //STYLES
    if ($icon == 1) :
        wp_enqueue_style( 'fl-btn-fa', $plugin_url . '/assets/css/font-awesome.min.css' );
    endif;
    wp_enqueue_style( 'fl-btn-front', $plugin_url . '/public/css/fl-front.css' );
    wp_add_inline_style( 'fl-btn-custom-style', fl_custom_css() );
    //SCRIPTS
    wp_enqueue_script( 'fl-front-js', $plugin_url . '/public/js/fl-front.js', array('jquery'), '', true);
}

function fl_custom_css() {
    global $wpdb;
    $fl_btn_table_name = $wpdb->prefix . 'fl_btn';
    $font_color = $wpdb->get_var("SELECT color FROM $fl_btn_table_name WHERE id = 1");
    $bg_color = $wpdb->get_var("SELECT bg FROM $fl_btn_table_name WHERE id = 1");
    $font_size = $wpdb->get_var("SELECT size FROM $fl_btn_table_name WHERE id = 1");
    $margin = $wpdb->get_var("SELECT margin FROM $fl_btn_table_name WHERE id = 1");
    $duration = $wpdb->get_var("SELECT duration FROM $fl_btn_table_name WHERE id = 1");
    $position = $wpdb->get_var("SELECT position FROM $fl_btn_table_name WHERE id = 1");
    $selected_menu = $wpdb->get_var("SELECT menu FROM $fl_btn_table_name WHERE id = 1");
    $form = $wpdb->get_var("SELECT form FROM $fl_btn_table_name WHERE id = 1");
    $menu_items = wp_get_nav_menu_items( $selected_menu );
    ?>
    <style>
        .fl-btn-menu .fl-btn {
            color: <?php echo $font_color; ?>;
            background-color: <?php echo $bg_color; ?>
        }
        .fl-btn-menu .menu {
            -webkit-transition: ease <?php echo $duration; ?>ms;
            -moz-transition: ease <?php echo $duration; ?>ms;
            -ms-transition: ease <?php echo $duration; ?>ms;
            -o-transition: ease <?php echo $duration; ?>ms;
            transition: ease <?php echo $duration; ?>ms;
        }
        .fl-btn-menu .menu li {
            color: <?php echo $font_color; ?>;
            background-color: <?php echo $bg_color; ?>;
            margin: <?php echo $margin; ?>px;
        }
        .fl-btn-menu .menu li a {
            font-size: <?php echo $font_size; ?>px;
            color: <?php echo $font_color; ?>;
        }
        .fl-btn-menu.fl-horizontal .menu {
            <?php if ($position == 1) : ?>
            left: <?php echo ($margin + 70); ?>px;
            <?php else : ?>
            right: <?php echo ($margin + 70); ?>px;
            <?php endif; ?>
        }
        .fl-btn-menu.fl-vertical .menu {
            bottom: <?php echo ($margin + 70); ?>px;
        }
        <?php if ($position == 1) : ?>
        .fl-btn-menu.fl-left.fl-tree .menu li {
            bottom: -<?php echo ($margin + 70); ?>px;
            right: -<?php echo ($margin); ?>px;
            -webkit-transition: ease <?php echo $duration; ?>ms;
            -moz-transition: ease <?php echo $duration; ?>ms;
            -ms-transition: ease <?php echo $duration; ?>ms;
            -o-transition: ease <?php echo $duration; ?>ms;
            transition: ease <?php echo $duration; ?>ms;
        }
        <?php
        $count = 1;
        $right = -($margin*2 + 70);
        $bottom = 0;
        $center_right = -($margin*2 + 70);
        $center_bottom = 0;
        foreach ($menu_items as $menu_item) {
            if ($count == 1 || $count % 3 == 1 ) : // For Menu Items № 1,4,7...
        ?>
        .fl-btn-menu.fl-tree.fl-opened .menu li:nth-child(<?php echo $count; ?>) {
            bottom: -<?php echo ($margin + 70); ?>px;
            right: <?php echo $right; ?>px;
        }
        <?php
            $right += - 70 - $margin;
            endif;
            if ( $count == 2 || ($count + 1) % 3 == 0 ) : // For Menu Items № 2,5,8...
        ?>
        .fl-btn-menu.fl-tree.fl-opened .menu li:nth-child(<?php echo $count; ?>) {
            bottom: <?echo $center_bottom; ?>px;
            right: <?php echo $center_right; ?>px;
        }
        <?php
                if ($form == 1) :
                    $center_right += - 70 - $margin/2;
                    $center_bottom += 70 + $margin/2;
                else :
                    $center_right += - 70;
                    $center_bottom += 70;
                endif;
            endif;
            if ( ($count + 1) % 3 == 1 ) : // For Menu Items № 3,6,9...
        ?>
        .fl-btn-menu.fl-tree.fl-opened .menu li:nth-child(<?php echo $count; ?>) {
            bottom: <?php echo $bottom; ?>px;
            right: -<?php echo $margin; ?>px;
        }
        <?php
            $bottom += 70 + $margin;
            endif;
        $count++;
        }
        else : ?>
        .fl-btn-menu.fl-tree .menu li {
            bottom: -<?php echo ($margin + 70); ?>px;
            left: -<?php echo ($margin); ?>px;
            -webkit-transition: ease <?php echo $duration; ?>ms;
            -moz-transition: ease <?php echo $duration; ?>ms;
            -ms-transition: ease <?php echo $duration; ?>ms;
            -o-transition: ease <?php echo $duration; ?>ms;
            transition: ease <?php echo $duration; ?>ms;
        }
        <?php
        $count = 1;
        $left = -($margin*2 + 70);
        $bottom = 0;
        $center_left = -($margin*2 + 70);
        $center_bottom = 0;
        foreach ($menu_items as $menu_item) {
            if ($count == 1 || $count % 3 == 1 ) : // 1,4,7...
        ?>
        .fl-btn-menu.fl-tree.fl-opened .menu li:nth-child(<?php echo $count; ?>) {
            bottom: -<?php echo ($margin + 70); ?>px;
            left: <?php echo $left; ?>px;
        }
        <?php
            $left += - 70 - $margin;
            endif;
            if ( $count == 2 || ($count + 1) % 3 == 0 ) : // 2,5,8...
        ?>
            .fl-btn-menu.fl-tree.fl-opened .menu li:nth-child(<?php echo $count; ?>) {
                bottom: <?echo $center_bottom; ?>px;
                left: <?php echo $center_left; ?>px;
            }
        <?php
                if ($form == 1) :
                    $center_left += - 70 - $margin/2;
                    $center_bottom += 70 + $margin/2;
                else :
                    $center_left += - 70;
                    $center_bottom += 70;
                endif;
            endif;
            if ( ($count + 1) % 3 == 1 ) : // 3,6,9...
        ?>
        .fl-btn-menu.fl-tree.fl-opened .menu li:nth-child(<?php echo $count; ?>) {
            bottom: <?php echo $bottom; ?>px;
            right: -<?php echo $margin; ?>px;
        }
        <?php
            $bottom += 70 + $margin;
            endif;
        $count++;
        }
        ?>
        <?php endif; ?>
        @media screen and (max-width: 768px) {
            .fl-btn-menu .menu li a {
                font-size: <?php echo $font_size/2; ?>px;
            }
        }
    </style>
<?php
}

function fl_btn_create() {

    global $wpdb;
    $fl_btn_table_name = $wpdb->prefix . 'fl_btn';
    $variaton = $wpdb->get_var("SELECT variation FROM $fl_btn_table_name WHERE id = 1");
    $form = $wpdb->get_var("SELECT form FROM $fl_btn_table_name WHERE id = 1");
    $icon = $wpdb->get_var("SELECT icon FROM $fl_btn_table_name WHERE id = 1");
    $fa_icon = $wpdb->get_var("SELECT fa FROM $fl_btn_table_name WHERE id = 1");
    $menu_text = $wpdb->get_var("SELECT text FROM $fl_btn_table_name WHERE id = 1");
    $selected_menu = $wpdb->get_var("SELECT menu FROM $fl_btn_table_name WHERE id = 1");
    $mobile = $wpdb->get_var("SELECT mobile FROM $fl_btn_table_name WHERE id = 1");
    $position = $wpdb->get_var("SELECT position FROM $fl_btn_table_name WHERE id = 1");
    $fl_classes = 'fl-btn-menu';
    if ($variaton == 1) :
        $fl_classes .= ' fl-tree';
    elseif ($variaton == 2) :
        $fl_classes .= ' fl-horizontal';
    elseif ($variaton == 3) :
        $fl_classes .= ' fl-vertical';
    endif;
    if ($form == 1) :
        $fl_classes .= ' fl-square';
    elseif ($form == 2) :
        $fl_classes .= ' fl-bubble';
    endif;
    if ($position == 1) :
        $fl_classes .= ' fl-left';
    endif;
?>
    <?php if ($mobile == 0 || ( $mobile == 1 && ! wp_is_mobile() )) : ?>
      <div class="<?php echo $fl_classes; ?>">
          <div class="fl-wrapper">
              <a href="#" class="fl-btn"><span class="fl-btn-closed-icon"><?php if ($icon == 1) { echo '<i class="fa fa-' . $fa_icon . '"></i>'; } else { echo $menu_text; } ?></span><span class="fl-btn-opened-icon">X</span></a>
              <?php
              wp_nav_menu( array(
                  'menu' => $selected_menu,
                  'container' => ''
              ) );
              ?>
          </div>
      </div>
    <?php endif; ?>
<?php

}

new FlBtnFrontPage;