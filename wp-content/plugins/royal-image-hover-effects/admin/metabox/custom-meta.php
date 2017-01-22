<?php
return array(
// Tougle Menu
	array(
		'type' => 'toggle',
		'name' => 'style1',
		'label' => __('Style 1', 'vp_textdomain'),
	),

	array(
		'type' => 'toggle',
		'name' => 'style2',
		'label' => __('Style 2 (<strong style="color:red;">Pro Only</strong>)', 'vp_textdomain'),
	),
	
		array(
		'type' => 'toggle',
		'name' => 'style3',
		'label' => __('Style 3 (<strong style="color:red;">Pro Only</strong>)', 'vp_textdomain'),
	),


	array(
		'type' => 'notebox',
		'name' => 'notebox',
		'label' => __('Author Comment', 'vp_textdomain'),
		'description' => __('To see all styles and effects use the <a target="_blank" href="http://demos.codecans.com/royal-image-hover-all-style-demo/">demo site</a>', 'vp_textdomain'),
		'status' => 'normal',
	),



	//Group Field Section
	array(
		'type'      => 'group',
		'repeating' => false,
		'sortable'  => true,
		'name'      => 'pro_option_1',
		'priority'  => 'high',
		'title'     => __('Style 2 Settings panel', 'vp_textdomain'),

		'dependency' => array(
			'field'    => 'style2',
			'function' => 'vp_dep_boolean',
		),

		'fields' => array(


			array(
				'type' => 'notebox',
				'name' => 'nb_2',
				'label' => __('Style 2 Only Available For pro Version:', 'vp_textdomain'),
				'description' => __('<p style="color: #000;">To get Pro Version of Royal Image hover effects pro, please buy the pro version only $12</p> </br><a target="_blank" href="http://codecans.com/items/royal-image-hover-effects-pro/"> <span id="buy_now_class"><img style="width: 170px;" src="http://demos.codecans.com/tutorials/images/buy_now.gif" /></span></a>', 'vp_textdomain'),
				'status' => 'normal',
			),

		)),

	//Group Field Section
	array(
		'type'      => 'group',
		'repeating' => false,
		'sortable'  => true,
		'name'      => 'pro_option_2',
		'priority'  => 'high',
		'title'     => __('Style 3 Settings panel', 'vp_textdomain'),

		'dependency' => array(
			'field'    => 'style3',
			'function' => 'vp_dep_boolean',
		),

		'fields' => array(


			array(
				'type' => 'notebox',
				'name' => 'nb_1_stl',
				'label' => __('Style 3 Only Available For pro Version:', 'vp_textdomain'),
				'description' => __('<p style="color: #000;">To get Pro Version of Royal Image hover effects pro, please buy the pro version only $12</p> </br><a target="_blank" href="http://codecans.com/items/royal-image-hover-effects-pro/"> <span id="buy_now_class"><img style="width: 170px;" src="http://demos.codecans.com/tutorials/images/buy_now.gif" /></span></a>', 'vp_textdomain'),
				'status' => 'normal',
			),

		)),

	//Style 1 Group Field Section
	array(
		'type'      => 'group',
		'repeating' => true,
		'sortable'  => true,
		'name'      => 'style1_option',
		'priority'  => 'high',
		'title'     => __('Royal Hover Item', 'vp_textdomain'),
			'dependency' => array(
				'field'    => 'style1',
				'function' => 'vp_dep_boolean',
				),

				
		'fields'    => array(
		
	
			array(
					'type' => 'upload',
					'name' => 'style1_image_upload',
					'label' => __('Hover Image', 'vp_textdomain'),
				),
				
			array(
				'type'  => 'textbox',
				'name'  => 'put_style1_title',
				'label' => __('Heading', 'vp_textdomain'),
				'default' => 'Heading Here',
				
			),			
			
			array(
				'type'  => 'textarea',
				'name'  => 'put_style1_description',
				'label' => __('Description', 'vp_textdomain'),
				'default' => 'Description goes here',
			),
                    array(
                        'type' => 'fontawesome',
                        'name' => 'first_social_icon_choser',
                        'label' => __('Select First Icon', 'vp_textdomain'),
                        'default' => array(
                                '{{last}}',
                            ),
                        ),
                                
                // Second Icon Choser
                    array(
                        'type' => 'fontawesome',
                        'name' => 'second_social_icon_choser',
                        'label' => __('Select Second Icon', 'vp_textdomain'),
                        'default' => array(
                                '{{first}}',
                            ),
                        ),	
                                
                // Third Icon Choser
                    array(
                        'type' => 'fontawesome',
                        'name' => 'third_social_icon_choser',
                        'label' => __('Select Third Icon', 'vp_textdomain'),
                        'default' => array(
                                '{{first}}',
                            ),
                        ),

                                
                //  Fourth Icon Choser
                    array(
                        'type' => 'fontawesome',
                        'name' => 'fourth_social_icon_choser',
                        'label' => __('Select Fourth Icon', 'vp_textdomain'),
                        'default' => array(
                                '{{first}}',
                            ),
                        ),
                        
                            
        // First Icon Color
                        array(
                    'type' => 'color',
                    'name' => 'first_icon_color',
                    'label' => __('First Icon Color - <span><a target="_blank" style="color: #ff3b3b;" href="http://codecans.com/items/royal-image-hover-effects-pro/">Pro Only</a></span>', 'vp_textdomain'),
                    'default' => '#cdcccc',
                    ),	
                        
        // Second Icon Color
                        array(
                    'type' => 'color',
                    'name' => 'second_icon_color',
                    'label' => __('second Icon Color - <span><a target="_blank" style="color: #ff3b3b;" href="http://codecans.com/items/royal-image-hover-effects-pro/">Pro Only</a></span>', 'vp_textdomain'),
                    'default' => '#cdcccc',
                    ),
                    
                            
        // Third Icon Color
                        array(
                    'type' => 'color',
                    'name' => 'third_icon_color',
                    'label' => __('Third Icon Color - <span><a target="_blank" style="color: #ff3b3b;" href="http://codecans.com/items/royal-image-hover-effects-pro/">Pro Only</a></span>', 'vp_textdomain'),
                    'default' => '#cdcccc',
                    ),
                                    
        // Fourth Icon Color
                        array(
                    'type' => 'color',
                    'name' => 'fourth_icon_color',
                    'label' => __('Fourth Icon Color - <span><a target="_blank" style="color: #ff3b3b;" href="http://codecans.com/items/royal-image-hover-effects-pro/">Pro Only</a></span>', 'vp_textdomain'),
                    'default' => '#cdcccc',
                    ),
                    
                        
            //First Icon Link
                            array(
                                'type' => 'textbox',
                                'name' => 'first_social_icon_link',
                                'label' => __('First Icon Link', 'vp_textdomain')
                                ),

                        
                // Second Icon Link
                        
                            array(
                                'type' => 'textbox',
                                'name' => 'second_social_icon_link',
                                'label' => __('Second Icon Link', 'vp_textdomain')
                                ),
                        
                // Third Icon Link
                        
                            array(
                                'type' => 'textbox',
                                'name' => 'third_social_icon_link',
                                'label' => __('Third Icon Link', 'vp_textdomain')
                                ),
                        
                // Fourth Icon Link
                        
                            array(
                                'type' => 'textbox',
                                'name' => 'fourth_social_icon_link',
                                'label' => __('Fourth Icon Link', 'vp_textdomain')
                                ),  
			
		),
	),
	

					
					
	//Group Field Section
	array(
		'type'      => 'group',
		'repeating' => false,
		'sortable'  => true,
		'name'      => 'style1_settings_option',
		'priority'  => 'high',
		'title'     => __('Style 1 Settings panel', 'vp_textdomain'),

					'dependency' => array(
				'field'    => 'style1',
				'function' => 'vp_dep_boolean',
			),

		'fields' => array(
				
	// Select Effects		
				array(
					'type' => 'select',
					'name' => 'select_hover_effects',
					'label' => __('Select Hover Effects', 'vp_textdomain'),
					'default' => array(
								'{{first}}',
								),
					'items' => array(
						array(
							'value' => 'effects1',
							'label' => 'Effect 1',
						),
						array(
							'value' => 'effects2',
							'label' => 'Effect 2',
						),	
						array(
							'value' => 'effects3',
							'label' => 'Effect 3 ',
						),	
						array(
							'value' => 'effects4',
							'label' => 'Effect 4',
						),	
						array(
							'value' => 'effects5',
							'label' => 'Effect 5 [<p class="roy_premium_info">Pro Only</p>]',
						),	
						array(
							'value' => 'effects6',
							'label' => 'Effect 6 [<p class="roy_premium_info">Pro Only</p>]',
						),	
						array(
							'value' => 'effects7',
							'label' => 'Effect 7 [<p class="roy_premium_info">Pro Only</p>]',
						),	
						array(
							'value' => 'effects8',
							'label' => 'Effect 8 [<p class="roy_premium_info">Pro Only</p>]',
						),	
						array(
							'value' => 'effects9',
							'label' => 'Effect 9 [<p class="roy_premium_info">Pro Only</p>]',
						),	
						array(
							'value' => 'effects10',
							'label' => 'Effect 10 [<p class="roy_premium_info">Pro Only</p>]',
						),		
						array(
							'value' => 'effects11',
							'label' => 'Effect 11 [<p class="roy_premium_info">Pro Only</p>]',
						),

					),
				),
		


	// Display Item Appear in One Row
				array(
					'type' => 'select',
					'name' => 'hover_item_show',
					'label' => __('How many item\'s show in Display?', 'vp_textdomain'),
					'default' => array(
								'{{last}}',
								),
					'items' => array(
						array(
							'value' => 'royal-col-lg-12 royal-col-md-12 royal-col-sm-12 royal-col-xs-12',
							'label' => '1',
						),
						array(
							'value' => 'royal-col-lg-6 royal-col-md-6 royal-col-sm-6 royal-col-xs-12',
							'label' => '2',
						),	
						array(
							'value' => 'royal-col-lg-4 royal-col-md-4 royal-col-sm-6 royal-col-xs-12',
							'label' => '3',
						),	
						array(
							'value' => 'royal-col-lg-3 royal-col-md-3 royal-col-sm-6 royal-col-xs-12',
							'label' => '4',
						),

					),
				),
					
			// Hover Animation Code		
			array(
					'type' => 'radiobutton',
					'name' => 'css3_hover_animation',
					'label' => __('Hover Animation ', 'vp_textdomain'),
					'default' => array(
								'{{first}}',
								),
					'items' => array(
						array(
							'value' => 'right',
							'label' => 'Left to right',
						),
						array(
							'value' => 'left',
							'label' => 'Right to left',
						),
						array(
							'value' => 'bottom',
							'label' => 'Top to bottom',
						),
						array(
							'value' => 'top',
							'label' => 'Bottom to top',
						),		
	
				),	),
				
				
				
				
						
			// Select hover Layout		
			array(
					'type' => 'radiobutton',
					'name' => 'css3_hover_layout',
					'label' => __('Hover item Layout ', 'vp_textdomain'),
					'default' => array(
								'{{first}}',
								),
					'items' => array(
						array(
							'value' => '',
							'label' => 'Square',
						),
						array(
							'value' => 'round',
							'label' => 'Cilcle',
						),		
	
				),	),	
				
							
					array(
						'type' => 'checkbox',
						'name' => 'seclect_circle_effects_border',
						'label' => __('circle border <p style="font-size: 11px; color: #005990; margin: 0;">(work circler effects only)</p>', 'vp_textdomain'),
						'items' => array(
							array(
								'value' => 'focus-dark',
							),
						),
					),
					
			array(
					'type' => 'radiobutton',
					'name' => 'seclect_circle_effects_border',
					'label' => __('Show Circle Border ', 'vp_textdomain'),
					'default' => array(
								'{{first}}',
								),
					'items' => array(
						array(
							'value' => 'focus-dark',
							'label' => 'Show',
						),	
						array(
							'value' => '',
							'label' => 'Hide',
						),		
	
				),	),


			// Custom CSS Code Editor

			array(
				'type'  => 'codeeditor',
				'name'  => 'style1_custom_css',
				'label' => __('Custom CSS ', 'vp_textdomain'),
				'description'=> __('Write your custom css here.','vp_textdomain'),
				'mode' => 'css',
			),



			array(
				'type' => 'notebox',
				'name' => 'nb_1',
				'label' => __('Pro Version Features Below:', 'vp_textdomain'),
				'description' => __('<p style="color: #000;">To get Below features working, please buy the pro version only $12</p> </br><a target="_blank" href="http://codecans.com/items/royal-image-hover-effects-pro/"> <span id="buy_now_class"><img style="width: 170px;" src="http://wpmetro.com/tutorials/images/buy_now.gif" /></span></a>', 'vp_textdomain'),
				'status' => 'normal',
			),

			// Padding for Each Item Style 1
				    array(
						'type' => 'slider',
						'name' => 'padding_item',
						'label' => __('Items Padding - <span><a target="_blank" style="color: #ff3b3b;" href="http://codecans.com/items/royal-image-hover-effects-pro/">Pro Only</a></span>', 'vp_textdomain'),
						'description' => __('You can set Padding for each item. Default is 5.', 'vp_textdomain'),
						'min' => '1',
						'max' => '30',
						'step' => '1',
						'default' => '5',
					),


			// Google Font
			array(
				'type' => 'select',
				'name' => 'style1_google_font',
				'label' => __('Custom Font - <span><a target="_blank" style="color: #ff3b3b;" href="http://codecans.com/items/royal-image-hover-effects-pro/">Pro Only</a></span>', 'vp_textdomain'),
				'description' => __('Select Font', 'vp_textdomain'),
				'default' => 'Roboto',
				'items' => array(
					'data' => array(
						array(
							'source' => 'function',
							'value' => 'vp_get_gwf_family',
						),
					),
				),
			),
					
				// Title Font Size
				    array(
						'type' => 'slider',
						'name' => 'title_font_size',
						'label' => __('Title Font Size - <span><a target="_blank" style="color: #ff3b3b;" href="http://codecans.com/items/royal-image-hover-effects-pro/">Pro Only</a></span>', 'vp_textdomain'),
						'description' => __('You can set your Title Font Size here.', 'vp_textdomain'),
						'min' => '5',
						'max' => '50',
						'step' => '1',
						'default' => '18',
					),
					
			// Description Font Size
				    array(
						'type' => 'slider',
						'name' => 'descript_font_size',
						'label' => __('Description Font Size- <span><a target="_blank" style="color: #ff3b3b;" href="http://codecans.com/items/royal-image-hover-effects-pro/">Pro Only</a></span>', 'vp_textdomain'),
						'description' => __('You can set your Description Font Size here.', 'vp_textdomain'),
						'min' => '2',
						'max' => '50',
						'step' => '1',
						'default' => '15',
					),
					
				
				// Color Picker For Background
					array(
						'type' => 'color',
						'name' => 'backg_color',
						'label' => __('Background Color - <span><a target="_blank" style="color: #ff3b3b;" href="http://codecans.com/items/royal-image-hover-effects-pro/">Pro Only</a></span>', 'vp_textdomain'),
						'description' => __('you can set the Background color here.', 'vp_textdomain'),
						'default' => 'rgba(255,0,0,0.5)',
						'format' => 'rgba',
					),
					
					// Title Color
					    array(
					'type' => 'color',
					'name' => 'title_color',
					'label' => __('Title Color - <span><a target="_blank" style="color: #ff3b3b;" href="http://codecans.com/items/royal-image-hover-effects-pro/">Pro Only</a></span>', 'vp_textdomain'),
					'description' => __('Set Title Color Here.', 'vp_textdomain'),
					'default' => '#FFFFFF;',
					'format' => 'HEX',
					),					
					
					// Description Color
					    array(
					'type' => 'color',
					'name' => 'descript_color',
					'label' => __('Description Color - <span><a target="_blank" style="color: #ff3b3b;" href="http://codecans.com/items/royal-image-hover-effects-pro/">Pro Only</a></span>', 'vp_textdomain'),
					'description' => __('Set Description Color Here.', 'vp_textdomain'),
					'default' => '#FFFFFF;',
					'format' => 'HEX',
					),	
                    								
													
	// =================  OPEN LINK In NEW TAB FOR STYLE 1================= //
					array(
						'type' => 'checkbox',
						'name' => 'new_tab',
						'label' => __('Open In New Tab? - <span><a target="_blank" style="color: #ff3b3b;" href="http://codecans.com/items/royal-image-hover-effects-pro/">Pro Only</a></span>', 'vp_textdomain'),
						'description'=> __('Check This Box if you want to open link in new TAB. Otherwise leave it ','vp_textdomain'),
						'items' => array(
							array(
								'value' => '_blank',
							),
						),
					),			

		),
	),



);