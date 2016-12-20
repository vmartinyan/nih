(function($){
    "use strict"; // Start of use strict
	$(document).ready(function(){
		$('body').click(function(){
			if($('.extra-menu-dropdown').hasClass('active')){
				$('.extra-menu-dropdown').removeClass('active');
			}
		})
		//Menu Responsive
		$('body').click(function(){					
			if($(window).width() < 768){
				$('.main-nav .main-menu').slideUp('slow');
			}
		});
		$('.btn-mobile-menu').click(function(event){
			if($(window).width() < 768){
				event.preventDefault();
				event.stopPropagation();
				$('.main-nav .main-menu').slideToggle('slow');
			}
		});
		$('.main-nav li.menu-item-has-children>a').click(function(event){
			if($(window).width() < 768){
				event.stopPropagation();
				$(this).toggleClass('active');
				if($(this).hasClass('active')){
					event.preventDefault();
					$(this).next().slideDown('slow');
				}else{
					$(this).next().slideUp('slow');
				}
			}
		});
		//Abroad Language
		$('.abroad-link').on('click',function(event){
			event.preventDefault();
			$('.abroad-language').toggleClass('active');
		});
		//Scroll blog
		function sv_blog_scroll(){
			$('.item-post-blog').each(function(){
				if($(this).is(':visible')){
					var ost = $(this).offset().top-$('.header-page').height()-50;
					var osb = ost+$(this).height();
					var sbt = $('.sidebar-blog').offset().top;
					var st = $(window).scrollTop();
					if(st>ost && st<osb){
						$(this).addClass('active');
						var id = $('.item-post-blog.active').index();
						$('.current-story').text(id+1);
						$('.list-post-blog li').removeClass('active');
						$('.list-post-blog li').eq(id).addClass('active');
					}else{
						$(this).removeClass('active');
					}
				}
			});
			var st = $(window).scrollTop();
			var sbt = $('.sidebar-blog').offset().top-$('.header-page').height();
			var atop = $('.list-post-blog li.active').offset().top-$('.list-post-blog li:eq(0)').offset().top;
			var stop = $('#footer').offset().top-420;
			var stop2 = $('#footer').offset().top-550;
			if(st>sbt){
				$('.inner-sidebar-blog').css('margin-top','-'+atop+'px');
			}else{
			}
			if(st>stop){
				$('.blog-post-count').addClass('stop-bog-count');
			}else{
				$('.blog-post-count').removeClass('stop-bog-count');
			}
			if(st>stop2){
				$('.blog-post-count').parent().addClass('stop-blog');
			}else{
				$('.blog-post-count').parent().removeClass('stop-blog');
			}
			/* var num=$('.item-post-blog:visible').size();
			console.log(num); */
			$('.prev-story').on('click',function(event){
				event.preventDefault();
			});
			$('.next-story').on('click',function(event){
				event.preventDefault();
			});
		}
		//Fixed Post Control
		function post_control(){
			if($('.post-control2').length>0){
				var st = $(window).scrollTop();
				var sbt = $('.main-content-blog2').offset().top-50;
				var stop = $('#footer').offset().top-400;
				if(st>sbt && st<stop){
					$('.post-control2').addClass('active');
				}else{
					$('.post-control2').removeClass('active');
				}
			}
		}
		post_control();
		$(window).scroll(function(){
			post_control();
			if ($(this).scrollTop() > 300) {
				$('.scroll-top').fadeIn();
			} else {
				$('.scroll-top').fadeOut();
			}
		});
		//end fix
		if($(window).width() > 768){
			if($('.main-nav-blog').length > 0){
				$('.header-page').css('position','fixed');
				$('.header-page').css('background','#fff');
				$('.header-page').css('width','100%');
				$('.header-page').css('z-index','999');
			}
		}
		if($('.content-page-blog').length > 0){
			//Add Blog pecial
			$('.prev-story').on('click',function(){
				var this_active = $('.item-post-blog.active');
				$('html, body').animate({
			        scrollTop: this_active.prev().offset().top - 125
			    }, 1000);
			    // this_active.prev().addClass('active');
			    // this_active.removeClass('active');
			})
			$('.next-story').on('click',function(){
				var this_active = $('.item-post-blog.active');
				$('html, body').animate({
			        scrollTop: $('.item-post-blog.active').next().offset().top - 125
			    }, 1000);
			    // this_active.next().addClass('active');
			    // this_active.removeClass('active');
			})
			//End add
			
			sv_blog_scroll();
			$(window).scroll(function(){
				sv_blog_scroll();
			});
		}
		//end scroll

		//Widget Faqs
		$('.widget1.widget-faqs a').on('click',function(event){
			event.preventDefault();
			$('.widget1.widget-faqs li').removeClass('active');
			$(this).parent().addClass('active');
		});
		//search home 6
		$('.btn-header-search').on('click',function(event){
			event.preventDefault();
			$('.input-header-search').toggleClass('active');
		});
		//change text newletter 
		if($('.newsletter-footer').length > 0){
			$('.newsletter-footer').find('input[type="submit"]').attr('value','OK');
		}
		//Close Adv
		$('.close-top-adv').on('click',function(event){
			event.preventDefault();
			$(this).parent().slideUp();
		});
		//Scroll Top
		$('.scroll-top').on('click',function(event){
			event.preventDefault();
			$('html, body').animate({scrollTop:0}, 'slow');
		});
	
		//change price html
		$('.product-price').each(function(){
			var del_html = $(this).find('del').html();
			if(del_html != ''){
				$(this).find('del').remove();
				$( '<del>'+del_html+'</del>' ).insertAfter( $(this).find('ins'));
			}
		})
		//Widget Adv
		if($('.adv-widget-slider').length>0){
			$('.adv-widget-slider').each(function(){
				$(this).find('.wrap-item').owlCarousel({
					items: 1,
					itemsCustom: [ 
					[0, 1], 
					[480, 1], 
					[768, 1], 
					[992, 1], 
					[1200, 1] 
					],
					pagination: true,
					navigation: false,
				});
			});
		}
		//Toggle Sub Category
		$('.product-categories > li.cat-parent').first().addClass('active');
		$('.product-categories > li > a').on('click',function(event){
			$(this).toggleClass('current');
			if($(this).hasClass('current')){
				event.preventDefault();
				$('.cat-parent').removeClass('active');
				$(this).parent().addClass('active');
			}else{
				$('.cat-parent').removeClass('active');
				$(this).parent().addClass('active');
			}
		});

		//Shop Tab
		$('.bxslider-cate').each(function(){
			var id = $(this).next().attr('id');
			$(this).bxSlider({
				pagerCustom: '#'+id,
				controls:false
			});
		})

		// Gallery Slider
		if($('.post-gallery-slider').length>0){
			$('.post-gallery-slider').owlCarousel({
				items: 1,
				itemsCustom: [ 
				[0, 1], 
				[480, 1], 
				[768, 1], 
				[992, 1], 
				[1200, 1] 
				],
				pagination: true,
				navigation: false,
			});
		}
		//Fix table responsive
		$('table').each(function(){
			$(this).addClass('table');
			$(this).wrap( "<div class='table-responsive'></div>" );
		})
		//End

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

		//Count item cart
		if($("#count-cart-item").length){
			var count_cart_item = $("#count-cart-item").val();
			$(".cart-item-count").html(count_cart_item);
		}
		if($(".get-count-cart-item")){
			var count_cart_item = $(".get-count-cart-item").val();
			$(".number-cart-total").html(count_cart_item);
		}
		//End
		
		//Show Search
		$('.header-btn-search').click(function(event){
			event.preventDefault();
			$('.header-input-search').toggleClass('active');
		});
		$('.event-btn-search').click(function(event){
			event.preventDefault();
			$('.event-form-search').toggleClass('active');
		});
		//End

		//Event Speaker Hover Dir
		$('.item-speaker').each( function() {
			$(this).hoverdir(); 
		});
		//End

		//Select Time
		$('.select-event-time').selectmenu();
		//End

		//get date value
		$('.select-event-time').on('selectmenuchange',function(){
			$(this).parent().find('.event-date-value').val($(this).val());
		})
		//end

		//Extra Menu
		$('body').on('click','.btn-extra-menu',function(event){
			event.preventDefault();
			event.stopPropagation();
			$(this).parent().next().toggleClass('active');
		});
		//End

		//Date Picker
		$( "#datepicker" ).datepicker();
		//End

		//Event photos
		$(".event-photos").click(function(event){
			event.preventDefault();
			var gallerys = $(this).attr('data-gallery');
			var gallerys_array = gallerys.split(',');
			var data = [];
			if(gallerys != ''){
				for (var i = 0; i < gallerys_array.length; i++) {
					if(gallerys_array[i] != ''){
						data[i] = {};
						data[i].href = gallerys_array[i];
					}
				};
			}
			$.fancybox.open(data);
		});
		//End

		//Fancy Box Event
		$('.event-video-popup').attr('rel', 'media-gallery').fancybox({
			openEffect : 'none',
			closeEffect : 'none',
			prevEffect : 'none',
			nextEffect : 'none',

			arrows : false,
			helpers : {
				media : {},
				buttons : {}
			}
		});
		//End

		//Extra link fix
		$('.extra-content').each(function(){
			var content = $(this).html();
			$(this).html('');
			$(this).prev().find('ul.newday-menu').parent().append(content);
		})
		//End

		//UpComming Countdown
		if($('.hotdeal-countdown').length>0){
			$(".hotdeal-countdown").TimeCircles({
				fg_width: 0.03,
				bg_width: 0,
				text_size: 0,
				circle_bg_color: "#494a4c",
				time: {
					Days: {
						show: true,
						text: "DAY",
						color: "#fbb450"
					},
					Hours: {
						show: true,
						text: "HOUR",
						color: "#fbb450"
					},
					Minutes: {
						show: true,
						text: "MIN",
						color: "#fbb450"
					},
					Seconds: {
						show: true,
						text: "SEC",
						color: "#fbb450"
					}
				}
			}); 
		}
		//End
		
	});

	$(window).load(function(){
		//Carousel Slider
		if($('.sv-slider').length>0){
			$('.sv-slider').each(function(){
				var seff = $(this);
				var item = seff.attr('data-item');
				var speed = seff.attr('data-speed');
				var itemres = seff.attr('data-itemres');
				var animation = seff.attr('data-animation');
				var auto_height = seff.attr('data-auto_height');
				if(auto_height) auto_height = true;
				else auto_height = false;
				var nav = seff.attr('data-nav');
				var pagination = true, navigation= false, singleItem = false;
				var autoplay;
				if(speed != '') autoplay = speed;
				else autoplay = false;
				// Navigation
				if(nav == 'nav-hidden'){
					pagination = false;
					navigation= false;
				}
				var prev_text = 'prev';
				var next_text = 'next';
				if(nav == 'home-direct-nav' || nav == 'info-expert' || nav == 'content-owl-speaker'){
					pagination = false;
					navigation = true;
					prev_text = '<span class="lnr lnr-chevron-left"></span>';
					next_text = '<span class="lnr lnr-chevron-right"></span>';
				}
				if(nav == 'event-banner-slider'){
					pagination = false;
					navigation = true;
					prev_text = '<span class="lnr lnr-arrow-left-circle"></span>';
					next_text = '<span class="lnr lnr-arrow-right-circle"></span>';
				}
				if(nav == 'banner-shop-slider'){
					pagination = false;
					navigation = true;
					prev_text = '';
					next_text = '';
				}
				if(animation != ''){
					singleItem = true;
					item = '1';
				}
				// Item responsive
				if(itemres == '' || itemres === undefined || itemres.split(',').length < 4){
					if(item == '1') itemres = '1,1,1,1';
					if(item == '2') itemres = '1,2,2,2';
					if(item == '3') itemres = '1,2,2,3';
					if(item == '4') itemres = '1,2,2,4';
					if(item >= '5') itemres = '1,2,3,5';
				}
				itemres = itemres.split(',');
				seff.owlCarousel({
					items: item,
					itemsCustom: [ 
					[0, itemres[0]], 
					[360, itemres[0]], 
					[568, itemres[1]],
					[768, itemres[2]], 
					[992, itemres[3]], 
					[1200, item] 
					],
					autoPlay:autoplay,
					pagination: pagination,
					navigation: navigation,
					navigationText:[prev_text,next_text],
					singleItem : singleItem,
					addClassActive : true,
					autoHeight: auto_height,
					transitionStyle : animation
				});
			});
		}
		//End

		// Fix height item post
		$('.home-direct-nav').each(function(){			
			var item_height = 0;
			$(this).find('.post-info.fix-height').each(function(){
				if($(this).height() > item_height) item_height = $(this).height();
			})
			// $(this).find('.post-info.fix-height').height(item_height);
		})
		//End

		//Gallery Slider
		if($('.gallery-slider .slider.center').length>0){
			$('.gallery-slider .slider.center').each(function(){
				if($(window).width()>768){
					$(this).slick({
						autoplay: true,
						 centerMode: true,
						 centerPadding: '218px',
						 slidesToShow: 1,
					});
				}
				if($(window).width()>640 && $(window).width()<=768){
					$(this).slick({
						autoplay: true,
						 centerMode: true,
						 centerPadding: '100px',
						 slidesToShow: 1,
					});
				}
				if($(window).width()<=640){
					$(this).slick({
						autoplay: true,
						 centerMode: true,
						 centerPadding: '0px',
						 slidesToShow: 1,
					});
				}
			});
		}
		//End

		//Event Comming Up
		if($('.event-upcomming-slider').length>0){
			$('.event-upcomming-slider').each(function(){
				$(this).find('.wrap-item').owlCarousel({
					items: 1,
					itemsCustom: [ 
					[0, 1], 
					[480, 1], 
					[768, 1], 
					[992, 1], 
					[1200, 1] 
					],
					pagination: false,
					navigation: true,
					navigationText:['<span class="lnr lnr-chevron-left"></span>','<span class="lnr lnr-chevron-right"></span>']
				});
			});
		}
		//End

		//Vertical Menu Slider
		if($('.vertical-menu-slider').length>0){
			$(".vertical-menu-slider").jCarouselLite({
				btnNext: ".control-menu-slider .next",
				btnPrev: ".control-menu-slider .prev",
				visible: 6,
				vertical: true
			});
		}
		//End

		//Skill piechart
		$('.chart-skill').each(function(){
			var id = $(this).attr('id');
			var radius = $(this).attr('data-radius');
			var value = $(this).attr('data-value');
			var width = $(this).attr('data-width');
			var color1 = $(this).attr('data-color1');
			var color2 = $(this).attr('data-color2');
			Circles.create({
				id:                  id,
				radius:              Number(radius),
				value:               Number(value),
				maxValue:            100,
				width:               Number(width),
				colors:              [color1, color2],
				duration:            800,
				wrpClass:            'circles-wrp',
				textClass:           'circles-text',
				valueStrokeClass:    'circles-valueStroke',
				maxValueStrokeClass: 'circles-maxValueStroke',
				styleWrapper:        true,
				styleText:           true
			});
		})		
		//End

		//menu fix
		if($(window).width() > 1024){
			$('.main-nav ul.sub-menu').each(function(){
				var left = $(this).offset().left;
				if(left > 1100){
					$(this).css({"left": "-100%"})
				}
				if(left < 20){
					$(this).css({"left": "100%"})
				}
			})
		}
		//End

		//Video Tab Slider
		if($('.tab-video-slider').length>0){
			$('.bxslider').each(function(){
				var id = $(this).attr('data-id');
				$(this).bxSlider({
					pagerCustom: '#'+id
				});
			})			
			$('.tab-item').hide();
			$('.tab-item.active').show();
			$('.title-tab-video a').on('click',function(event){
				event.preventDefault();
				var id = $(this).attr('data-id');
				$(this).parents('ul').find('li').removeClass('active');
				$(this).parent().addClass('active');
				$('#'+id).parent().find('.tab-item').hide();
				$('#'+id).show();
			});
		}
		//End

		//Featured Product Slider
		if($('.featured-product-slider').length>0){
			$('.featured-product-slider').each(function(){
				$(this).find('.wrap-item').owlCarousel({
					items: 1,
					itemsCustom: [ 
					[0, 1], 
					[480, 1], 
					[768, 1], 
					[992, 1], 
					[1200, 1] 
					],
					pagination: false,
					navigation: true,
					navigationText:['','']
				});
			});
		}
		//End
		//Owl Product Slider
		if($('.owl-tab-slider').length>0){
			$('.owl-tab-slider').each(function(){
				$(this).find('.wrap-item').owlCarousel({
					items: 4,
					itemsCustom: [ 
					[0, 1], 
					[480, 2], 
					[768, 3], 
					[992, 3], 
					[1200, 4] 
					],
					pagination: false,
					navigation: true,
					navigationText:['','']
				});
			});
		}
		//End

		//Detail Gallery
		if($('.detail-gallery').length>0){
			$(".col-md-12 .detail-gallery .carousel").jCarouselLite({
				btnNext: ".gallery-control .next",
				btnPrev: ".gallery-control .prev",
				speed: 800,
				visible: 4,
			});

			$(".col-md-9 .detail-gallery .carousel").jCarouselLite({
				btnNext: ".gallery-control .next",
				btnPrev: ".gallery-control .prev",
				speed: 800
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
		$('.reset_variations').click(function(){
			$('.select-attr-color').find('a').removeClass('selected');
			$('.selected-attr-size').text($('.select-attr-size li').first().find('a').text());
		})
		//Fix product variable thumb
        $('body .variations_form select').live('change',function(){         
            var id = $('input[name="variation_id"]').val();
            if(id){
                $('.detail-gallery').find('.carousel').find('li[data-variation_id="'+id+'"] a').trigger( 'click' );
            }
        })
		//Latest Product Slider
		if($('.latest-product-slider').length>0){
			$('.latest-product-slider').each(function(){
				$(this).find('.wrap-item').owlCarousel({
					items: 3,
					itemsCustom: [ 
					[0, 1], 
					[480, 2], 
					[768, 2], 
					[992, 3], 
					[1200, 3] 
					],
					pagination: false,
					navigation: true,
					navigationText:['','']
				});
			});
		}
		//End

		//Banner Slider
		if($('.banner-slider3').length>0){
			$('.banner-slider3').each(function(){
				$(this).find('.wrap-item').owlCarousel({
					items: 1,
					itemsCustom: [ 
					[0, 1], 
					[480, 1], 
					[768, 1], 
					[992, 1], 
					[1200, 1] 
					],
					pagination: true,
					navigation: true,
					navigationText:['<span class="lnr lnr-chevron-left"></span>','<span class="lnr lnr-chevron-right"></span>']
				});
			});
		}
		//End

		//Popular Slider
		if($('.most-popular-slider .center').length>0){
			$('.most-popular-slider .center').each(function(){
				if($(window).width()>1024){
					$(this).slick({
						 centerMode: true,
						 centerPadding: '200px',
						 slidesToShow: 1,
					});
				}else{
					$(this).slick({
						 centerMode: true,
						 centerPadding: '0px',
						 slidesToShow: 1,
						 arrows: false,
					});
				}
			});
		}
		//End

		//Post Format Slider
		if($('.post-format-slider').length>0){
			$('.post-format-slider').each(function(){
				$(this).find('.wrap-item').owlCarousel({
					items: 1,
					itemsCustom: [ 
					[0, 1], 
					[480, 1], 
					[768, 1], 
					[992, 1], 
					[1200, 1] 
					],
					pagination: false,
					navigation: true,
					navigationText:['<span class="lnr lnr-chevron-left"></span>','<span class="lnr lnr-chevron-right"></span>']
				});
			});
		}
		//End
		//Trending Slider
		if($('.trending-post').length>0){
			$('.trending-post').each(function(){
				$(this).find('.wrap-item').owlCarousel({
					items: 1,
					itemsCustom: [ 
					[0, 1], 
					[480, 1], 
					[768, 1], 
					[992, 1], 
					[1200, 1] 
					],
					pagination: false,
					navigation: true,
					addClassActive:true,
					navigationText:['<span class="lnr lnr-chevron-left"></span>','<span class="lnr lnr-chevron-right"></span>']
				});
				$('.trending-post .owl-theme .owl-controls .owl-buttons').append('<div class="total-slide"></div>');
				$('.trending-post .owl-theme .owl-controls .owl-buttons .total-slide').insertAfter('.trending-post .owl-theme .owl-controls .owl-buttons .owl-prev');
				function show_total_slide(){
					var total = $('.trending-post  .owl-item').size();
					console.log(total);
					var current = $('.trending-post  .owl-item.active').index()+1;
					$('.trending-post .total-slide').html('<span class="current-item">'+current+'</span>'+'<span class="total-item">/'+total+'</span>');
				}
				show_total_slide();
				$('.trending-post .owl-theme .owl-controls .owl-buttons div').click(function(){
					show_total_slide();
				});
			});
		}
		//End

		//Top Post Slider
		if($('.top-post-slider6').length>0){
			$('.top-post-slider6').each(function(){
				$(this).find('.wrap-item').owlCarousel({
					items: 1,
					itemsCustom: [ 
					[0, 1], 
					[480, 1], 
					[768, 2], 
					[992, 2], 
					[1200, 2] 
					],
					pagination: false,
					navigation: true,
					navigationText:['<span class="lnr lnr-chevron-left"></span>','<span class="lnr lnr-chevron-right"></span>']
				});
			});
		}
		//End

		//Gallery Slider
		if($('.main-gallery-slider').length>0){
			$('.main-gallery-slider').each(function(){
				$(this).find('.wrap-item').owlCarousel({
					items: 1,
					itemsCustom: [ 
					[0, 1], 
					[480, 1], 
					[768, 1], 
					[992, 1], 
					[1200, 1] 
					],
					pagination: false,
					navigation: true,
					addClassActive:true,
					loop:true,
					slideSpeed:800,
					navigationText:['<span class="lnr lnr-chevron-left"></span>','<span class="lnr lnr-chevron-right"></span>']
				});
				$('.main-gallery-slider .owl-theme .owl-controls .owl-buttons').append('<div class="total-slide"></div>');
				$('.main-gallery-slider .owl-theme .owl-controls .owl-buttons .total-slide').insertAfter('.main-gallery-slider .owl-theme .owl-controls .owl-buttons .owl-prev');
				function show_total_slide(){
					var total = $('.main-gallery-slider  .owl-item').size();
					var current = $('.main-gallery-slider  .owl-item.active').index()+1;
					$('.main-gallery-slider .total-slide').html('<span class="current-item">'+current+'</span>'+'<span class="total-item">/'+total+'</span>');
				}
				show_total_slide();
				$('.main-gallery-slider .owl-theme .owl-controls .owl-buttons div').click(function(){
					show_total_slide();
				});
				function get_html(){
					if($('.main-gallery-slider').find('.owl-item.active').prev().length>0){
					$('.item-gallery-prev').html($('.main-gallery-slider').find('.owl-item.active').prev().find('.gallery-slider-thumb').html());
					}else{
						$('.item-gallery-prev').html($('.main-gallery-slider').find('.owl-item').last().find('.gallery-slider-thumb').html());
					}
					if($('.main-gallery-slider').find('.owl-item.active').next().length>0){
						$('.item-gallery-next').html($('.main-gallery-slider').find('.owl-item.active').next().find('.gallery-slider-thumb').html());
					}else{
						$('.item-gallery-next').html($('.main-gallery-slider').find('.owl-item').first().find('.gallery-slider-thumb').html());
					}
				}
				if($(window).width()>1024){
					get_html();
					$('.owl-prev').on('click',function(){
						get_html();
					});
					$('.owl-next').on('click',function(){
						get_html();
					});
				}
			});
		}
		//End
	//Home 7
		//post slider
		if($('.content-bx-latest-post').length>0){
			if($(window).width()>480){
				$('.content-bx-latest-post').bxSlider({
					minSlides: 1,
					maxSlides: 4,
					moveSlides: 1,
					slideMargin: 5,
					slideWidth: 280,
					pager: false,
					touchEnabled:true,
					nextText:'<span class="lnr lnr-chevron-right"></span>',
					prevText:'<span class="lnr lnr-chevron-left"></span>',
				});
			}else{
				$('.content-bx-latest-post').bxSlider({
					minSlides: 1,
					maxSlides: 1,
					moveSlides: 1,
					slideMargin: 0,
					slideWidth: 480,
					pager: false,
					touchEnabled:true,
					nextText:'<span class="lnr lnr-chevron-right"></span>',
					prevText:'<span class="lnr lnr-chevron-left"></span>',
				});
			}
		}
		//End

		if($('.content-what-new-slider').length>0){
			$('.content-what-new-slider').each(function(){
				$(this).find('.wrap-item').owlCarousel({
					items: 1,
					itemsCustom: [ 
					[0, 1], 
					[480, 1], 
					[768, 1], 
					[992, 1], 
					[1200, 1] 
					],
					navigationText:['<span class="lnr lnr-chevron-left"></span>','<span class="lnr lnr-chevron-right"></span>'],
					pagination: false,
					navigation: true,
				});
			});
		}
		//End

		if($('.content-photo-video-slider').length>0){
			$('.content-photo-video-slider').each(function(){
				$(this).find('.wrap-item').owlCarousel({
					items: 1,
					itemsCustom: [ 
					[0, 1], 
					[480, 1], 
					[768, 1], 
					[992, 1], 
					[1200, 1] 
					],
					navigationText:['<span class="lnr lnr-arrow-left-circle"></span>','<span class="lnr lnr-arrow-right-circle"></span>'],
					pagination: true,
					navigation: true,
				});
			});
		}
		//End

		//Home 2
		if($('.analysis-slider').length>0){
			$('.analysis-slider').each(function(){
				$(this).find('.wrap-item').owlCarousel({
					items: 1,
					itemsCustom: [ 
					[0, 1], 
					[480, 1], 
					[768, 1], 
					[992, 1], 
					[1200, 1] 
					],
					navigationText:['<span class="lnr lnr-chevron-left"></span>','<span class="lnr lnr-chevron-right"></span>'],
					pagination: false,
					navigation: true,
				});
			});
		}

		//Masonry
		if($('.masonry-post-box').length>0){
			$('.masonry-post-box').masonry({
				// options
				itemSelector: '.item-post-box',
			});
		}

		//Most Popular Post Box Home 2
		if($('.most-popular-post-slider').length>0){
			$('.most-popular-post-slider').each(function(){
				$(this).find('.wrap-item').owlCarousel({
					items: 1,
					itemsCustom: [ 
					[0, 1], 
					[480, 1], 
					[768, 1], 
					[992, 1], 
					[1200, 1] 
					],
					pagination: true,
					navigation: false,
				});
			});
		}

		//End

	//Home 4
		//Featured Newday
		if($('.featured-newday-slider').length>0){
			$('.featured-newday-slider').each(function(){
				$(this).find('.wrap-item').owlCarousel({
					items: 1,
					itemsCustom: [ 
					[0, 1], 
					[480, 1], 
					[768, 2], 
					[992, 3], 
					[1200, 3] 
					],
					pagination: false,
					navigation: true,
					navigationText:['<span class="lnr lnr-chevron-left"></span>','<span class="lnr lnr-chevron-right"></span>']
				});
			});
		}

		//Topic Slider
		if($('.content-topic-slider').length>0){
			$('.content-topic-slider').each(function(){
				$(this).find('.wrap-item').owlCarousel({
					items: 1,
					itemsCustom: [ 
					[0, 1], 
					[480, 1], 
					[768, 1], 
					[992, 1], 
					[1200, 1] 
					],
					pagination: true,
					navigation: false,
					// navigationText:['<span class="lnr lnr-chevron-left"></span>','<span class="lnr lnr-chevron-right"></span>']
				});
			});
		}

		//Trending Slider
		if($('.list-trending-box').length>0){
			$('.list-trending-box').each(function(){
				$(this).find('.wrap-item').owlCarousel({
					items: 1,
					itemsCustom: [ 
					[0, 1], 
					[480, 1], 
					[768, 1], 
					[992, 1], 
					[1200, 1] 
					],
					pagination: true,
					navigation: false,
				});
			});
		}

		//Most Read Slider
		if($('.most-read-slider').length>0){
			$('.most-read-slider').each(function(){
				$(this).find('.wrap-item').owlCarousel({
					items: 1,
					itemsCustom: [ 
					[0, 1], 
					[480, 1], 
					[768, 1], 
					[992, 1], 
					[1200, 1] 
					],
					pagination: false,
					navigation: true,
					navigationText:['<span class="lnr lnr-chevron-left"></span>','<span class="lnr lnr-chevron-right"></span>']
				});
			});
		}

		//Motion Event
		if($('.motion-event').length>0){
			$('.motion-event').each(function(){
				$(this).find('.wrap-item').owlCarousel({
					items: 1,
					itemsCustom: [ 
					[0, 1], 
					[480, 1], 
					[768, 1], 
					[992, 1], 
					[1200, 1] 
					],
					pagination: false,
					navigation: true,
					addClassActive:true,
					navigationText:['<span class="lnr lnr-chevron-left"></span>','<span class="lnr lnr-chevron-right"></span>']
				});
				$('.motion-event .owl-theme .owl-controls .owl-buttons').append('<div class="total-slide"></div>');
				$('.motion-event .owl-theme .owl-controls .owl-buttons .total-slide').insertBefore('.motion-event .owl-theme .owl-controls .owl-buttons');
				function show_total_slide(){
					var total = $('.motion-event  .owl-item').size();
					var current = $('.motion-event  .owl-item.active').index()+1;
					$('.total-slide').html(current+' of '+total);
				}
				show_total_slide();
				$('.motion-event .owl-theme .owl-controls .owl-buttons div').click(function(){
					show_total_slide();
				});
			});
		}

		//Latest News Category
		if($('.content-latest-news-category').length>0){
			$('.content-latest-news-category').each(function(){
				$(this).find('.wrap-item').owlCarousel({
					items: 1,
					itemsCustom: [ 
					[0, 1], 
					[480, 1], 
					[768, 2], 
					[992, 2], 
					[1200, 2] 
					],
					pagination: false,
					navigation: true,
					navigationText:['<span class="lnr lnr-chevron-left"></span>','<span class="lnr lnr-chevron-right"></span>']
				});
			});
		}

	//end

	//Home 5

		if($('.bxslider5').length>0){
			$('.bxslider5').each(function(){
				var id = $(this).attr('data-bxid');
				$('.bxslider5').bxSlider({
					pagerCustom: '#bx-pager'+id,
					auto:true,
					nextText:'<span class="lnr lnr-chevron-right"></span>',
					prevText:'<span class="lnr lnr-chevron-left"></span>',
				});
			})
		}

		//Blog slider

		//Item Blog List Slider
		if($('.item-blog-full-slider').length>0){
			$('.item-blog-full-slider').each(function(){
				$(this).find('.wrap-item').owlCarousel({
					items: 1,
					itemsCustom: [ 
					[0, 1], 
					[480, 1], 
					[768, 1], 
					[992, 1], 
					[1200, 1] 
					],
					pagination: false,
					navigation: true,
					navigationText:['<span class="lnr lnr-chevron-left"></span>','<span class="lnr lnr-chevron-right"></span>']
				});
			});
		}	
		if($('.item-blog-list').length>0){
			$('.item-blog-list').each(function(){
				$(this).find('.wrap-item').owlCarousel({
					items: 1,
					itemsCustom: [ 
					[0, 1], 
					[480, 1], 
					[768, 1], 
					[992, 1], 
					[1200, 1] 
					],
					pagination: true,
					navigation: false,
				});
			});
		}
		if($('.content-blog-grid').length>0){
			$('.content-blog-grid').masonry({
				// options
				itemSelector: '.item-blog-grid',
			});
		}
		if($('.item-blog-slider').length>0){
			$('.item-blog-slider').each(function(){
				$(this).find('.wrap-item').owlCarousel({
					items: 1,
					itemsCustom: [ 
					[0, 1], 
					[480, 1], 
					[768, 1], 
					[992, 1], 
					[1200, 1] 
					],
					pagination: false,
					navigation: true,
					navigationText:['<span class="lnr lnr-chevron-left"></span>','<span class="lnr lnr-chevron-right"></span>']
				});
			});
		}
	//End
	// Mega slider
		if($('.mega-post-slider .home-direct-nav').length>0){
			$('.mega-post-slider .home-direct-nav').each(function(){
				$(this).find('.wrap-item').owlCarousel({
					items: 1,
					itemsCustom: [ 
					[0, 1], 
					[480, 1], 
					[768, 2], 
					[992, 3], 
					[1200, 3] 
					],
					pagination: false,
					navigation: true,
					navigationText:['<span class="lnr lnr-chevron-left"></span>','<span class="lnr lnr-chevron-right"></span>']
				});
			});
		}
		if($('.vertical-mega-slider').length>0){
			$(".vertical-mega-slider").jCarouselLite({
				btnNext: ".control-mega-slider .next",
				btnPrev: ".control-mega-slider .prev",
				visible: 3,
				vertical: true
			});
		}
		//End

	});
	$(window).resize(function(){
    	if($(window).width() >= 768) $('.main-nav .main-menu').slideDown();
    });

})(jQuery);