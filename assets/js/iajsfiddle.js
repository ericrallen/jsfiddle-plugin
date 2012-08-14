	
	jQuery(function() {
		if(jQuery('#ia-fiddle-head').length) {
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
				var user, id, height, width, show;
				if(jQuery('#ia_fiddle_other_user').length) {
					user = ' user=\"' + jQuery('#ia_fiddle_other_user').val() + '\"';
				} else {
					user = '';
				}
				if(jQuery('#ia_fiddle_other_fiddle').length) {
					id = jQuery('#ia_fiddle_other_fiddle').val();
				} else {
					id = jQuery('#ia-fiddle-id').val();
				}
				height = jQuery('#ia-fiddle-height').val();
				width = jQuery('#ia-fiddle-width').val();
				show = jQuery('#ia-fiddle-show').val();
				skin = jQuery('#ia-fiddle-skin').val();
				var shortcode = '[iajsfiddle' + user + ' fiddle=\"' + id + '\" height=\"' + height + '\" width=\"' + width + '\" show=\"' + show + '\" skin=\"' + skin + '\"]';
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
			jQuery('body').on('click','#ia-fiddle-other-user',function() {
				jQuery('#ia-fiddle-container').fadeOut(function() {
					jQuery('#ia-fiddle-other-user-container').fadeIn();
					if(jQuery('#ia_fiddle_other_user').length) {
						jQuery('#ia_fiddle_other_user').remove();
					}
					if(jQuery('#ia_fiddle_other_fiddle').length) {
						jQuery('#ia_fiddle_other_fiddle').remove();
					}
				});
			});
			jQuery('body').on('click','#ia-fiddle-add-user',function() {
				jQuery('#ia-fiddle-other-user-container').fadeOut(function() {
					jQuery('#ia-fiddle-options').find('form').prepend('<input type="hidden" id="ia_fiddle_other_user" name="ia_fiddle_other_user" value="' + jQuery('#fiddle_user').val() + '" />');
					jQuery('#ia-fiddle-options').find('form').prepend('<input type="hidden" id="ia_fiddle_other_fiddle" name="ia_fiddle_other_fiddle" value="' + jQuery('#fiddle_id').val() + '" />');
					jQuery('#ia-fiddle-options').fadeIn();
				});
			});
		}
	});