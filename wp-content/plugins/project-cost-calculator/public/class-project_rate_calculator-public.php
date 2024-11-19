<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://unlimitedwp.com/
 * @since      1.0.0
 *
 * @package    Project_rate_calculator
 * @subpackage Project_rate_calculator/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Project_rate_calculator
 * @subpackage Project_rate_calculator/public
 * @author     Unlimited Wp <hello@unlimitedwp.com>
 */
class PRC_Public{

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

	private $db;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		/* get database access for forms */
		$this->db = new PRC_db();
		/* shortcode */
		add_shortcode( 'rate-calculator-form', array($this, 'load_shortcode') );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/project_rate_calculator-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'project_rate_calculator-public-custom', plugin_dir_url( __FILE__ ) . 'css/project_rate_calculator-public_custom.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( "pro_rate_cal_front", plugin_dir_url( __FILE__ ) . 'js/pro_rate_cal_front.js', array( 'jquery' ), false, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/project_rate_calculator-public.js', array( 'jquery' ), false, false );
		wp_localize_script( $this->plugin_name, $this->plugin_name,
			array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'pro_rate_cal_current_country_currency'=> "USD",
				'pro_rate_cal_rate'=> "1",
			)
		);
	}

	public function load_shortcode( $atts ){
		$atts = shortcode_atts( array(
			'id' => null,
			'name' => null,
			'title' => null,
		), $atts, 'rate-calculator-form' );
		if( !empty( $atts['id'] ) ){
			$shortcode = new PRC_form( sanitize_text_field( $atts['id'] ) , sanitize_text_field( $atts['name']) );
			ob_start();
			if( trim($atts['title']) == "true" ){
				$shortcode->isFormNameShow(true);
			}else{
				$shortcode->isFormNameShow(false);
			}

			$shortcode->render_form();
			return ob_get_clean();
		}
	}

	public function ajax_submit_pro_rate_cal_custom_form(){
		$return = array();
		if( isset( $_POST['form_id'] ) && !empty( sanitize_text_field( $_POST['form_id'] ) ) ){
			$form_entry = new PRC_form_entries( sanitize_text_field( $_POST['form_id'] ) );
			if( isset( $_POST['data'] ) && is_array( $_POST['data'] ) ){
				if( $form_entry->insertData( $_POST['data'] ) ){
					$return["message"] = __("Form Submitted successfully.");
					$form_field = new PRC_FormField( sanitize_text_field( $_POST['form_id'] ) );
					$formProperties = $form_field->getProperties();
					if( $formProperties['iswebhook'] == 1 ){
						$Formtitle = get_the_title( sanitize_text_field( $_POST['form_id'] ) );
						$_POST['data']['Form title'] = $Formtitle;
						$hook_url = $formProperties['webhookurl'];
						do_action( 'pro_rate_cal_zapier_trigger_webhook', $_POST['data'] , $hook_url);
					}
					do_action( "pro_rate_cal_sticky_form_submit", $_POST  );
					status_header(200 , "success");
				}else{
					$return["message"] = __("Somethong gone wrong.");
					status_header(400 , "something gone wrong");
				}
			}else{
				$return["message"] = __("Somethong gone wrong.");
				status_header(400 , "something gone wrong");
			}
		}
		header( 'Content-type: application/json' );
		wp_send_json( $return );
	}

	public function ajax_pro_rate_cal_submit_quatation_to_user(){
		$return = array();
		if( isset( $_POST['email'] ) && !empty( sanitize_email( $_POST['email'] ) ) ){
			if( isset( $_POST['formid'] ) &&  !empty( sanitize_text_field( $_POST['formid'] ) ) ){
				$form = $this->db->get_form( sanitize_text_field( $_POST['formid'] ) );
				if( $form ){
					$email = sanitize_email( $_POST['email'] );
					$user_emails = explode(",",$email);
					$quotation_settings = new PRC_FormQuotation( $form->ID );
					$template = $quotation_settings->get_properties( "quatation_email_template" );
					$subject = !empty( $quotation_settings->get_properties( "quatation_email_subject" ) ) ?  $quotation_settings->get_properties( "quatation_email_subject" )  : "Your Quotation";
					$admin_email = !empty( $quotation_settings->get_properties( "quatation_email" ) ) ?  $quotation_settings->get_properties( "quatation_email" )  : get_bloginfo('admin_email');
					$admin_email_array = explode(",",$admin_email);
					$emails = array_merge ($admin_email_array, $user_emails );
					// //Dynamic data
					$dynamicData = array();
					ob_start();
					$file = PRC_TEMPLATE_DIR."/email/email-quatation.php";
					if( file_exists( $file )){
						include $file;
					}
					$quotation = ob_get_clean();
					$dynamicData["quotation"] = $quotation ;
					//Email for user to send quoatation
					$user_email_template =  $template;
					if( new PRC_Email( $user_emails ,$subject, $dynamicData, $user_email_template ) ){
						$return['message'] = PRC_db::message_string( "quotation_has_been_send" );
						$return['status'] = true;
					}else{
						$return['message'] = PRC_db::message_string( "issue_with_email_sending" );
					}
					//admin email
					$template = "<p>Quotation Recieved from ".$email."</p>". $template ;
					$admin_email_template = $template;
					if( new PRC_Email( $admin_email_array ,$subject, $dynamicData, $admin_email_template ) ){
						
					}

				}else{
					$return['message'] = PRC_db::message_string( "form_id_is_not_valid" );
				}

			}else{
				$return['message'] = PRC_db::message_string( "form_is_is_not_set" );
			}

		}else{
			$return['message'] = PRC_db::message_string( "email_not_sent_something_gone_wrong" );
		}
		header( 'Content-type: application/json' );
		wp_send_json( $return );
	}

	public function ajax_pro_rate_cal_submit_quatation(){
		$return = array();
		$notification = new PRC_NotificationField( sanitize_text_field( $_POST['formid'] ) );
		if( isset( $_POST['formid'] ) &&  !empty( sanitize_text_field( $_POST['formid'] ) ) ){
			$form = $this->db->get_form( sanitize_text_field( $_POST['formid'] ) );
			if( $form ){
				$quotation_settings = new PRC_FormQuotation( $form->ID );
				$template = $quotation_settings->get_properties( "quatation_email_template" );
				$email = !empty( $quotation_settings->get_properties( "quatation_email" ) ) ?  $quotation_settings->get_properties( "quatation_email" )  : get_bloginfo('admin_email');
				$emails = explode(",",$email);
				$subject = !empty( $quotation_settings->get_properties( "quatation_email_subject" ) ) ?  $quotation_settings->get_properties( "quatation_email_subject" )  : "Your Quotation";
				//Dynamic data
				$dynamicData = array();
				ob_start();
				$file = PRC_TEMPLATE_DIR."/email/email-quatation.php";
				if( file_exists( $file )){
					include $file;
				}
				$quotation = ob_get_clean();
				$dynamicData["quotation"] = $quotation ;
				//Email
				if( new PRC_Email( $emails ,$subject, $dynamicData, $template ) ){
					$return['message'] = apply_filters( "pro_rate_cal_quotation_email_send_message_response", PRC_db::message_string( "quotation_has_been_send" ) );
				}else{
					$return['message'] = PRC_db::message_string( "there_are_some_issue_with_email" ); 
				}
				do_action( "pro_rate_cal_submit_quotation", $_POST );
			}else{
				$return['message'] = PRC_db::message_string( "form_id_is_invalid" );
			}
		}else{
			$return['message'] = PRC_db::message_string( "form_id_is_not_set" );
		}
		header( 'Content-type: application/json' );
		wp_send_json( $return );
	}

	public static function get_image_url( $file_name = "" ){
		if( !defined( "PRC_IMAGE_PATH_URL" ) ){
		  define( "PRC_IMAGE_PATH_URL" , plugin_dir_url( __FILE__ ).'/public/images/' );
		}
		return PRC_IMAGE_PATH_URL."/".$file_name ;
	}

	// Zapier Trigger Function
	public function pro_rate_cal_zapier_trigger_function( array $data, $hook_url ) {
		$content_type = 'application/json';
		$blog_charset = get_option( 'blog_charset' );
		if ( ! empty( $blog_charset ) ) {
			$content_type .= '; charset=' . get_option( 'blog_charset' );
		}
		$args = array(
			'method'    => 'POST',
			'body'      => json_encode( $data ),
			'headers'   => array(
				'Content-Type'  => $content_type,
			),
		);
		wp_remote_post( $hook_url, $args );
	}

}


