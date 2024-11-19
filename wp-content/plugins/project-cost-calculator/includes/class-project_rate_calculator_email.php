<?php
if( !class_exists( 'PRC_Email' ) ){

	class PRC_Email{
		/**
		 * Emails array
		 */
		protected $emails;
		/**
		 * email subject or title
		 */
		protected $title;
		/**
		 * dynamic data which will replaced with keywords
		 */
		protected $dynamicData = array();
		/**
		 * email template to be send
		 */
		protected $template;
		/**
		 * Final template to be sent as email
		 */
		protected $outputTemplate;

		public function __construct($emails, $title, $dynamicData, $template ){

			$this->emails = $emails;
			$this->title = $title;
			$this->dynamicData = $dynamicData;
			$this->template = $template;
			$this->prepareTemplate();
			return $this->send();

		}
		/**
		 * preparing template ,
		 */
		private function prepareTemplate(){
			$template = $this->getTemplate();
			foreach ($this->dynamicData as $placeholder => $value) {
				// Ensure that the placeholder will be in uppercase
				$securePlaceholder = strtolower( $placeholder );
				// Placeholder used in our template
				$preparedPlaceholder = "{{" . $securePlaceholder . "}}";
				// Template with real data
				$template = str_replace( $preparedPlaceholder, $value, $template );
			}
			$this->outputTemplate = $this->get_email_template("email-header").$template.$this->get_email_template("email-footer");
		}

		/**
		 * Get template
		 */
		private function getTemplate(){
			return $this->template;
		}

		/**
		 * Send email
		 */
		private function send(){
			$headers[] = 'Content-Type: text/html; charset=UTF-8';
			return wp_mail( $this->emails, $this->title, $this->outputTemplate,$headers );
		}
		
		/**
		 * Get email template from template 
		 */
		private function get_email_template( $file ){
			ob_start();
			$file = PRC_TEMPLATE_DIR."/email/".$file.".php";
			if( file_exists( $file )){
				include $file;
			}
			return ob_get_clean();
		}

	}

}
?>