<?php

function atmo_cdn_walled_garden() {

    atmo_cdn_checked("atmo_cdn_iap",'');
 
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
<h2>Walled Garden</h2><br />

<div class="postbox" id="atmocdn">
<table class="form-table" id="atmocdn_table">
<tbody>
<ul>
<b>NOTICE:</b>
<p>Some workplace networks have either misconfigured IAP's or are overly restrictive. If the site admin or any users of this blog is having a hard time trying to access the frontend, but the backend is loading fine, then you can try to bypass the local router or ISP's internet access policy (IAP) for each individual user or all at once.</p>
<div style="border-top: 1px dotted #e1e1e1;padding-top:10px;"></div>
<b>HOW-TO:</b>
<p>Provide the user the following url: <code>http://walled-garden.atmocdn.com</code>. If the user is walled gardened, they will be able to type a <b>Captcha</b> in a box and unrestrict their network for the next <b>365 days</b>. If they are not, they'll see a message stating so. If the user can't access the page mentioned or the Captcha doesn't fix the problem, then you may attempt to <b>Bypass</b> it below. They'll most likely need to clear their browser cache and cookies afterwards.</p>
<p></p>
</ul>
</tbody>
</table>
</div>

<form action="" method="post">

<div class="postbox" id="atmocdn_settings">
<table class="form-table">
<tbody>

<tr valign="top">
<th scope="row"><label for="home">BYPASS:</label></th>
<td>
<label for="atmo_cdn_iap">
<input name="atmo_cdn_iap" type="checkbox" value="1" <?php echo get_option("atmo_cdn_iap"); ?> style="margin-left:5px;margin-right:5px">To attempt to bypass a walled garden, check the box, then click <b>Update Policy</b> to <b>Disable</b>. 
</label>
</td>
</tr>

</tbody>
</table>
</div>

<input type="hidden" name="atmo_cdn_submit" value="1">
<input type="submit" class="button button-primary" value="Update Policy">
</form>

</div><!--/.wrap -->
<?php

}
