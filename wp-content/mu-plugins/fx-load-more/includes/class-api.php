<?php

namespace FX_Load_More;

use SWP_Query;
use WP_Query;

defined( 'ABSPATH' ) || exit;


final class Api
{
    /**
     * Constructor
     * 
     * @return  void
     */	
	public function __construct()
	{
		$this->add_wp_hooks();
	}


	/**
	 * Hook into WordPress
	 *
	 * @return 	void
	 */
	private function add_wp_hooks(): void
	{
		// @todo — add hooks if needed
	}


	/**
	 * Get posts based on provided arguments
	 *
	 * @param	int 	$page 			Page number of posts
	 * @param 	string 	$post_type 		Post type of requested posts
	 * @param 	string 	$search_string 	Term for searching specific posts
	 * @param 	int 	$posts_per_page	Number of posts to return
	 * @param 	string 	$taxonomy 		Post taxonomy
	 * @param 	int 	$term_id 		ID of term in taxonomy
     * @param 	string 	$exclude_ids	Comma-separated list of post IDs to exclude
	 * 
	 * @return	array 					Contains number of posts for page and HTML for posts
	 */
	public function get_posts( int $page, string $post_type = 'post', string $search_string = '', int $posts_per_page = 10, $taxonomy = null, $term_id = null, $exclude_ids = null ): array
	{
		// what we'll send back through endpoint
		$response = [
			'posts'			=> [],
			'post_count'	=> 0
		];

		$query_args = [
			'order'				=> 'DESC',
			'paged'				=> $page,
			'post_type'			=> $post_type,
			'posts_per_page'	=> $posts_per_page,
		];

		// is this for search results?
		$is_search = !empty( $search_string );
		if( $is_search ) {
			$query_args['s'] = $search_string;
		}

		// for specific taxonomy/term?
		if( !empty( $taxonomy ) && !empty( $term_id ) ) {
			$query_args['tax_query'] = [
				[
					'taxonomy'	=> $taxonomy,
					'terms'		=> $term_id,
				]
			];
		}

        // any posts to exclude? eg. featured posts displayed in a different container
        if( !empty( $exclude_ids ) ) {
            $exclude_ids = explode( ',', $exclude_ids );
            $query_args['post__not_in'] = $exclude_ids;
        }

		// if searching and SearchWP is available ...
		if( $is_search && class_exists( 'SWP_Query' ) ) {
			$query = new SWP_Query( $query_args );
		
		// otherwise, use WP's default query
		} else {

			/**
			 * Allow other plugins or theme to change SearchWP engine based on provided query args
			 * 
			 * @since 	1.0.3
			 * 
			 * @param	string	$engine 	Default SearchWP engine
			 * @param 	array 	$query_args	Query args for current search request
			 * 
			 * @return 	string 				SearchWP engine to use
			 */
			$query_args['engine'] = apply_filters( 'fx_load_more/get_posts/searchwp_engine', 'default', $query_args );

			$query = new WP_Query( $query_args );
		}

		// note post count for updating widget on frontend
		$response['post_count'] = count( $query->posts );

		// add query args and query to frontend request for debugging
		if( FX_Load_More()::is_debug_mode() ) {
			$response['query'] = $query;
			$response['query_args'] = $query_args;
		}

		// check if theme has template file (otherwise, use plugin's template file)
		$template_file = self::get_template_file( $is_search );

		global $post;
		foreach( $query->posts as $post ) {
			setup_postdata( $post );

			// include args to pass to template
			$args = [];
			if( $is_search ) {
				$args['query'] = $search_string;
			}
			
			ob_start();
			include( $template_file );
			$response['posts'][] = ob_get_clean();
		}
		wp_reset_postdata();
		
		return $response;
	}


	/**
	 * Get template file based on whether query is for search and if files exist in theme 
	 *
	 * @param	bool 	$is_search 	Query is for search
	 * @return 	string 				File path
	 */
	private static function get_template_file( bool $is_search ): string
	{
		$filename = $is_search ? 'search-result.php' : 'loop-content.php';
		$template = null;

		// check if theme has partial
		$theme_file = sprintf( '%s/partials/%s', get_stylesheet_directory(), $filename );
		if( is_file( $theme_file ) ) {
			$template = $theme_file;

		// otherwise, use template from plugin templates
		} else {
			$plugin_templates = sprintf( '%stemplates', FX_Load_More()->plugin_path );
			$template = sprintf( '%s/%s', $plugin_templates, $filename );
		}

		/**
		 * Allow plugin or theme to customize which template file to use
		 *
		 * @since	1.0.5
		 *
		 * @param	string	$template 	File path to template
		 * @param 	bool 	$is_search 	True, if current query is for a search result
		 * 
		 * @return 	string 				Filtered file path to template
		 */
		$template = apply_filters( 'fx_load_more/use_template', $template, $is_search );

		return $template;
	}
}