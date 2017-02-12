/**
 * Created by Administrator on 6/8/2015.
 */
(function($) {
    "use strict";
    $(document).ready(function() {
        //Add advantage widget
        $('body').on('click','.sv-button-add-slider',function(){
            var key = $(this).parent().find('.add').find('.sv-add-item').last().data('item');
            var idname= $(this).parent().find('.add').attr('data-idname');
            if(key == '' || key == undefined)
            {
                key = 1;
            }else
            {
                key = parseInt(key) + 1;
            }
            var item = '<div class="sv-add-item" data-item="'+key+'">';

            item += '<label style="margin-top:10px; margin-bottom: 10px; display: block; ">Title Adv</label>';
            item += '<input class="images-url widefat" name="'+idname+'['+key+'][title]" value="" type="text">';
            item += '<label style="margin-top:10px; margin-bottom: 10px; display: block; ">Link Adv</label>';
            item += '<input class="images-url widefat" name="'+idname+'['+key+'][link]" value="" type="text">';
            item += '<label style="margin-top:10px; margin-bottom: 10px; display: block; ">Image</label>';
            item += '<img style="max-width: 100%; width:100%;" class ="image-preview" src="">';
            item += '<input class="custom_media_url images-img-link" name="'+idname+'['+key+'][image]" value="" type="hidden">';
            item += '<button class="sv-button-upload" style="background: #00A0D2;  color: #fff;  border: none;  padding: 7px 10px;">Upload</button>';
            item += '<button class="sv-button-remove-item" style="margin-right: 15px; margin-bottom: 10px;  margin-top: 10px;  background: #D2001D;  color: #fff;  border: none;  padding: 7px 10px;">Remove</button>';
            item += '<hr></div>';
            $(this).parent().find('.add').append(item);

            $('.sv-button-upload').on('click',function () {
                var send_attachment_bkp = wp.media.editor.send.attachment;
                var seff = $(this);
                wp.media.editor.send.attachment = function (props, attachment) {

                    seff.parent().find('.custom_media_image').attr('src', attachment.url);
                    seff.parent().find('.custom_media_image').attr('style','display:block');
                    seff.parent().find('input.custom_media_url').val(attachment.url);
                    seff.parent().find('.image-preview').attr('src',attachment.url);
                   wp.media.editor.send.attachment = send_attachment_bkp;
                }

                wp.media.editor.open();

                return false;
            });

            $('.sv-remove-item').on('click',function () {
                $(this).parent().remove();
                return false;
            });
            return false;
        })

        $('.sv-remove-item').on('click',function () {
            $(this).parent().remove();
            return false;
        });
        $('.sv-button-remove-upload').on('click',function () {
            $(this).parent().find('img').attr('src','');
            $(this).parent().find('input').attr('value','');
            return false;
        });         
        //end

        $('.sv-button-upload').on('click',function () {
            var send_attachment_bkp = wp.media.editor.send.attachment;
            var seff = $(this);
            wp.media.editor.send.attachment = function (props, attachment) {

                seff.parent().find('.custom_media_image').attr('src', attachment.url);
                seff.parent().find('.custom_media_image').attr('style','display:block');
                seff.parent().find('input.custom_media_url').val(attachment.url);
                seff.parent().find('.image-preview').attr('src',attachment.url);
               wp.media.editor.send.attachment = send_attachment_bkp;
            }

            wp.media.editor.open();

            return false;
        });

        $('.sv-button-remove').on('click',function () {

            $(this).parent().find('input').val('');
            $(this).parent().find('img').attr('src','');
            $(this).parent().find('img').attr('style','display:none');
            return false;
        });


        $('.sv-button-upload-img').on("click",function(options){
            var default_options = {
                callback:null
            };
            options = $.extend(default_options,options);
            var image_custom_uploader;
            var self = $(this);
            //If the uploader object has already been created, reopen the dialog
            if (image_custom_uploader) {
                image_custom_uploader.open();
                return false;
            }
            //Extend the wp.media object
            image_custom_uploader = wp.media.frames.file_frame = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Choose Image'
                },
                multiple: true
            });
            //When a file is selected, grab the URL and set it as the text field's value
            image_custom_uploader.on('select', function() {
                var selection = image_custom_uploader.state().get('selection');
                var ids = [], urls=[];
                selection.map(function(attachment)
                {
                    attachment  = attachment.toJSON();
                    ids.push(attachment.id);
                    urls.push(attachment.url);

                });
                var img_prev = '';
                for(var i=0;i<urls.length;i++)
                {
                    img_prev += '<img src="'+urls[i]+'" style="width:100px; height:100px; padding:5px;">';
                }
                if(img_prev!='')
                    self.parent().find(".img-previews").html(img_prev);
                    self.parent().find("input.multi-image-url").val( JSON.stringify(urls) );


                if (typeof options.callback == 'function'){
                    options.callback({'self':self,'urls':urls});

                };


            });
            image_custom_uploader.open();
            return false;
        });

        $('.st-button-remove-img').on("click",function(options){
            $(this).parent().find('img').remove();
            $(this).parent().find('input.multi-image-url').val('');
            return false;
        });
    });

    $('.st-button-remove-img-item').on('click',function () {

        $(this).parent().remove();

        return false;
    });
    $('.st-button-add').on('click', function()
    {
        var key = $(this).parent().find('.add').find('.st-add-item').last().data('item');

        var idname= $(this).parent().find('.add').attr('data-idname');
        if(key == '' || key == undefined)
        {
            key = 1;
        }else
        {
            key = parseInt(key) + 1;
        }
        var item = '<div class="st-add-item" data-item="'+key+'">';

        item += '<label style="margin-top:10px; margin-bottom: 10px; display: block; ">Link URL</label>';
        item += '<input class="images-url" name="'+idname+'['+key+'][url]" value="" type="text" placeholder="-- Link --">';
        item += '<label style="margin-top:10px; margin-bottom: 10px; display: block; ">Link Image</label>';
        item += '<input class="custom_media_url images-img-link" name="'+idname+'['+key+'][img_link]" value="" type="text" placeholder="-- Link --">';
        item += '<button class="st-button-upload" style="display: inline; margin-right: 15px; margin-bottom: 10px;  margin-top: 10px;  background: #00A0D2;  color: #fff;  border: none;  padding: 7px 10px;">Upload Image</button>';
        item += '<button class="st-button-remove-img-item" style="display: inline; margin-right: 15px; margin-bottom: 10px;  margin-top: 10px;  background: #00A0D2;  color: #fff;  border: none;  padding: 7px 10px;">Remove</button>';

        item += '</div>';
        $(this).parent().find('.add').append(item);

        $('.st-button-upload').on('click',function () {
            var send_attachment_bkp = wp.media.editor.send.attachment;
            var seff = $(this);
            wp.media.editor.send.attachment = function (props, attachment) {

                seff.parent().find('.custom_media_image').attr('src', attachment.url);
                seff.parent().find('.custom_media_image').attr('style','display:block');
                seff.parent().find('input.custom_media_url').val(attachment.url);
                wp.media.editor.send.attachment = send_attachment_bkp;
            }

            wp.media.editor.open();

            return false;
        });
        $('.st-button-remove-img-item').on('click',function () {

            $(this).parent().remove();

            return false;
        });
        return false;
    });       

    $('body').on('click', '.st-del', function(e)
    {
        e.preventDefault();
        $(this).parent().remove();
    })
})(jQuery);