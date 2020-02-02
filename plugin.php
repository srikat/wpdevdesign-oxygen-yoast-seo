<?php
/*
Plugin Name:	WPDevDesign Oxygen Yoast SEO
Plugin URI:		https://wpdevdesign.com/fix-for-yoast-seo-in-oxygen/
Description:	Includes WordPress content in Yoast's SEO analsysis when using Oxygen.
Version:		1.0.0
Author:			Sridhar Katakam
Author URI:		https://wpdevdesign.com
License:		GPL-2.0+
License URI:	http://www.gnu.org/licenses/gpl-2.0.txt

This plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

This plugin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with This plugin. If not, see {URI to Plugin License}.
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

remove_action( 'admin_enqueue_scripts', 'oxygen_vsb_yoast_compatibility', 11 );

add_action( 'admin_enqueue_scripts', 'wpdd_oxygen_yoast_compatibility', 11 );
/**
 * Loads <list assets here>.
 */
function wpdd_oxygen_yoast_compatibility() {
	// check if Yoast Seo is active
	if ( ! is_plugin_active( 'wordpress-seo/wp-seo.php' ) && ! is_plugin_active( 'wordpress-seo-premium/wp-seo-premium.php' ) ) {
		return;
	}

	global $pagenow;
	global $post;

	// save global $post to restore later
	$saved_post = $post;

	// exclude templates
	if ( is_object( $post ) && $post->post_type=='ct_template' ) {
		return;
	}

	if ( 'post.php' == $pagenow && ! is_null( $post ) ) {
		wp_enqueue_script( 'ysco-oxygen-analysis', plugin_dir_url( __FILE__ ) . '/assets/js/yoast-seo-compatibility.js', array( 'jquery' ), false, true );
		wp_localize_script( 'ysco-oxygen-analysis', 'ysco_data', array(
			'oxygen_markup' => ct_do_shortcode( get_post_meta( $post->ID, 'ct_builder_shortcodes', true ) )
		) );
	}

	// restore original global post
	$post = $saved_post;
}
