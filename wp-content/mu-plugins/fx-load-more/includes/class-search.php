<?php

namespace FX_Load_More;

use SWP_Query;
use WP_Query;
use WP_Post;

defined( 'ABSPATH' ) || exit;


final class Search
{
	/**
	 * @todo — add additional post types to include in search as needed
	 */
	public $searchable_post_types = [
		'page'		=> 'Pages',
		'post'		=> 'Posts',
		'product'	=> 'Products',
	];


	public $posts_per_page;



    /**
     * Constructor
     * 
     * @return  void
     */	
	public function __construct()
	{
		$this->posts_per_page = get_option( 'posts_per_page' );

		$this->add_wp_hooks();
	}


	/**
	 * Hook into WordPress
	 *
	 * @return 	void
	 */
	private function add_wp_hooks(): void
	{
		add_action( 'init',				[ $this, 'check_post_types' ], 20 );
		add_action( 'searchwp\query', 	[ $this, 'apply_post_id_order_hack'], 20, 2 );
	}


	/**
	 * Ensure that searchable post types actually exist. This avoids DB database errors when searching
	 *
	 * @return 	void
	 */
	public function check_post_types()
	{
		$all_post_types = get_post_types();

		foreach( $this->searchable_post_types as $post_type_key => $pretty_name ) {
			if( !in_array( $post_type_key, $all_post_types ) ) {
				unset( $this->searchable_post_types[ $post_type_key ] );
			}
		}
	}


	/**
	 * Add an arbitrary orderby param to prevent duplicate search results
	 * 
	 * If results have the same relevance, SearchWP may return a seemingly "random" order (e.g. five posts with a 
	 * relevance of 1 may appear multiple times across search result pages).
	 * 
	 * @since	1.0.6
	 * 
	 * @todo 	Rob is contacting SearchWP to see if there's a better/native way to do this, so we'll probably remove
	 * 			this function in near future
	 *
	 * @param	array	$query 	SearchWP query
	 * @param 	array 	$args 	Query args
	 * 
	 * @return 	array 			Filtered SearchWP query
	 */
	public function apply_post_id_order_hack( array $query, array $args ): array
	{
		// add arbitrary orderby param. This has no importance; just prevents same result from appearing multiple times
		$query['order_by'][] = 's.id DESC'; // need to figure out if "s" is ever not used post row

		return $query;
	}


	/**
	 * Get tabs for switching between search results
	 *
	 * @param 	string 	$search_query 	User search string
	 * @param 	int 	$paged 			Page of search results
	 * @param 	bool 	$id_only 		If true, return post IDs for results; otherwise, WP_Post objs
	 * 
	 * @return 	array 	Contains array of tab titles, tab post types, and post count (and optionally debug info)
	 */
	public function get_tabbed_results( string $search_query = '', int $paged = 1, bool $id_only = true )
	{
		// what we'll return
		$response = [
			'results' => []
		];

		// exit early if SearchWP isn't installed @todo — back up to use WP_Query and "s" param
		if( !class_exists( 'SWP_Query' ) ) {
			_doing_it_wrong( 
				__FUNCTION__, 
				'SearchWP needs to be installed in order to calculate tabbed results', 
				'5.8' 
			);

			return $response;
		}

		// prep results
		$results = [];
		foreach( $this->searchable_post_types as $post_type_key => $tab_title ) {
			$result = [
				'post_type_key'	=> $post_type_key,
				'tab_title'		=> $tab_title,
				'tab_count'		=> 0,
				'posts'			=> []
			];

			$results[ $post_type_key ] = $result;
		}

		$args = [
			'post_type'			=> array_keys( $this->searchable_post_types ),
			'posts_per_page'	=> -1,
			's'					=> $search_query,
		];

		// to speed up query and decrease memory usage
		if( $id_only ) {
			$args['fields'] = 'ids';
		}

		/**
		 * Allow other plugins or theme to change SearchWP engine based on provided query args
		 * 
		 * @since 	1.0.3
		 * 
		 * @param	string	$engine	Default SearchWP engine
		 * @param 	array 	$args	Query args for current search request
		 * 
		 * @return 	string 			SearchWP engine to use
		 */
		$args['engine'] = apply_filters( 'fx_load_more/get_tabbed_results/searchwp_engine', 'default', $args );

		$query = new SWP_Query( $args );
		foreach( $query->posts as $post ) {

			if( is_a( $post, 'WP_Post' ) ) {
				$results[ $post->post_type ]['posts'][] = $post;

			} elseif( $id_only && is_int( $post ) ) {
				$post_type = get_post_type( $post );
				$results[ $post_type ]['posts'][] = $post;
			}
		}

		// clean up results by getting post count and extracting target page of posts
		foreach( $results as $post_type_key => &$data ) {
			$posts = $data['posts'];

			// set post count (will appear in tab title)
			$data['tab_count'] = count( $data['posts'] );

			// extract specific page of posts
			$posts_per_page = $this->posts_per_page;
			$paged_posts = array_splice( 
				$posts, 
				( $paged - 1 ) * $posts_per_page,
				$posts_per_page
			);

			$data['posts'] = $paged_posts;
		}

		$response['results'] = $results;

		// add query args and query to frontend request for debugging
		if( FX_Load_More()::is_debug_mode() ) {
			$response['query'] 		= $query;
			$response['query_args'] = $args;
		}		

		return $response;
	}

}
