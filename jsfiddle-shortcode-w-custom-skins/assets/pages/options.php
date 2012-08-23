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
	$jsfiddle_skin_dir = get_option('ia_jsfiddle_skins_dir');
	$jsfiddle_cron_schedule = get_option('ia_jsfiddle_theme_manager_cron'); ?>
	
	<form method="post">
		<label for="ia_jsfiddle_username_field">JSFiddle Username Field:<br />
			<input type="text" name="ia_jsfiddle_username_field" id="ia_jsfiddle_username_field" value="<?php echo $jsfiddle_field; ?>" />
		</label><br />
		<label for="ia_jsfiddle_skins_dir">JSFiddle Skins Directory:<br />
			<input type="text" name="ia_jsfiddle_skins_dir" id="ia_jsfiddle_skins_dir" value="<?php echo $jsfiddle_skin_dir; ?>" />
		</label><br />
		<label for="ia_jsfiddle_theme_manager_cron">JSFiddle Skin Manager Auto-Refresh:<br />
			<select name="ia_jsfiddle_theme_manager_cron" id="ia_jsfiddle_theme_manager_cron">

				<?php $crons = array('hourly','daily','twicedaily');
				foreach($crons as $cron) {
					if($cron === get_option('ia_jsfiddle_theme_manager_cron')) {
						$selected = ' selected';
					} else {
						$selected = '';
					} ?>

					<option value="<?php echo $cron; ?>"><?php echo ucfirst($cron); ?></option>

				<?php } ?>

				<option value="false">None</option>
			</select>
		</label><br />
		<input type="submit" name="submit" value="Update" />
 	</form>
	
<?php }

//update options
function ia_jsfiddle_update_options() {
	$ok_1 = false;
	$ok_2 = false;
	$ok_3 = false;

	if($_REQUEST['ia_jsfiddle_username_field'] !== get_option('ia_jsfiddle_username_field')) {
		if(update_option('ia_jsfiddle_username_field',$_REQUEST['ia_jsfiddle_username_field'])) {
			$ok_1 = true;
		}
	} else {
		$ok_1 = true;
	}
	if($_REQUEST['ia_jsfiddle_skins_dir'] !== get_option('ia_jsfiddle_skins_dir')) {
		if(update_option('ia_jsfiddle_skins_dir',$_REQUEST['ia_jsfiddle_skins_dir'])) {
			$ok_2 = true;
		}
	} else {
		$ok_2 = true;
	}
	if($_REQUEST['ia_jsfiddle_theme_manager_cron'] !== get_option('ia_jsfiddle_theme_manager_cron')) {
		if(update_option('ia_jsfiddle_theme_manager_cron',$_REQUEST['ia_jsfiddle_theme_manager_cron'])) {
			$ok_3 = true;
		}
	} else {
		$ok_3 = true;
	}

	if($ok_1 && $ok_2 && $ok_3) { ?>
		
		<div id="message" class="updated fade">
			<p>Options saved.</p>
		</div>
	
	<?php } else { ?>
		
		<div id="message" class="error fade">
			<p>Failed to save options.</p>
		</div>
	
	<?php }
} ?>