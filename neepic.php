<?php
/*
Plugin Name: NeePic - Cloud Image Hosting
Description: Integrating NeePic with WordPress. All details <a href='http://neepic.net/plugin'>here</a>.
Version: 1.0.0
Requires at least: WP 2.9
Tested up to: WP 3.8
License: GNU General Public License 2.0 (GPL) http://www.gnu.org/licenses/gpl.html
Author: NeePic
Text Domain: neepic
Author URI: http://neepic.net/
Plugin URI: http://neepic.net/plugin
Maximum image size: 5 Mb
Allowed image formats: JPEG, PNG and GIF
Last Modified: 13 December, 2013
*/

// wp-admin
add_action('admin_enqueue_scripts', array('NeepicPlugin','neepic_admin'));

// user comments
add_action('wp_enqueue_scripts', array('NeepicPlugin','neepic_comments'));
add_shortcode('neepic', array('NeepicPlugin', 'neepicShortCode'));
add_filter('comment_text', 'do_shortcode');

// internationalization
load_plugin_textdomain('neepic', false, basename( dirname( __FILE__ ) ) . '/languages' );

class NeepicPlugin
{
    protected static function localize($scriptName){
        wp_localize_script( $scriptName, 'neepicL10n', array(
            'add_image'  => __('Add image', 'neepic'),
            'uploading' => __('Uploading', 'neepic'),
            'saving' => __('Saving', 'neepic'),
        ));
    }

    public static function neepic_admin()
    {
        wp_enqueue_script(
            'neepic-admin',
            plugins_url( '/js/neepic-admin.js' , __FILE__ )
        );
        self::localize('neepic-admin');
    }

    public static function neepic_comments()
    {
        wp_enqueue_script(
            'neepic',
            plugins_url( '/js/neepic.js' , __FILE__ )
        );
        self::localize('neepic');
    }

    public static function neepicShortCode($atts) {
        extract(shortcode_atts(array(
            'id' => '',
            'preview' => '',
            'name' => ''
        ), $atts));
        return "<a href='http://neepic.net/{$id}'><img src='{$preview}' title='{$name}' alt='{$name}'></a>";
    }
}

