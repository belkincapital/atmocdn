<?php

function atmo_cdn_panel() {

    atmo_cdn_checked("atmo_cdn_one",'');
    atmo_cdn_setting("atmo_cdn_two",'');
 
?>
<style>
.wrap h2 a {text-decoration:none;color:#333333}
.wrap h2 a:hover {text-decoration:underline;color:#333333}
th label{padding-left:10px}
th,td{border-left:1px solid #e1e1e1;border-right:1px solid #e1e1e1;border-top:1px solid #e1e1e1}
.form-table{margin-top:0px}
#atmocdn {font-size:13px;padding-left:10px;padding-right:10px}
#atmocdn ul {background:#fafafa;border:1px solid #e1e1e1;padding-left:10px;padding-top:10px;;padding-right:10px}
#atmocdn_settings label {font-size:13px;}
</style>
<div class="wrap">
<h2><b>atmocdn</b> configuration</h2><br />

<div class="postbox" id="atmocdn">
<table class="form-table" id="atmocdn_table">
<tbody>
<ul>
<b>NOTICE:</b>
<p><a target="_blank" href="https://atmocdn.com/">atmocdn</a> is a secure global end-to-end content delivery network that was created by Jason Jersey of Belkin Capital Ltd. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the <a target="_blank" href="http://www.gnu.org/licenses/gpl-2.0.txt">GNU General Public License</a> for more details.</p>
<div style="border-top: 1px dotted #e1e1e1;padding-top:10px;"></div>
<b>SETUP:</b>
<p>Please make sure you setup a <b>Addon Domain</b> within your <b>cPanel</b>, like such <code>your-id.atmocdn.com</code> and point it to your <code>public_html</code> root directory.</p>
<div style="border-top: 1px dotted #e1e1e1;padding-top:10px;"></div>
<b>RULES:</b>
<p>atmocdn will rewrite your frontend source code urls for your <code>/wp-includes</code>, <code>/wp-content/plugins</code>, <code>/wp-content/themes</code>, <code>/wp-content/uploads</code> and we achieve this by using the WordPress action hook <code>template_redirect</code>. More information on this action hook may be found via the <a target="_blank" href="https://codex.wordpress.org/Plugin_API/Action_Reference/template_redirect">Codex</a>.</p>
<?php if ( is_multisite() ) { ?>
<div style="border-top: 1px dotted #e1e1e1;padding-top:10px;"></div>
<b>ACCESS:</b>
<p>If a blog admin is having a hard time trying to access the frontend of their blog, but the backend is loading fine, then you can try to bypass their local router or ISP's internet access policy (IAP) all together. Some workplace networks have either misconfigured IAP's or are overly restrictive.</p> 
<p>To bypass, navigate to their blog <code>wp-admin</code>, then to <code>Tools > Walled Garden</code>. More instructions are provided on that page.</p>
<?php } ?>
</ul>
</tbody>
</table>
</div>

<?php if ( is_multisite() ) { ?>
<?php if ( current_user_can('manage_network_options') ) { ?>
<form action="" method="post">
<?php } ?>
<?php } else { ?>
<?php if ( current_user_can('manage_options') ) { ?>
<form action="" method="post">
<?php } ?>
<?php } ?>

<div class="postbox" id="atmocdn_settings">
<table class="form-table">
<tbody>

<tr valign="top">
<th scope="row"><label for="home">ENABLE:</label></th>
<td>
<label for="atmo_cdn_one">
<input name="atmo_cdn_one" type="checkbox" value="1" <?php echo get_option("atmo_cdn_one"); ?> style="margin-left:5px;margin-right:5px">Once you've added your <b>CDN URL</b> and the DNS has resolved globally, check the box, then click <b>Update CDN</b> to <b>turn-on</b> this feature. 
</label>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="home">CDN URL:</label></th>
<td>
<label for="atmo_cdn_two">
<input type="text" name="atmo_cdn_two" value="<?php echo get_option("atmo_cdn_two"); ?>" placeholder="http://your-id.atmocdn.com" style="margin-left:5px;margin-right:5px;width:400px"> Do not include a trailing forward slash. (ie: <code>http://your-id.atmocdn.com/</code>)
</label>
</td>
</tr>

</tbody>
</table>
</div>

<?php if ( is_multisite() ) { ?>
<?php if ( current_user_can('manage_network_options') ) { ?>
<input type="hidden" name="atmo_cdn_submit" value="1">
<input type="submit" class="button button-primary" value="Update CDN">
</form>
<?php } else {
    echo "<span style='color:red'>For security reasons, only SuperAdmin's with the manage_network_options capability can update this option.</span>";
} ?>
<?php } else { ?>
<?php if ( current_user_can('manage_options') ) { ?>
<input type="hidden" name="atmo_cdn_submit" value="1">
<input type="submit" class="button button-primary" value="Update CDN">
</form>
<?php } else {
    echo "<span style='color:red'>For security reasons, only an Administrator with the manage_options capability can update this option.</span>";
} ?>
<?php } ?>

</div><!--/.wrap -->
<?php

}
