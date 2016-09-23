<?php
// See http://wiki.intern/index.php/WordPress-Pagespeed
if (get_option('dpib_pagespeed_querystrings')) {
    // Remove query string from static files
    function remove_cssjs_ver( $src ) {
        if( strpos( $src, '?ver=' ) )
            $src = remove_query_arg( 'ver', $src );
        return $src;
    }
    add_filter( 'style_loader_src', 'remove_cssjs_ver', 10, 2 );
    add_filter( 'script_loader_src', 'remove_cssjs_ver', 10, 2 );
}