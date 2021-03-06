<?php
function dpib_ga() {
    if( get_option('dpib_google_ga_type') && get_option('dpib_google_ga_id') )  {
        switch(get_option('dpib_google_ga_type')) {
            case '1':
                echo "
                <script type=\"text/javascript\">

                  var _gaq = _gaq || [];
                  _gaq.push(['_setAccount', '" . get_option('dpib_google_ga_id') . "']);
                  _gaq.push(['_trackPageview']);

                  (function() {
                    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
                  })();

                </script>
                ";
                break;
            case '2':
                echo "
                <script>
                  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

                  ga('create', '" . get_option('dpib_google_ga_id') . "', 'auto');
                  ga('send', 'pageview');

                </script>
                ";
                break;
        }
    } else {
        echo '<!-- Warning: Google Analytics integration not complete -->';
    }
}

if (get_option('dpib_google_ga')) {
    add_action('wp_head', 'dpib_ga');
}