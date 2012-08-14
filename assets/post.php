<?php
	
	//post editor actions
	function ia_jsfiddle_metabox() {
		add_meta_box('ia_jsfiddle_list','JSFiddles','ia_jsfiddle_user_fiddles','post','side','high');
		add_meta_box('ia_jsfiddle_list','JSFiddles','ia_jsfiddle_user_fiddles','post','side','high');
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
					<p><a id="ia-fiddle-other-user" href="javascript:void(0);">add Fiddle from another user</a></p>
				</div>
				<div id="ia-fiddle">
					<div id="ia-fiddle-container">Loading fiddles...</div>
					<div id="ia-fiddle-other-user-container" style="display:none;">
						<form>
							<table>
								<tr>
									<td>
										<label for="fiddle_user">User Name</label>
									</td>
								</tr>
								<tr>
									<td>
										<input type="text" value="" id="fiddle_user" name="fiddle_user" />
									</td>
								</tr>
								<tr>
									<td>
										<label for="fiddle_id">Fiddle ID</label>
									</td>
								</tr>
								<tr>
									<td>
										<input type="text" value="" id="fiddle_id" name="fiddle_id" />
									</td>
								</tr>
								<tr>
									<td>
										<p>The Fiddle ID is the string of characters at the end of the JSFiddle url. Example: For http://jsfiddle.net/allenericr/RVY4N/ the Fiddle ID is <strong>RVY4N</strong></p>
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
											<option value="dark">Dark</option>
											<option value="alchemy">Alchemy</option>
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
		global $parent_file;
		if ( isset( $_GET['action'] ) && $_GET['action'] == 'edit' && isset( $_GET['post'] ) && $parent_file == 'edit.php') {
			//jquery crossdomain ajax
			wp_register_script('crossdomain-ajax',plugins_url() . '/jsfiddle-plugin/assets/js/crossdomain-ajax/jquery.crossdomain-ajax.min.js',array('jquery'),'',false);
			wp_enqueue_script('crossdomain-ajax');
			//jsfiddle utils
			wp_register_script('jsfiddle-utils',plugins_url() . '/jsfiddle-plugin/assets/js/jsfiddle-utils/jquery.jsfiddle-utils.min.js',array('jquery','crossdomain-ajax'),'',false);
			wp_enqueue_script('jsfiddle-utils');
			//iajsfiddle js
			wp_register_script('iajsfiddle-js',plugins_url() . '/jsfiddle-plugin/assets/js/iajsfiddle.js',array('jquery','crossdomain-ajax','jsfiddle-utils'),'',false);
			wp_enqueue_script('iajsfiddle-js');
			//iajsfiddle css
			wp_register_style('iajsfiddle-style',plugins_url() . '/jsfiddle-plugin/assets/css/jsfiddle.css','','','all');
			wp_enqueue_style('iajsfiddle-style');
		}
	}
	add_filter('admin_head','ia_jsfiddle_include_admin_js');

?>