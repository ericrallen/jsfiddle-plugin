<?php

	require_once("classes/IAJSFiddleAPI.class.php");
	
	//post editor actions
	function ia_jsfiddle_metabox() {
		add_meta_box('ia_jsfiddle_list','JSFiddles','ia_jsfiddle_user_fiddles','post','side','high');
		add_meta_box('ia_jsfiddle_list','JSFiddles','ia_jsfiddle_user_fiddles','post','side','high');
	}
	add_action('admin_init','ia_jsfiddle_metabox',10,1);

	function ia_jsfiddle_user_fiddles() {
		$user_id = get_current_user_id();
		$field = get_option('ia_jsfiddle_username_field');
		$fiddle_user = get_user_meta($user_id,$field,true); ?>

		<style>
			#ia-fiddle {
				width: 98%;
				margin: 10px 0.5%;
				padding: 10px 0.5%;
			}
			#ia-fiddle-container {
				width: 98%;
				padding: 0 1%;
				background: #fff;
				overflow-y: scroll;
				height: 300px;
				border: 1px solid #ccc;
			}
			.ia-fiddle-item {
				padding-bottom: 10px;
				margin-top: 10px;
				border-bottom: 1px solid #ccc;
			}
			.ia-fiddle-item:first-child {
				margin-top: 0;
			}
			.ia-fiddle-item:last-child {
				border-bottom: none;
				padding-bottom: 0;
			}
			.ia-fiddle-item-head {
				font-weight: bold;
				color: #333;
			}
			.ia-fiddle-item p {
				margin: 5px 0;
			}
			#ia-fiddle-generated-shortcode {
				resize: none;
				width: 100%;
				height: 70px;
				border: 1px solid #ccc;
			}
		</style>

		<div class="inside">
			<div id="ia-fiddle-head" data-user="<?php echo $fiddle_user; ?>">
				<h2>Fiddles for <?php echo $fiddle_user; ?></h2>
			</div>
			<div id="ia-fiddle">
				<div id="ia-fiddle-container">Loading fiddles...</div>
				<div id="ia-fiddle-shortcode" style="display:none;"></div>
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
			</div>

			<script type="text/javascript">
				jQuery(function() {
					var username = jQuery('#ia-fiddle-head').attr('data-user');
					var output = '<ul class="ia-fiddle-list">';
					// username cannot be empty - signalize error
					if (username !== "") {
						jsfiddle.retrieve(username, function(data) {
							// show results into the pre
							//output = JSON.stringify(data);
							for(var i in data) {
								var format_url, fiddle_id;
								format_url = data[i].url.substring(7,data[i].url.length-1);
								var format_url_array = format_url.split('/');
								fiddle_id = format_url_array[format_url_array.length-1];
								output += '<li class="ia-fiddle-item"><p class="ia-fiddle-item-head">' + data[i].title + '</p><p style="display:none;" class="ia-fiddle-desc">' + data[i].description + '</p><p><a href="javascript:void(0);" title="Get Shortcode" class="ia-fiddle-insert" data-id="' + fiddle_id + '">Insert</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:void(0);" title="View Description" class="ia-fiddle-details" data-id="' + fiddle_id + '">Details</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a target="_blank" href="' + data[i].url + '" title="Include ' + data[i].title + '">View</a></li>';
							}
							output += '</ul>';
							jQuery("#ia-fiddle-container").html(output);
						});
					}
					jQuery('body').on('click','.ia-fiddle-details',function() {
						if(jQuery(this).parent().parent().find('.ia-fiddle-desc').is(':visible')) {
							jQuery(this).parent().parent().find('.ia-fiddle-desc').slideUp();
							jQuery(this).html('Details');
						} else {
							jQuery('.ia-fiddle-desc').slideUp();
							jQuery('.ia-fiddle-details').html('Details');
							jQuery(this).parent().parent().find('.ia-fiddle-desc').slideDown();
							jQuery(this).html('Hide');
						}
						
					});
					jQuery('body').on('click','.ia-fiddle-insert',function() {
						jQuery('#ia-fiddle-id').val(jQuery(this).attr('data-id'));
						jQuery('#ia-fiddle-container').fadeOut(function() {
							jQuery('#ia-fiddle-options').fadeIn();
						});
					});
					jQuery('body').on('click','#ia-fiddle-embed',function() {
						var id, height, width, show;
						id = jQuery('#ia-fiddle-id').val();
						height = jQuery('#ia-fiddle-height').val();
						width = jQuery('#ia-fiddle-width').val();
						show = jQuery('#ia-fiddle-show').val();
						var shortcode = '[iajsfiddle fiddle=\"' + id + '\" height=\"' + height + '\" width=\"' + width + '\" show=\"' + show + '\"]';
						var display = '<p><a href="javascript:void(0);" id="ia-fiddle-back-to-ops">Back to Options</a></p><p><label for="ia-fiddle-generated-shortcode">Copy + Paste the shortcode below: <br/><textarea name="ia-fiddle-generated-shortcode" id="ia-fiddle-generated-shortcode">' + shortcode + '</textarea></p><p><a href="javascript:void(0)" id="ia-fiddle-back-to-fiddles">Back to Fiddles</a></p>';
						jQuery('#ia-fiddle-shortcode').html(display);
						jQuery('#ia-fiddle-options').fadeOut(function() {
							jQuery('#ia-fiddle-shortcode').fadeIn();
						});
					});
					jQuery('body').on('click','#ia-fiddle-back-to-ops',function() {
						jQuery('#ia-fiddle-shortcode').fadeOut(function() {
							jQuery('#ia-fiddle-options').fadeIn();
							jQuery('#ia-fiddle-shortcode').html('');
						});
					});
					jQuery('body').on('click','#ia-fiddle-back-to-list',function() {
						jQuery('#ia-fiddle-options').fadeOut(function() {
							jQuery('#ia-fiddle-container').fadeIn();
							jQuery('#ia-fiddle-id').val('');
						});
					});
					jQuery('body').on('click','#ia-fiddle-back-to-fiddles',function() {
						jQuery('#ia-fiddle-shortcode').fadeOut(function() {
							jQuery('#ia-fiddle-container').fadeIn();
							jQuery('#ia-fiddle-id').val('');
							jQuery('#ia-fiddle-shortcode').html('');
						});
					});
				});
			</script>

		</div>

	<?php }

	//include admin js files
	function ia_jsfiddle_include_admin_js() {
		global $parent_file;
		if ( isset( $_GET['action'] ) && $_GET['action'] == 'edit' && isset( $_GET['post'] ) && $parent_file == 'edit.php') {
			//jquery crossdomain ajax
			wp_register_script('crossdomain-ajax',plugins_url() . '/jsfiddle-plugin/assets/js/crossdomain-ajax/jquery.crossdomain-ajax.min.js',array('jquery'),'',false);
			wp_enqueue_script('crossdomain-ajax');
			//jsfiddle utils
			wp_register_script('jsfiddle-utils',plugins_url() . '/jsfiddle-plugin/assets/js/jsfiddle-utils/jquery.jsfiddleutils.min.js',array('jquery','crossdomain-ajax'),'',false);
			wp_enqueue_script('jsfiddle-utils');
		}
	}
	add_filter('admin_head','ia_jsfiddle_include_admin_js');

?>