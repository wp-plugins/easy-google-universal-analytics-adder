<?php
/*
 * Plugin Name: Google Universal Analytics
 * Version: 1.0.0
 * Plugin URI: http://wordpress.org/extend/plugins/google-universal-analytics/
 * Description: Adds the required javascript tags to enable the new Google Universal Analytics (Open beta March 2013). 
 * Author: UTX
 * Author URI: http://www.utx.com.au
 * Text Domain: UTX
 *
Copyright (C) 2013  UTX

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */
 
 $usergaid = get_option($gaid);

# Add the script
if(get_option('gastatus')=="Enabled")
{
add_action('wp_head', 'add_google_analytics_universal', 999999);
add_action('login_head', 'add_google_analytics_universal', 999999);
}
add_action( 'admin_menu', 'Google_Universal_Analytics_menu' );

function Google_Universal_Analytics_menu() {
	add_options_page( 'Google Universal Analytics', 'Google Universal Analytics', 'manage_options', 'Google_Universal_Analytics', 'ga_plugin_options' );
}

function updateoptionsga()
{
echo '<div style="border:1px solid black;margin-top:10px;padding:5px;width:100px;">Updated</div>';
	$thestatus = esc_attr($_POST["gastatus"]); 
	update_option("gastatus", $thestatus);
	$thegaid = esc_attr($_POST["gaid"]);     
    update_option("gaid", $thegaid);
	$thedomain = esc_attr($_POST["gadomain"]);     
    update_option("gadomain", $thedomain);
}

function ga_plugin_options() {
    if ( $_POST['update_settings'] == 'Y' ) { updateoptionsga(); }  

	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<div class="wrap">';
	echo '<form method="POST" action="">';
	echo '<input type="hidden" name="update_settings" value="Y" />';
	echo '<p>Google Universal Analytics tracking is currently:';
	echo '<select id="gastatus" name="gastatus">';
	echo '<option value="Disabled';
	if(get_option('gastatus')=="Disabled") echo (" selected");
	echo '">Disabled</option>';
	echo '<option value="Enabled"';
	if(get_option('gastatus')=="Enabled") echo (" selected");
	echo'>Enabled</option>';
	echo '</select>';
	echo '<p>Enter your Google Universal Analytics ID:';
	echo '<input type="text" id="gaid" name="gaid" value="';
	echo get_option("gaid");
	echo '"></p>';
	echo '<p>Enter your domain (ie example.com or utx.com.au):';
	echo '<input type="text" id="gadomain" name="gadomain" value="';
	echo get_option("gadomain");
	echo '"></p>';
	echo '<input type="submit" value="Save settings" class="button-primary"/>';
	echo '</form>';
	?>
	<div class='GAtext'>
	<p>Google Universal Analytics is the latest version of the google analytics tracking code. It has been opened to public beta as of March 2013.</p>
	<p>In the future, this will the default tracking recommended tracking code so it's a good idea to start using it now.</p>
	<p>It can be installed side by side the existing tracking code so not need to remove your current tracking.</p>
	<p>To install it create a google analytics account, or if you already have one create a new web property and choose the univeral analytics option.</p>
	<p>Full instructions are available at <a href='http://support.google.com/analytics/bin/answer.py?hl=en&answer=2817075' target='_blank'>Google Support</a>
	<p>Then copy and paste the your id and domain name in to the boxes above and you're all set</p>
	</div>
	<?php
	echo '</div>';	
}

function add_google_analytics_universal()
{
	?>
	<!-- Google Analytics tag added by utx.com.au wordpress plugin -->
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '<?php echo(get_option('gaid')); ?>', '<?php echo(get_option('gadomain')); ?>');
  ga('send', 'pageview');
</script>
<?php
}
?>
