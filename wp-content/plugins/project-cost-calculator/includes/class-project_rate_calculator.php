<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://unlimitedwp.com/
 * @since      1.0.0
 *
 * @package    Project_rate_calculator
 * @subpackage Project_rate_calculator/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Project_rate_calculator
 * @subpackage Project_rate_calculator/includes
 * @author     Unlimited Wp <hello@unlimitedwp.com>
 */
class Project_rate_calculator {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      PRC_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PROJECT_RATE_CALCULATOR_VERSION' ) ) {
			$this->version = PROJECT_RATE_CALCULATOR_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'project_rate_calculator';
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		add_action( 'init', array( $this , 'wp_create_cpt_rate_calculator' ));
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - PRC_Loader. Orchestrates the hooks of the plugin.
	 * - PRC_i18n. Defines internationalization functionality.
	 * - PRC_Admin. Defines all hooks for the admin area.
	 * - PRC_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
				
		/*  DATABASE AND WORDPRESS POSTTYPE CONTROLLER  */
		if( file_exists( plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-project_rate_calculator-db.php' ) ){
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-project_rate_calculator-db.php';
		}

		/* MANAGE CATEGORY */
		if( file_exists( plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-project_rate_calculator-field-category.php' ) ){
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-project_rate_calculator-field-category.php';
		}
		
		if( file_exists( plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-project_rate_calculator_email.php' ) ){
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-project_rate_calculator_email.php';
		}

		/* FORM FIELD SETTINGS */
		if( file_exists( plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-project_rate_calculator-form-field.php' ) ){
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-project_rate_calculator-form-field.php';
		}

		if( file_exists( plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-project_rate_calculator-form-notification-field.php' ) ){
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-project_rate_calculator-form-notification-field.php';
		}

		/* FORM ENTRIES */
		/* class-project_rate_calculator-form-entries.php */
		if( file_exists( plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-project_rate_calculator-form-entries.php' ) ){
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-project_rate_calculator-form-entries.php';
		}

		//class-project_rate_calculator-form-layout.php
		if( file_exists( plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-project_rate_calculator-form-layout.php' ) ){
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-project_rate_calculator-form-layout.php';
		}

		//class-project_rate_calculator-form-quotation.php
		if( file_exists( plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-project_rate_calculator-form-quotation.php' ) ){
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-project_rate_calculator-form-quotation.php';
		}
		
		/*  CALCULATOR FIELDS MODULE MODEL OR BLUEPRINT */
		if( file_exists( plugin_dir_path( dirname( __FILE__ ) ) . 'includes/interface-project_rate_calculator-fields-module.php' ) ){
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/interface-project_rate_calculator-fields-module.php';
		}
		
		/*  CALCULATOR FIELDS MODULE MODEL OR BLUEPRINT */
		if( file_exists( plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-project_rate_calculator-fields-module.php' ) ){
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-project_rate_calculator-fields-module.php';
		}

		/*  CALCULATOR FIELDS MODULE GENERATOR */
		if( file_exists( plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-project_rate_calculator-fields-modules.php' ) ){
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-project_rate_calculator-fields-modules.php';
		}

		/* CALCULATOR SHORTCODE GENERATOR */
		if( file_exists( plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-project_rate_calculator-form.php' ) ){
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-project_rate_calculator-form.php';
		}

		/* This file set prebuilt fields modules */
		if( file_exists( plugin_dir_path( dirname( __FILE__ ) ) . 'includes/modules/project_rate_calculator_prebuilt_modules.php' ) ){
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/modules/project_rate_calculator_prebuilt_modules.php';
		}

		//class-abstract-project_rate_calculator-fields-modules
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-project_rate_calculator-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-project_rate_calculator-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-project_rate_calculator-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-project_rate_calculator-public.php';

		$this->loader = new PRC_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the PRC_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new PRC_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new PRC_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_ajax_pro_rate_cal_submit_calculator', $plugin_admin, 'ajax_submit_calculator' ); 
		$this->loader->add_action( 'wp_ajax_delete_rate_calculator_form', $plugin_admin, 'ajax_delete_calculator_form' ); 
		$this->loader->add_action( 'wp_ajax_get_pro_rate_cal_form_module_settings', $plugin_admin, 'ajax_form_module_settings' ); 
		$this->loader->add_action( 'wp_ajax_submit_form_state', $plugin_admin, 'ajax_submit_form_state' ); 
		$this->loader->add_action( 'wp_ajax_pro_rate_cal_get_form_categories', $plugin_admin, 'pro_rate_cal_get_form_categories' ); 
		$this->loader->add_filter( 'get_pro_rate_cal_form_setting_fields', $plugin_admin, 'set_category_field', 10, 2 ); 
		$this->loader->add_filter( 'mce_buttons', $plugin_admin, 'remove_fullscreen_options', 10, 2 ); 
		/* submit categories */
		$this->loader->add_action( 'wp_ajax_submit_pro_rate_cal_field_cat', $plugin_admin, 'ajax_submit_category' ); 
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'setup_admin_menu' );
	
		
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new PRC_Public( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_ajax_submit_pro_rate_cal_custom_form', $plugin_public, 'ajax_submit_pro_rate_cal_custom_form' );
		$this->loader->add_action( 'wp_ajax_nopriv_submit_pro_rate_cal_custom_form', $plugin_public, 'ajax_submit_pro_rate_cal_custom_form' );
		$this->loader->add_action( 'pro_rate_cal_zapier_trigger_webhook', $plugin_public , 'pro_rate_cal_zapier_trigger_function', 10, 2 );
		$this->loader->add_action( 'wp_ajax_nopriv_pro_rate_cal_submit_quatation', $plugin_public, 'ajax_pro_rate_cal_submit_quatation' );
		$this->loader->add_action( 'wp_ajax_pro_rate_cal_submit_quatation', $plugin_public, 'ajax_pro_rate_cal_submit_quatation' );	
		$this->loader->add_action( 'wp_ajax_nopriv_pro_rate_cal_submit_quatation_to_user', $plugin_public, 'ajax_pro_rate_cal_submit_quatation_to_user' );
		$this->loader->add_action( 'wp_ajax_pro_rate_cal_submit_quatation_to_user', $plugin_public, 'ajax_pro_rate_cal_submit_quatation_to_user' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    PRC_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	function wp_create_cpt_rate_calculator() {
			PRC_Post_Texonomy::wp_create_cpt_rate_calculator();
    }

}
?>