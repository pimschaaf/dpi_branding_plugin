<?php
/**
 * Display the RSS entries in a list.
 *
 * Custom wp_widget_rss_output() function
 */
function dpib_widget_rss_output( $rss, $args = array() ) {
    if ( is_string( $rss ) ) {
        $rss = fetch_feed($rss);
    } elseif ( is_array($rss) && isset($rss['url']) ) {
        $args = $rss;
        $rss = fetch_feed($rss['url']);
    } elseif ( !is_object($rss) ) {
        return;
    }

    if ( is_wp_error($rss) ) {
        if ( is_admin() || current_user_can('manage_options') )
            echo '<p>' . sprintf( __('<strong>RSS Error</strong>: %s'), $rss->get_error_message() ) . '</p>';
        return;
    }

    $default_args = array( 'show_author' => 0, 'show_date' => 0, 'show_summary' => 0 );
    $args = wp_parse_args( $args, $default_args );
    extract( $args, EXTR_SKIP );

    $items = (int) $items;
    if ( $items < 1 || 20 < $items )
        $items = 10;
    $show_summary  = (int) $show_summary;
    $show_author   = (int) $show_author;
    $show_date     = (int) $show_date;

    if ( !$rss->get_item_quantity() ) {
        echo '<ul><li>' . __( 'An error has occurred, which probably means the feed is down. Try again later.' ) . '</li></ul>';
        $rss->__destruct();
        unset($rss);
        return;
    }

    echo '<ul>';
    foreach ( $rss->get_items(0, $items) as $item ) {
        $link = $item->get_link();
        while ( stristr($link, 'http') != $link )
            $link = substr($link, 1);
        $link = esc_url(strip_tags($link));
        $title = esc_attr(strip_tags($item->get_title()));
        if ( empty($title) )
            $title = __('Untitled');

        $desc = @html_entity_decode( $item->get_description(), ENT_QUOTES, get_option( 'blog_charset' ) );
        $desc = esc_attr( strip_tags( $desc ) );
        $desc = trim( str_replace( array( "\n", "\r" ), ' ', $desc ) );
        $desc = wp_html_excerpt( $desc, 360 );

        $summary = '';
        if ( $show_summary ) {
            $summary = $desc;

            // Append ellipsis. Change existing [...] to [&hellip;].
            if ( '[...]' == substr( $summary, -5 ) ) {
                $summary = substr( $summary, 0, -5 ) . '[&hellip;]';
            } elseif ( '[&hellip;]' != substr( $summary, -10 ) && $desc !== $summary ) {
                $summary .= ' [&hellip;]';
            }

            $summary = '<div class="rssSummary">' . esc_html( $summary ) . '</div>';
        }

        $date = '';
        if ( $show_date ) {
            $date = $item->get_date( 'U' );

            if ( $date ) {
                $date = ' <span class="rss-date">' . date_i18n( get_option( 'date_format' ), $date ) . '</span>';
            }
        }

        $author = '';
        if ( $show_author ) {
            $author = $item->get_author();
            if ( is_object($author) ) {
                $author = $author->get_name();
                $author = ' <cite>' . esc_html( strip_tags( $author ) ) . '</cite>';
            }
        }

        if ( $link == '' ) {
            echo "<li>$title{$date}{$summary}{$author}</li>";
        } elseif ( $show_summary ) {
            echo "<li><a class='rsswidget' target=\"_blank\" href='$link'>$title</a>{$date}{$summary}{$author}</li>";
        } else {
            echo "<li><a class='rsswidget' target=\"_blank\" href='$link' title='$desc'>$title</a>{$date}{$author}</li>";
        }
    }
    echo '</ul>';
    $rss->__destruct();
    unset($rss);
}

echo '<div class="rss-widget">';
    dpib_widget_rss_output(array(
        'url' => get_option('dpib_news_widget_feed'),
        'items' => 3,
        'show_summary' => 1,
        'show_author' => 1,
        'show_date' => 1,
    ));
echo "</div>";