<?php

	//ia_jsfiddle options
	function ia_jsfiddle_options_page() { ?>

		<div class="wrap">
			<h2>InternetAlche.Me JSFiddle Shortcode Options (v<?php echo get_option('ia_jsfiddle_version_number'); ?>)</h2>

			<?php if($_REQUEST['submit']) {
				ia_jsfiddle_update_options();
			}
			ia_jsfiddle_display_option_form(); ?>

		</div>

	<?php }

//display options form
function ia_jsfiddle_display_option_form() { 
	$jsfiddle_field = get_option('ia_jsfiddle_username_field');
	$jsfiddle_skin_dir = get_option('ia_jsfiddle_skins_dir'); ?>
	
	<form method="post">
		<label for="ia_jsfiddle_username_field">JSFiddle Username Field:<br />
			<input type="text" name="ia_jsfiddle_username_field" id="ia_jsfiddle_username_field" value="<?php echo $jsfiddle_field; ?>" />
		</label><br />
		<label for="ia_jsfiddle_skins_dir">JSFiddle Skins Directory:<br />
			<input type="text" name="ia_jsfiddle_skins_dir" id="ia_jsfiddle_skins_dir" value="<?php echo $jsfiddle_skin_dir; ?>" />
		</label><br />
		<input type="submit" name="submit" value="Update" />
 	</form>
	
<?php }

//update options
function ia_jsfiddle_update_options() {
	$ok = false;

	if($_REQUEST['ia_jsfiddle_username_field'] || $_REQUEST['ia_jsfiddle_skins_dir']) {
		update_option('ia_jsfiddle_username_field',$_REQUEST['ia_jsfiddle_username_field']);
		update_option('ia_jsfiddle_skins_dir',$_REQUEST['ia_jsfiddle_skins_dir']);
		$ok = true;
	}

	if($ok) { ?>
		
		<div id="message" class="updated fade">
			<p>Options saved.</p>
		</div>
	
	<?php } else { ?>
		
		<div id="message" class="error fade">
			<p>Failed to save options.</p>
		</div>
	
	<?php }	
} ?>