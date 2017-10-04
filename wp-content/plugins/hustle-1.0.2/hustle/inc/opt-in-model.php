<?php

/**
 * Class Opt_In_Model
 *
 * @property int $id
 * @property int $blog_id
 * @property string $optin_name
 * @property string $optin_title
 * @property string $optin_message
 * @property string $optin_provider
 * @property array $optin_mail_list
 * @property string $list_id
 * @property string $list_name
 * @property string $api_key
 * @property int $active
 * @property int $test_mode
 * @property Opt_In_Meta_Design $design
 * @property Opt_In_Meta_Settings $settings
 * @property Opt_In_Decorator $decorated
 * @property array $data
 * @property array $attributes
 * @property bool $is_allow_in_frontend
 * @property array $active_types
 * @property Object $provider_args
 */

class Opt_In_Model extends Opt_In_Data {

    /**
     * Optin id
     *
     * @since 1.0.0
     *
     * @var $id int
     */
    var $id;

    private $_test_types = array();

    private $_stats = array();


    static function instance(){
        return new self;
    }

    function __get($field)
    {
        $from_parent = parent::__get($field);
        if( !empty( $from_parent ) )
            return $from_parent;

        if( in_array( $field, $this->optin_types ) ){
           if( !isset( $this->_stats[ $field ] ) )
                $this->_stats[ $field ] = new Opt_In_Model_Stats($this, $field);

            return $this->_stats[ $field ];
        }

    }

    /**
     * Returns optin based on provided id
     *
     * @param $id
     * @return $this
     */
    function get( $id ){
        $key = "opt_inc_optin_data_" . $id;
        $this->_data  = wp_cache_get( $key );
        $this->id = (int) $id;

        if( false === $this->_data ){
            $this->_data = $this->_wpdb->get_row( $this->_wpdb->prepare( "SELECT * FROM  " . $this->get_table() . " WHERE `optin_id`=%d", $this->id ), OBJECT );
            wp_cache_set( $key, $this->_data );
        }

       $this->_populate();

        return $this;
    }

    private function _populate(){
        if( $this->_data ){
            $this->id = $this->_data->optin_id;
            foreach( $this->_data as $key => $data){
                $this->{$key} = $data;
            }
        }

        $this->get_test_types();
    }
    /**
     * Returns optin based on shortcode id
     *
     * @param string $shortcode_id
     * @return $this
     */
    function get_by_shortcode( $shortcode_id ){

        $key = "opt_inc_optin_shortcode_data_" . $shortcode_id;
        $this->_data  = wp_cache_get( $key );

        if( false === $this->_data ){
            $prefix = $this->_wpdb->base_prefix;
            $this->_data = $this->_data = $this->_wpdb->get_row( $this->_wpdb->prepare( "
            SELECT * FROM  `" . $this->get_table() . "` as optins JOIN `{$prefix}optin_meta` as meta
             ON optins.`optin_id`=meta.`optin_id`
             WHERE `meta_key`='shortcode_id'
             AND `meta_value`=%s", trim( $shortcode_id ) ), OBJECT );
        }

        $this->_populate();
        return $this;
    }


    /**
     * Saves or updates optin
     *
     * @since 1.0.0
     *
     * @return false|int
     */
    function save(){
        $data = get_object_vars($this);

        if( !isset( $data['blog_id'] ) )
            $data['blog_id'] = get_current_blog_id();

        $table = $this->get_table();
        if( empty( $this->id ) ){
            $this->_wpdb->insert($table, $this->_sanitize_model_data( $data ), array_values( $this->get_format() ));
            $this->id = $this->_wpdb->insert_id;
        }else{
            $this->_wpdb->update($table, $this->_sanitize_model_data( $data ), array( "optin_id" => $this->id ), array_values( $this->get_format() ), array("%d") );
        }

        return $this->id;
    }

    /**
     * Returns populated model attributes
     *
     * @return array
     */
    public function get_attributes(){
        return $this->_sanitize_model_data( $this->data );
    }

    /**
     * Matches given data to the data format
     *
     * @param $data
     * @return array
     */
    private function _sanitize_model_data( array $data ){
        $d = array();
        foreach($this->get_format() as $key => $format ){
            $d[ $key ] = isset( $data[ $key ] ) ? $data[ $key ] : "";
        }
        return $d;
    }

    /**
     * Adds meta for the current optin
     *
     * @since 1.0.0
     *
     * @param $meta_key
     * @param $meta_value
     * @return false|int
     */
    function add_meta( $meta_key, $meta_value ){
        return $this->_wpdb->insert( $this->get_meta_table(), array(
            "optin_id" => $this->id,
            "meta_key" => $meta_key,
            "meta_value" => is_array( $meta_value ) || is_object( $meta_value ) ?  json_encode( $meta_value ) : $meta_value
        ), array(
            "%d",
            "%s",
            "%s",
        ));
    }

    /**
     * Updates meta for the current optin
     *
     * @since 1.0.0
     *
     * @param $meta_key
     * @param $meta_value
     * @return false|int
     */
    function update_meta( $meta_key, $meta_value ){

        if( $this->has_meta( $meta_key ) ) {
            return $this->_wpdb->update($this->get_meta_table(), array(
                "meta_value" => is_array($meta_value) || is_object($meta_value) ? json_encode($meta_value) : $meta_value
            ), array(
                'optin_id' => $this->id,
                'meta_key' => $meta_key
            ),
                array(
                    "%s",
                ),
                array(
                    "%d",
                    "%s"
                )
            );

        }

        return $this->add_meta( $meta_key, $meta_value );

    }

    /**
     * Checks if optin has $meta_key added disregarding the meta_value
     *
     * @param $meta_key
     * @return bool
     */
    public function has_meta( $meta_key ){
        return (bool)$this->_wpdb->get_row( $this->_wpdb->prepare( "SELECT * FROM " . $this->get_meta_table() .  " WHERE `meta_key`=%s AND `optin_id`=%d", $meta_key, (int) $this->id ) );
    }

    /**
     * Retrieves optin meta from db
     *
     * @param $meta_key
     * @return null|string
     */
    public function get_meta( $meta_key ){
        $value = wp_cache_get( $this->id, 'optin_meta_' . $meta_key );
        if( false === $value ){
            $value = $this->_wpdb->get_var( $this->_wpdb->prepare( "SELECT `meta_value` FROM " . $this->get_meta_table() .  " WHERE `meta_key`=%s AND `optin_id`=%d", $meta_key, (int) $this->id ) );
            wp_cache_add( $this->id, $value,  'optin_meta_' . $meta_key );
        }
        return  $value;
    }

    /**
     * Returns optin settings ready to inject to frontend, with extra metadata generated programatically to let know
     * the frontend if the optin or any of the related optin types should be displayed in a particular set of pages /
     * categories / tags
     *
     * @param $post
     * @param $categories_array
     * @param $tags_array
     * @return Opt_In_Meta_Settings
     */
    public function get_frontend_settings($post, $categories_array, $tags_array){
        $optin_settings = $this->get_settings()->to_object();


        $post_id = (string)$post->ID;

        foreach ( $this->optin_types as $environment) {
            $optin_settings->{$environment}["display"] = true;

            $is_disabled = isset( $optin_settings->{$environment}["enabled"] ) && ! filter_var( $optin_settings->{$environment}["enabled"], FILTER_VALIDATE_BOOLEAN );
            /**
             * Set is_test to true if the whole optin is in test mode ( doesn't have api added ) or the type is it test mode
             */
            $optin_settings->{$environment}["is_test"] =  $this->test_mode || $this->is_test_type_active( $environment );
            if( !$is_disabled && !$this->test_mode ) // if it's enabled it can't be in test mode
                $optin_settings->{$environment}["is_test"] = false;

            /**
             * Check if it's enabled
             */
            if( $is_disabled )
                $optin_settings->{$environment}["display"] = false;


            /**
             * If current user is admin, then check test mode of current $environment or if $environment is enabled
             */
            if( current_user_can( 'manage_options' ) ){
                $optin_settings->{$environment}["display"] = $this->is_test_type_active( $environment ) || $optin_settings->{$environment}["display"];

                if( $this->is_test_type_active( $environment ) ) // no need to check rest of the conditions if it's a test
                    continue;
            }

            /**
             * Check for next $environment if $environment is not enabled and current user is not admin
             */
            if(  !$optin_settings->{$environment}["display"] )
                continue;

            if( is_singular() ) {

                /**
                 * Check for visibility on the particular post/page
                 */
                if ($post->post_type === 'post') {
                    $excluded_posts = !empty( $optin_settings->{$environment}['excluded_posts'] ) ? (array)$optin_settings->{$environment}['excluded_posts'] : array();
                    $optin_settings->{$environment}["display"] = reset( $excluded_posts ) !== "all" && !in_array( $post_id, $excluded_posts ) ;

                    $selected_posts = !empty( $optin_settings->{$environment}['selected_posts'] )  ? (array) $optin_settings->{$environment}['selected_posts'] : array();
                    $optin_settings->{$environment}["display"] = $optin_settings->{$environment}["display"] && ( array() === $selected_posts || reset( $selected_posts ) === "all" || in_array( $post_id, $selected_posts) );

                } else if( $post->post_type === "page" ) {
                    $excluded_pages = !empty( $optin_settings->{$environment}['excluded_pages'] ) ?  (array)$optin_settings->{$environment}['excluded_pages'] : array();
                    $optin_settings->{$environment}["display"] = reset( $excluded_pages ) !== "all" && !in_array( $post_id, $excluded_pages) ;

                    $selected_pages = !empty( $optin_settings->{$environment}['selected_pages'] ) ? (array) $optin_settings->{$environment}['selected_pages'] : array() ;
                    $optin_settings->{$environment}["display"] = $optin_settings->{$environment}["display"] && ( array() === $selected_pages || reset( $selected_pages ) === "all" || in_array( $post_id, $selected_pages ) );
                }

            }else {

                /**
                 * Check for visibility on categories
                 */
                if ( isset( $optin_settings->{$environment}['show_on_all_cats'] ) && !filter_var($optin_settings->{$environment}['show_on_all_cats'], FILTER_VALIDATE_BOOLEAN) && count(array_intersect($categories_array, (array)$optin_settings->{$environment}['show_on_these_cats'])) == 0)
                    $optin_settings->{$environment}["display"] = false;

                if ( isset($optin_settings->{$environment}['show_on_all_cats']) && filter_var($optin_settings->{$environment}['show_on_all_cats'], FILTER_VALIDATE_BOOLEAN) && count(array_intersect($categories_array, (array)$optin_settings->{$environment}['show_on_these_cats'])) > 0)
                    $optin_settings->{$environment}["display"] = false;

                /**
                 * Check for visibility on tags
                 */
                if( isset(  $optin_settings->{$environment}['show_on_all_tags'] ) && !filter_var( $optin_settings->{$environment}['show_on_all_tags'], FILTER_VALIDATE_BOOLEAN ) && count( array_intersect( $tags_array, (array) $optin_settings->{$environment}['show_on_these_tags'] ) ) == 0 )
                    $optin_settings->{$environment}["display"] = false;

                if( isset( $optin_settings->{$environment}['show_on_all_tags'] ) && filter_var( $optin_settings->{$environment}['show_on_all_tags'], FILTER_VALIDATE_BOOLEAN ) && count( array_intersect( $tags_array, (array) $optin_settings->{$environment}['show_on_these_tags'] ) ) > 0 )
                    $optin_settings->{$environment}["display"] = false;

            }




            /**
             * Check for visibility by conditions
             */
             $optin_settings->{$environment}["display"] = $optin_settings->{$environment}["display"] && $this->_meets_conditions( $environment );

            }

        return $optin_settings;
    }

    /**
     * Checks if optin meets the display conditions
     *
     * @param $optin_type
     * @return bool
     */
    private function _meets_conditions( $optin_type ){
        if( !count( $this->settings->{$optin_type}->conditions ) ) return true;

        foreach( $this->settings->{$optin_type}->conditions as $condition_key => $args ){
            $condition_class = Opt_In_Condition_Factory::build( $condition_key, $args );
            $condition_class->set_type( $optin_type );
            if( !$condition_class->is_allowed( $this, $optin_type ) )
                return false;
        }

        return true;
    }

    /**
     * Returns optin settings
     *
     * @return Opt_In_Meta_Settings
     */
    public function get_settings(){
        $settings_json = $this->get_meta( self::KEY_SETTINGS );
        return new Opt_In_Meta_Settings( json_decode( $settings_json ? $settings_json : "{}", true ), $this );
    }

    /**
     * Returns opt-in design settings
     *
     * @return Opt_In_Meta_Design
     */
    public function get_design(){
        $settings_json = $this->get_meta( self::KEY_DESIGN );
        return new Opt_In_Meta_Design( json_decode( $settings_json ? $settings_json : "{}", true ), $this );
    }

    function get_api_key(){
        return $this->get_meta( self::KEY_API_KEY );
    }


    /**
     * Returns db data for current optin
     *
     * @return array
     */
    function get_data(){
        return array_merge( (array) $this->_data , array("api_key" => $this->api_key, 'test_types' => $this->get_test_types() ) );
    }

    /**
     * Returns mail list id
     *
     * @return bool|mixed
     */
    function get_list_id(){
        return $this->optin_mail_list ? key( $this->optin_mail_list ) : false;
    }

    /**
     * Returns mail list name
     *
     * @return bool|mixed
     */
    function get_list_name(){
        return $this->optin_mail_list ? current( $this->optin_mail_list ) : false;
    }

    /**
     * Toggles state of optin or optin type
     *
     * @param null $environment
     * @return false|int|WP_Error
     */
    function toggle_state( $environment = null ){
        if( is_null( $environment ) ){ // so we are toggling state of the optin
            return $this->_wpdb->update( $this->get_table(), array(
                "active" => (1 - $this->active)
            ), array(
                "optin_id" => $this->id
            ), array(
                "%d"
            ) );
        }

        if( in_array( $environment, $this->optin_types ) ) { // we are toggling state of a specific environment

            if( !is_object( $this->settings->{$environment} ) )
                return new WP_Error("Invalid_env", "Invalid environment . " . $environment);

            $prev_value = $this->settings->{$environment}->to_array();
            $prev_value['enabled'] = !isset( $prev_value['enabled'] ) || "false" === $prev_value['enabled'] ? "true": "false";
            $new_value = array_merge($this->settings->to_array(), array( $environment => $prev_value ));
            return $this->update_meta( self::KEY_SETTINGS,  json_encode( $new_value ) );
        }

    }

    /**
     * Logs interactions done on the optin
     *
     * @param $data
     * @param string $type
     * @return false|int
     */
    private function _log($data, $type = self::KEY_VIEW){

        $data = wp_parse_args($data, array(
            "date"      => current_time('timestamp'),
            'ip'        => Opt_In::get_client_ip(),
            'deleted'   => 0,
            'page_type' => "",
            'page_id'   => 0
        ));

        return $this->add_meta( $type, $data );
    }

    /**
     * Logs optin view
     *
     * @param $data
     * @param $optin_type
     * @return false|int
     */
    function log_view( $data, $optin_type ){
        return $this->_log( $data,  $optin_type  . '_' . self::KEY_VIEW  );
    }


    /**
     * Logs optin conversion
     *
     * @param $data
     * @param $optin_type
     * @return false|int
     */
    function log_conversion( $data, $optin_type ){
        return $this->_log( $data, $optin_type  . '_' . self::KEY_CONVERSION );
    }

    /**
     * Converts the model to json
     *
     * @since 1.0.0
     * @return string json
     */
    function to_json(){
        $model_data = array_merge( $this->_sanitize_model_data( get_object_vars( $this ) ), array("id" => $this->id) );
        return json_encode( $model_data );
    }

    /**
     * Decorates current model
     *
     * @return Opt_In_Decorator
     */
    function get_decorated(){
        return new Opt_In_Decorator( $this );
    }

    /**
     * Deletes optin from optin table and optin meta table
     *
     * @return bool
     */
    function delete(){

        // delete optin
        $result = $this->_wpdb->delete( $this->get_table(), array(
            "optin_id" => $this->id
        ),
            array(
                "%d"
            )
        );

        //delete metas
        return $result && $this->_wpdb->delete( $this->get_meta_table(), array(
            "optin_id" => $this->id
        ),
            array(
                "%d"
            )
        );

    }

    /**
     * Checks if this optin is allowed to show up in frontend for current user
     *
     * @return bool
     */
    function is_allowed_for_current_user(){
        return  1 === (int)$this->test_mode || current_user_can( 'manage_options' );
    }

    /**
     * Retrieves active types from db
     *
     * @return null|string
     */
    function get_test_types(){
        $this->_test_types = json_decode( $this->get_meta( self::TEST_TYPES ), true );
        return $this->_test_types;
    }

    /**
     * Checks if $type is active
     *
     * @param $type
     * @return bool
     */
    function is_test_type_active( $type ){
        return isset( $this->_test_types[ $type ] );
    }

    /**
     * Toggles $type's test mode
     *
     * @param $type
     * @return bool
     */
    function toggle_type_test_mode( $type ){

        if( $this->is_test_type_active( $type ) )
            unset( $this->_test_types[ $type ] );
        else
            $this->_test_types[ $type ] = true;

        return $this->update_meta( self::TEST_TYPES, $this->_test_types );
    }


    /**
     * Returns provider args
     *
     * @since 1.0.1
     *
     * @return object
     */
    function get_provider_args(){
        $args = $this->get_meta( self::PROVIDER_ARGS );
        return empty( $args ) ? false : json_decode( $args, false );
    }
}