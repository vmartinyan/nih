(function($){
"use strict";
    $(window).load(function(){
    	$(".customize-control-select select").each(function(){
    		var label = $(this).prev().html().toLowerCase();
    		if(label.indexOf("sidebar") != -1 && label.indexOf("select") == -1){
    			var current_val = $(this).val();
    			if(current_val == 'no') $(this).parent().parent().next().fadeOut();
    		}    		
    	})
    	$(".customize-control-select select").on('change',function(){
			var new_val = $(this).val();
			if(new_val == 'no') $(this).parent().parent().next().fadeOut();
			else $(this).parent().parent().next().fadeIn();
		})
    	var api = wp.customize;
        
        function update_bg(setting_id,set_color){
            var setting_class = setting_id.replace('[','-');
            setting_class = setting_class.replace(']','');
        	var background={};
            var color = $('.'+setting_class+' input.sv-color-picker').val();
            if(set_color) color = set_color;
            var bg_repeat = $('.'+setting_class+' .sv-background-repeat').val();
            var bg_attachment = $('.'+setting_class+' .sv-background-attachment').val();
            var bg_position = $('.'+setting_class+' .sv-background-position').val();
            var bg_size = $('.'+setting_class+' .sv-background-size').val();
            var bg_image = $('.'+setting_class+' .sv-background-image').val();
            var input_id = $('.'+setting_class+" input.sv-color-picker").attr("name");
            background['background-color'] = color;
            background['background-repeat'] = bg_repeat;
            background['background-attachment'] = bg_attachment;
            background['background-position'] = bg_position;
            background['background-size'] = bg_size;
            background['background-image'] = bg_image;
            api.instance(setting_id).set( background );
        }
        function update_typography(setting_id,set_color){
            var setting_class = setting_id.replace('[','-');
            setting_class = setting_class.replace(']','');
            var typography={};
            var color = $('.'+setting_class+' input.sv-typography-font-color').val();
            if(set_color) color = set_color;
            var font_family = $('.'+setting_class+' .sv-typography-font-family').val();
            var font_size = $('.'+setting_class+' .sv-typography-font-size').val();
            var font_style = $('.'+setting_class+' .sv-typography-font-style').val();
            var font_variant = $('.'+setting_class+' .sv-typography-font-variant').val();
            var font_weight = $('.'+setting_class+' .sv-typography-font-weight').val();
            var letter_spacing = $('.'+setting_class+' .sv-typography-letter-spacing').val();
            var line_height = $('.'+setting_class+' .sv-typography-line-height').val();
            var text_decoration = $('.'+setting_class+' .sv-typography-text-decoration').val();
            var text_transform = $('.'+setting_class+' .sv-typography-text-transform').val();
            typography['font-color'] = color;
            typography['font-family'] = font_family;
            typography['font-size'] = font_size;
            typography['font-style'] = font_style;
            typography['font-variant'] = font_variant;
            typography['font-weight'] = font_weight;
            typography['letter-spacing'] = letter_spacing;
            typography['line-height'] = line_height;
            typography['text-decoration'] = text_decoration;
            typography['text-transform'] = text_transform;
            console.log(color);
            console.log(typography);
            api.instance(setting_id).set( typography );
        }
            $(".sv-color-picker").wpColorPicker({
                defaultColor: false,
                change: function(event, ui){
                    var color = $(this).iris('color');
                    var setting_id = $(this).parent().parent().parent().parent().parent().parent().attr('data-setting');
                    if(setting_id != '' && setting_id !== undefined) update_bg(setting_id,color);
                    var setting_id_typo = $(this).parent().parent().parent().parent().parent().attr('data-setting');
                    if(setting_id_typo != '' && setting_id_typo !== undefined) update_typography(setting_id_typo,color);
                    
                },
                clear: function() {},
                hide: true,
                palettes: true
            });

        $(".format-setting.type-background").each(function(){
            var setting_id = $(this).attr('data-setting');
            var setting_class = setting_id.replace('[','-');
            setting_class = setting_class.replace(']','');
            $("body").on("change keyup",'.'+setting_class+" input[class*='sv-background-']",function(){
                update_bg(setting_id);
            });
            $('.'+setting_class+" select[class*='sv-background-']").on("change",function(){
                update_bg(setting_id);
            });
        })
        $(".format-setting.type-typography").each(function(){
            var setting_id = $(this).attr('data-setting');
            var setting_class = setting_id.replace('[','-');
            setting_class = setting_class.replace(']','');
            $("body").on("change keyup",'.'+setting_class+" input[class*='sv-typography-']",function(){
                update_typography(setting_id);
            });
            $('.'+setting_class+" select[class*='sv-typography-']").on("change",function(){
                update_typography(setting_id);
            });
        })
        $( document ).on( 'click', '.upload_single_image', function( event ) {
            var seff = $(this);
            event.preventDefault();
            var send_attachment_bkp = wp.media.editor.send.attachment;
            wp.media.editor.send.attachment = function (props, attachment) {
                seff.parent().find('input').val(attachment.url);
                seff.parent().find('img').attr('src',attachment.url);                
                var setting_id = seff.parent().parent().parent().attr('data-setting');
                if(setting_id != '') update_bg(setting_id);
                seff.parent().find('a.remove_single_image').fadeIn();
                wp.media.editor.send.attachment = send_attachment_bkp;
            }
            wp.media.editor.open();
            return false;
        });
        $('.remove_single_image').on('click',function(){
            $(this).fadeOut();
            $(this).parent().find('input').val('');
            $(this).parent().find('img').attr('src','');
            var setting_id = $(this).parent().parent().parent().attr('data-setting');
            if(setting_id != '') update_bg(setting_id);
        })
    })
})(jQuery);