<?php

/* Super Admin menu */
function atmo_cdn_menu() {
    if ( is_multisite() ) { 
        if ( current_user_can('manage_options') ) {
            $icon_url_panel = "dashicons-smiley";
            $position_panel = "99"; 
            add_menu_page('CDN', 'CDN', 'manage_options', 'atmocdn', 'atmo_cdn_panel', $icon_url_panel, $position_panel);
        }
    } else {
        if ( current_user_can('edit_posts') ) {
            $icon_url_panel = "dashicons-smiley";
            $position_panel = "99"; 
            add_menu_page('CDN', 'CDN', 'manage_options', 'atmocdn', 'atmo_cdn_panel', $icon_url_panel, $position_panel);
        }  
    }
}

function atmo_cdn_tools() {
        if ( current_user_can('manage_options') ) {
            add_submenu_page('tools.php', 'Walled Garden', 'Walled Garden', 'manage_network', 'walled-garden', 'atmo_cdn_walled_garden');
        }
}

/* Checkboxes */
function atmo_cdn_checked($param){
    $param = sanitize_text_field($param);
    $submit = sanitize_text_field("atmo_cdn_submit");
    if ( isset($_POST[$submit]) ) {
        if ( isset($_POST[$param]) )
            $check = 'checked';
        else
            $check = '';
            update_option($param, $check);
    }
}

/* Input fields */
function atmo_cdn_setting($par,$def){
    if (isset($_POST[$par])) { if(isset($_POST[$par]) and $_POST[$par]!='' ) $k=$_POST[$par];else $k=$def; update_option($par,$k);} 
}
