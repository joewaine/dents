<?php
$module = array(
	'name' => __( 'Filter by author or site', 'wmd_msreader' ),
	'description' => __( 'Displays posts by selected author or site', 'wmd_msreader' ),
	'slug' => 'filter_blog_author',
	'class' => 'WMD_MSReader_Module_FilterBlogAuthor',
    'can_be_default' => false,
    'global_cache' => true,
    'type' => array('query', 'query_args_required')
);

class WMD_MSReader_Module_FilterBlogAuthor extends WMD_MSReader_Modules {
	function init() {
		add_filter('msreader_post_author', array($this,'add_author_link'),10,2);
        add_filter('msreader_post_blog', array($this,'add_blog_link'),10,2);

        add_filter('msreader_rss_feeds_extra_enable_feed', array($this,'add_module_slug_to_array'),10,1);
        add_filter('msreader_rss_feeds_enable_args', array($this,'add_module_slug_to_array'),10,1);
    }

    function add_author_link($name, $post) {
        return '<a title="'.__('View all posts by this author', 'wmd_msreader').'" href="'.$this->get_module_dashboard_url(array('author_id' => $post->post_author)).'">'.$name.'</a>';
    }

    function add_blog_link($name, $post) {
        return '<a title="'.__('View all posts on this site', 'wmd_msreader').'" href="'.$this->get_module_dashboard_url(array('blog_id' => $post->blog_details->blog_id)).'">'.$name.'</a>';
    }

    function get_page_title() {
        $title = '';
        if(isset($this->args['blog_id']) && is_numeric($this->args['blog_id'])) {
            $blog_details = get_blog_details($this->args['blog_id']);
            return __('Posts from:', 'wmd_msreader').' <span>'.$blog_details->blogname.'</span> <a href="'.$blog_details->siteurl.'" class="add-new-h2"><span class="dashicons dashicons-admin-links"></span> '.__('Visit site', 'wmd_msreader').'</a>';
        }
        elseif(isset($this->args['author_id']) && is_numeric($this->args['author_id'])) {
            $user_details = get_userdata( $this->args['author_id'] );
            return __('Posts by:', 'wmd_msreader').' <span>'.$user_details->display_name.'</span>';
        }
        else
            return '';
    }

    function query() {
        global $wpdb;

        $limit = $this->get_limit();
        $public = $this->get_public();

    	$query = "
            SELECT posts.BLOG_ID AS BLOG_ID, ID, post_author, post_date, post_date_gmt, post_content, post_title
            FROM $this->db_network_posts AS posts
            INNER JOIN $this->db_blogs AS blogs ON blogs.blog_id = posts.BLOG_ID
            WHERE $public blogs.archived = 0 AND blogs.spam = 0 AND blogs.deleted = 0
            AND post_status = 'publish'
            AND post_password = ''
        ";

        if(isset($this->args['blog_id']) && is_numeric($this->args['blog_id']))
            $query .= $wpdb->prepare("
                AND posts.BLOG_ID = %d
            ", $this->args['blog_id']);

        if(isset($this->args['author_id']) && is_numeric($this->args['author_id']))
            $query .= $wpdb->prepare("
                AND post_author = %d
            ", $this->args['author_id']);

        $query .= "
            ORDER BY post_date_gmt DESC
            $limit
        ";
        $query = apply_filters('msreader_'.$this->details['slug'].'_query', $query, $this->args, $limit, $public);
        $posts = $wpdb->get_results($query);

    	return $posts;
    }
}