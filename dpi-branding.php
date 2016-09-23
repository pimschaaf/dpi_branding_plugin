<?php
/**
 * Plugin Name: DPI Branding
 * Plugin URI: http://www.dpi.nl
 * Description: Brands the WordPress dashboard for DPI Animation House
 * Version: 1.0
 * Author: Pim Schaaf
 * Author URI: http://www.dpi.nl
 * License: GPL2
 */

/*  Copyright 2014  Pim Schaaf  (email : pim@dpi.nl)

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

*/

defined('ABSPATH') or die("Sorry, this file is blocked. Contact the web developer.");
require_once(ABSPATH . '/wp-includes/pluggable.php');
require_once(ABSPATH . '/wp-admin/includes/file.php');
require_once(ABSPATH . '/wp-admin/includes/misc.php');

if (current_user_can('manage_options')) {
    require_once(plugin_dir_path( __FILE__ ) . '_lib/options.php');
}

if (get_option('dpib_wp_reset')) {
    require_once(plugin_dir_path( __FILE__ ) . '_lib/wp_reset.php');
}

require_once(plugin_dir_path( __FILE__ ) . '_lib/wp_pagespeed.php');
require_once(plugin_dir_path( __FILE__ ) . '_lib/google.php');
require_once(plugin_dir_path( __FILE__ ) . '_lib/social.php');

function my_admin_scripts() {
    if (is_admin() && isset($_GET['page']) && $_GET['page'] == 'dpib-settings') {
        wp_enqueue_media();
        wp_register_script('dpi-branding', plugins_url('dpi-branding/attribs/js')."/main.js", array('jquery'));
        wp_enqueue_script('dpi-branding');
    }
}
add_action('admin_enqueue_scripts', 'my_admin_scripts');

/**
 * Change the logo on the wp-login.php page
 */

function dpib_login_logo_style() {
    wp_enqueue_style( 'dpib', plugins_url('dpi-branding/attribs/css')."/dpi-logo.css");

    $path = get_option('dpib_logo_path') ? get_option('dpib_logo_path') : plugins_url('dpi-branding/attribs/img')."/DPI_logo.png";
    echo '<style>
            body.login div#login h1 a {
                background-image: url(' . $path . ');
            }
         </style>';
}

function dpib_login_logo_url() {
    return get_option('dpib_logo_url', "http://www.dpi.nl");
}

function dpib_login_logo_url_title() {
    return get_option('dpib_logo_title', "DPI Animation House");
}

if (get_option('dpib_logo')) {
    add_action( 'login_enqueue_scripts', 'dpib_login_logo_style' );
    add_filter( 'login_headerurl', 'dpib_login_logo_url' );
    add_filter( 'login_headertitle', 'dpib_login_logo_url_title' );
}

/**
 * Add a widget to the dashboard.
 */
function dpib_add_news_widget() {

    wp_add_dashboard_widget(
        'dpib_news_widget',
        get_option('dpib_news_widget_title', get_option('dpib_news_widget_title', "DPI Nieuws")),
        'dpib_news_widget_function'
    );
}

function dpib_add_vcard_widget() {

    wp_add_dashboard_widget(
        'dpib_vcard_widget',
        get_option('dpib_vcard_widget_title', get_option('dpib_vcard_widget_title', "DPI Nieuws")),
        'dpib_vcard_widget_function'
    );
    wp_enqueue_style( 'dpib', plugins_url('dpi-branding/attribs/css')."/dpib-vcard.css");
}

function dpib_news_widget_function() {
    include("_lib/widgets/news.php");
}

function dpib_vcard_widget_function() {
    include("_lib/widgets/vcard.php");
}

if (get_option('dpib_news_widget')) {
    add_action( 'wp_dashboard_setup', 'dpib_add_news_widget' );
}

if (get_option('dpib_vcard_widget')) {
    add_action( 'wp_dashboard_setup', 'dpib_add_vcard_widget' );
}

function remove_dashboard_meta() {
    if (get_option('dpib_welcome_panel') || get_option('dpib_disable_widgets'))   { remove_action( 'welcome_panel', 'wp_welcome_panel' ); }
    if (get_option('dpib_incoming_links') || get_option('dpib_disable_widgets'))  { remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' ); }
    if (get_option('dpib_primary') || get_option('dpib_disable_widgets'))         { remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' ); }
    if (get_option('dpib_secondary') || get_option('dpib_disable_widgets'))       { remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' ); }
    if (get_option('dpib_quick_press') || get_option('dpib_disable_widgets'))     { remove_meta_box( 'dashboard_quick_press', 'dashboard', 'normal' ); }
    if (get_option('dpib_recent_drafts') || get_option('dpib_disable_widgets'))   { remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'normal' ); }
    if (get_option('dpib_recent_comments') || get_option('dpib_disable_widgets')) { remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' ); }
    if (get_option('dpib_right_now') || get_option('dpib_disable_widgets'))       { remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' ); }
    if (get_option('dpib_activity') || get_option('dpib_disable_widgets'))        { remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' ); }
}
add_action( 'admin_init', 'remove_dashboard_meta' );

function dpib_write_htaccess($lines = array()) {
    $htaccess = get_home_path().".htaccess";
    insert_with_markers($htaccess, "DPI Pagespeed", $lines);
}

// Exclude this plugin from update checks
function dpi_branding( $r, $url ) {
    if ( 0 !== strpos( $url, 'http://api.wordpress.org/plugins/update-check' ) )
        return $r;

    $plugins = unserialize( $r['body']['plugins'] );
    unset(
    $plugins->plugins[ plugin_basename( __FILE__ ) ],
    $plugins->active[ array_search( plugin_basename( __FILE__ ), $plugins->active ) ]
    );
    $r['body']['plugins'] = serialize( $plugins );

    return $r;
}
add_filter( 'http_request_args', 'dpi_branding', 5, 2 );