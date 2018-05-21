<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class FlBtnAdminPage {
    function __construct() {
        add_action( 'admin_menu', array( $this, 'fl_btn_add_menu' ) );
        add_action( 'admin_enqueue_scripts', 'fl_btn_scripts' );
    }

    function fl_btn_add_menu() {
        add_menu_page('Floating Button Menu', 'Floating Button Menu', 'manage_options', 'flbtn-main', array($this, 'fl_btn_page'), 'dashicons-image-filter');
    }

    function fl_btn_page () {
        global $wpdb;
        $fl_btn_table_name = $wpdb->prefix . 'fl_btn';
        if ( !empty($_POST) && check_admin_referer('fl_btn_action','fl_btn_nonce_field') ) {
            echo '<h3 class="fl-submit-mesage">Saved Successfully!</h3>';
            if (empty($_POST['fl-duration'])) :
                $animation_duration = 100;
            else :
                $animation_duration = $_POST['fl-duration'];
            endif;
            if (empty($_POST['fl-margin'])) :
                $items_margin = 10;
            else :
                $items_margin = $_POST['fl-margin'];
            endif;
            $wpdb->update( $fl_btn_table_name,
                array(
                    'variation' => $_POST['fl-variaton'],
                    'form' => $_POST['fl-form'],
                    'icon' => $_POST['fl-icon'],
                    'fa' => $_POST['fl-select-fa'],
                    'text' => $_POST['icon-text-content'],
                    'menu' => $_POST['fl-menu'],
                    'color' => $_POST['fl-font-color'],
                    'bg' => $_POST['fl-bg-color'],
                    'size' => $_POST['fl-font-size'],
                    'position' => $_POST['fl-position'],
                    'mobile' => $_POST['fl-mobile-hide'],
                    'duration' => $animation_duration,
                    'margin' => $items_margin
                ),
                array( 'ID' => 1 )
            );
        }
        $variaton = $wpdb->get_var("SELECT variation FROM $fl_btn_table_name WHERE id = 1");
        $form = $wpdb->get_var("SELECT form FROM $fl_btn_table_name WHERE id = 1");
        $icon = $wpdb->get_var("SELECT icon FROM $fl_btn_table_name WHERE id = 1");
        $fa_icon = $wpdb->get_var("SELECT fa FROM $fl_btn_table_name WHERE id = 1");
        $menu_text = $wpdb->get_var("SELECT text FROM $fl_btn_table_name WHERE id = 1");
        $selected_menu = $wpdb->get_var("SELECT menu FROM $fl_btn_table_name WHERE id = 1");
        $menus = wp_get_nav_menus();
        $font_color = $wpdb->get_var("SELECT color FROM $fl_btn_table_name WHERE id = 1");
        $bg_color = $wpdb->get_var("SELECT bg FROM $fl_btn_table_name WHERE id = 1");
        $font_size = $wpdb->get_var("SELECT size FROM $fl_btn_table_name WHERE id = 1");
        $position = $wpdb->get_var("SELECT position FROM $fl_btn_table_name WHERE id = 1");
        $mobile = $wpdb->get_var("SELECT mobile FROM $fl_btn_table_name WHERE id = 1");
        $duration = $wpdb->get_var("SELECT duration FROM $fl_btn_table_name WHERE id = 1");
        $margin = $wpdb->get_var("SELECT margin FROM $fl_btn_table_name WHERE id = 1");
    ?>
        <div class="fl-wrap">
            <h1>Floating Button Menu</h1>
            <form id="fl-btn-form" method="post">
                <div class="form-row">
                    <div class="label" for="fl-variaton">Select Structure Of Your Menu</div>
                    <select name="fl-variaton" id="fl-variaton">
                        <option value="1" <?php if ( 1 == $variaton ) { echo 'selected'; } ?>>Tree</option>
                        <option value="2" <?php if ( 2 == $variaton ) { echo 'selected'; } ?>>Horizontal Line</option>
                        <option value="3" <?php if ( 3 == $variaton ) { echo 'selected'; } ?>>Vertical Line</option>
                    </select>
                </div>
                <div class="form-row">
                    <div class="label" for="fl-form">Select What Shape The Menu Items Should Be</div>
                    <select name="fl-form" id="fl-form">
                        <option value="1" <?php if( 1 == $form ) { echo 'selected'; } ?>>Square</option>
                        <option value="2" <?php if( 2 == $form ) { echo 'selected'; } ?>>Bubble</option>
                    </select>
                </div>
                <div class="form-row radio-row">
                    <div class="label">Select Type Of Menu Image</div>
                    <input type="radio" name="fl-icon" id="fl-icon-fa" value="1" <?php if( 1 == $icon ) { echo 'checked'; } ?>> <label for="fl-icon-fa">Font Awesome Icon</label>
                    <input type="radio" name="fl-icon" id="fl-icon-text" value="2" <?php if( 2 == $icon ) { echo 'checked'; } ?>> <label for="fl-icon-text">Text</label>
                </div>
                <?php
                $fontawesome = file_get_contents(plugins_url('floating-btn-menu').'/assets/FontAwesome.json');
                $fontawesome_array = json_decode($fontawesome, true);
                $fontawesome_icons = $fontawesome_array['icons']; ?>
                <div class="form-row icon-fa-row" <?php if( 2 == $icon ) { echo 'style="display:none"'; } ?>>
                    <label for="fl-select-fa">Select Font Awesome Icon</label>
                    <select name="fl-select-fa" id="fl-select-fa">
                            <?php foreach ($fontawesome_icons as $fontawesome_icon) : ?>
                                <option value="<?php echo $fontawesome_icon['id']; ?>" <?php if($fa_icon == $fontawesome_icon['id']) echo 'selected'; ?>><?php echo $fontawesome_icon['name']; ?></option>
                            <?php endforeach; ?>
                    </select>
                    <i id="icon-preview" class="fa fa-<?php echo $fa_icon; ?>"></i>
                </div>
                <div class="form-row icon-text-row" <?php if( 1 == $icon ) { echo 'style="display:none"'; } ?>>
                    <label for="icon-text-content">Type Menu Text</label>
                    <input type="text" name ="icon-text-content" id="icon-text-content" value="<?php echo $menu_text; ?>">
                </div>
                <div class="form-row">
                    <div class="label">Choose Menu Than Will Appear</div>
                    <select name="fl-menu" id="fl-menu">
                        <?php foreach ($menus as $menu) : ?>
                            <option value="<?php echo $menu->term_id; ?>" <?php if ($selected_menu == $menu->term_id) { echo 'selected'; } ?>><?php echo $menu->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-row">
                    <div class="label">Choose Font Color For Menu Items</div>
                    <input class="fl-color" type="text" name="fl-font-color" value="<?php echo $font_color; ?>">
                </div>
                <div class="form-row">
                    <div class="label">Choose Background Color For Menu Items</div>
                    <input class="fl-color" type="text" name="fl-bg-color" value="<?php echo $bg_color; ?>">
                </div>
                <div class="form-row">
                    <div class="label">Choose Font Size (in px) For Menu Items</div>
                    <input type="number" name="fl-font-size" value="<?php echo $font_size; ?>">
                </div>
                <div class="form-row">
                    <div class="label">Choose Menu Position. In Defaults It Appear On The Right Side. Check This If You Want To Choose Left Position</div>
                    <small>* menu always located at the bottom of the web page.</small>
                    <input type="checkbox" name="fl-position" value="1" <?php if ($position == 1) { echo 'checked'; } ?>> Left Position
                </div>
                <div class="form-row">
                    <div class="label">Hide On Mobile Devices</div>
                    <input type="checkbox" name="fl-mobile-hide" value="1" <?php if ($mobile == 1) { echo 'checked'; } ?>> Hide
                </div>
                <div class="form-row">
                    <div class="label">Set CSS Animation Duration (in ms)</div>
                    <small>* in defaults 100ms</small>
                    <input type="number" name="fl-duration" value="<?php echo $duration; ?>">
                </div>
                <div class="form-row">
                    <div class="label">Set Margin Between Menu Items (in px)</div>
                    <small>* in defaults 10px</small>
                    <input type="number" name="fl-margin" value="<?php echo $margin; ?>">
                </div>
                <div class="form-row">
                    <?php wp_nonce_field('fl_btn_action','fl_btn_nonce_field'); ?>
                    <button type="submit" class="button button-primary button-large">Submit</button>
                </div>
            </form>
        </div>
    <?php }
}

function fl_btn_scripts($hook) {
    if ( 'toplevel_page_flbtn-main' != $hook ) {
        return;
    }
    $plugin_url = plugins_url('floating-btn-menu');

    wp_enqueue_style( 'fl-admin', $plugin_url . '/admin/css/fl-admin.css' );
    wp_enqueue_style( 'fl-admin-fa', $plugin_url . '/assets/css/font-awesome.min.css' );
    wp_enqueue_style( 'wp-color-picker' );

    wp_enqueue_script( 'fl-admin-js', $plugin_url . '/admin/js/fl-admin.js', array('jquery'), '', true);
    wp_enqueue_script( 'wp-color-picker' );
}



new FlBtnAdminPage;