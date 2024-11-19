<?php

namespace FX_Load_More;

use SWP_Query;
use WP_Query;

defined( 'ABSPATH' ) || exit;


final class Frontend
{
    /**
     * Constructor
     * 
     * @return  void
     */	
	public function __construct()
	{
        $this->include();		
		$this->add_wp_hooks();
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
        require_once( FX_Load_More()->plugin_path_inc . 'shortcodes/fx-load-more-pagination.php' );
    }



	/**
	 * Hook into WordPress
	 *
	 * @return 	void
	 */
	public function add_wp_hooks()
	{
		add_action( 'wp_enqueue_scripts', [ $this, 'maybe_enqueue_assets' ] );
	}


	/**
	 * Enqueues assets for specific pages
	 * 
	 * @todo 	update to use FX_Assets
	 *
	 * @return 	void
	 */
	public function maybe_enqueue_assets(): void
	{
		wp_register_script(
			'FXLM',
			FX_Load_More()->plugin_url . 'src/app.js',
			[ 'jquery' ],
			filemtime( FX_Load_More()->plugin_path . 'src/app.js' ),
			true
		);

		// only enqueue on blog, archive pages, and search page
		if( is_home() || is_archive() || is_search() ) {
			wp_enqueue_script( 'FXLM' );

			$addon_data = [
				'post_type'			=> get_post_type() ?: '',
				'post_count'		=> $this->get_total_post_count(),
				'posts_per_page'	=> get_option( 'posts_per_page' ),
				'rest_url' 			=> get_rest_url( null, FX_Load_More()->endpoint::NAMESPACE ),
			];

			if( is_tax() || is_category() ) {
				$term = get_queried_object();

				$addon_data['post_taxonomy'] 	= $term->taxonomy;
				$addon_data['post_term_id']		= $term->term_id;
			}

			wp_localize_script( 'FXLM', 'FXLM', $addon_data ); 
		}
	}



	/**
	 * Get total post count for current query
	 * 
	 * @todo 	update to use optional $post_type argument to get count for specific post type
	 * @todo 	is_tax||is_category doesn't look right; need to double-check this is working correctly
	 * @todo 	else — maybe use this for all non-home cases? Probably good/broad enough to expand
	 *
	 * @return 	int 	Post count
	 */
	private function get_total_post_count(): int
	{
		$count = 0;

		// blog page
		if( is_home() ) {
			$count = wp_count_posts( 'post' )->publish;

		// all post type archive pages
		} elseif( is_post_type_archive() ) {
			$post_type = get_post_type();
			$count = wp_count_posts( $post_type )->publish;

		// all taxonomy pages (see @todo above)
		} elseif( is_tax() || is_category() ) {
			$count = get_queried_object()->count;

		// backup for all other cases (e.g. data archives) (see @todo above)
		} else {
			global $wp_query;

			$query_vars = $wp_query->query_vars;
			$query_vars['posts_per_page'] = -1;
			$query_vars['fields'] = 'ids';
			$query_vars = array_filter( $query_vars ); // not the best solution, but works for now

			$query_for_count = new WP_Query( $query_vars );
			wp_reset_postdata();

			$count = $query_for_count->post_count;
		}

		return $count;
	}

}