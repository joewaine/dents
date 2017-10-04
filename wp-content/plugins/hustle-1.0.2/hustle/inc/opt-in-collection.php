<?php

/**
 * Class Opt_In_Collection
 *
 *
 */
class Opt_In_Collection {


    /**
     * Reference to $wpdb global var
     *
     * @since 1.0.0
     *
     * @var $_db WPDB
     * @access private
     */
    private static $_db;

    /**
     * @return Opt_In_Collection
     */
    public static function instance(){
        global $wpdb;

        self::$_db = $wpdb;

        return new self;
    }

    /**
     * Returns
     *
     * @param null $active
     * @return array Opt_In_Model[]
     */
    public function get_all_optins( $active = true, $args = array() ){
        $blog_id = (int) ( isset( $args['blog_id'] ) ? $args['blog_id']  : get_current_blog_id() );

        if( is_null( $active ) )
            $ids = self::$_db->get_col( self::$_db->prepare( "SELECT `optin_id` FROM " . $this->_get_table() . " WHERE `blog_id`=%d ORDER BY  `optin_name`", $blog_id ) );
        else
            $ids = self::$_db->get_col( self::$_db->prepare( "SELECT `optin_id` FROM " . $this->_get_table() ." WHERE `active`= %d AND `blog_id`=%d ORDER BY  `optin_name`", (int) $active, $blog_id )  );

        return array_map( array( $this, "return_model_from_id" ), $ids );
    }

    function get_count(){
        return self::$_db->num_rows;
    }

    function return_model_from_id( $id ){
        if( empty( $id )) return array();
        return Opt_In_Model::instance()->get( $id );
    }

    /**
     * Returns table name
     *
     * @since 1.0.0
     *
     * @return string
     */
    private function _get_table(){
        return self::$_db->base_prefix . Opt_In_Db::TABLE_OPT_IN;
    }

    public function get_all_id_names(){
        return self::$_db->get_results( self::$_db->prepare( "SELECT `optin_id`, `optin_name` FROM " . $this->_get_table() ." WHERE `active`=%d AND `blog_id`=%d", 1, get_current_blog_id() ), OBJECT );
    }
}