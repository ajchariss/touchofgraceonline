# Changelog

## [1.0.3]
- created change log
- added function for checking for debug mode
- passed query and query args to AJAX requests for getting posts when in debug mode
- passed query and query args to search template for tabbed results when in debug mode
- added "fx_load_more_get_tabbed_results_searchwp_engine" for allowing plugin or theme to change SearchWP engine for tabbed results
- added "fx_load_more_get_posts_searchwp_engine" for allowing plugin or theme to change SearchWP engine for API/AJAX results

## [1.0.4]
- fixed class dependencies

## [1.0.5]
- renamed "fx_load_more_get_tabbed_results_searchwp_engine" filter to "fx_load_more/get_tabbed_results/searchwp_engine"
- renamed "fx_load_more_get_posts_searchwp_engine" filter to "fx_load_more/get_posts/searchwp_engine"
- renamed "fx_load_more_template" to "fx_load_more/use_template"
- added hack to circumvent issue with SearchWP returning identical results with same relevance across multiple search result pages