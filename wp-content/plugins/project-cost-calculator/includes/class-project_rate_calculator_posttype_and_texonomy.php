<?php
if( !class_exists( "PRC_Post_Texonomy" ) ){
    class PRC_Post_Texonomy{
        public static function wp_create_cpt_rate_calculator() {
            // Set UI labels for Custom Post Type
            $labels = array(
              'name'                => _x( 'Rate Calculator', 'Post Type General Name', "project-cost-calculator" ),
              'singular_name'       => _x( 'rate_calculator', 'Post Type Singular Name', "project-cost-calculator" ),
              'menu_name'           => __( 'Rate Calculator', "project-cost-calculator" ),
              'parent_item_colon'   => __( 'Parent Rate Calculator', "project-cost-calculator" ),
              'all_items'           => __( 'All Rate Calculator', "project-cost-calculator" ),
              'view_item'           => __( 'View Rate Calculator', "project-cost-calculator" ),
              'add_new_item'        => __( 'Add New Rate Calculator', "project-cost-calculator" ),
              'add_new'             => __( 'Add New Rate Calculator', "project-cost-calculator" ),
                'edit_item'           => __( 'Edit Rate Calculator', "project-cost-calculator" ),
              'update_item'         => __( 'Update Rate Calculator', "project-cost-calculator" ),
              'search_items'        => __( 'Search Rate Calculator', "project-cost-calculator" ),
              'not_found'           => __( 'Not Found', "project-cost-calculator" ),
              'not_found_in_trash'  => __( 'Not found in Trash', "project-cost-calculator" ),
            );
      
            // Set other options for Custom Post Type Rate Calculator
            $args = array(
              'label'               => __( 'Rate Calculator', "project-cost-calculator" ),
              'description'         => __( 'Rate Calculator can handle Categories', "project-cost-calculator" ),
              'labels'              => $labels,  // Features this CPT supports in Post Editor
              'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
              'taxonomies'          => array(), /* Rate Calculator have not Child Items.So we will set false */ 
              'hierarchical'        => false,
              'public'              => false,
              'show_ui'             => true,
              'show_in_menu'        => false,
              'show_in_nav_menus'   => true,
              'show_in_admin_bar'   => true,
              'menu_position'       => 5,
              'can_export'          => true,
              'has_archive'         => true,
              'exclude_from_search' => false,
              'publicly_queryable'  => true,
              'capability_type'     => 'post',
              'show_in_rest'        => true,
              'rewrite'             => array( 'slug' => 'rate_calculator' ),
      
            );
      
            // Registering Rate Calculator - CPT
            if( !post_type_exists( PRC_POST_TYPE ) ){
                register_post_type( PRC_POST_TYPE, $args );
            }
            
      
            // Registering Rate Calculator taxonomy - CPT
            $labels_cat = array(
                'name'              => _x( 'Categories', 'taxonomy general name', "project-cost-calculator" ),
                'singular_name'     => _x( 'Category', 'taxonomy singular name', "project-cost-calculator" ),
                'search_items'      => __( 'Search Categories', "project-cost-calculator" ),
                'all_items'         => __( 'All Categories', "project-cost-calculator" ),
                'view_item'         => __( 'View Category', "project-cost-calculator" ),
                'parent_item'       => __( 'Parent Category', "project-cost-calculator" ),
                'parent_item_colon' => __( 'Parent Category:', "project-cost-calculator" ),
                'edit_item'         => __( 'Edit Category', "project-cost-calculator" ),
                'update_item'       => __( 'Update Category', "project-cost-calculator" ),
                'add_new_item'      => __( 'Add New Category', "project-cost-calculator" ),
                'new_item_name'     => __( 'New Category Name', "project-cost-calculator" ),
                'not_found'         => __( 'No Categories Found', "project-cost-calculator" ),
                'back_to_items'     => __( 'Back to Categories', "project-cost-calculator" ),
                'menu_name'         => __( 'Categories', "project-cost-calculator" ),
            );
      
            $args_cat = array(
                'labels'            => $labels_cat,
                'hierarchical'      => true,
                'public'            => true,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array( 'slug' => 'rate_calculator_category' ),
                'show_in_rest'      => true,
                'show_in_menu'      => true,
            );
            if( !taxonomy_exists( PRC_CATEGORY ) ){
                register_taxonomy( PRC_CATEGORY, PRC_POST_TYPE, $args_cat );
            }
        }
        
        public static function create_pre_form(){
            /**
             * Create Pre Form
             */
            $forms = array(
                array(
                    "name" => "SEO Cost Calculator",
                    "slug" => "seo_cost_calculator",
                    "json_values" => '{"field_1641896122770":{"element_id":"field_1641896122770","module_id":"text","module_name":"Text","settings":{"label_name":"SEO Cost Calculator","content":"Input your information below to find out an estimated SEO cost based on your needs.","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641896148256"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"SEO Cost Calculator"},"order":"0"},"field_1641896148256":{"element_id":"field_1641896148256","module_id":"dropdown","module_name":"Dropdown","settings":{"label_name":"Physical Location?","option":{"labels":["1-10","11-50","51-100","100+"],"values":["10","50","100","150"],"default":"1-10"},"tooltip":"","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641896122770"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"SEO Cost Calculator"},"order":"1"},"field_1641896279590":{"element_id":"field_1641896279590","module_id":"dropdown","module_name":"Dropdown","settings":{"label_name":"Target Audience","option":{"labels":["Local","National","Global"],"values":["1000","3000","5000"],"default":"Local"},"tooltip":"","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641896122770"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"SEO Cost Calculator"},"order":"2"},"field_1641896467254":{"element_id":"field_1641896467254","module_id":"dropdown","module_name":"Dropdown","settings":{"label_name":"How many pages need optimization?","option":{"labels":["1-10","11-50","51-100","100+"],"values":["100","500","1000","2000"],"default":"1-10"},"tooltip":"","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641896122770"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"SEO Cost Calculator"},"order":"4"},"field_1641896842552":{"element_id":"field_1641896842552","module_id":"dropdown","module_name":"Dropdown","settings":{"label_name":"Level of competition in your industry","option":{"labels":["Low","Medium","High"],"values":["100","500","1000"],"default":"Low"},"tooltip":"","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641896122770"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"SEO Cost Calculator"},"order":"5"},"field_1641896959773":{"element_id":"field_1641896959773","module_id":"dropdown","module_name":"Dropdown","settings":{"label_name":"Age of Website:","option":{"labels":["1 Year","2-5 Years","5+ Years"],"values":["10","50","100"],"default":"1 Year"},"tooltip":"","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641896122770"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"SEO Cost Calculator"},"order":"6"},"field_1641897015988":{"element_id":"field_1641897015988","module_id":"radio","module_name":"Radio","settings":{"label_name":"How well do your target keywords rank?","option":{"labels":["Top 10","11-30","31+"],"values":["50","100","300"],"default":"Top 10"},"tooltip":"","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641896122770"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"SEO Cost Calculator"},"order":"7"},"field_1641898939533":{"element_id":"field_1641898939533","module_id":"radio","module_name":"Radio","settings":{"label_name":"How aggressive do you want to be?","option":{"labels":["Long Term","Quickly"],"values":["100","200"],"default":"Long Term"},"tooltip":"","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641896122770"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"SEO Cost Calculator"},"order":"3"}}',
                ),
                array(
                    "name" => "PPC ROI Calculator",
                    "slug" => "ppc_roi_calculator",
                    "json_values" => '{"field_1641968805809":{"element_id":"field_1641968805809","module_id":"text","module_name":"Text","settings":{"label_name":"Optimise your business campaign budget with our free tool","content":"<h3>Optimise your business campaign budget with our free tool<\/h3>","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"PPC ROI Calculator"},"order":"0"},"field_1641968846152":{"element_id":"field_1641968846152","module_id":"range","module_name":"Range","settings":{"label_name":"Projected Monthly Spend","rate":"50","min_range":"500","max_range":"5000","default_quantity":"1000","tooltip":"Normally we recommend you start with a minimum of $1,000 for ad spend to begin with","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641968805809"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"PPC ROI Calculator"},"order":"1"},"field_1641968952831":{"element_id":"field_1641968952831","module_id":"range","module_name":"Range","settings":{"label_name":"Expected CPC","rate":"10","min_range":"1","max_range":"50","default_quantity":"12","tooltip":"An average CPC (Cost Per Click) varies by each industry but can range on average from $2-$8.","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641968805809"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"PPC ROI Calculator"},"order":"2"},"field_1641968983507":{"element_id":"field_1641968983507","module_id":"range","module_name":"Range","settings":{"label_name":"Target Conversion Rate (%)","rate":"100","min_range":"1","max_range":"100","default_quantity":"12","tooltip":"A great, campaign will generate anywhere from 10-15% conversion rate.","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641968805809"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"PPC ROI Calculator"},"order":"3"},"field_1641969012347":{"element_id":"field_1641969012347","module_id":"range","module_name":"Range","settings":{"label_name":"Average Sales Price","rate":"50","min_range":"1","max_range":"5000","default_quantity":"1","tooltip":"The average amount a customer normally spends with you.","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641968805809"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"PPC ROI Calculator"},"order":"4"},"field_1641969066574":{"element_id":"field_1641969066574","module_id":"range","module_name":"Range","settings":{"label_name":"Lead to Customer Rate (%)","rate":"200","min_range":"1","max_range":"100","default_quantity":"15","tooltip":"When a new lead comes in, how many normally close? Most services close 20-30% while an e-commerce store close 1-3%.","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641968805809"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"PPC ROI Calculator"},"order":"5"}}',
                ),
                array(
                    "name" => "How Much Does A Logo Cost",
                    "slug" => "how_much_does_a_logo_cost",
                    "json_values" => '{"field_1641917726430":{"element_id":"field_1641917726430","module_id":"radio","module_name":"Radio","settings":{"label_name":"What type of logo are you looking for?","option":{"labels":["Symbol or Icon","Wordmark","Both"],"values":["500","750","100"],"default":""},"tooltip":"","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["0"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"How Much Does A Logo Cost"},"order":"0"},"field_1641917892526":{"element_id":"field_1641917892526","module_id":"checkbox","module_name":"Checkbox","settings":{"label_name":"What style are you looking for?","option":{"labels":["Flat\/Simplified","3D","Custom letterforms"],"values":["500","750","100"],"default":""},"tooltip":"","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641917726430"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"How Much Does A Logo Cost"},"order":"1"},"field_1641917958607":{"element_id":"field_1641917958607","module_id":"toggle","module_name":"Toggle","settings":{"label_name":"Do you have a color scheme for your company\/logo?","rate":"300","active_name":"Yes","deactive_name":"No","default_state":"activated","tooltip":"","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641917726430"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"How Much Does A Logo Cost"},"order":"2"},"field_1641917994670":{"element_id":"field_1641917994670","module_id":"toggle","module_name":"Toggle","settings":{"label_name":"Do you need brand guidelines created?","rate":"500","active_name":"Yes","deactive_name":"No","default_state":"activated","tooltip":"(example: https:\/\/www.dropbox.com\/branding)","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641917726430"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"How Much Does A Logo Cost"},"order":"3"},"field_1641918056385":{"element_id":"field_1641918056385","module_id":"radio","module_name":"Radio","settings":{"label_name":"Do you need an app icon?","option":{"labels":["Yes","No"],"values":["500","0"],"default":""},"tooltip":"","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641917726430"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"How Much Does A Logo Cost"},"order":"4"},"field_1641918090924":{"element_id":"field_1641918090924","module_id":"radio","module_name":"Radio","settings":{"label_name":"Would you like additional assets created with your logo?","option":{"labels":["Business card","Sticker","Both","No"],"values":["200","100","400","0"],"default":""},"tooltip":"","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641917726430"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"How Much Does A Logo Cost"},"order":"5"}}',
                ),
                array(
                    "name" => "The Advertising ROI Calculator",
                    "slug" => "the_advertising_roi_calculator",
                    "json_values" => '{"field_1641918356342":{"element_id":"field_1641918356342","module_id":"range","module_name":"Range","settings":{"label_name":"Expected CPC true","rate":"10","min_range":"1","max_range":"50","default_quantity":"1","tooltip":"How much are you willing to pay for a click? Depending on the ad network and audience, B2B marketers can expect cost-per-click to range from $1-$7 or more. You can use the Google KeyWord Planner for help estimating your CPC for search ads.","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641918412706"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"The Advertising ROI Calculator"},"order":"0"},"field_1641918412706":{"element_id":"field_1641918412706","module_id":"range","module_name":"Range","settings":{"label_name":"Projected Monthly Budget","rate":"50","min_range":"100","max_range":"50000","default_quantity":"100","tooltip":"How much do you spend a month on digital ads? If you do spend on ads now, just test out a number, 10% of your total marketing budget is a good place to start. Once you ve entered all other metrics, come back to budget to see how it affects profit.","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641918356342"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"The Advertising ROI Calculator"},"order":"1"},"field_1641918499233":{"element_id":"field_1641918499233","module_id":"range","module_name":"Range","settings":{"label_name":"Target Conversion Rate (%)","rate":"100","min_range":"1","max_range":"50","default_quantity":"1","tooltip":"How often does a visitor convert into a lead on your website? For the average for B2B marketers its around 2.6%. Check out these 10 Tips to improve your conversion rate (CVR).","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641918356342"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"The Advertising ROI Calculator"},"order":"2"},"field_1641918549580":{"element_id":"field_1641918549580","module_id":"range","module_name":"Range","settings":{"label_name":"Average Sale Price","rate":"200","min_range":"100","max_range":"100000","default_quantity":"100","tooltip":"On average, how valuable is a single customer? For many companies this number may vary or increase over time. Test different options, such as a new customer vs. the lifetime value of a customer.","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641918356342"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"The Advertising ROI Calculator"},"order":"3"},"field_1641918611173":{"element_id":"field_1641918611173","module_id":"range","module_name":"Range","settings":{"label_name":"Lead to Customer Rate (%)","rate":"10","min_range":"1","max_range":"90","default_quantity":"10","tooltip":"What percentage of your leads turn into Customers? This is crtical to monitor. Talk to sales and make sure the leads you deliver are top notch. Increasing lead to customer rate can drastically improve the ROI of your ads 10 Tips to align sales and marketing.","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641918356342"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"The Advertising ROI Calculator"},"order":"4"}}',
                ),
                array(
                    "name" => "How much does a website cost",
                    "slug" => "how_much_does_a_website_cost",
                    "json_values" => '{"field_1641916092688":{"element_id":"field_1641916092688","module_id":"dropdown","module_name":"Dropdown","settings":{"label_name":"Who\/what is the website for?","option":{"labels":["Nonprofit","Business","Personal","Event","Other"],"values":["500","2000","1000","1500","2500"],"default":""},"tooltip":"","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["0"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"How much does a website cost"},"order":"0"},"field_1641916232408":{"element_id":"field_1641916232408","module_id":"radio","module_name":"Radio","settings":{"label_name":"What type of platform would you like?","option":{"labels":["Wordpress","Custom Build","Square Space","Shopify"],"values":["1000","1500","750","2000"],"default":""},"tooltip":"","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641916092688"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"How much does a website cost"},"order":"1"},"field_1641916325875":{"element_id":"field_1641916325875","module_id":"radio","module_name":"Radio","settings":{"label_name":"How many pages will you need?","option":{"labels":["Website","Enterprise Website"],"values":["2000","5000"],"default":""},"tooltip":"Landing Page:- 1, Microsite:- 1-10, Website:- 10+, Enterprise Website:-50+","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641916092688"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"How much does a website cost"},"order":"2"},"field_1641916610805":{"element_id":"field_1641916610805","module_id":"dropdown","module_name":"Dropdown","settings":{"label_name":"A personal profile means that your website has login functionality for returning users on free or paid memberships.","option":{"labels":["Yes- Free membership","Yes- Paid membership","No"],"values":["100","300","0"],"default":""},"tooltip":"","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641916092688"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"How much does a website cost"},"order":"3"},"field_1641916753009":{"element_id":"field_1641916753009","module_id":"checkbox","module_name":"Checkbox","settings":{"label_name":"Will you need to accept donations or online payments?","option":{"labels":["Yes - Donation","Yes - Payments (Store and Product)","Yes - Donation and Payments","No"],"values":["250","500","750","0"],"default":""},"tooltip":"Accept credit cards, debit cards, paypal, etc.","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641916092688"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"How much does a website cost"},"order":"4"},"field_1641916963489":{"element_id":"field_1641916963489","module_id":"toggle","module_name":"Toggle","settings":{"label_name":"Do people rate or review things?","rate":"100","active_name":"Yes","deactive_name":"No","default_state":"activated","tooltip":"People leave reviews and\/or rate things.","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641916092688"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"How much does a website cost"},"order":"5"},"field_1641917016712":{"element_id":"field_1641917016712","module_id":"toggle","module_name":"Toggle","settings":{"label_name":"Does your website need sharing functions?","rate":"200","active_name":"Yes","deactive_name":"No","default_state":"activated","tooltip":"Sharing to Twitter, Facebook, Email, etc.","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641916092688"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"How much does a website cost"},"order":"6"},"field_1641917064314":{"element_id":"field_1641917064314","module_id":"radio","module_name":"Radio","settings":{"label_name":"Does your website need to connect with another app or website (ie. share data with a mobile application)?","option":{"labels":["Yes","No"],"values":["500","0"],"default":""},"tooltip":"This means you ll need to make an API (or Application Programming Interface). Its how all your friendly apps talk to each other.","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641916092688"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"How much does a website cost"},"order":"7"},"field_1641917111940":{"element_id":"field_1641917111940","module_id":"toggle","module_name":"Toggle","settings":{"label_name":"Does your website need search functionality?","rate":"50","active_name":"Yes","deactive_name":"No","default_state":"activated","tooltip":"","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641916092688"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"How much does a website cost"},"order":"8"},"field_1641917152103":{"element_id":"field_1641917152103","module_id":"toggle","module_name":"Toggle","settings":{"label_name":"Will your website need to look good on mobile devices?","rate":"500","active_name":"Yes","deactive_name":"No","default_state":"deactivated","tooltip":"","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641916092688"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"How much does a website cost"},"order":"9"},"field_1641917200309":{"element_id":"field_1641917200309","module_id":"checkbox","module_name":"Checkbox","settings":{"label_name":"What type of integrations will you need?","option":{"labels":["Mailchimp","Classy Fundraising","Google Analytics","Constant Contact","Crowdrise","A\/B Testing Software","Stripe","Heatmap Tracking","Paypal","None"],"values":["50","100","50","50","50","150","50","50","50","0"],"default":""},"tooltip":"Other apps you use, like Mailchimp, Classy Fundraising, Google Analytics, etc. Select all that apply.","logic":"","elements_state":"show","elements_state_if":"all","elements_condition":{"elements_select":["field_1641916092688"],"elements_select_condition":["is"],"elements_select_value":[""]},"category_field":"How much does a website cost"},"order":"10"}}',
                ),
                
            );
    
            foreach ($forms as $key => $value) {
                if( !post_exists( $value['name'], '', '', PRC_POST_TYPE, '' ) ){
                    $temp_term_id = 0;
                    $json_array = json_decode( $value['json_values'], true );
                    //element loop
                    foreach ($json_array as $k => $v) {
                        if( isset( $v['settings']['category_field'] ) && sanitize_text_field( $v['settings']['category_field'] ) ){
                            //check form term id exist ?
                            if( term_exists( $v['settings']['category_field'], "rate_calculator_category" ) == null ){
                                $term_array = array(
                                    "cat_name" => $v['settings']['category_field'],
                                    "taxonomy" => PRC_CATEGORY,
                                );
                                wp_insert_category( $term_array );
                                $term = get_term_by( "name", $v['settings']['category_field'], "rate_calculator_category" );
                                $json_array[$k]['settings']['category_field'] = $term->term_id;
                                if( empty( $temp_term_id ) && $temp_term_id == 0 ){
                                    $temp_term_id = $term->term_id;
                                }
                            }else{
                                $term = get_term_by( "name", $v['settings']['category_field'], "rate_calculator_category" );
                                $json_array[$k]['settings']['category_field'] = $term->term_id;
                                if( empty( $temp_term_id ) && $temp_term_id == 0 ){
                                    $temp_term_id = $term->term_id;
                                }
                            }
                                                        
                        }
                    }
                    $my_post = array(
                        'post_title'    => $value['name'],
                        'post_status'   => 'publish',
                        'post_type' => PRC_POST_TYPE,
                    );
                    $form_id = wp_insert_post( $my_post );
                                    
                    update_post_meta( $form_id, "calculator_form_properties", $json_array );
                     
                    update_post_meta( $form_id, "calculator_form_category", $temp_term_id );
                }
            }
    
        }
    }
}
?>