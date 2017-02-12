jQuery(document).ready(function() {
	
	egw = {
		firstImageOpen: true,
		
		calcAspectRatio: function(id, axis) {
			if (jQuery(id + ' .keep-aspect-ratio').prop('checked')) {
				var display_width = jQuery(id + ' .display-width').attr('value');
				var display_height = jQuery(id + ' .display-height').attr('value');
				var original_width = jQuery(id + ' .original-width').attr('value');
				var original_height = jQuery(id + ' .original-height').attr('value');
				var aspect_ratio = 0;

				if (this.isValidInt(display_width) && axis == 'x') {
					aspect_ratio = original_width / original_height;
					jQuery(id + ' .display-height').attr('value', Math.round(display_width / aspect_ratio));
				}

				if (this.isValidInt(display_height) && axis == 'y') {
					aspect_ratio = original_height / original_width;
					jQuery(id + ' .display-width').attr('value', Math.round(display_height / aspect_ratio));
				}

				if (display_width == '' && axis == 'x') {
					jQuery(id + ' .display-height').attr('value', '');
				}

				if (display_height == '' && axis == 'y') {
					jQuery(id + ' .display-width').attr('value', '');
				}
			}
		},

		closeTextEditor: function(evt) {
			evt.preventDefault();
			
			if (evt.data.save == true) {
				
				if (jQuery('#wp-egw-tmce-wrap').hasClass('tmce-active')) {
					content = tinyMCE.get('egw-tmce').getContent();
				} else {
					content = window.switchEditors.wpautop(tinyMCE.DOM.get('egw-tmce').value);
				}
				
				jQuery(egw.editorForId + ' .text').attr('value', content);
				jQuery(egw.editorForId + ' .text-preview').html(content.replace(/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi, ' '));
			}
			
			jQuery('#egw-te-backdrop').css('display', 'none');
			jQuery('#egw-te').css('display', 'none');
		},
		
		displaySize: function(id, val) {
			if (val == 'fixed') {
				jQuery(id + ' div.fixed-size').slideDown(200);
			} else {
				jQuery(id + ' div.fixed-size').slideUp(200);
			}
		},
		
		imageEmbeded: function(id, image) {
			jQuery(id + ' .display-width').attr('value', image.width);
			jQuery(id + ' .display-height').attr('value', image.height);
			jQuery(id + ' .original-width').attr('value', image.width);
			jQuery(id + ' .original-height').attr('value', image.height);
			jQuery(id + ' .remove-image-link').show();
			jQuery(id + ' .img-thumb').html('<img src="' + image.url + '" style="max-width: 100%;">');
			jQuery(id + ' .src').attr('value', image.url);
			jQuery(id + ' .alt').attr('value', image.alt);
		},
		
		imageSelected: function(id, selectedSize, image) {
			objSize = image.sizes[selectedSize];
			jQuery(id + ' .remove-image').show();
			jQuery(id + ' .img-thumb').html('<img src="' + objSize.url + '" style="max-width: 100%;">');
			jQuery(id + ' .src').attr('value', objSize.url);
			jQuery(id + ' .alt').attr('value', image.alt);
			jQuery(id + ' .select-image').hide();
			/*jQuery(id + ' .remove-image-link').show();
			jQuery(id + ' .img-thumb').html('<img src="' + imageSize.url + '" style="max-width: 100%;">');
			jQuery(id + ' .src').attr('value', imageSize.url);
			jQuery(id + ' .display-width').attr('value', imageSize.width);
			jQuery(id + ' .display-height').attr('value', imageSize.height);
			jQuery(id + ' .original-width').attr('value', imageSize.width);
			jQuery(id + ' .original-height').attr('value', imageSize.height);
			jQuery(id + ' .alt').attr('value', image.alt);

			if (image.title != '' && jQuery(id + ' .title').attr('value') == '') {
				jQuery(id + ' .title').attr('value', image.title);
			}*/
		},
		
		init: function() {
			// Bind editor buttons.
			jQuery('#egw-te-backdrop').bind('click', {save: false}, this.closeTextEditor);
			jQuery('.egw-te-close').bind('click', {save: false}, this.closeTextEditor);
			jQuery('.egw-te-btn-discard').bind('click', {save: false}, this.closeTextEditor);
			jQuery('.egw-te-btn-save').bind('click', {save: true}, this.closeTextEditor);
		},
		
		isValidInt: function(val) {
			var intRegex = /^\d+$/;
			return intRegex.test(val);
		},
		
		// Keeps track of aspect ratio checkbox.
		keepAspectRatio: function(id) {
			if (jQuery(id + ' .keep-aspect-ratio').prop('checked')) {
				this.calcAspectRatio(id, 'x');
			}
		},
		
		mediaClose: function() {
			// Restore original functions.
			wp.media.editor.send.attachment = egw.insert;
			wp.media.string.image = egw.embed;
		},
		
		openTextEditor: function(id) {
			egw.editorForId = id;
			
			// Ugly way of switching to WYSIWYG view before showing the editor (don't see a way to set HTML content manually).
			if (jQuery('#wp-egw-tmce-wrap').hasClass('html-active')) {
				jQuery('#egw-tmce-tmce').click();
			}
			
			// Set data to tmce.
			tinyMCE.get('egw-tmce').setContent(jQuery(id + ' .text').attr('value'));
			
			// Display editor.
			jQuery('#egw-te').css('display', 'block');
			jQuery('#egw-te-backdrop').css('display', 'block');
		},
		
		removeImage: function(id) {
			/*jQuery(id + ' .remove-image-link').hide();
			jQuery(id + ' .img-thumb').html('');
			jQuery(id + ' .src').attr('value', '');
			jQuery(id + ' .display-width').attr('value', '');
			jQuery(id + ' .display-height').attr('value', '');
			jQuery(id + ' .original-width').attr('value', '');
			jQuery(id + ' .original-height').attr('value', '');*/
			
			jQuery(id + ' .remove-image').hide();
			jQuery(id + ' .img-thumb').html('');
			jQuery(id + ' .src').attr('value', '');
			jQuery(id + ' .select-image').show();
		},
		
		selectImage: function(id) {
			
			// Backup original functions.
			egw.insert = wp.media.editor.send.attachment;
			egw.embed = wp.media.string.image;
						
			// Open insert media lightbox.
			if ( typeof wp !== 'undefined' && wp.media && wp.media.editor ) {
				wp.media.editor.open(id, {multiple: false, title: 'HW Image Widget', type: 'image'});
			}

			// Image was selected from Media Library.
			wp.media.editor.send.attachment = function(selection, image) {
				egw.imageSelected(id, selection.size, image)
				egw.mediaClose();
			};

			// Image was selected by URL.
			wp.media.string.image = function (image) {
				egw.imageEmbeded(id, image);
				egw.mediaClose();
			}
			
			// Lightbox was closed, make sure to restore backed up functions.
			if (egw.firstImageOpen) {
				wp.media.frame.on('escape', function() {
					egw.mediaClose();
				});
			}
			
			egw.firstImageOpen = false;
		},
		
		target: function(id) {
			if (jQuery(id + ' .target-option').val() != 'other') {
				jQuery(id + ' .target-name').hide();
			} else {
				jQuery(id + ' .target-name').show();
			}
		}
	};
	egw.init();
});

