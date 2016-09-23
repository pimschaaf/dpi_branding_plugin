<?php
/* Add Menu option
-----------------------------------------------------------------*/
add_action('admin_menu', 'dpib_admin');
function dpib_admin() {
    /* Base Menu */
    add_options_page('DPI Branding', 'DPI Branding', 'administrator', 'dpib-settings', 'dpib_settings_page');
}

/* Add sections with options
-----------------------------------------------------------------*/
add_action('admin_init', 'dpib_options');
function dpib_options() {
    /**
     * Dashboard Options Section
     */
    add_settings_section(
        'dpib_dashboard',
        'Dashboard options',
        'dpib_dashboard_callback',
        'dpib_dashboard_options'
    );

    //DPI Dashboard widgets
    add_settings_field( 'dpib_news_widget', 'DPI News Dashboard widget', 'dpib_checkbox_callback', 'dpib_dashboard_options', 'dpib_dashboard', array('name' => 'dpib_news_widget', 'default' => false) );
    add_settings_field( 'dpib_news_widget_title', 'DPI News Widget titel', 'dpib_textbox_callback', 'dpib_dashboard_options', 'dpib_dashboard', array('name' => 'dpib_news_widget_title', 'default' => 'DPI Nieuws', 'placeholder' => 'DPI Nieuws'));
    add_settings_field( 'dpib_news_widget_feed', 'DPI News Widget feed <br/><small><em>URL van RSS feed</em></small>', 'dpib_textbox_callback', 'dpib_dashboard_options', 'dpib_dashboard', array('name' => 'dpib_news_widget_feed', 'default' => 'http://blog.dpi.nl/categorie/techniek/feed/', 'placeholder' => 'http://'));
    add_settings_field( 'dpib_vcard_widget', 'DPI Vcard Dashboard widget', 'dpib_checkbox_callback', 'dpib_dashboard_options', 'dpib_dashboard', array('name' => 'dpib_vcard_widget', 'default' => false) );
    add_settings_field( 'dpib_vcard_widget_title', 'DPI Vcard Widget titel', 'dpib_textbox_callback', 'dpib_dashboard_options', 'dpib_dashboard', array('name' => 'dpib_vcard_widget_title', 'default' => 'DPI Support', 'placeholder' => 'DPI Support'));

    register_setting( 'dpib_dashboard_options', 'dpib_news_widget');
    register_setting( 'dpib_dashboard_options', 'dpib_news_widget_title');
    register_setting( 'dpib_dashboard_options', 'dpib_news_widget_feed');
    register_setting( 'dpib_dashboard_options', 'dpib_vcard_widget');
    register_setting( 'dpib_dashboard_options', 'dpib_vcard_widget_title');

    //Default dashboard widgets
    add_settings_field( 'dpib_disable_widgets', 'Disable All Native Widgets <br /><small><em>overrides widget specific settings</em></small>', 'dpib_checkbox_callback', 'dpib_dashboard_options', 'dpib_dashboard', array('name' => 'dpib_disable_widgets', 'default' => false) );
    add_settings_field( 'dpib_welcome_panel', 'Disable Welcome Panel', 'dpib_checkbox_callback', 'dpib_dashboard_options', 'dpib_dashboard', array('name' => 'dpib_welcome_panel', 'default' => false) );
    add_settings_field( 'dpib_primary', 'Disable Wordpress News', 'dpib_checkbox_callback', 'dpib_dashboard_options', 'dpib_dashboard', array('name' => 'dpib_primary', 'default' => false) );
    add_settings_field( 'dpib_quick_press', 'Disable Quick Draft', 'dpib_checkbox_callback', 'dpib_dashboard_options', 'dpib_dashboard', array('name' => 'dpib_quick_press', 'default' => false) );
    add_settings_field( 'dpib_right_now', 'Disable At a Glance', 'dpib_checkbox_callback', 'dpib_dashboard_options', 'dpib_dashboard', array('name' => 'dpib_right_now', 'default' => false) );
    add_settings_field( 'dpib_activity', 'Disable Activity', 'dpib_checkbox_callback', 'dpib_dashboard_options', 'dpib_dashboard', array('name' => 'dpib_activity', 'default' => false) );

    register_setting( 'dpib_dashboard_options', 'dpib_disable_widgets');
    register_setting( 'dpib_dashboard_options', 'dpib_welcome_panel');
    register_setting( 'dpib_dashboard_options', 'dpib_primary');
    register_setting( 'dpib_dashboard_options', 'dpib_quick_press');
    register_setting( 'dpib_dashboard_options', 'dpib_right_now');
    register_setting( 'dpib_dashboard_options', 'dpib_activity');

    if (false): //These widgets have been described as dashboard widgets, but don't appear in WordPress 3.9.1+
        add_settings_field( 'dpib_incoming_links', 'Unknown widget', 'dpib_checkbox_callback', 'dpib_dashboard_options', 'dpib_dashboard', array('name' => 'dpib_incoming_links', 'default' => false) );
        add_settings_field( 'dpib_plugins', 'Unknown widget', 'dpib_checkbox_callback', 'dpib_dashboard_options', 'dpib_dashboard', array('name' => 'dpib_plugins', 'default' => false) );
        add_settings_field( 'dpib_secondary', 'Unknown widget', 'dpib_checkbox_callback', 'dpib_dashboard_options', 'dpib_dashboard', array('name' => 'dpib_secondary', 'default' => false) );
        add_settings_field( 'dpib_recent_drafts', 'Unknown widget', 'dpib_checkbox_callback', 'dpib_dashboard_options', 'dpib_dashboard', array('name' => 'dpib_recent_drafts', 'default' => false) );
        add_settings_field( 'dpib_recent_comments', 'Unknown widget', 'dpib_checkbox_callback', 'dpib_dashboard_options', 'dpib_dashboard', array('name' => 'dpib_recent_comments', 'default' => false) );

        register_setting( 'dpib_dashboard_options', 'dpib_incoming_links');
        register_setting( 'dpib_dashboard_options', 'dpib_plugins');
        register_setting( 'dpib_dashboard_options', 'dpib_secondary');
        register_setting( 'dpib_dashboard_options', 'dpib_recent_drafts');
        register_setting( 'dpib_dashboard_options', 'dpib_recent_comments');
    endif;

    /**
     * Login Options Section
     */
    add_settings_section(
        'dpib_login',
        'Login options',
        'dpib_login_callback',
        'dpib_login_options'
    );

    add_settings_field( 'dpib_logo', 'Custom logo op wp-login', 'dpib_checkbox_callback', 'dpib_login_options', 'dpib_login', array('name' => 'dpib_logo', 'default' => false) );
    add_settings_field( 'dpib_logo_path', 'Afbeeldingpad <br/><small><em>(166x115px)</em></small>', 'dpib_upload_callback', 'dpib_login_options', 'dpib_login', array('name' => 'dpib_logo_path', 'placeholder' => 'http://') );
    add_settings_field( 'dpib_logo_url', 'Logo url', 'dpib_textbox_callback', 'dpib_login_options', 'dpib_login', array('name' => 'dpib_logo_url', 'default' => 'http://www.dpi.nl', 'placeholder' => 'http://'));
    add_settings_field( 'dpib_logo_title', 'Logo title', 'dpib_textbox_callback', 'dpib_login_options', 'dpib_login', array('name' => 'dpib_logo_title', 'default' => 'DPI Animation House', 'placeholder' => ''));

    register_setting( 'dpib_login_options', 'dpib_logo' );
    register_setting( 'dpib_login_options', 'dpib_logo_path' );
    register_setting( 'dpib_login_options', 'dpib_logo_url' );
    register_setting( 'dpib_login_options', 'dpib_logo_title' );

    /**
     * WordPress Options Section
     */
    add_settings_section(
        'dpib_wordpress',
        'WordPress options',
        'dpib_wordpress_callback',
        'dpib_wordpress_options'
    );

    add_settings_field( 'dpib_wp_reset', 'Reset WordPress <br /><small><em>If unchecked: cancels the following options</em></small>', 'dpib_checkbox_callback', 'dpib_wordpress_options', 'dpib_wordpress', array('name' => 'dpib_wp_reset', 'default' => false) );
    add_settings_field( 'dpib_wp_disable_toolbar', 'Disable toolbar on frontend <br/><small><em>For non-admins</em></small>', 'dpib_checkbox_callback', 'dpib_wordpress_options', 'dpib_wordpress', array('name' => 'dpib_wp_disable_toolbar', 'default' => false) );
    add_settings_field( 'dpib_wp_disable_rsd', 'Disable RSD support', 'dpib_checkbox_callback', 'dpib_wordpress_options', 'dpib_wordpress', array('name' => 'dpib_wp_disable_rsd', 'default' => false) );
    add_settings_field( 'dpib_wp_disable_wlw', 'Disable WLW support', 'dpib_checkbox_callback', 'dpib_wordpress_options', 'dpib_wordpress', array('name' => 'dpib_wp_disable_wlw', 'default' => false) );
    add_settings_field( 'dpib_wp_disable_generator', 'Disable generator', 'dpib_checkbox_callback', 'dpib_wordpress_options', 'dpib_wordpress', array('name' => 'dpib_wp_disable_generator', 'default' => false) );
    add_settings_field( 'dpib_wp_disable_emoji_styles', 'Disable WP 4.2 emoji styles', 'dpib_checkbox_callback', 'dpib_wordpress_options', 'dpib_wordpress', array('name' => 'dpib_wp_disable_emoji_styles', 'default' => false) );
    add_settings_field( 'dpib_wp_disable_rest_api', 'Disable Rest API <br/><small><em>note: WP embeds rely on the Rest API.</em></small>', 'dpib_checkbox_callback', 'dpib_wordpress_options', 'dpib_wordpress', array('name' => 'dpib_wp_disable_rest_api', 'default' => false) );
    add_settings_field( 'dpib_wp_disable_embeds', 'Disable Embeds <br/><small><em>note: Embeds require the Rest API.</em></small>', 'dpib_checkbox_callback', 'dpib_wordpress_options', 'dpib_wordpress', array('name' => 'dpib_wp_disable_embeds', 'default' => false) );
    add_settings_field( 'dpib_wp_add_pingback_link', 'Add pingback link <br/><small><em>note: most themes will do this for you and you probably want this option disabled.</em></small>', 'dpib_checkbox_callback', 'dpib_wordpress_options', 'dpib_wordpress', array('name' => 'dpib_wp_add_pingback_link', 'default' => false) );

    register_setting('dpib_wordpress_options', 'dpib_wp_reset');
    register_setting('dpib_wordpress_options', 'dpib_wp_disable_toolbar');
    register_setting('dpib_wordpress_options', 'dpib_wp_disable_rsd');
    register_setting('dpib_wordpress_options', 'dpib_wp_disable_wlw');
    register_setting('dpib_wordpress_options', 'dpib_wp_disable_generator');
    register_setting('dpib_wordpress_options', 'dpib_wp_disable_emoji_styles');
    register_setting('dpib_wordpress_options', 'dpib_wp_disable_rest_api');
    register_setting('dpib_wordpress_options', 'dpib_wp_disable_embeds');
    register_setting('dpib_wordpress_options', 'dpib_wp_add_pingback_link');

    /**
     * Pagespeed Options Section
     */
    add_settings_section(
        'dpib_pagespeed',
        'Pagespeed options',
        'dpib_pagespeed_callback',
        'dpib_pagespeed_options'
    );

    add_settings_field( 'dpib_pagespeed_querystrings', 'Remove query strings from static resources', 'dpib_checkbox_callback', 'dpib_pagespeed_options', 'dpib_pagespeed', array('name' => 'dpib_pagespeed_querystrings', 'default' => false) );

    register_setting('dpib_pagespeed_options', 'dpib_pagespeed_querystrings');

    /**
     * Google Options Section
     */
    add_settings_section(
        'dpib_google',
        'Google options',
        'dpib_google_callback',
        'dpib_google_options'
    );

    add_settings_field( 'dpib_google_ga', 'Enable Google Analytics <br /><small><em>Requires code type and ID</em></small>', 'dpib_checkbox_callback', 'dpib_google_options', 'dpib_google', array('name' => 'dpib_google_ga', 'default' => false) );
    add_settings_field( 'dpib_google_ga_type', 'Google Analytics code type', 'dpib_radio_callback', 'dpib_google_options', 'dpib_google', array('name' => 'dpib_google_ga_type', 'radios' => array(1 => 'Old analytics (ga.js)', 2 => 'Universal Analytics (analytics.js)'), 'default' => false) );
    add_settings_field( 'dpib_google_ga_id', 'Google Analytics Tracking ID', 'dpib_textbox_callback', 'dpib_google_options', 'dpib_google', array('name' => 'dpib_google_ga_id', 'default' => false) );

    register_setting('dpib_google_options', 'dpib_google_ga');
    register_setting('dpib_google_options', 'dpib_google_ga_type');
    register_setting('dpib_google_options', 'dpib_google_ga_id');

    /**
     * Social Options Section
     */
    add_settings_section(
        'dpib_social',
        'Social options',
        'dpib_social_callback',
        'dpib_social_options'
    );

    add_settings_field( 'dpib_social_disable_comments', 'Disable comments <br /><small><em>Disables all comments and pingbacks <br/>Overwrites WordPress values and disables comments menus</em></small>', 'dpib_checkbox_callback', 'dpib_social_options', 'dpib_social', array('name' => 'dpib_social_disable_comments', 'default' => false) );

    register_setting('dpib_social_options', 'dpib_social_disable_comments');
}

/* Callbacks
-----------------------------------------------------------------*/
function dpib_dashboard_callback() {
    echo '<p>These options allow control over the custom widget display on the WordPress dashboard.</p>';
}

function dpib_login_callback() {
    echo '<p>These options allow some control over the login screen.</p>';
}

function dpib_wordpress_callback() {
    echo '<p>These options allow control over WordPress standard functionalities.</p>';
}

function dpib_pagespeed_callback() {
    echo '<p>These options allow control over Pagespeed options.</p>';
}

function dpib_google_callback() {
    echo '<p>These options allow control over Google code.</p>';
}

function dpib_social_callback() {
    echo '<p>These options allow control over social options.</p>';
}

function dpib_textbox_callback($args) {
    $val = get_option($args['name']) ? sanitize_text_field(get_option($args['name'])) : $args['default'];
    $placeholder = isset($args['placeholder']) ? $args['placeholder'] : '';
    echo '<input type="text" id="' . $args['name'] . '" name="' . $args['name'] . '" value="' . $val . '" placeholder="' . $placeholder . '"/>';
}

function dpib_textarea_callback($args) {
    $val = get_option($args['name']) ? sanitize_text_field(get_option($args['name'])) : $args['default'];
    echo '<textarea id="' . $args['name'] . '" name="' . $args['name'] . '" placeholder="' . $args['placeholder'] . '">' . $val . '</textarea>';
}

function dpib_checkbox_callback($args) {
    echo '<input type="checkbox" id="' . $args['name'] . '" name="' . $args['name'] . '" ' . checked(get_option($args['name']), 'on', false) . '/>';
}

function dpib_radio_callback($args) {
    $val = get_option($args['name']);

    $html = '';
    foreach ($args['radios'] as $idx => $radio) {
        $html .= '<input type="radio" id="'. $args['name'] . '_' . $idx . '" name="' . $args['name'] . '" value="' . $idx . '"' . checked( $idx, $val, false ) . '/>';
        $html .= '<label for="' . $args['name'] . '_' . $idx . '">' . $radio . '</label><br/>';
    }
    echo $html;
}

function dpib_upload_callback($args) {
    $val = get_option($args['name']) ? sanitize_text_field(get_option($args['name'])) : $args['default'];
    echo '
    <label for="upload_image">
        <input id="upload_image" type="text" size="36" name="' . $args['name'] . '" value="' . $val . '" placeholder="' . $args['placeholder'] . '" />
        <input id="upload_image_button" class="button" type="button" value="Upload Image" />
        <br />&nbsp;&nbsp;Enter a URL or upload an image
    </label>
    ';
}

//Select
//function dpib_featured_post_callback() {
//    query_posts( $args );
//
//    echo '<select id="featured_post" name="dpib_dashboard_option[featured_post]">';
//    while ( have_posts() ) : the_post();
//
//        $selected = selected($options[featured_post], get_the_id(), false);
//        printf('<option value="%s" %s>%s</option>', get_the_id(), $selected, get_the_title());
//
//    endwhile;
//    echo '</select>';
//}

/* Display Page
-----------------------------------------------------------------*/
function dpib_settings_page() { ?>
    <div class="wrap">
        <div id="icon-themes" class="icon32"></div>
        <h2>DPI Branding Options</h2>
        <?php
        $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'dashboard_options';
        ?>

        <h2 class="nav-tab-wrapper">
            <a href="?page=dpib-settings&tab=dashboard_options" class="nav-tab <?php echo $active_tab == 'dashboard_options' ? 'nav-tab-active' : ''; ?>">Dashboard</a>
            <a href="?page=dpib-settings&tab=login_options" class="nav-tab <?php echo $active_tab == 'login_options' ? 'nav-tab-active' : ''; ?>">Login</a>
            <a href="?page=dpib-settings&tab=wordpress_options" class="nav-tab <?php echo $active_tab == 'wordpress_options' ? 'nav-tab-active' : ''; ?>">WordPress</a>
            <a href="?page=dpib-settings&tab=pagespeed_options" class="nav-tab <?php echo $active_tab == 'pagespeed_options' ? 'nav-tab-active' : ''; ?>">Pagespeed</a>
            <a href="?page=dpib-settings&tab=google_options" class="nav-tab <?php echo $active_tab == 'google_options' ? 'nav-tab-active' : ''; ?>">Google</a>
            <a href="?page=dpib-settings&tab=social_options" class="nav-tab <?php echo $active_tab == 'social_options' ? 'nav-tab-active' : ''; ?>">Social</a>
        </h2>

        <form method="post" action="options.php">
            <?php submit_button($text = null, $type = 'primary', $name = 'submit', $wrap = false, $other_attributes = array('style' => 'float:right;')); ?>
            <?php
            switch ($active_tab) {
                case 'dashboard_options':
                    settings_fields( 'dpib_dashboard_options' );
                    do_settings_sections( 'dpib_dashboard_options' );
                    break;
                case 'login_options':
                    settings_fields( 'dpib_login_options' );
                    do_settings_sections( 'dpib_login_options' );
                    break;
                case 'wordpress_options':
                    settings_fields( 'dpib_wordpress_options' );
                    do_settings_sections( 'dpib_wordpress_options' );
                    break;
                case 'pagespeed_options':
                    settings_fields( 'dpib_pagespeed_options' );
                    do_settings_sections( 'dpib_pagespeed_options' );
                    break;
                case 'google_options':
                    settings_fields( 'dpib_google_options' );
                    do_settings_sections( 'dpib_google_options' );
                    break;
                case 'social_options':
                    settings_fields( 'dpib_social_options' );
                    do_settings_sections( 'dpib_social_options' );
                    break;
            }
            ?>
            <?php submit_button($text = null, $type = 'primary', $name = 'submit', $wrap = true, $other_attributes = array('style' => 'float:right;')); ?>
        </form>

    </div>
<?php
}