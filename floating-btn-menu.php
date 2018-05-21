<?php

/*
Plugin Name: Floating Button Menu
Version: 1.0
Author: Vitaly Kazak
*/

/* Define Plugin Dir */
define('FL_BTN_PLAGINURL', WP_PLUGIN_DIR.'/floating-btn-menu');

/* Create Table If Not Exists */
function fl_btn_create_table() {
    global $wpdb;
    $charset_collate = "DEFAULT CHARACTER SET ".$wpdb->charset." COLLATE ".$wpdb->collate."";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    $fl_btn_table_name = $wpdb->prefix . 'fl_btn';
    if ($wpdb->get_var("SHOW TABLES LIKE '".$fl_btn_table_name."'") != $fl_btn_table_name) {

        $sql_textes = "CREATE TABLE " . $fl_btn_table_name . " (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  variation mediumint(9) NOT NULL,
		  form mediumint(9) NOT NULL,
		  icon mediumint(9) NOT NULL,
		  fa VARCHAR(255) NOT NULL,
		  text VARCHAR(255) NOT NULL,
		  menu mediumint(9) NOT NULL,
		  color VARCHAR(255) NOT NULL,
		  bg VARCHAR(100) NOT NULL,
		  size mediumint(9) NOT NULL,
		  position mediumint(9) NOT NULL,
		  mobile mediumint(9) NOT NULL,
		  duration mediumint(9) NOT NULL,
		  margin mediumint(9) NOT NULL,
		  UNIQUE KEY id (id)
		) ".$charset_collate.";";

        dbDelta($sql_textes);
    }
    $menus = wp_get_nav_menus();
    if (! empty($menus)) :
        $firstMenuId = $menus[0]->term_id;
    else :
        $firstMenuId = '';
    endif;
    /*Create default*/
    $wpdb->insert(
        $fl_btn_table_name,
        array(
            'variation' => 1,
            'form' => 1,
            'icon' => 1,
            'fa' => 'bars',
            'menu' => $firstMenuId,
            'color' => '#f1f1f1',
            'bg' => '#8892BF',
            'size' => 14,
            'position' => 0,
            'mobile' => 0,
            'duration' => 100,
            'margin' => 10,
        )
    );
}

register_activation_hook(__FILE__, 'fl_btn_create_table');

/* Remove Table On Deactivation*/
function fl_btn_remove_table() {
    global $wpdb;
    $fl_btn_table_name = $wpdb->prefix . 'fl_btn';
    $sql = "DROP TABLE IF EXISTS $fl_btn_table_name";
    $wpdb->query($sql);
    delete_option("my_plugin_db_version");
}

register_uninstall_hook( __FILE__, fl_btn_remove_table );

/*Admin Page*/
include FL_BTN_PLAGINURL.'/admin/class-fl-adminpage.php';

/*Frontend Class*/
include FL_BTN_PLAGINURL.'/public/class-fl-public.php';