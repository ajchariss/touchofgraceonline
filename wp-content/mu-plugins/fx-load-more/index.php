<?php

/**
 * 	Plugin Name:	FX Load More
 * 	Plugin URI: 	https://www.webfx.com
 * 	Description:	Adds "load more" functionality to blog and search results
 * 	Version: 		1.0.5
 * 	Author: 		The WebFX Team
 * 	Author URI: 	https://www.webfx.com
 * 	Text Domain: 	webfx
 */


final class FX_Load_More
{
    protected static $instance = null;
	
	public $plugin_path     = null;
    public $plugin_path_inc = null;
    public $plugin_url      = null;


	// subclasses
	public $frontend;
	public $api;
	public $endpoint;
    public $search;



    /**
     * Singleton instance
     *
     * @return  self
     */
	public static function instance() 
    {
		if( null === self::$instance ) {
			self::$instance = new self();
        }

        return self::$instance;
	}


    /**
     * Checks if WP is in debug/development mode
     *
     * @since	1.0.3
     *
     * @return  bool    True, if site is in debug/dev mode
     */
    public static function is_debug_mode(): bool
    {
        // check for constants set in wp-config
        if( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            return true;
        }

        // check if site is in development mode
        if( 'development' === wp_get_environment_type() ) {
            return true;
        }

        return false;
    }



    /**
     * Constructor
     * 
     * @return  void
     */
    public function __construct()
    {
        $this->define();
        $this->include();
        $this->add_wp_hooks();
    }


    
    /**
     * Define common vars
     *
     * @return  void
     */
    public function define(): void
    {
        $this->plugin_path 		= plugin_dir_path( __FILE__ );
        $this->plugin_url 		= plugin_dir_url( __FILE__ );
        $this->plugin_path_inc 	= sprintf( '%sincludes/', $this->plugin_path );
    }



    /**
     * Include required files
     * 
     * @todo    separate includes conditionally by frontend/admin
     *
     * @return  void
     */
    private function include(): void
    {
        require_once( $this->plugin_path_inc . 'class-api.php' );
		require_once( $this->plugin_path_inc . 'class-endpoint.php' );
		require_once( $this->plugin_path_inc . 'class-frontend.php' );
        require_once( $this->plugin_path_inc . 'class-search.php' );
    }


	/**
	 * Hook into WordPress
	 *
	 * @return	void
	 */
    private function add_wp_hooks(): void
    {
        add_action( 'plugins_loaded', [ $this, 'get_subclasses' ] );
    }



    /**
     * Set up required subclasses
     * 
     * @todo    separate classes conditionally by frontend/admin
     *
     * @return  void
     */
    public function get_subclasses(): void
    {
		$this->endpoint 	= new FX_Load_More\Endpoint();
		$this->api          = new FX_Load_More\Api();
        $this->frontend     = new FX_Load_More\Frontend();
        $this->search       = new FX_Load_More\Search();
    }

}


/**
 * Returns main instance of FX_Load_More
 * 
 * @return  FX_Load_More
 */
function FX_Load_More() {
	return FX_Load_More::instance();
}


FX_Load_More();
