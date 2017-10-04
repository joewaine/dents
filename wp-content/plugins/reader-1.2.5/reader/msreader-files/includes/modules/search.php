<?php
$module = array(
	'name' => __( 'Search', 'wmd_msreader' ),
	'description' => __( 'Allows to search posts by title, author or tag', 'wmd_msreader' ),
	'slug' => 'search',
	'class' => 'WMD_MSReader_Module_Search',
    'can_be_default' => false,
    'global_cache' => true,
    'type' => array('query', 'query_args_required')
);

class WMD_MSReader_Module_Search extends WMD_MSReader_Modules {

	function init() {
		add_filter( 'msreader_dashboard_reader_sidebar_widgets', array($this,'add_widget'), 5 );
        add_action( 'admin_print_styles', array($this,'add_css'));

        add_filter('msreader_rss_feeds_extra_enable_feed', array($this,'add_module_slug_to_array'),10,1);
        add_filter('msreader_rss_feeds_enable_args', array($this,'add_module_slug_to_array'),10,1);
    }

    function add_css() {
        ?>
        <style type="text/css">
            #msreader-widget-search {
                margin-bottom: 30px;
            }
            #msreader-widget-search .fullwidth-text {
                width: 100%;
            }
            #msreader-widget-search label {
                margin-right: 10px;
            }
        </style>
        <?php
    }
    function add_widget($widgets) {
        //set title search as default
        if(!isset($this->args['search_author']) && !isset($this->args['search_tag']) && !isset($this->args['search_title']))
            $this->args['search_title'] = 1;

        $search_value = isset($this->args['search_value']) ? esc_attr($this->args['search_value']) : '';
        $search_html = '
            <form id="msreader-searc" action="'.add_query_arg(array('module' => 'search'), admin_url('index.php?page=msreader.php')).'" method="post">
                <p><input name="args[search_value]" class="fullwidth-text" type="text" value="'.$search_value.'" placeholder="'.__('Search...', 'wmd_msreader').'"/><p/>
                <label for="search_title">
                <input name="args[search_title]" id="search_title" type="checkbox" value="1" '.checked( isset($this->args['search_title']) ? $this->args['search_title'] : '', true, false ).'>'.__('Title', 'wmd_msreader').'
                </label>
                <label for="search_author">
                <input name="args[search_author]" id="search_author" type="checkbox" value="1" '.checked( isset($this->args['search_author']) ? $this->args['search_author'] : '', true, false ).'>'.__('Author', 'wmd_msreader').'
                </label>
                <label for="search_tag">
                <input name="args[search_tag]" id="search_tag" type="checkbox" value="1" '.checked( isset($this->args['search_tag']) ? $this->args['search_tag'] : '', true, false ).'>'.__('Tag', 'wmd_msreader').'
                </label>
                <input class="button button-primary right" type="submit" value="'.__('Search', 'wmd_msreader').'"/>
            </form>
        ';

        $widget = array('search' => array(
                'title' => $this->details['menu_title'],
                'default_style' => 0,
                'data' => array(
                    'html' => $search_html
                )
            ));

    	$widgets = array_merge($widget, $widgets);

    	return $widgets;
    }

    function get_page_title() {
 		return $this->details['page_title'].': <span>'.esc_attr($this->args['search_value']).'</span>';
    }

    function query() {
        global $wpdb;

        $blocked_words = apply_filters('msreader_'.$this->details['slug'].'_blocked_words', array());
        $search_words = explode(' ', $this->args['search_value']);
        $blocked = 0;
        foreach ($search_words as $search_word)
            if(in_array(trim($search_word), $blocked_words)) {
                $blocked = 1;
                break;
            }

        if(!$blocked) {
            $limit = $this->get_limit();
            $public = $this->get_public();

            //set title search as default
            if(!isset($this->args['search_author']) && !isset($this->args['search_tag']) && !isset($this->args['search_title']))
                $this->args['search_title'] = 1;

            $query = "
                SELECT posts.BLOG_ID AS BLOG_ID, posts.ID AS ID, post_author, post_date, post_date_gmt, post_content, post_title
                FROM $this->db_network_posts AS posts
                INNER JOIN $this->db_blogs AS blogs ON blogs.blog_id = posts.BLOG_ID";
            if(isset($this->args['search_tag']) && $this->args['search_tag'])
                $query .= "
                    LEFT JOIN $this->db_network_term_rel AS b ON (b.object_id = posts.ID AND b.blog_id = posts.BLOG_ID)
                    LEFT JOIN $this->db_network_terms AS c ON (c.term_id = b.term_taxonomy_id)";
            if(isset($this->args['search_author']) && $this->args['search_author'])
                $query .= "
                    LEFT JOIN $this->db_users AS d ON (d.ID = posts.post_author)";
            $query .= "
                WHERE $public blogs.archived = 0 AND blogs.spam = 0 AND blogs.deleted = 0
                AND post_status = 'publish'
                AND post_password = ''
                ";

            $where_search = array();
            if(isset($this->args['search_title']) && $this->args['search_title']) {
                $where_search[] = $wpdb->prepare("posts.post_title LIKE %s", $this->args['search_value'].'%');
                $where_search[] = $wpdb->prepare("posts.post_title LIKE %s", '% '.$this->args['search_value'].'%');
            }
            if(isset($this->args['search_tag']) && $this->args['search_tag']) {
                $where_search[] = $wpdb->prepare("c.name LIKE %s", $this->args['search_value'].'%');
                $where_search[] = $wpdb->prepare("c.name LIKE %s", '% '.$this->args['search_value'].'%');
            }
            if(isset($this->args['search_author']) && $this->args['search_author']) {
                $where_search[] = $wpdb->prepare("d.display_name LIKE %s", $this->args['search_value'].'%');
                $where_search[] = $wpdb->prepare("d.display_name LIKE %s", '% '.$this->args['search_value'].'%');
            }

            $where_search = count($where_search) > 0 ? 'AND ('.implode(' OR ', $where_search).')' : '';
            $query .= "
                $where_search
                ORDER BY post_date_gmt DESC
                $limit
                ";
            $query = apply_filters('msreader_'.$this->details['slug'].'_query', $query, $this->args, $limit, $public);
            $posts = $wpdb->get_results($query);
        }
        else
            $posts = 'error';

    	return $posts;
    }
}