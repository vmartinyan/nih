(function($){
    "use strict";
    $(document).ready(function() {
        
        /// Woocommerce Ajax
        $("body").on("click",".add_to_cart_button:not(.product_type_variable)",function(e){
            e.preventDefault();
            var product_id = $(this).attr("data-product_id");
            var seff = $(this);
            seff.append('<i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                type : "post",
                url : ajax_process.ajaxurl,
                crossDomain: true,
                data: {
                    action: "add_to_cart",
                    product_id: product_id
                },
                success: function(data){
                    seff.find('.fa-spinner').remove();
                    var cart_content = data.fragments['div.widget_shopping_cart_content'];
                    $('.mini-cart-content').html(cart_content);
                    var count_item = cart_content.split("<li").length;
                    $('.cart-item-count').html(count_item-1);
                },
                error: function(MLHttpRequest, textStatus, errorThrown){                    
                    console.log(errorThrown);  
                }
            });
        });

        $('body').on('click', '.btn-remove', function(e){
            e.preventDefault();
            var cart_item_key = $(this).parents('.item-info-cart').attr("data-key");
            console.log(cart_item_key);
            var element = $(this).parents('.item-info-cart');
            var currency = ["د.إ","лв.","kr.","Kr.","Rs.","руб."];
            var decimal = $("#num-decimal").val();
            function get_currency(pricehtml){
                var check,index,price,i;
                for(i = 0;i<6;i++){
                    if(pricehtml.search(currency[i]) != -1)  {
                        check = true;
                        index = i;
                    }
                }
                if(check) price =  pricehtml.replace(currency[index],"");
                else price = pricehtml.replace(/[^0-9\.]+/g,"");
                return price;
            }
            $.ajax({
                type: 'POST',
                url: ajax_process.ajaxurl,                
                crossDomain: true,
                data: { 
                    action: 'product_remove',
                    cart_item_key: cart_item_key
                },
                success: function(data){
                    console.log(data);
                    var price_html = element.find('span.amount').html();
                    var price = get_currency(price_html);
                    var qty = element.find('.cart-qty').find('span').html();
                    var price_remove = price*qty;
                    var current_total_html = $(".total-price").find(".amount").html();
                    console.log(current_total_html);
                    var current_total = get_currency(current_total_html);
                    var new_total = current_total-price_remove;
                    new_total = parseFloat(new_total).toFixed(decimal);
                    current_total_html = current_total_html.replace(',','');
                    var new_total_html = current_total_html.replace(current_total,new_total);
                    element.slideUp().remove();
                    // console.log(current_total);
                    // console.log(new_total);
                    // console.log(new_total_html);
                    $(".total-price").find(".amount").html(new_total_html);
                    var current_html = $('.cart-item-count').html();
                    $('.cart-item-count').html(current_html-1);
                },
                error: function(MLHttpRequest, textStatus, errorThrown){  
                    console.log(errorThrown);  
                }
            });
            return false;
        });

        $('body').on('click','.product-quick-view', function(e){            
            $.fancybox.showLoading();
            var product_id = $(this).attr('data-product-id');
            $.ajax({
                type: 'POST',
                url: ajax_process.ajaxurl,                
                crossDomain: true,
                data: { 
                    action: 'product_popup_content',
                    product_id: product_id
                },
                success: function(res){
                    // console.log(res);
                    if(res[res.length-1] == '0' ){
                        res = res.split('');
                        res[res.length-1] = '';
                        res = res.join('');
                    }
                    $.fancybox.hideLoading();
                    $.fancybox(res, {
                        onStart: function(opener) { 
                            if ($(opener).attr('id') == 'login') {
                                $.get('/hicommon/authenticated', function(res) { 
                                    if ('yes' == res) {
                                      console.log('this user must have already authenticated in another browser tab, SO I want to avoid opening the fancybox.');
                                      return false;
                                    } else {
                                      console.log('the user is not authenticated');
                                      return true;
                                    }
                                }); 
                            }
                        },
                    });
                    $('.product-gallery .bxslider').bxSlider({
                        pagerCustom: '.product-gallery #bx-pager',
                        nextText:'<span class="lnr lnr-chevron-right"></span>',
                        prevText:'<span class="lnr lnr-chevron-left"></span>'
                    });
                    
/*!
 * Variations Plugin
 */
!function(a,b,c,d){a.fn.wc_variation_form=function(){var c=this,f=c.closest(".product"),g=parseInt(c.data("product_id"),10),h=c.data("product_variations"),i=h===!1,j=!1,k=c.find(".reset_variations");return c.unbind("check_variations update_variation_values found_variation"),c.find(".reset_variations").unbind("click"),c.find(".variations select").unbind("change focusin"),c.on("click",".reset_variations",function(){return c.find(".variations select").val("").change(),c.trigger("reset_data"),!1}).on("reload_product_variations",function(){h=c.data("product_variations"),i=h===!1}).on("reset_data",function(){var b={".sku":"o_sku",".product_weight":"o_weight",".product_dimensions":"o_dimensions"};a.each(b,function(a,b){var c=f.find(a);c.attr("data-"+b)&&c.text(c.attr("data-"+b))}),c.wc_variations_description_update(""),c.trigger("reset_image"),c.find(".single_variation_wrap").slideUp(200).trigger("hide_variation")}).on("reset_image",function(){var a=f.find("div.images img:eq(0)"),b=f.find("div.images a.zoom:eq(0)"),c=a.attr("data-o_src"),e=a.attr("data-o_title"),g=a.attr("data-o_title"),h=b.attr("data-o_href");c!==d&&a.attr("src",c),h!==d&&b.attr("href",h),e!==d&&(a.attr("title",e),b.attr("title",e)),g!==d&&a.attr("alt",g)}).on("change",".variations select",function(){if(c.find('input[name="variation_id"], input.variation_id').val("").change(),c.find(".wc-no-matching-variations").remove(),i){j&&j.abort();var b=!0,d=!1,e={};c.find(".variations select").each(function(){var c=a(this).data("attribute_name")||a(this).attr("name");0===a(this).val().length?b=!1:d=!0,e[c]=a(this).val()}),b?(e.product_id=g,j=a.ajax({url:wc_cart_fragments_params.wc_ajax_url.toString().replace("%%endpoint%%","get_variation"),type:"POST",data:e,success:function(a){a?(c.find('input[name="variation_id"], input.variation_id').val(a.variation_id).change(),c.trigger("found_variation",[a])):(c.trigger("reset_data"),c.find(".single_variation_wrap").after('<p class="wc-no-matching-variations woocommerce-info">'+wc_add_to_cart_variation_params.i18n_no_matching_variations_text+"</p>"),c.find(".wc-no-matching-variations").slideDown(200))}})):c.trigger("reset_data"),d?"hidden"===k.css("visibility")&&k.css("visibility","visible").hide().fadeIn():k.css("visibility","hidden")}else c.trigger("woocommerce_variation_select_change"),c.trigger("check_variations",["",!1]),a(this).blur();c.trigger("woocommerce_variation_has_changed")}).on("focusin touchstart",".variations select",function(){i||(c.trigger("woocommerce_variation_select_focusin"),c.trigger("check_variations",[a(this).data("attribute_name")||a(this).attr("name"),!0]))}).on("found_variation",function(a,b){var e=f.find("div.images img:eq(0)"),g=f.find("div.images a.zoom:eq(0)"),h=e.attr("data-o_src"),i=e.attr("data-o_title"),j=e.attr("data-o_alt"),k=g.attr("data-o_href"),l=b.image_src,m=b.image_link,n=b.image_caption,o=b.image_title;c.find(".single_variation").html(b.price_html+b.availability_html),h===d&&(h=e.attr("src")?e.attr("src"):"",e.attr("data-o_src",h)),k===d&&(k=g.attr("href")?g.attr("href"):"",g.attr("data-o_href",k)),i===d&&(i=e.attr("title")?e.attr("title"):"",e.attr("data-o_title",i)),j===d&&(j=e.attr("alt")?e.attr("alt"):"",e.attr("data-o_alt",j)),l&&l.length>1?(e.attr("src",l).attr("alt",o).attr("title",o),g.attr("href",m).attr("title",n)):(e.attr("src",h).attr("alt",j).attr("title",i),g.attr("href",k).attr("title",i));var p=c.find(".single_variation_wrap"),q=f.find(".product_meta").find(".sku"),r=f.find(".product_weight"),s=f.find(".product_dimensions");q.attr("data-o_sku")||q.attr("data-o_sku",q.text()),r.attr("data-o_weight")||r.attr("data-o_weight",r.text()),s.attr("data-o_dimensions")||s.attr("data-o_dimensions",s.text()),b.sku?q.text(b.sku):q.text(q.attr("data-o_sku")),b.weight?r.text(b.weight):r.text(r.attr("data-o_weight")),b.dimensions?s.text(b.dimensions):s.text(s.attr("data-o_dimensions"));var t=!1,u=!1;b.is_purchasable&&b.is_in_stock&&b.variation_is_visible||(u=!0),b.variation_is_visible||c.find(".single_variation").html("<p>"+wc_add_to_cart_variation_params.i18n_unavailable_text+"</p>"),""!==b.min_qty?p.find(".quantity input.qty").attr("min",b.min_qty).val(b.min_qty):p.find(".quantity input.qty").removeAttr("min"),""!==b.max_qty?p.find(".quantity input.qty").attr("max",b.max_qty):p.find(".quantity input.qty").removeAttr("max"),"yes"===b.is_sold_individually&&(p.find(".quantity input.qty").val("1"),t=!0),t?p.find(".quantity").hide():u||p.find(".quantity").show(),u?p.is(":visible")?c.find(".variations_button").slideUp(200):c.find(".variations_button").hide():p.is(":visible")?c.find(".variations_button").slideDown(200):c.find(".variations_button").show(),c.wc_variations_description_update(b.variation_description),p.slideDown(200).trigger("show_variation",[b])}).on("check_variations",function(c,d,f){if(!i){var g=!0,j=!1,k={},l=a(this),m=l.find(".reset_variations");l.find(".variations select").each(function(){var b=a(this).data("attribute_name")||a(this).attr("name");0===a(this).val().length?g=!1:j=!0,d&&b===d?(g=!1,k[b]=""):k[b]=a(this).val()});var n=e.find_matching_variations(h,k);if(g){var o=n.shift();o?(l.find('input[name="variation_id"], input.variation_id').val(o.variation_id).change(),l.trigger("found_variation",[o])):(l.find(".variations select").val(""),f||l.trigger("reset_data"),b.alert(wc_add_to_cart_variation_params.i18n_no_matching_variations_text))}else l.trigger("update_variation_values",[n]),f||l.trigger("reset_data"),d||l.find(".single_variation_wrap").slideUp(200).trigger("hide_variation");j?"hidden"===m.css("visibility")&&m.css("visibility","visible").hide().fadeIn():m.css("visibility","hidden")}}).on("update_variation_values",function(b,d){i||(c.find(".variations select").each(function(b,c){var e,f=a(c);f.data("attribute_options")||f.data("attribute_options",f.find("option:gt(0)").get()),f.find("option:gt(0)").remove(),f.append(f.data("attribute_options")),f.find("option:gt(0)").removeClass("attached"),f.find("option:gt(0)").removeClass("enabled"),f.find("option:gt(0)").removeAttr("disabled"),e="undefined"!=typeof f.data("attribute_name")?f.data("attribute_name"):f.attr("name");for(var g in d)if("undefined"!=typeof d[g]){var h=d[g].attributes;for(var i in h)if(h.hasOwnProperty(i)){var j=h[i];if(i===e){var k="";d[g].variation_is_active&&(k="enabled"),j?(j=a("<div/>").html(j).text(),j=j.replace(/'/g,"\\'"),j=j.replace(/"/g,'\\"'),f.find('option[value="'+j+'"]').addClass("attached "+k)):f.find("option:gt(0)").addClass("attached "+k)}}}f.find("option:gt(0):not(.attached)").remove(),f.find("option:gt(0):not(.enabled)").attr("disabled","disabled")}),c.trigger("woocommerce_update_variation_values"))}),c.trigger("wc_variation_form"),c};var e={find_matching_variations:function(a,b){for(var c=[],d=0;d<a.length;d++){var f=a[d];e.variations_match(f.attributes,b)&&c.push(f)}return c},variations_match:function(a,b){var c=!0;for(var e in a)if(a.hasOwnProperty(e)){var f=a[e],g=b[e];f!==d&&g!==d&&0!==f.length&&0!==g.length&&f!==g&&(c=!1)}return c}};a.fn.wc_variations_description_update=function(b){var c=this,d=c.find(".woocommerce-variation-description");if(0===d.length)b&&(c.find(".single_variation_wrap").prepend(a('<div class="woocommerce-variation-description" style="border:1px solid transparent;">'+b+"</div>").hide()),c.find(".woocommerce-variation-description").slideDown(200));else{var e=d.outerHeight(!0),f=0,g=!1;d.css("height",e),d.html(b),d.css("height","auto"),f=d.outerHeight(!0),Math.abs(f-e)>1&&(g=!0,d.css("height",e)),g&&d.animate({height:f},{duration:200,queue:!1,always:function(){d.css({height:"auto"})}})}},a(function(){"undefined"!=typeof wc_add_to_cart_variation_params&&a(".variations_form").each(function(){a(this).wc_variation_form().find(".variations select:eq(0)").change()})})}(jQuery,window,document);
                    
                // BEGIN Fix Variable product

                //Select Size
                $('.selected-attr-size').text($('.select-attr-size li').first().find('a').text());
                $('body').click(function(){
                    $('.select-attr-size').slideUp();
                });
                $('.selected-attr-size').click(function(event){
                    event.preventDefault();
                    event.stopPropagation();
                    $(this).parent().find('.select-attr-size').slideToggle();
                    $(this).parent().next().find('select').trigger( 'focusin' );            
                    var content = '';
                    var old_content = $(this).parent().find('.select-attr-size').html();
                    var current_val = $(this).parent().find('.select-attr-size').find('a.selected').parent().attr('data-attribute');
                    $(this).parent().parent().next().find('select').find('option').each(function(){
                        var val = $(this).attr('value');
                        var title = $(this).html();
                        var el_class = '';
                        if(current_val == val) el_class = ' class="selected" ';
                        content += '<li data-attribute="'+val+'"><a href="#"'+el_class+'>'+title+'</a></li>';
                    })
                    if(content != old_content) $(this).parent().find('.select-attr-size').html(content);
                });
                $('body').on('click','.select-attr-size a',function(event){
                    event.preventDefault();
                    // console.log($(this));
                    $(this).parents('.select-attr-size').find('a').removeClass('selected');
                    $(this).addClass('selected');
                    $(this).parents('.attr-product').find('.selected-attr-size').text($(this).text());
                });
                //Select Color
                $('body').on('click','.attr-color li a',function(event){
                    // console.log($(this));
                    event.preventDefault();
                    $('.attr-color li a').removeClass('selected');
                    $(this).addClass('selected');
                });
                $('body').on('click','.select-attr-size li',function(event){
                    // console.log($(this));
                    var attribute = $(this).attr('data-attribute');
                    var id = $(this).parent().attr('data-attribute-id');
                    $('#'+id).val(attribute);
                    $('#'+id).trigger( 'change' );
                    $('#'+id).trigger( 'focusin' );
                })
                $('.attr-color').hover(function(){
                    var old_html = $(this).next().find('select').html();
                    var current_val = $(this).find('.select-attr-color').find('a.selected').parent().attr('data-attribute');
                    $(this).next().find('select').trigger( 'focusin' );
                    var content = '';
                    $(this).next().find('select').find('option').each(function(){
                        var val = $(this).attr('value');
                        var title = $(this).html();
                        var el_class = '';
                        if(current_val == val) el_class = ' class="selected" ';
                        if(val != '') content += '<li data-attribute="'+val+'"><a href="#"'+el_class+'><span class="color-'+val+'"></span></a></li>';
                    })
                    if(old_html != content) $(this).find('.select-attr-color').html(content);
                })
                $('body').on('click','.select-attr-color li',function(event){
                    var attribute = $(this).attr('data-attribute');
                    var id = $(this).parent().attr('data-attribute-id');
                    $('#'+id).val(attribute);
                    $('#'+id).trigger( 'change' );
                    $('#'+id).trigger( 'focusin' );
                    return false;
                })
                // END FIX

                //Select Color
                $('.attr-color li a').click(function(event){
                    event.preventDefault();
                    $('.attr-color li a').removeClass('selected');
                    $(this).addClass('selected');
                });
                $('body').click(function(){
                    $('.select-attr-size').slideUp();
                });

                //QUANTITY CLICK
                $(".quantity").find(".qty-up").on("click",function(){
                    var min = $(this).prev().attr("data-min");
                    var max = $(this).prev().attr("data-max");
                    var step = $(this).prev().attr("data-step");
                    if(step === undefined) step = 1;
                    if(max !==undefined && Number($(this).prev().val())< Number(max) || max === undefined){ 
                        if(step!='') $(this).prev().val(Number($(this).prev().val())+Number(step));
                    }
                    return false;
                })
                $(".quantity").find(".qty-down").on("click",function(){
                    var min = $(this).prev().prev().attr("data-min");
                    var max = $(this).prev().prev().attr("data-max");
                    var step = $(this).prev().prev().attr("data-step");
                    if(step === undefined) step = 1;
                    if(Number($(this).prev().prev().val()) > 1){
                        if(min !==undefined && $(this).prev().prev().val()>min || min === undefined){
                            if(step!='') $(this).prev().prev().val(Number($(this).prev().prev().val())-Number(step));
                        }
                    }
                    return false;
                })
                $("input.qty-val").on("keyup change",function(){
                    var max = $(this).attr('data-max');
                    if( Number($(this).val()) > Number(max) ) $(this).val(max);
                })
                //END

                //single add to cart
                $('.single_add_to_cart_button').each(function(){
                    $(this).addClass('link-add-cart');
                    var bt_html = $(this).html();
                    $(this).html('<span data-hover="'+bt_html+'">'+bt_html+'</span>');
                })
                //End
                $('.reset_variations').click(function(){
                    $('.select-attr-color').find('a').removeClass('selected');
                    $('.selected-attr-size').text($('.select-attr-size li').first().find('a').text());
                })
                //Detail Gallery
                if($('.detail-gallery').length>0){
                    $(".detail-gallery .carousel").jCarouselLite({
                        btnNext: ".gallery-control .next",
                        btnPrev: ".gallery-control .prev",
                        speed: 800,
                        visible: 4,
                    });

                    $(".detail-gallery .carousel a").on('click',function(event) {
                        event.preventDefault();
                        $(".detail-gallery .carousel a").removeClass('active');
                        $(this).addClass('active');
                        // $(".detail-gallery .mid img").attr("src", $(this).find('img').attr("src"));
                        $(".detail-gallery .mid").html($(this).html());
                    });
                }
                //End
                },
                error: function(MLHttpRequest, textStatus, errorThrown){  
                    console.log(errorThrown);  
                }
            });
            return false;
        })
        //End
        $('body').on('click', '.btn-load-more', function(e){
            e.preventDefault();
            var seff = $(this);
            var number = $(this).attr('data-number');
            var orderby = $(this).attr('data-orderby');
            var order = $(this).attr('data-order');
            var paged = $(this).attr('data-paged');
            var type_post = $(this).attr('data-type_post');
            var cats = $(this).attr('data-cats');
            var max_page = $(this).attr('data-maxpage');
            $.ajax({
                type: 'POST',
                url: ajax_process.ajaxurl,                
                crossDomain: true,
                data: { 
                    action: 'post_load_more',
                    number: number,
                    orderby: orderby,
                    order: order,
                    paged: paged,
                    type_post: type_post,
                    cats: cats,
                    max_page: max_page,
                },
                success: function(data){
                    if(data[data.length-1] == '0' ){
                        data = data.split('');
                        data[data.length-1] = '';
                        data = data.join('');
                    }
                    $('.latest-post-loadmore').append(data);
                    var curent_page = Number(paged)+1;
                    seff.attr('data-paged',curent_page);
                    if(curent_page == Number(max_page)){
                        seff.parent().fadeOut();
                    }
                },
                error: function(MLHttpRequest, textStatus, errorThrown){  
                    console.log(errorThrown);  
                }
            });
            return false;
        });

        //Load more button
        $('body').on('click', '.load-more-button', function(e){
            e.preventDefault();
            var seff = $(this);
            var number = $(this).attr('data-number');
            var orderby = $(this).attr('data-orderby');
            var order = $(this).attr('data-order');
            var paged = $(this).attr('data-paged');
            var type_post = $(this).attr('data-type_post');
            var cats = $(this).attr('data-cats');
            var max_page = $(this).attr('data-maxpage');
            $(this).find('i').addClass('fa-spin');
            $.ajax({
                type: 'POST',
                url: ajax_process.ajaxurl,                
                crossDomain: true,
                data: { 
                    action: 'post_load_more_button',
                    number: number,
                    orderby: orderby,
                    order: order,
                    paged: paged,
                    type_post: type_post,
                    cats: cats,
                    max_page: max_page,
                },
                success: function(data){
                    if(data[data.length-1] == '0' ){
                        data = data.split('');
                        data[data.length-1] = '';
                        data = data.join('');
                    }
                    $('.content-load-more .row').append(data);
                    seff.find('i').removeClass('fa-spin');
                    var curent_page = Number(paged)+1;
                    seff.attr('data-paged',curent_page);
                    if(curent_page == Number(max_page)){
                        seff.parent().fadeOut();
                    }
                },
                error: function(MLHttpRequest, textStatus, errorThrown){  
                    console.log(errorThrown);  
                }
            });
            return false;
        });
        //end

        //Load more blog masonry
        $('body').on('click', '.load-more-blog-masonry', function(e){
            e.preventDefault();
            var seff = $(this);
            var number = $(this).attr('data-number');
            var orderby = $(this).attr('data-orderby');
            var order = $(this).attr('data-order');
            var paged = $(this).attr('data-paged');
            var max_page = $(this).attr('data-maxpage');
            $(this).find('i').addClass('fa-spin');
            $.ajax({
                type: 'POST',
                url: ajax_process.ajaxurl,                
                crossDomain: true,
                data: { 
                    action: 'post_load_more_blog_masonry',
                    number: number,
                    orderby: orderby,
                    order: order,
                    paged: paged,
                    max_page: max_page,
                },
                success: function(data){
                    if(data[data.length-1] == '0' ){
                        data = data.split('');
                        data[data.length-1] = '';
                        data = data.join('');
                    }
                    // console.log(data);
                    var $newItem = $(data);
                    $(".content-blog-grid").append($newItem).masonry( 'appended', $newItem, true );                    
                    $('.content-blog-grid').imagesLoaded( function() {
                        $('.content-blog-grid').masonry('layout');
                    });
                    seff.find('i').removeClass('fa-spin');
                    var curent_page = Number(paged)+1;
                    seff.attr('data-paged',curent_page);
                    if(curent_page == Number(max_page)){
                        seff.parent().fadeOut();
                    }
                },
                error: function(MLHttpRequest, textStatus, errorThrown){  
                    console.log(errorThrown);  
                }
            });
            return false;
        });
        //end

        //Load more blog special
        $('body').on('click', '.loadmore-story', function(e){
            e.preventDefault();
            var seff = $(this);
            var number = $(this).attr('data-number');
            var orderby = $(this).attr('data-orderby');
            var order = $(this).attr('data-order');
            var paged = $(this).attr('data-paged');
            var max_page = $(this).attr('data-maxpage');
            $(this).find('i').addClass('fa-spin');
            $.ajax({
                type: 'POST',
                url: ajax_process.ajaxurl,                
                crossDomain: true,
                data: { 
                    action: 'post_load_more_blog_special',
                    number: number,
                    orderby: orderby,
                    order: order,
                    paged: paged,
                    max_page: max_page,
                },
                success: function(data){
                    if(data[data.length-1] == '0' ){
                        data = data.split('');
                        data[data.length-1] = '';
                        data = data.join('');
                    }
                    $(".blog-special-content").append(data);                    
                    seff.find('i').removeClass('fa-spin');
                    var curent_page = Number(paged)+1;
                    seff.attr('data-paged',curent_page);
                    if(curent_page == Number(max_page)){
                        seff.fadeOut();
                        seff.next().fadeIn();
                    }
                },
                error: function(MLHttpRequest, textStatus, errorThrown){  
                    console.log(errorThrown);  
                }
            });
            return false;
        });
        //end

        //Load more blog special
        $('body').on('click', '.explode-more', function(e){
            e.preventDefault();
            var seff = $(this);
            var number = $(this).attr('data-number');
            var orderby = $(this).attr('data-orderby');
            var order = $(this).attr('data-order');
            var paged = $(this).attr('data-paged');
            var max_page = $(this).attr('data-maxpage');
            $.ajax({
                type: 'POST',
                url: ajax_process.ajaxurl,                
                crossDomain: true,
                data: { 
                    action: 'post_load_more_blog_title',
                    number: number,
                    orderby: orderby,
                    order: order,
                    paged: paged,
                    max_page: max_page,
                },
                success: function(data){
                    if(data[data.length-1] == '0' ){
                        data = data.split('');
                        data[data.length-1] = '';
                        data = data.join('');
                    }
                    $("ul.list-post-blog").append(data);
                    var number_add = $('.post-number-add-'+paged).val();
                    var old_number = $('.total-story').html();
                    $('.total-story').html(Number(old_number)+Number(number_add));
                    var curent_page = Number(paged)+1;
                    seff.attr('data-paged',curent_page);
                    if(curent_page == Number(max_page)){
                        seff.fadeOut();
                        seff.next().fadeIn();
                    }
                },
                error: function(MLHttpRequest, textStatus, errorThrown){  
                    console.log(errorThrown);  
                }
            });
            return false;
        });
        //end

    });

})(jQuery);