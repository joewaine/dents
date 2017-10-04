<?php
$module = array(
	'name' => __( 'Trending Tags', 'wmd_msreader' ),
	'description' => __( 'Displays trending tags', 'wmd_msreader' ),
	'slug' => 'trending_tags',
	'class' => 'WMD_MSReader_Module_TrendingTags',
    'can_be_default' => false,
    'global_cache' => true,
    'default_options' => array(
        'widget_links_limit' => 5,
        'widget_sample_limit' => 100
    ),
    'type' => array('query', 'query_args_required')
);

class WMD_MSReader_Module_TrendingTags extends WMD_MSReader_Modules {

	function init() {
		add_filter( 'msreader_dashboard_reader_sidebar_widgets', array($this,'add_widget'), 20 );

        add_filter( 'msreader_module_options_'.$this->details['slug'], array($this,'add_options_html'), 10, 2 );
    }

    function add_widget($widgets) {
        global $wpdb;

    	$limit_sample = $this->get_limit($this->options['widget_sample_limit'], 1);
    	$limit_links = $this->options['widget_links_limit'];
    	$limit = $this->get_limit($limit_links, 1);

		$query_hash = md5($this->cache_init.$this->details['slug'].$limit_sample.$limit_links);
		$cache_group = 'msreader_global';
		$top_tags = wp_cache_get('widget_'.$query_hash, $cache_group);

		if(!$top_tags) {
	    	$query = "
	            SELECT id, slug, name, count(id) AS count
	            FROM (
		            SELECT a.term_taxonomy_id AS id, c.slug AS slug, c.name AS name
		            FROM $this->db_network_term_rel AS a
		            INNER JOIN $this->db_network_term_tax AS b ON b.term_taxonomy_id = a.term_taxonomy_id
		            INNER JOIN $this->db_network_terms AS c ON c.term_id = a.term_taxonomy_id
                    INNER JOIN $this->db_network_posts AS d ON (a.blog_id = d.BLOG_ID AND a.object_id = d.ID)
		            WHERE b.taxonomy = 'post_tag'
                    ORDER BY d.post_date_gmt DESC
		            $limit_sample
	            ) a
	            GROUP BY id
	            ORDER BY count DESC
	            $limit
	        ";
            $query = apply_filters('msreader_'.$this->details['slug'].'_widget', $query, $this->args, $limit, $limit_sample);
	        $top_tags = $wpdb->get_results($query, ARRAY_A);

	        wp_cache_set('widget_'.$query_hash, $top_tags, $cache_group, 3600);
    	}

        //prepare trending tags links
        $top_tags_ready = array();
        foreach ($top_tags as $tag)
        	$top_tags_ready[] = array('args' => $tag['id'],'title' => $tag['name']);

        if($top_tags_ready)
    	   $widgets['trending-tags'] = $this->create_list_widget($top_tags_ready);

    	return $widgets;
    }

    function get_page_title() {
        global $wpdb;

    	$tax_id = $this->args[0];

    	$query = $wpdb->prepare("
			SELECT name
			FROM $this->db_network_terms
			WHERE term_id = %d
			LIMIT 1
        ", $tax_id);
        $query = apply_filters('msreader_'.$this->details['slug'].'_page_title', $query, $this->args, $tax_id);
        $tag = $wpdb->get_row($query, ARRAY_A);

		return $this->details['page_title'].': <span>'.$tag['name'].'</span>';
    }

    function query() {
        global $wpdb;

        $limit = $this->get_limit();
        $public = $this->get_public();
        $tax_id = $this->args[0];

    	$query = $wpdb->prepare("
            SELECT posts.BLOG_ID AS BLOG_ID, ID, post_author, post_date, post_date_gmt, post_content, post_title
            FROM $this->db_network_posts AS posts
            INNER JOIN $this->db_blogs AS blogs ON blogs.blog_id = posts.BLOG_ID
            INNER JOIN $this->db_network_term_rel AS b ON (b.object_id = posts.ID AND b.blog_id = posts.BLOG_ID)
            WHERE $public blogs.archived = 0 AND blogs.spam = 0 AND blogs.deleted = 0
            AND post_status = 'publish'
            AND post_password = ''
            AND b.term_taxonomy_id = %d
            ORDER BY post_date_gmt DESC
            $limit
        ", $tax_id);
        $query = apply_filters('msreader_'.$this->details['slug'].'_query', $query, $this->args, $limit, $public, $tax_id);
        $posts = $wpdb->get_results($query);

    	return $posts;
    }

    function add_options_html($blank, $options) {
        return '
            <label for="wmd_msreader_options[name]">'.__( 'Number of links in "Trending Tags" widget', 'wmd_msreader' ).':</label><br/>
            <input type="number" class="small-text ltr" name="wmd_msreader_options[modules_options]['.$this->details['slug'].'][widget_links_limit]" value="'.$options['widget_links_limit'].'" /><br/>
            <label for="wmd_msreader_options[name]">'.__( 'Number of recently added tags to check and see which one are popular', 'wmd_msreader' ).':</label><br/>
            <input type="number" class="small-text ltr" name="wmd_msreader_options[modules_options]['.$this->details['slug'].'][widget_sample_limit]" value="'.$options['widget_sample_limit'].'" />
        ';
    }
}