<?php
/*
Plugin Name: Social Warfare - Floating Footer Options
Plugin URI: https://github.com/Developd/social-warfare-floating-footer-options/
Description: Adds options for a floating background color in the footer.
Version: 0.1.0
Author: Kyle B. Johnson
Author URI: http://kylebjohnson.me
*/

final class KBJ_SocialWarfare_FloatingFooter
{
    public function __construct()
    {
        // Queue up your filter to be ran on the sw_options hook.
        add_filter('sw_options', array( $this, 'sw_options_function' ) );

        add_action( 'wp_footer', array( $this, 'sw_background_color_footer' ) );
    }


    // Create the function that will filter the options
    public function sw_options_function($sw_options)
    {
        $sw_options['options']['floatingButtons'][ 'floatFooterTitle' ] = array(
            'type' => 'title',
            'content' => 'Floating Share Buttons - Footer Options'
        );

        $sw_options['options']['floatingButtons'][ 'floatFooterSelector' ] = array(
            'type' => 'textbox',
            'content' => 'Footer CSS Selector'
        );

        $sw_options['options']['floatingButtons'][ 'floatFooterBgColor' ] = array(
            'type' => 'colorselect',
            'name' => 'Footer Background Color Footer',
            'default' => '#ffffff'
        );


        // Be sure to return the modified options array or the world will explode
        return $sw_options;
    }

    public function sw_background_color_footer()
    {
        $sw_user_options = sw_get_user_options();

        ?>
        <style>
            .nc_wrapper {
                transition: background-color .2s ease;
                -moz-transition: background-color .2s ease;
                -webkit-transition: background-color .2s ease;
            }
        </style>
        <script>
            var iScrollPos = 0;
            jQuery(window).scroll(function() {

                if( ! jQuery('<?php echo $sw_user_options['floatFooterSelector']; ?>') ) return;

                var iCurScrollPos = jQuery(this).scrollTop();
                if (iCurScrollPos > iScrollPos) {

                    // Scrolling Down
                    if(
                        jQuery(window).scrollTop() + jQuery(window).height()
                        > jQuery(document).height()
                        - jQuery('<?php echo $sw_user_options['floatFooterSelector']; ?>').outerHeight()
                        - jQuery( '.nc_wrapper' ).outerHeight()
                    ){
                        jQuery( '.nc_wrapper' ).css('background-color', '<?php echo $sw_user_options['floatFooterBgColor']; ?>');
                    }

                } else {

                    //Scrolling Up
                    if(
                        jQuery(window).scrollTop() + jQuery(window).height()
                        < jQuery(document).height()
                        - jQuery('<?php echo $sw_user_options['floatFooterSelector']; ?>').outerHeight()
                    ){
                        jQuery( '.nc_wrapper' ).css('background-color', '<?php echo $sw_user_options['floatBgColor']; ?>');
                    }

                }

                iScrollPos = iCurScrollPos;

            });
        </script>
        <?php
    }
}

new KBJ_SocialWarfare_FloatingFooter();
