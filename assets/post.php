<?php
	
	//post editor actions
	function ia_jsfiddle_metabox() {
		add_meta_box('ia_jsfiddle_list','JSFiddles','ia_jsfiddle_user_fiddles','post','side','high');
		add_meta_box('ia_jsfiddle_list','JSFiddles','ia_jsfiddle_user_fiddles','page','side','high');
	}
	add_action('admin_init','ia_jsfiddle_metabox',10,1);

	function ia_jsfiddle_user_fiddles() {
		$user_id = get_current_user_id();
		$field = get_option('ia_jsfiddle_username_field');
		$fiddle_user = get_user_meta($user_id,$field,true); 
		if($fiddle_user) { ?>

			<div class="inside">
				<div id="ia-fiddle-head" data-user="<?php echo $fiddle_user; ?>">
					<h2>Fiddles for <?php echo $fiddle_user; ?></h2>
					<p class="other_user"><a id="ia-fiddle-other-user" href="javascript:void(0);">add Fiddle from another user</a></p>
					<p class="back_to_user" style="display:none;"><a id="ia-fiddle-back-to-user" href="javascript:void(0);">back to your Fiddles</a></p>
				</div>
				<div id="ia-fiddle">
					<div id="ia-fiddle-container">Loading fiddles...</div>
					<div id="ia-fiddle-other-user-container" style="display:none;">
						<form>
							<table>
								<tr>
									<td>
										<label for="fidde_link">Fiddle URL</label>
									</td>
								</tr>
								<tr>
									<td>
										<input type="text" value="" id="fiddle_link" name="fiddle_link" />
									</td>
								</tr>
								<tr>
									<td>
										<input type="button" id="ia-fiddle-add-user" value="Use Fiddle" />
									</td>
								</tr>
							</table>
						</form>
					</div>
					<div id="ia-fiddle-options" style="display:none;">
						<p><a href="javascript:void(0);" id="ia-fiddle-back-to-list">Back to Fiddles</a></p>
						<form>
							<input type="hidden" value="" name="ia-fiddle-id" id="ia-fiddle-id" />
							<table>
								<tr>
									<td>
										<label for="ia-fiddle-show">Fields</label>
									</td>
								</tr>
								<tr>
									<td>
										<input type="text" value="js,resources,html,css,result" name="ia-fiddle-show" id="ia-fiddle-show" />
									</td>
								</tr>
								<tr>
									<td>
										<label for="ia-fiddle-width">Width</label>
									</td>
								</tr>
								<tr>
									<td>
										<input type="text" value="100%" name="ia-fiddle-width" id="ia-fiddle-width" />
									</td>
								</tr>
								<tr>
									<td>
										<label for="ia-fiddle-height">Height</label>
									</td>
								</tr>
								<tr>
									<td>
										<input type="text" value="300px" name="ia-fiddle-height" id="ia-fiddle-height" />
									</td>
								</tr>
								<tr>
									<td>
										<label for="ia-fiddle-skin">Skin</label>
									</td>
								</tr>
								<tr>
									<td>
										<select name="ia-fiddle-skin" id="ia-fiddle-skin">
											<option value="default">Default</option>
											
											<?php
												//get skins from JSON file
												$skin_dir = get_option('ia_jsfiddle_skins_dir');
												$skins = json_decode(file_get_contents($skin_dir . '/jsfiddle-skins.json'));
												foreach($skins as $id => $skin) { ?>
												
													<option value="<?php echo $id; ?>"><?php echo ucfirst($id); ?></option>
												
												<?php } ?>

										</select>
									</td>
								</tr>
								<tr>
									<td>
										<input type="button" id="ia-fiddle-embed" value="Get Shortcode" />
									</td>
								</tr>
							</table>
						</form>
					</div>
					<div id="ia-fiddle-shortcode" style="display:none;"></div>
				</div>
			</div>

		<?php } else { ?>

			<div class="inside">
				<p>You haven't set a JSFiddle username yet. Add a JSFiddle user name to your <a href="<?php echo admin_url('profile.php'); ?>">profile</a> to use this plug-in's advanced features.</p>
			</div>

		<?php }
	}

	//include admin js files
	function ia_jsfiddle_include_admin_js() {
		//jquery crossdomain ajax
		wp_register_script('crossdomain-ajax',plugins_url() . '/jsfiddle-shortcode-w-custom-skins/assets/js/crossdomain-ajax/jquery.crossdomain-ajax.min.js',array('jquery'),'',false);
		wp_enqueue_script('crossdomain-ajax');
		//jsfiddle utils
		wp_register_script('jsfiddle-utils',plugins_url() . '/jsfiddle-shortcode-w-custom-skins/assets/js/jsfiddle-utils/jquery.jsfiddle-utils.min.js',array('jquery','crossdomain-ajax'),'',false);
		wp_enqueue_script('jsfiddle-utils');
		//iajsfiddle js
		wp_register_script('iajsfiddle-js',plugins_url() . '/jsfiddle-shortcode-w-custom-skins/assets/js/iajsfiddle.js',array('jquery','crossdomain-ajax','jsfiddle-utils'),'',false);
		wp_enqueue_script('iajsfiddle-js');
		//iajsfiddle css
		wp_register_style('iajsfiddle-style',plugins_url() . '/jsfiddle-shortcode-w-custom-skins/assets/css/jsfiddle.css','','','all');
		wp_enqueue_style('iajsfiddle-style');
	}
	add_filter('admin_head','ia_jsfiddle_include_admin_js');

?>