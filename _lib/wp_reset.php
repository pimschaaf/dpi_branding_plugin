<?php
if (!is_admin()) {
    // For frontend

    if (get_option('dpib_wp_disable_toolbar')) {
        add_filter('show_admin_bar', '__return_false');
    }

    if (get_option('dpib_wp_disable_rsd')) {
        remove_action('wp_head', 'rsd_link');
    }

    if (get_option('dpib_wp_disable_wlw')) {
        remove_action('wp_head', 'wlwmanifest_link');
    }

    if (get_option('dpib_wp_disable_generator')) {
        function remove_generator() {
            return '';
        }

        add_filter('the_generator', 'remove_generator');
        remove_action('wp_head', 'wp_generator');
    }

    if (get_option('dpib_wp_disable_emoji_styles')) {	
		/**
		 * Filter function used to remove the tinymce emoji plugin.
		 * 
		 * @param    array  $plugins  
		 * @return   array             Difference betwen the two arrays
		 */
		function disable_emojis_tinymce( $plugins ) {
			if ( is_array( $plugins ) ) {
				return array_diff( $plugins, array( 'wpemoji' ) );
			} else {
				return array();
			}
		}

		function disable_emojis() {	
			remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
			remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
			remove_action( 'wp_print_styles', 'print_emoji_styles' );
			remove_action( 'admin_print_styles', 'print_emoji_styles' );	
			remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
			remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
			remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
			add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
		}
		add_action( 'init', 'disable_emojis' );
    }

    if (get_option('dpib_wp_disable_rest_api')) {
        function disable_rest_api() {
            // Filters for WP-API version 1.x
            add_filter('json_enabled', '__return_false');
            add_filter('json_jsonp_enabled', '__return_false');

            // Filters for WP-API version 2.x
            add_filter('rest_enabled', '__return_false');
            add_filter('rest_jsonp_enabled', '__return_false');

            // Remove REST API info from head and headers
            remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );
            remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
            remove_action( 'template_redirect', 'rest_output_link_header', 11 );
        }
        add_action('init', 'disable_rest_api');
    }

    function add_pingback_url() {
        if (get_option('dpib_wp_add_pingback_link')) {
            echo '<link rel="pingback" href="' . get_bloginfo( 'pingback_url' ) . '">';
        }
    }
    add_action ( 'wp_enqueue_scripts', 'add_pingback_url' );

} else {

    // For backend
    function hide_update_notice_to_all_but_admin_users()
    {
        if (!current_user_can('update_core')) {
            remove_action( 'admin_notices', 'update_nag', 3 );
        }
    }
    add_action( 'admin_head', 'hide_update_notice_to_all_but_admin_users', 1 );

}

//Both frontend and backend
if (get_option('dpib_wp_disable_embeds')) {
    function disable_embeds() {
        /* @var WP $wp */
        global $wp;

        // Remove the embed query var.
        $wp->public_query_vars = array_diff( $wp->public_query_vars, array(
            'embed',
        ) );

        // Remove the REST API endpoint.
        remove_action( 'rest_api_init', 'wp_oembed_register_route' );

        // Turn off oEmbed auto discovery.
        add_filter( 'embed_oembed_discover', '__return_false' );

        // Don't filter oEmbed results.
        remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );

        // Remove oEmbed discovery links.
        remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

        // Remove oEmbed-specific JavaScript from the front-end and back-end.
        remove_action( 'wp_head', 'wp_oembed_add_host_js' );
        add_filter( 'tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin' );

        // Remove all embeds rewrite rules.
        add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
    }
    add_action ( 'init', 'disable_embeds', 9999 );

    /**
     * Removes the 'wpembed' TinyMCE plugin.
     *
     * @since 1.0.0
     *
     * @param array $plugins List of TinyMCE plugins.
     * @return array The modified list.
     */
    function disable_embeds_tiny_mce_plugin( $plugins ) {
        return array_diff( $plugins, array( 'wpembed' ) );
    }
}
