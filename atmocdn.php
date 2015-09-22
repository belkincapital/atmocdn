<?php
/*
    Plugin Name: atmocdn
    Plugin URI: https://atmocdn.com
    Description: A secure global end-to-end content delivery network.
    Author: Belkin Capital Ltd
    Author URI: https://belkincapital.com/
    Version: 1.4.9
    License: GNU General Public License 2.0
    License URI: http://www.gnu.org/licenses/gpl-2.0.txt
    
    Copyright 2015 Created by Jason Jersey of Belkin Capital Ltd.
    Contact: https://belkincapital.com/contact/

    This plugin is opensource; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License,
    or (at your option) any later version (if applicable).

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111 USA
*/


/** exit if accessed directly **/
if ( ! defined( 'ABSPATH' ) ) die();

/** Error Reporting for Production **/
error_reporting(0);
@ini_set('display_errors', 0);

/* Plugin version */
function atmocdn_version() {
    $plugin_data = get_plugin_data(__FILE__);
    $plugin_version = $plugin_data['Version'];
    return $plugin_version;
}

/** Required **/
require_once(dirname(__FILE__)."/functions.php");
require_once(dirname(__FILE__)."/panel.php");
require_once(dirname(__FILE__)."/iap.php");

/* Add js to header for lazyload */
add_action('wp_enqueue_scripts', 'atmocdn_add_javascript');
function atmocdn_add_javascript() {
    wp_enqueue_script('jquery');    
    wp_enqueue_script('atmocdn-lazyloader', "http://assets.atmocdn.com/js/jquery.lazyload.js", array('jquery'));
}

/** CDN defines **/
if ( is_multisite() ) {
  if ( ! get_option('atmo_cdn_iap', '') ) {
    if ( get_blog_option('1', 'atmo_cdn_one', '') ) {
      define('GLOBAL_CDN', 'true');
      $vcdn_var = get_blog_option('1', 'atmo_cdn_two', '');
      define('FILES_CDN', $vcdn_var); /* Set Addon Domain to /public_html */
    }
  }
} else {
  if ( get_option('atmo_cdn_one', '') ) {    
    define('GLOBAL_CDN', 'true');
    $vcdn_var = get_option('atmo_cdn_two', '');
    define('FILES_CDN', $vcdn_var); /* Set Addon Domain to /public_html */
  }
}

/**
 * Start frontend CDN
 * Since 1.0
 */
if ( is_multisite() ) {
  if ( ! get_option('atmo_cdn_iap', '') ) {
    if ( get_blog_option('1', 'atmo_cdn_one', '') ) {
      if (GLOBAL_CDN == 'true') {
          $atmocdn = array(
            "files"  => FILES_CDN,
          );         
          add_action('template_redirect', 'atmo_cdn');
      }
    }
  }
} else {
  if ( get_option('atmo_cdn_one', '') ) {
    if (GLOBAL_CDN == 'true') {
        $atmocdn = array(
          "files"  => FILES_CDN,
        );         
        add_action('template_redirect', 'atmo_cdn');
    }
  }
}

/* Rewrite url html output
 * Since 1.0
 */
function atmo_cdn(){
    global $wptouch_pro;
    if ( !$wptouch_pro->is_mobile_device && !$wptouch_pro->showing_mobile_theme ) {
        ob_start('atmo_cdn_path');
    }
}

function atmo_cdn_path($buffer) {
    global $atmocdn;
    $cdn_url = $atmocdn['files'];

    /* Rewrite rules */
    $site_url = site_url('/wp-content/uploads', 'http');
    $sites_url = "wp-content/uploads"; 
    $plugin_url = site_url('/wp-content/plugins', 'http');
    $plugins_url = "wp-content/plugins";
    $theme_url = site_url('/wp-content/themes', 'http');
    $themes_url = "wp-content/themes";         
    $include_url = site_url('/wp-includes', 'http');
    $includes_url = "wp-includes";

    /* Begin rewriting urls */
    $initial=strlen($buffer);
    $buffer=explode("<!--atmocdn-->", $buffer);
    $count=count($buffer);

    for ($i = 0; $i <= $count; $i++){
        if (stristr(isset($buffer[$i]), '<!--atmocdn no-change-->')){
            @$buffer[$i]=(str_replace("<!--atmocdn no-change-->", " ", $buffer[$i]));
        } else {

            /* Lazyload rules */
            @$buffer[$i]=(str_replace("<iframe src=", "<iframe data-src=", $buffer[$i]));

            if ( !is_home() || !is_front_page() ) {
                @$buffer[$i]=(str_replace("<img src=", "<img data-src=", $buffer[$i]));
                @$buffer[$i]=(str_replace('id="doc_51038" src=', 'id="doc_51038" data-src=', $buffer[$i]));
                @$buffer[$i]=(str_replace('id="doc_25277" src=', 'id="doc_25277" data-src=', $buffer[$i]));
                @$buffer[$i]=(str_replace('class="scribd_iframe_embed" src=', 'class="scribd_iframe_embed" data-src=', $buffer[$i]));
                @$buffer[$i]=(str_replace('title="Green check" src=', 'title="Green check" data-src=', $buffer[$i]));
                @$buffer[$i]=(str_replace('<img class="aligncenter" src=', '<img class="aligncenter" data-src=', $buffer[$i]));
                @$buffer[$i]=(str_replace('alt="" src=', 'alt="image" data-src=', $buffer[$i]));
            }
     
            /* Rewrite rules */
            @$buffer[$i]=(str_replace($site_url, "$cdn_url/$sites_url", $buffer[$i]));
            @$buffer[$i]=(str_replace($include_url, "$cdn_url/$includes_url", $buffer[$i]));
            @$buffer[$i]=(str_replace($plugin_url, "$cdn_url/$plugins_url", $buffer[$i]));
            @$buffer[$i]=(str_replace($theme_url, "$cdn_url/$themes_url", $buffer[$i]));

        }
        @$buffer_out.=$buffer[$i];
    }

    $final=strlen($buffer_out);
    $savings=($initial-$final)/$initial*100;
    $savings=round($savings, 2);
    $buffer_out.='';
    return $buffer_out;
}

/** Enable panel in menu **/
if ( is_multisite() ) { 
    add_action('network_admin_menu', 'atmo_cdn_menu');
    add_action('admin_menu', 'atmo_cdn_tools');
} else {
    add_action('admin_menu', 'atmo_cdn_menu');
}
