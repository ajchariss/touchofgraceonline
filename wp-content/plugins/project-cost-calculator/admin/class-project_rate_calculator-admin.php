<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://unlimitedwp.com/
 * @since      1.0.0
 *
 * @package    Project_rate_calculator
 * @subpackage Project_rate_calculator/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Project_rate_calculator
 * @subpackage Project_rate_calculator/admin
 * @author     Unlimited Wp <hello@unlimitedwp.com>
 */
class PRC_Admin extends PRC_db {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/* form module object */
	private $module;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		/* declare module object */
		$this->module = new PRC_fields_module();
	}

	public function project_rate_calculator_plugin_settings(){
		global $response;
		//Api Setting actions
		register_setting( 'project_rate_calculator_settings_groups', 'project_rate_calculator_layout_type' );
		register_setting( 'project_rate_calculator_settings_groups', 'project_rate_calculator_layout_css' );
		//pages
		register_setting( 'project_rate_calculator_pages_groups', 'project_rate_searchform' );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Project_rate_calculator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Project_rate_calculator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if( isset( $_REQUEST["page"] )  && ( sanitize_text_field( $_REQUEST["page"] ) == "rate_calculator_main" )){
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/project_rate_calculator-admin.css', array(), $this->version, 'all' );
			wp_enqueue_style( "jquery_datatable", plugin_dir_url( __FILE__ ) . 'css/jquery.dataTables.min.css', array(), "1.11.3", 'all' );
			wp_enqueue_style( "jquery_datatable_responsive", plugin_dir_url( __FILE__ ) . 'css/dataTables.responsive.css', array(), "1.11.4", 'all' );
		} elseif ( isset( $_REQUEST["page"] ) && ( sanitize_text_field( $_REQUEST["page"] ) == "rate_calculator_categories" ) ) { 
			wp_enqueue_style( "jquery_datatable", plugin_dir_url( __FILE__ ) . 'css/jquery.dataTables.min.css', array(), "1.11.3", 'all' );
			wp_enqueue_style( "jquery_datatable_responsive", plugin_dir_url( __FILE__ ) . 'css/dataTables.responsive.css', array(), "1.11.4", 'all' );
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/project_rate_calculator-admin.css', array(), $this->version, 'all' );
		} elseif ( isset( $_REQUEST["page"] )  && ( sanitize_text_field( $_REQUEST["page"] ) == "rate_calculator_settings" )){
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/project_rate_calculator-admin.css', array(), $this->version, 'all' );
			wp_enqueue_style( "jquery_datatable", plugin_dir_url( __FILE__ ) . 'css/jquery.dataTables.min.css', array(), "1.11.3", 'all' );
			wp_enqueue_style( "jquery_datatable_responsive", plugin_dir_url( __FILE__ ) . 'css/dataTables.responsive.css', array(), "1.11.4", 'all' );
		}
		elseif ( isset( $_REQUEST["page"] ) && ( sanitize_text_field( $_REQUEST["page"] ) == "rate_calculator_how_to_use" ) ) { 
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/project_rate_calculator-admin.css', array(), $this->version, 'all' );
		}
		wp_enqueue_style( "proratecalcat", plugin_dir_url( __FILE__ ) . 'css/proratecalcat.css', array(), date('mdYhis'), 'all' );
		if( isset( $_REQUEST["submenu"] ) && ( sanitize_text_field( $_REQUEST["submenu"] ) == "currency_settings" ) ){
			wp_enqueue_style( "semantic-ui-css", plugin_dir_url( __FILE__ ) . 'css/semantic.min.css', array(), $this->version, 'all' );
		}
		wp_enqueue_style( 'wp-color-picker' ); 
	}

	/**
	 * Register the JavaScript for the admin area.
	 *	
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Project_rate_calculator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Project_rate_calculator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		
		if( (isset( $_REQUEST["page"] )  && ( sanitize_text_field( $_REQUEST["page"] ) == "rate_calculator_main" )) ){
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script('wp-color-picker');
			wp_enqueue_editor();
			wp_enqueue_media();
			wp_enqueue_script( 'jquery-datatable', plugin_dir_url( __FILE__ ) . 'js/jquery.dataTables.min.js', array( 'jquery' ), $this->version, false );
		    wp_enqueue_script( 'jquery-datatable-responsive', plugin_dir_url( __FILE__ ) . 'js/dataTables.responsive.min.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/project_rate_calculator-admin.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( "temp-script", plugin_dir_url( __FILE__ ) . 'js/proratecaletool.js', array( 'jquery' ),false, true );
			wp_enqueue_script( "proRateCal-script", plugin_dir_url( __FILE__ ) . 'js/proratecal.js', array( 'jquery' ),false, false );
			wp_localize_script( $this->plugin_name, $this->plugin_name,
				array( 
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					"calFormData" => array(
						"data" => isset( $_REQUEST["id"] ) ? $this->get_calculator_properties($_REQUEST["id"]) : null ,
						"modules" => PRC_fields_module::get_modules_settings(), //$this->getModuleSettings(),
						"category" => $this->get_categories_for_current_form(),
						"images" => array(
							"dragdropicon" => plugin_dir_url( __FILE__ )."images/drag-drop-icon.svg",
						)
					),
					"message" => PRC_db::message_string('js_message'),
					"tool_tip_for_field" => PRC_db::message_string('tip_for_add_field'),
					'pro_rate_cal_default_currency' =>"$",
				)
			);

		} elseif ( isset( $_REQUEST["page"] ) && ( sanitize_text_field( $_REQUEST["page"] ) == "rate_calculator_categories" ) ) {
			wp_enqueue_script( 'jquery-datatable', plugin_dir_url( __FILE__ ) . 'js/jquery.dataTables.min.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( 'jquery-datatable-responsive', plugin_dir_url( __FILE__ ) . 'js/dataTables.responsive.min.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( "proRateCalCategories-script", plugin_dir_url( __FILE__ ) . 'js/proratecalcategories.js', array( 'jquery' ),false, false );
			wp_localize_script( "proRateCalCategories-script", "proRateCalCategoriesObj",
				array( 
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
				)
			);
		}
	}

	/* get plugin main page url */
	protected static function get_admin_main_page_url( $arguments = array() ){
		if( !defined( "PRC_MAIN_PAGE_URL" ) ){
			define( "PRC_MAIN_PAGE_URL" , admin_url("admin.php?page=rate_calculator_main") );
		}
		$url = add_query_arg(
			$arguments,
			PRC_MAIN_PAGE_URL
		);
		return $url;
	}

	/* get category page url */
	protected static function get_category_page_url( $arguments = array() ){
		if( !defined( "PRC_ADMIN_CAT_PAGE_URL" ) ){
			define( "PRC_ADMIN_CAT_PAGE_URL" , admin_url( "admin.php?page=".PRC_CATEGORY ) );
		}
		$url = add_query_arg(
			$arguments,
			PRC_ADMIN_CAT_PAGE_URL
		);
		return $url;
	}

	/* setup menu and submenu */
	public function setup_admin_menu(){
		add_menu_page(
            __('Cost Calculator', "project-cost-calculator"),
            __( 'Cost Calculator', "project-cost-calculator" ),
            'manage_options',
            'rate_calculator_main',
            array( $this, 'get_rate_calculator_main_page' ),
            PRC_PLUGIN_DESHICON
        );

		add_submenu_page(
			"rate_calculator_main",
			__("Calculators", "project-cost-calculator"),
			__("Calculators", "project-cost-calculator"),
			'manage_options',
			'rate_calculator_main',
			array( $this, 'get_rate_calculator_main_page' )
		);

		add_submenu_page(
			"rate_calculator_main",
			__("Categories", "project-cost-calculator"),
			__("Categories", "project-cost-calculator"),
			'manage_options',
			"rate_calculator_categories",
			array( $this, 'get_rate_calculator_categories' )
		);

		add_submenu_page(
			"rate_calculator_main",
			__("How to Use", "project-cost-calculator"),
			__("How to Use", "project-cost-calculator"),
			'manage_options',
			"rate_calculator_how_to_use",
			array( $this, 'get_rate_calculator_how_to_use' )
		);
	}

	/**
     *  Settings page
     */
    public function get_rate_calculator_settings(){
        ob_start();
        echo '<div class="pro_rate_cal_main_section" style="min-height: 100vh;">';
        require_once plugin_dir_path( __FILE__ ) . '/partials/header/header.php';
        require_once plugin_dir_path( __FILE__ ) . 'partials/containers/settings.php';
        echo '</div>';
        echo ob_get_clean();
    }

	/* Get Main Page with footer */
	public function get_rate_calculator_main_page(){
		require_once plugin_dir_path( __FILE__ ) . 'partials/project_rate_calculator-admin-display.php';
		require_once plugin_dir_path( __FILE__ ) . 'partials/footer/footer.php';
	}

	/* get categories page */
	public function get_rate_calculator_categories(){
		ob_start();
		echo '<div class="pro_rate_cal_main_section">';
		require_once plugin_dir_path( __FILE__ ) . '/partials/header/header.php';
		require_once plugin_dir_path( __FILE__ ) . 'partials/containers/form_category.php';
		require_once plugin_dir_path( __FILE__ ) . 'partials/footer/footer.php';
		echo '</div>';
		echo ob_get_clean();
	}
	/* get How to Use page */
	public function get_rate_calculator_how_to_use(){
		ob_start();
		echo '<div class="pro_rate_cal_main_section">';
		require_once plugin_dir_path( __FILE__ ) . '/partials/header/header.php';
		require_once plugin_dir_path( __FILE__ ) . 'partials/containers/project_rate_calculator_how_to_use.php';
		require_once plugin_dir_path( __FILE__ ) . 'partials/footer/footer.php';
		echo '</div>';
		echo ob_get_clean();
	}

	/* function to submit form using ajax */
	public function ajax_submit_calculator(){
		$return = array();
		if ( isset( $_POST['_wpnonce'] ) || wp_verify_nonce( $_POST['_wpnonce'] ) ) {
			if ( isset( $_POST['form_id'] ) && !empty( sanitize_text_field( $_POST['form_id'] ) )){
				/* checking json array */
				if( isset( $_POST['json_values'] ) && is_array( $_POST['json_values'] ) ){
					$properties = $_POST['json_values'];
				}
				/* check for form exist, if exist then form will update */
				if( $this->form_exist( sanitize_text_field( $_POST['form_id'] ) ) ){
					if( is_array( $properties ) || !empty( sanitize_text_field($_POST['form_name']) ) ){
						 if( $this->save_calculator_properties( sanitize_text_field( $_POST['form_id'] ), $properties ) ){
							$return["message"] = PRC_db::message_string('form_updated');
							$return["ID"] = sanitize_text_field( $_POST['form_id'] );
							status_header(200 , "Form Updated");
						 } else {
							/* if false then calculator properties has no changes  */
							$return["message"] =  PRC_db::message_string('elements_changes');
							$return["ID"] = sanitize_text_field( $_POST['form_id'] );
							status_header(200 , "Form Updated");
						 }
						 /* Form Name update if form name changes appear */
						if( isset( $_POST['form_name'] ) && !empty( sanitize_text_field($_POST['form_name']) ) ){
							$post_title = $this->get_form( sanitize_text_field( $_POST['form_id'] ) ) -> post_title;
							if( $post_title != sanitize_text_field( $_POST['form_name'] ) ){
								/* Before updating form name check for is form name exist or not */
								if( $this->is_form_name_exist( sanitize_text_field( $_POST['form_name'] ) ) ){
									$return["message"] = PRC_db::message_string('form_name_already');
								}else{
									/* Update form name */
									$post_data = array(
										"ID" => sanitize_text_field( $_POST['form_id'] ) ,
										"post_title" => sanitize_text_field( $_POST['form_name'] ),
									);
									if( $this->update_form($post_data) == sanitize_text_field( $_POST['form_id'] ) ){
										/* update related category aswell */
										$return['cat'] = $this->update_form_category( sanitize_text_field( $_POST['form_id'] ), $post_data['post_title'] );
										$return["message"] = $return["message"].PRC_db::message_string('form_update');
									}
								}

							}
						}
					} else {
						$return["message"] = PRC_db::message_string('form_is_not_exist');
						$return["ID"] = sanitize_text_field( $_POST['form_id'] );
						status_header(400 , "Invalid Form Data");
					}

				} else {
					$return["message"] = PRC_db::message_string('form_is_not_exist');
					$return["ID"] = sanitize_text_field( $_POST['form_id'] );
					status_header(400 , "Invalid Form Id");
				}
			} else {
				/* check for form name exist or not */
				if( $this->is_form_name_exist( sanitize_text_field( $_POST['form_name'] ) ) ){
					$return['message'] = PRC_db::message_string('form_name_already');
					status_header(400 , "Form not saved");
				}else{
					/* create new form */
					$form_id = $this->save_new_form( sanitize_text_field( $_POST['form_name'] ) );
					/* check for created form exist or not */
					if( $this->form_exist( $form_id ) ){
						/* save category with form name as well */
						$this->save_form_category( $form_id, sanitize_text_field( $_POST['form_name'] ));
						if( isset( $_POST['json_values'] ) && is_array( $_POST['json_values'] ) ){
							$properties = $_POST['json_values'];
						}
						$return['shortcode'] = self::get_form_shortcode( $form_id );
						$return['form_id'] =  $form_id;
						if( isset( $properties ) && is_array( $properties ) ){
							$this->save_calculator_properties( $form_id , $properties );
							status_header(200 , "Form saved successfully");
							$return['message'] = PRC_db::message_string('form_saved');
						}else{
							$this->set_form_state($form_id,false);
							status_header(200 , "Form saved without builder data, form is deactivated");
							$return['message'] = PRC_db::message_string('form_saved_add_fields');
						}
					}else{
						$return['message'] = PRC_db::message_string('form_not_saved_already_exist');
						status_header(400 , "Form not saved");
					}
				}
			}
		} else {
			$return["message"] = PRC_db::message_string('form_request_varified');
			$return["ID"] = sanitize_text_field( $_POST['form_id'] );
			status_header(400 , "invalid _wpnonce");
		}
		header( 'Content-type: application/json' );
		wp_send_json( $return );
	}

	/** get all form list */
	public function get_form_lists(){
		$forms = $this -> get_all_forms();
		ob_start();
			if( is_array( $forms ) && !empty( $forms ) ){
				foreach ( $forms as $key => $value ) {
					include plugin_dir_path( __FILE__ ) . 'partials/containers/form_item.php';
				}
			} 
		echo ob_get_clean();
	}

	/* delete calculator using AJAX Request */
	public function ajax_delete_calculator_form(){
		if( isset($_POST['id']) ){
			if( !empty( sanitize_text_field( $_POST['id'] ) ) ){
				/** Remove related category */
				$this->remove_form_category( sanitize_text_field( $_POST['id'] ) );
				/** Remove form */
				$post = $this->remove_form( sanitize_text_field( $_POST['id'] ) );
				if( $post ){
					$return = array(
						'message'  => __('Form removed successfully.',"project-cost-calculator"),
						'status'   => 'true',
						'ID' => $post->ID
					);
				}else{
					$return = array(
						'message'  => __('Form not removed',"project-cost-calculator"),
						'status'   => 'false'
					);
				}
			}else{
				$return = array(
					'message'  => __('Form not removed',"project-cost-calculator"),
					'status'   => 'false'
				);
			}
		}else{
			$return = array(
				'message'  => __('Form not removed',"project-cost-calculator"),
				'status'   => 'false'
			);
		}
		header( 'Content-type: application/json' );
		wp_send_json( $return );
	}

	/* generate shortcode */
	public static function get_form_shortcode($form){
		return PRC_db::get_shortcode($form);
	}

	/* Rendering modules on edit page */
	private function render_module_elements(){
		foreach (PRC_fields_module::get_modules() as $key => $value) {
			ob_start();
			include plugin_dir_path( __FILE__ ) . 'partials/containers/modules_item.php';
			echo ob_get_clean();
		}
	}

	/* get module settings */
	public function ajax_form_module_settings(){
		if( isset($_POST['module']) && isset( $_POST['id'] ) ){
			if( !empty( sanitize_text_field( $_POST['module'] ) ) ){
				$module = $this->module->get_module( sanitize_text_field( $_POST['module'] ) );
				$settings = $module->getSettingFields();
				if( !empty( $settings ) ){
					$settings = $this -> set_category_field( $settings, sanitize_text_field( $_POST['module'] ) );
					status_header(200 , "Module Found");
					header( 'Content-type: application/json' );
					wp_send_json(
						array(
							"status" => "success",
							"settings" => $settings,
							"module_name" => $module->getName(),
							"module_id" => $module->getId(),
						)
					);
				}else{
					status_header(204 , "Module Not Found");
					header( 'Content-type: application/json' );
					wp_send_json(
						array(
							"status" => "failed",
							"message" => __("Module Not Found !","project-cost-calculator"),
						)
					);

				}
			}else{
				status_header(400 , "Invalid Module Id");
				header( 'Content-type: application/json' );
				wp_send_json(
					array(
						"status" => "failed",
						"message" => __("Module id is not valid !","project-cost-calculator"),
					)
				);
			}
		}else{
			status_header(400 , "Invalid Module Id");
			header( 'Content-type: application/json' );
			wp_send_json(
				array(
					"status" => "failed",
					"message" => __("Module id is not valid","project-cost-calculator"),
				)
			);
		}
	}

	/** Submit Categories using AJAX  */
	function ajax_submit_category(){
		$return = array();
		if( isset( $_POST["formData"] ) && ( !empty( $_POST["formData"] ) ) &&  is_array( $_POST["formData"] ) ){
			if( !empty( sanitize_text_field( $_POST["formData"]['id']) ) ){
				if( $this->get_category( 'ID', sanitize_text_field( $_POST["formData"]['id']) ) ){
					$id = $this->insert_or_update_category( $_POST["formData"] );
					if( $catData = $this->get_category( 'ID', $id ) ){
						$return["htmlItem"] = $this->render_category_item( $catData['term_id'] );
						$return["state"] = "update";
						$return["id"] = $catData['term_id'];
						$return["message"] = PRC_db::message_string('category_updated');
						status_header(200 , "category updated");
					} else {
						$return["error"] =  PRC_db::message_string('category_allready'); 
						status_header(200 , "category allready exist");
					}
				}else{
					$return["error"] =  PRC_db::message_string('category_invalid'); 
					status_header(200 , "category is invalid");
				}
			} elseif ( $this->is_category_exist( sanitize_text_field( $_POST["formData"]['category-slug']) ) == null ){
				$id = $this->insert_or_update_category( $_POST["formData"] );
				if( $catData = $this->get_category( 'ID', $id ) ){
					$return["category"] = $catData;
					$return["state"] = "insert";
					$return["htmlItem"] = $this->render_category_item( $id );
					$return["message"] =  PRC_db::message_string('category_added'); 
					status_header(200 , "category allready exist");
				} else {
					$return["error"] = PRC_db::message_string('category_allready');
					status_header(200 , "category allready exist");
				}
			}else{
				$return["error"] = PRC_db::message_string('category_allready');
				status_header(200 , "category allready exist");
			}
		}else{
			$return["error"] = PRC_db::message_string('category_response');
			status_header(400 , "invalid or empty response data");
		}
		header( 'Content-type: application/json' );
		wp_send_json( $return );
	}

	/** Render Single Category */
	private function render_category_item( $id ){
		$category = $this->get_category( "ID", $id);
		ob_start();
		include plugin_dir_path( __FILE__ ) . 'partials/containers/cat-item.php';
		return ob_get_clean();
	}

	/** Render All Categories */
	public function render_category_list(){
		$categories = $this->get_all_categories_parent();
		ob_start();
			foreach( $categories as $category ) {
				if( $category->parent == 0 ) {
					echo $this->render_category_item( $category->term_id );
					foreach( $categories as $subcategory ) {
						if($subcategory->parent == $category->term_id) {
							echo $this->render_category_item( $subcategory->term_id );
						}
					}
				}
			}
		echo ob_get_clean();
	}

	/* Get Categories for current requested form */
	public function get_categories_for_current_form(){
		$catList = array();
		if( isset( $_REQUEST['id'] ) && $this->get_form( sanitize_text_field( $_REQUEST['id'] ) ) ){
			$form = $this->get_form( sanitize_text_field($_REQUEST['id']));
			$form_cat = $this->get_form_category( $form->ID );
			if( !empty( $form_cat['term_id'] ) ){
				$catList[ $form_cat['term_id'] ] = $form_cat['name'];
				$categories = self::get_category_list( $form_cat['term_id'] );
				foreach ( $categories as $key => $value ) {
					$catList[ $value->term_id ] = $value->name;
				}
			}
		}
		return $catList;
	}

	/* Get Only Category and id */
	public function get_categories_id_and_name(){
		$categories = self::get_category_list(  );
		$catList = array();
		foreach ( $categories as $key => $value ) {
			$catList[ $value->term_id ] = $value->name;
		}
		$catList[ 0 ] = "Uncategorized";
		return $catList;
	}

	/* Set Category in module fields */
	function set_category_field( $fieldSettings, $key = null ){
			$fieldSettings['category_field'] = array(
				"name" => "Category",
				"element" => "select",
				"attributes" => array(
					"name" => "category_field",
					"placeholder" => "Select Category",
					"class" => "simple_input_setting_field",
					"id" => "simple_input_setting_field",
					"list" => $this->get_categories_for_current_form(),
				)
			);
		return $fieldSettings;
	}

	/* Set Current Forms category in Module fields */
	function set_form_category_field( $fieldSettings, $key = null , $id){
		$fieldSettings['category_field'] = array(
			"name" => "Category",
			"element" => "select",
			"attributes" => array(
				"name" => "category_field",
				"placeholder" => "Select Category",
				"class" => "simple_input_setting_field",
				"id" => "simple_input_setting_field",
				"list" => $this->get_categories_for_current_form(),
			)
		);
		return $fieldSettings;
	}

	/* Set Category Level */
	function get_category_level( $id ){
		$slash = "";
		if( $id > 0 ){
			$slash = "-";
			$term = $this->get_category("ID", $id );
			$slash .= $this->get_category_level( $term['parent'] );
		}
		return $slash;
	}

	/** Submit Form State using AJAX */
	function ajax_submit_form_state(){
		$return = array();
		if( isset( $_POST['formState'] ) && isset( $_POST['form_id'] ) && !empty( sanitize_text_field( $_POST['formState'] ) ) && !empty( sanitize_text_field( $_POST['form_id'] ) ) ){
			if( sanitize_text_field( $_POST['formState'] ) == "active" ){
				$this->set_form_state( sanitize_text_field($_POST['form_id']), true );
			}else if( sanitize_text_field( $_POST['formState'] ) == "deactive" ){
				$this->set_form_state( sanitize_text_field( $_POST['form_id'] ), false );
			}
			$state = $this->get_form_state( sanitize_text_field($_POST['form_id']) );
			$return['message'] = PRC_db::message_string('form_state').$state;
			status_header(200 , "success");
		}
		wp_send_json( $return );
	}

	/** Get Current form categories for ajax and post request */
	public function pro_rate_cal_get_form_categories(){
			$catList = array();
			if( isset( $_POST['id'] ) && $this->get_form( sanitize_text_field($_POST['id']) ) ){
				$form = $this->get_form( sanitize_text_field($_REQUEST['id']));
				$form_cat = $this->get_form_category( $form->ID );
				if( !empty( $form_cat['term_id'] ) ){
					$catList[ $form_cat['term_id'] ] = $form_cat['name'];
					$categories = self::get_category_list( $form_cat['term_id'] );
					foreach ( $categories as $key => $value ) {
						$catList[ $value->term_id ] = $value->name;
					}
				}
			}
			$catList[ 0 ] = "Uncategorized";
			header( 'Content-type: application/json' );
			wp_send_json( $catList );
	}

	/** Disabled Fullscreen button in custom field */
	public function remove_fullscreen_options( $btns, $editor ){
		if( $editor == "intro_paragraph" || $editor == "valeditonary_text" || $editor == "quatation_message" || $editor == "quatation_email_template" ){
			foreach ($btns as $key => $value) {
				if( $value == "fullscreen" ){
					unset($btns[$key]);
				}
			}
		}
		return $btns;
	}
}
?>