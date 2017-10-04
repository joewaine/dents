<?php 
function ibk_get_table_list($return_type='all'){
	/*
	 * @param : return_type - string : all, wp, non_wp
	 * @return all tables from db
	 */
	global $wpdb;
	$arr = array();
	$q = "SELECT table_name FROM information_schema.tables
	WHERE table_schema = '". DB_NAME ."'";
	$data = $wpdb->get_results($q);
	foreach ($data as $table){
		if (strpos($table->table_name, $wpdb->prefix)===0){
			$key = str_replace($wpdb->prefix, '', $table->table_name);
		} else {
			$key = $table->table_name;
		}
		$arr[$key] = $table->table_name;
	}

	//we don't want to backup indeed_logs
	if (isset($arr['indeed_logs'])){
		unset($arr['indeed_logs']);
	}

	$arr = $arr + $wpdb->tables('all', TRUE);
	
	if ($return_type!='all'){
		$native_wp = array();
		$blog_ids_arr = ibk_blog_ids_list();
		if ($blog_ids_arr){
			foreach ($blog_ids_arr as $id){
				$native_wp_i = array();
				$tables_wp_blog = $wpdb->tables('all', TRUE, $id);
				foreach ($tables_wp_blog as $k=>$v){
					if (strpos($v, $wpdb->base_prefix)===0){///$wpdb->prefix
						$key = str_replace($wpdb->base_prefix, "", $v);///$wpdb->prefix
					} else {
						$key = $v;
					}
					$native_wp[$key] = $v;
				}
			}			
		}

		if ($return_type=='wp'){
			return $native_wp;
		} elseif ($return_type=='non_wp'){
			return array_diff($arr, $native_wp);
		}
	}
	return $arr;
}

function ibk_only_tables_for_blog_id($the_tables = array(), $blog_id=1){
	/*
	 * @param the_tables(array), blog_id (int)
	 * @return array
	 */
	global $wpdb;
	$excluded_ids = array_diff(ibk_blog_ids_list(), array($blog_id));

	foreach ($excluded_ids as $id){
		$tables_wp_blog = $wpdb->tables('blog', TRUE, $id);
		foreach ($tables_wp_blog as $k=>$v){
			if (isset($the_tables[$id ."_" . $k])) {
				unset($the_tables[$id ."_" . $k]);
			}
		}
	}

	$tables_wp_blog = $wpdb->tables('global', TRUE, $id);		
	foreach ($the_tables as $key=>$value){
		if (empty($tables_wp_blog[$key])){
			if (strpos($key, $blog_id . "_")!==0){
				unset($the_tables[$key]);
			}						
		}
	}
	
	foreach ($the_tables as $k=>$v){
		if (strpos($k, $blog_id . "_")===0){
			unset($the_tables[$k]);
			$k = $wpdb->prefix . $k;
			$k = str_replace($wpdb->prefix . $blog_id . "_", "", $k);
			$the_tables[$k] = $v;
		}
	}
	
	//exclude the multisite tables
	$multisite_tables = array($wpdb->base_prefix . 'blogs', $wpdb->base_prefix . 'blog_versions', $wpdb->base_prefix . 'registration_log', $wpdb->base_prefix . 'signups', $wpdb->base_prefix . 'site', $wpdb->base_prefix . 'sitemeta');
	$the_tables = array_diff($the_tables, $multisite_tables);
	
	return $the_tables;
}

function ibk_is_table_native_wp($table_name, $blog_id){
	/*
	 * return true if table is like wp_{blog_id}_{$table_name} in multisite
	 * @param table name string, blog id int
	 * @return boolean
	 */
	global $wpdb;
	$tables_without_blog_id = array('blogs', 'blog_versions', 'registration_log', 'signups', 'site', 'sitemeta', 'users', 'usermeta');
	if (in_array($table_name, $tables_without_blog_id)){
		return FALSE;
	}
	if ($blog_id>1){
		$prefix = $wpdb->base_prefix . $blog_id . '_';
	} else {
		//main site...
		$prefix = $wpdb->base_prefix;
	}
	$table_name = $prefix . $table_name;
	if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'")){
		return TRUE;
	}
	return FALSE;
}

function ibk_is_native($table_name, $blog_id=0){
	/*
	 * @param $table name without prefix
	 * @return int, 1 is native 
	 */
	global $wpdb;
	$prefix = $wpdb->prefix;
	if ($blog_id){
		$tables_wp = $wpdb->tables('all', FALSE, $blog_id);
		if (in_array($table_name, $tables_wp)){
			return 1;
		}
	} else {
		$ids = ibk_blog_ids_list();
		if ($ids){
			foreach ($ids as $id){
				$tables_wp = $wpdb->tables('all', TRUE, $id);
				if (in_array($prefix . $table_name, $tables_wp)){
					return 1;
				}
			}
		} else {
			$tables_wp = $wpdb->tables('all', TRUE);
		}		
	}
	
	if (in_array($prefix . $table_name, $tables_wp)){
		return 1;
	}
	return 0;
}

function ibk_blog_ids_list($return_with_name=FALSE){
	/*
	 * @param 
	 * @return array with all blog ids
	 */
	global $wpdb;
	$return_arr = array();
	if (is_multisite() && function_exists('wp_get_sites')){
		$data = wp_get_sites();
	} else {
		$data = array(1);
	}
	foreach ($data as $arr){
		if ($return_with_name){
			if ($arr['blog_id']==1){
				$prefix = $wpdb->base_prefix;
			} else {
				$prefix = $wpdb->base_prefix . $arr['blog_id'] . '_';
			}
			$obj = $wpdb->get_row("SELECT option_value FROM " . $prefix . "options WHERE option_name='blogname';");
			if (isset($obj->option_value)){
				$return_arr[$arr['blog_id']] = $obj->option_value;
			}
		} else {
			$return_arr[] = $arr['blog_id'];
		}		
	}
	return $return_arr;
}

function ibk_return_metas_from_custom_db($type = '', $id=false, $no_defaults_return=FALSE, $status=FALSE){
	/*
	 * @param type (string) = 'backups'/'destinations', id of current backup/destination
	 * @return array with metas
	 */
	$arr = FALSE;
	if ($type){
		switch ($type){
			case 'backups':
				$arr = array(
								'name' => '',
								'description' => '',
								'save_files' => 'all',
								'save_files_list' => '',
								'excluded_files' => '',
								'excluded_folders' => '',
								'blog_id' => 0,
								//'save_db' => '',
								'save_db_table_list' => FALSE,
								'backup_interval_type' => 0,
								'cron-specified_date' => '',
								'cron-periodically' => '12',
								'specified_date' => '',
								'max_archives' => '1',
								'destination' => '',
								'admin_box_color' => '',
							);
				if ($id){
					if ($no_defaults_return){
						unset($arr);
						$arr = array();
					}
					//query to get meta from wp_indeed_backup_metas
					global $wpdb;
					$t1_exists = $wpdb->get_results('SHOW TABLES LIKE "'.$wpdb->base_prefix.'indeed_backups";');
					$t2_exists = $wpdb->get_results('SHOW TABLES LIKE "'.$wpdb->base_prefix.'indeed_backup_metas";');
					if ($t1_exists && $t2_exists){
						$data = $wpdb->get_results("SELECT * FROM ".$wpdb->base_prefix."indeed_backups WHERE id=".$id.";");
						if ($data){
							foreach ($data as $obj){
								$arr['name'] = $obj->name;
								$arr['create_date'] = $obj->create_date;
							}
						}
						$data = $wpdb->get_results("SELECT * FROM ".$wpdb->base_prefix."indeed_backup_metas WHERE backup_id=".$id.";");
						if ($data){
							foreach ($data as $obj){
								$arr[$obj->meta_name] = $obj->meta_value;
							}
						}
					}
				}
				break;
			case 'destinations':
				
				$arr = array(
								'name' => '',
								'type' => '',
								'admin_box_color' => '',
								'connected' => 0,
								'status'=>'',
							);
				
				if ($id){
					if ($no_defaults_return){
						unset($arr);
						$arr = array();
					}
					//query to get meta from wp_indeed_backup_metas
					global $wpdb;
					$t1_exists = $wpdb->get_results('SHOW TABLES LIKE "'.$wpdb->base_prefix.'indeed_destinations";');
					$t2_exists = $wpdb->get_results('SHOW TABLES LIKE "'.$wpdb->base_prefix.'indeed_destination_metas";');
					if ($t1_exists && $t2_exists){
						$q = "SELECT * FROM ".$wpdb->base_prefix."indeed_destinations WHERE 1=1";
						$q .= " AND id=".$id." ";
						if ($status){
							$q .= " AND status='".$status."' ";
						}
						$q .= ";";
						$data = $wpdb->get_results($q);
						if ($data){
							foreach ($data as $obj){
								$arr['name'] = $obj->name;
								$arr['type'] = $obj->type;
								$arr['create_date'] = $obj->create_date;
								$arr['status'] = $obj->status;
							}
						}
						$data = $wpdb->get_results("SELECT * FROM ".$wpdb->base_prefix."indeed_destination_metas WHERE destination_id=".$id.";");
						if ($data){
							foreach ($data as $obj){
								$arr[$obj->meta_name] = $obj->meta_value;
							}
						}
					}
				}											
			break;
		}		
	}
	return $arr;
}

function ibk_get_general_metas(){
	$arr = array(
					'ibk_backup_dir' => 'isnapshots',
					'ibk_backup_files' => 0,
					'ibk_email_sent' => 1,			
					'ibk_email' => get_option('admin_email'),
					'ibk_email_sent_1' => 0,
					'ibk_email_sent_2' => 0,
					'ibk_email_sent_3' => 0,
					'ibk_memory_limit' => '',
					'ibk_db_segmentation' => ibk_segmentation_sugestion(),
					'ibk_global_debug_value' => 1,								
				);
	$data = get_option('ibk_general_metas');
	if ($data!==FALSE){
		foreach ($arr as $k=>$v){
			if (isset($data[$k])){
				$arr[$k] = $data[$k];
			}
		}
	} else {
		update_option('ibk_general_metas', $arr);
	}
	return $arr;
}

function ibk_save_general_metas($data){
	$arr = ibk_get_general_metas();
	
	//temp dir
	if (isset($data['ibk_backup_dir']) && isset($arr['ibk_backup_dir']) && ($data['ibk_backup_dir']!=$arr['ibk_backup_dir']) ){
		//remove old temp dir
		indeed_rmdir_recursive(IBK_UPLOADS_DIRECTORY . '/'. $arr['ibk_backup_dir']);
		//create new temp dir
		$dir = IBK_UPLOADS_DIRECTORY . '/'.$data['ibk_backup_dir'];
		if (!file_exists($dir)){
			@mkdir($dir, 0777, TRUE);
		}
	}
	
	//notifications
	if (isset($data['ibk_notification_time'])){
		$time = time();
		if ($data['ibk_notification_time']==-1){
			$time +=  360 * 24 * 60 * 60;
		} else {
			$time += $data['ibk_notification_time'];
		}
		
		update_option('ibk_dashboard_notification_time', $time);
		unset($data['ibk_notification_time']);
	}
	
	foreach ($arr as $k=>$v){
		if (isset($data[$k])){
			$arr[$k] = $data[$k];
		}
	}
	update_option('ibk_general_metas', $arr);
}

function indeed_rmdir_recursive($dir, $keep_base_dir=FALSE){
	foreach (scandir($dir) as $file) {
		if ('.' === $file || '..' === $file){
			continue;
		}
		if (is_dir("$dir/$file")){
			indeed_rmdir_recursive("$dir/$file");
		}
		else {
			unlink("$dir/$file");
		}
	}
	if (!$keep_base_dir){
		rmdir($dir);
	}
}

function ibk_get_destination_type($id){
	/*
	 * @param id of a backup item
	 * @return type of destination for current backup
	 */
	global $wpdb;
	if ($id){
		$data = $wpdb->get_results('SELECT type FROM '.$wpdb->base_prefix.'indeed_destinations WHERE id='.$id.'; ');
		if (!empty($data[0]->type)){
			return $data[0]->type;
		}		
	}
	return FALSE;
}

function ibk_get_destination_name($id){
	global $wpdb;
	$data = $wpdb->get_row('SELECT name FROM '.$wpdb->base_prefix.'indeed_destinations WHERE id='.$id.'; ');
	if (isset($data->name)){
		return $data->name;
	}
	return FALSE;
}


function indeed_set_cron_job($id, $target_time){
	/*
	 * set our main cron job
	 * @param id of backup item, target_time in hours
	 * @return none
	 */
	if (wp_next_scheduled('indeed_main_job', array($id) )){//check for prev cron schedule
		wp_clear_scheduled_hook( 'indeed_main_job', array($id) );//delete prev cron job
	}	
	wp_schedule_single_event( $target_time , 'indeed_main_job', array( $id ) );
}

function indeed_get_free_space_size(){
	/*
	 * @param none
	 * @return disk free space in MB
	 */
	return round(disk_free_space("/")/ 1024 / 1024);
}

function indeed_get_dir_size($path){
	$bytestotal = 0;
    $path = realpath($path);
    if($path!==false){
        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object){
            $bytestotal += $object->getSize();
        }
    }
    return $bytestotal;
}

function indeed_from_byte_to_mb_gb($num, $extra_divide=FALSE){
	$num = $num / 1024 / 1024;
	if ($extra_divide) $num = $num / $extra_divide;
	if ($num>1024){
		$num = $num / 1024;
		return round($num, 1) . ' GB';
	}
	return round($num, 1) . ' MB';
}
function indeed_from_byte_to_kb_mb_gb($num){
	$num = $num / 1024;
	if($num>1024){
		$num = $num / 1024;
		if ($num>1024){
			$num = $num / 1024;
			return round($num, 1) . ' GB';
		}
		return round($num, 1) . ' MB';
	}
	return round($num, 1) . ' Kb';
}


function ibk_formated_time_for_dashboard($date){
	/*
	 * @param target time as timestamp
	 * @return target time retunr as : last x minutes/hours/days ago
	 */
	$return = FALSE;
	$diff = (int)time() - (int)$date;
	if ($diff<3600){
		//minutes
		$return = round($diff/60);
		$return .= ' minutes';		
	} elseif($diff>(60*60) && $diff<(60*60*24)){
		//hours
		$return = round($diff/(60*60));
		$return .= ' hours';
	} else {
		//days
		$return = round($diff/(60*60*24));
		$return .= ' days';
	}
	return $return; 
}

function indeed_count_dir_subdirs($path){
	$count = 0;
	if ($handle = opendir($path)) {
		while (false !== ($entry = readdir($handle))) {
			if ($entry=='.' || $entry=='..')continue;
			if (is_dir($path.$entry)) $count++;
		}
	}
	return $count;
}

function ibk_get_complete_percetage_for_log($data){
	/*
	 * @param data object that holds current log
	 * @return complete percetage for current process
	 */
	$complete = 0;
	end($data);
	$last_key = key($data);
	@$log = $data[$last_key]->stage;
	if (!empty($log)){
		$percentage = 100;
		if (strpos($log, '-')!==FALSE){
			$log_arr = explode('-', $log);
			$percentage = $log_arr[1];
			$log = $log_arr[0];
		} 
		switch ($log){
			case 'start':
				$complete = 0 + (10*$percentage/100);
				break;
					
			case 'sql':
				$complete = 10 + (20*$percentage/100);
				break;
					
			case 'file':
				$complete = 30 + (20*$percentage/100);
				break;
				
			case 'zip':
				$complete = 50 + (30*$percentage/100);
				break;
					
			case 'sending_file':
				$complete = 80;
				break;
					
			case 'delete_zip':
				$complete = 99;
				break;
					
			case 'finish':
				$complete = 100;
				break;
		}
	}
	return $complete;
}

function ibk_return_destination_types(){
	$arr = array(
				'local' => 'Local',
				'ftp' => 'FTP',				
				'google' => 'Google Drive',	
				'dropbox' => 'DropBox',
				'rackspace' => 'RackSpace',
				'amazon' => 'Amazon',
				'onedrive' => 'OneDrive',
				'copy' => 'Copy',
				);
	return $arr;
}

function ibk_return_active_snapshots_nr(){
	global $wpdb;
	$data = $wpdb->get_row("SELECT COUNT(*) as c FROM ".$wpdb->base_prefix."indeed_backups;");
	if (isset($data->c)) return $data->c;
	return 0;
}

function indeed_delete_dir_recursive($dir){
	/*
	 * delete entire folder
	 * @param full path of dir
	 * @return none
	 */
	if (file_exists($dir)){
		foreach (scandir($dir) as $file) {
			if ('.' === $file || '..' === $file){
				continue;
			}
			if (is_dir("$dir/$file")){
				indeed_delete_dir_recursive("$dir/$file");
			}
			else {
				unlink("$dir/$file");
			}
		}
		rmdir($dir);
	}
}
function ibk_checkCron() {
		global $wp_version;

		if ( defined( 'DISABLE_WP_CRON' ) && DISABLE_WP_CRON ) {
			return __( 'The DISABLE_WP_CRON constant is set to true. WP-Cron spawning is disabled.', 'ibk' ) ;
		}
		if ( defined( 'ALTERNATE_WP_CRON' ) && ALTERNATE_WP_CRON ) {
			return true;
		}

		$cached_status = get_transient( 'wp-cron-test-ok' );
		if ($cached_status ) {
			return true;
		}

		$sslverify     = version_compare( $wp_version, 4.0, '<' );
		$doing_wp_cron = sprintf( '%.22F', microtime( true ) );

		$cron_request = apply_filters( 'cron_request', array(
			'url'  => site_url( 'wp-cron.php?doing_wp_cron=' . $doing_wp_cron ),
			'key'  => $doing_wp_cron,
			'args' => array(
				'timeout'   => 3,
				'blocking'  => true,
				'sslverify' => apply_filters( 'https_local_ssl_verify', $sslverify ),
			),
		) );

		$cron_request['args']['blocking'] = true;

		$result = wp_remote_post( $cron_request['url'], $cron_request['args'] );

		if ( is_wp_error( $result ) ) {
			return $result;
		} else if ( wp_remote_retrieve_response_code( $result ) >= 300 ) {
			return __( 'Unexpected HTTP response code:'.wp_remote_retrieve_response_code( $result ).'', 'ibk' );
		} else {
			set_transient( 'wp-cron-test-ok', 1, 3600 );
			return true;
		}

}
function indeed_get_cron_list() {

		$crons  = _get_cron_array();
		$events = array();

		if ( empty( $crons ) ) {
			return new WP_Error(
				'no_events',
				__( 'You currently have no scheduled cron events.', 'wp-crontrol' )
			);
		}

		foreach ( $crons as $time => $cron ) {
			foreach ( $cron as $hook => $dings ) {
				foreach ( $dings as $sig => $data ) {

					# This is a prime candidate for a Crontrol_Event class but I'm not bothering currently.
					$events[ "$hook-$sig-$time" ] = (object) array(
						'hook'     => $hook,
						'time'     => $time,
						'sig'      => $sig,
						'args'     => $data['args'],
						'schedule' => $data['schedule'],
						'interval' => isset( $data['interval'] ) ? $data['interval'] : null,
					);

				}
			}
		}

		return $events;

}
function ibk_timeFormat($diff){
	/*
	 * @param target time as timestamp
	 * @return target time retunr as : last x minutes/hours/days ago
	 */
	if ($diff<3600){
		//minutes
		$return = round($diff/60);
		if($return > 1) $return .= ' minutes';
		else $return .= ' minute';	
	} elseif($diff>(60*60) && $diff<(60*60*24)){
		//hours
		$return = round($diff/(60*60));
		if($return > 1) $return .= ' hours';
		else $return .= ' hour';
	} else {
		//days
		$return = round($diff/(60*60*24));
		
		if($return > 1) $return .= ' days';
		else $return .= ' day';
	}
	return $return; 
}
function ibk_nextTimerun($date){
	/*
	 * @param target time as timestamp
	 * @return target time retunr as : last x minutes/hours/days ago
	 */
	$return = FALSE;
	$diff =(int)$date -  (int)time();
	if ($diff<3600){
		//minutes
		$return = round($diff/60);
		$return .= ' minutes';		
	} elseif($diff>(60*60) && $diff<(60*60*24)){
		//hours
		$return = round($diff/(60*60));
		$return .= ' hours';
	} else {
		//days
		$return = round($diff/(60*60*24));
		$return .= ' days';
	}
	return $return; 
}
function ibk_runCron( $hookname, $sig ) {
		$crons = _get_cron_array();
		foreach ( $crons as $time => $cron ) {
			if ( isset( $cron[ $hookname ][ $sig ] ) ) {
				$args = $cron[ $hookname ][ $sig ]['args'];
				delete_transient( 'doing_cron' );
				wp_schedule_single_event( time() - 1, $hookname, $args );
				spawn_cron();
				return true;
			}
		}
		return false;
}
function ibk_deleteCron( $hookname, $sig, $next_run ) {
		$crons = _get_cron_array();
		if ( isset( $crons[ $next_run ][ $hookname ][ $sig ] ) ) {
			$args = $crons[ $next_run ][ $hookname ][ $sig ]['args'];
			wp_unschedule_event( $next_run, $hookname, $args );
			return true;
		}
		return false;
}
function ibk_getFolders($path){
		echo '<h4>'.str_replace(WP_CONTENT_DIR.'/', "", $path).'</h4>';
		echo '<ul class="ibk_system_dir">';
				$total = ibk_getFolderlist($path);			
		echo '</ul>';
				echo '<div class = "ibk_system_folderSize"> Total: '.indeed_from_byte_to_kb_mb_gb($total).'</div>';
}	
function ibk_getFolderlist($path) {
	$total_size = 0;
	$size = 0 ;	
    $files = scandir($path);
    $cleanPath = rtrim($path, '/'). '/';
    foreach($files as $t) {
        if ($t<>"." && $t<>"..") {
            $currentFile = $cleanPath . $t;
            if (is_dir($currentFile)) {	
				echo '<li><span   class="ibk_system_subdir_name">'.str_replace($path.'/', "", $currentFile).'</span><ul class="ibk_system_subdir">';
                
				$size = ibk_getFolderlist($currentFile);
               $total_size += $size;
				echo '<span class="ibk_system_folder_size"> "'.str_replace($path.'/', "", $currentFile).'" size: '.indeed_from_byte_to_kb_mb_gb($size).'</span>';
				echo '</ul></li>';
            }
            else {
                $size = filesize($currentFile);
                $total_size += $size;
				
				echo '<li  class="ibk_system_files">'.str_replace($path.'/', "", $currentFile).' : <span class="ibk_system_filezie">'.indeed_from_byte_to_kb_mb_gb($size).'</span></li>';
            }
        }   
    }
    return $total_size;
}

function ibk_debug($str='', $priority=0){
	/*
	 * @param string to write into file, priority (int)
	 * @return none
	 */
	try {	
		if ($priority){
			//test if must do insert 
			$value = get_option('ibk_general_metas');
			if (isset($value['ibk_global_debug_value'])){
				if ($value['ibk_global_debug_value']-1<$priority){
					return;
				}
			}
		}	
		$file = IBK_UPLOADS_DIRECTORY . '/indeed-backups/ibk_global_log.log';//full path
		$file_handler = @fopen($file, 'a');
		if ($file_handler && is_resource($file_handler)){
			$data = date("Y-m-d h:i:s", time()) . ": (". round(@memory_get_usage(false)/1048576, 1) ."Mb) " . $str . "\n";
			fwrite($file_handler, $data);
			fclose($file_handler);
		}
		unset($file);
		unset($file_handler);
		unset($str);
		unset($priority);
	} catch (Exception $e){}
}

function ihc_print_global_log(){
	/*
	 * @param none
	 * @return string with global log content
	 */
	$str = '';
	$file = IBK_UPLOADS_DIRECTORY . '/indeed-backups/ibk_global_log.log';//full path
	if (file_exists($file)){
		$file_handler = @fopen($file, 'r');
		if ($file_handler && is_resource($file_handler)){		
			while (($chunk = fgets($file_handler, 4096)) !== false) {
				$str .= $chunk;
			}
		}		
	}
	return nl2br($str);
}

function ibk_get_min_space_needed(){
	/*
	 * @param none
	 * @return float
	 */
	$sum = 0;
	//files
	$sum += indeed_get_dir_size(IBK_THEMES_DIRECTORY);
	$sum += indeed_get_dir_size(WP_PLUGIN_DIR);
	$sum += indeed_get_dir_size(IBK_UPLOADS_DIRECTORY);
	//db
	global $wpdb;
	$q = "SELECT table_name,table_rows,data_length,index_length,engine FROM information_schema.tables
	WHERE table_schema = '". DB_NAME ."'";
	$data = $wpdb->get_results($q);
	if (isset($data) && count($data)>0){
		foreach($data as $k=>$table){
			$sum += $table->data_length + $table->index_length;
		}
	}
	return $sum;
}
function ibk_check_dir_permission($dir=''){
	/*
	 * @param string
	 * @return int, 0 if not available for write
	 */
	if (file_exists($dir)){
		$perm = substr(decoct(fileperms($dir)), -3);
		if ($perm>=755){
			return $perm;
		}
	}
	return 0;
}

function ibk_check_dir_if_writable($dir=''){
	/*
	 * @param string
	 * @return bool true if ok
	 */
	if (!file_exists($dir)){
		@mkdir($dir, 0777, TRUE);
	}
	if (@is_writable($dir)){
		$file = $dir . "/" . md5(rand()) . ".txt";
		while (file_exists($file)) {
			$file = $dir . "/" . md5(rand()) . ".txt";
		}
		$writed = @file_put_contents($file, 'Hello World');
		if ($writed){
			@unlink($file);
			return TRUE;
		}
	}
	return FALSE;
}

function ibk_get_total_entries(){
	/*
	 * @param none
	 * @return float
	 */
	global $wpdb;
	$tables = ibk_get_table_list('all');
	$total_entries = 0;
	foreach ($tables as $k=>$v){
		$data = $wpdb->get_results("SELECT COUNT(*) as c FROM " . $v . ";");
		if (isset($data[0]->c)){
			$total_entries += $data[0]->c;
		}
	}
	return $total_entries;
}

function ibk_segmentation_sugestion($entries=0){
	/*
	 * @param float
	 * @return int
	 */
	if (empty($entries)){
		$entries = ibk_get_total_entries();
	}
	$entries = (float)$entries;
	switch ($entries){
		case ($entries>=1000000):
			return 5000;
			break;
		case ($entries>=500000 && $entries<1000000):
			return 3000;
			break;
		case ($entries>=200000 && $entries<500000):
			return 2000;
			break;
		case ($entries>=100000 && $entries<200000):
			return 1000;
			break;	
		case ($entries>=10000 && $entries<100000):
			return 500;
			break;
		case ($entries>=5000 && $entries<10000):
			return 200;
			break;
		case ($entries<5000):
		default: 
			return 100;
			break;
	}
	return 200;
}

function ibk_get_local_storage_destination_dirs(){
	/*
	 * @param none
	 * @return array
	 */	
	$return = array();
	global $wpdb;
	$data = $wpdb->get_results("SELECT meta_value FROM " . $wpdb->base_prefix . "indeed_destination_metas WHERE meta_name='local_folder_target';");
	if ($data){
		foreach ($data as $obj){
			$return[] = $obj->meta_value;
		}
	}
	return $return;
}

function ibk_get_single_download_link($backup_id, $destination_id){
	/*
	 * @param int, int
	 * @return string 
	 */	
	$destination_type = ibk_get_destination_type($destination_id);
	switch ($destination_type){
		case 'google':
			if (!class_exists('IndeedGoogle')){
				require_once IBK_PATH . 'classes/API/IndeedGoogle.class.php';
			}
			$goo = new IndeedGoogle($destination_id);
			$goo->login();
			
			$arr = ibk_get_google_files_for_backup_destination_id($goo, $backup_id);
			if (count($arr)==1){
				$file_id = $arr[key($arr)]['fileId'];
				return $goo->get_file_url($file_id);
			} else {
				return '';
			}			
			break;
			
		case 'local':
			$arr = ibk_return_local_files_for_destination_backup($destination_id, $backup_id);
			if (count($arr)==1){
				$path = $arr[key($arr)];
				return ibk_make_url_for_local_snapshot($path);
			} else {
				return '';
			}
			break;
			
		case 'ftp':
			if (!class_exists('IndeedFtp')){
				require_once IBK_PATH . 'classes/API/IndeedFtp.class.php';
			}			
			$ftp = new IndeedFtp($destination_id);//destination id
			$ftp->login();
			$arr = $ftp->list_snapshots($backup_id);//snapshot id
			if (count($arr)==1){
				$path = $arr[key($arr)];
				return ibk_return_ftp_link_to_file($destination_id, $path);
			} else {
				return '';
			}			
			break;
			
		case 'dropbox':
			if (!class_exists('IndeedDropbox')){
				require_once IBK_PATH . 'classes/API/IndeedDropbox.class.php';
			}
			$obj = new IndeedDropbox($destination_id);
			$obj->login();
			$arr = ibk_return_dropbox_files_arr_for_backup_id($obj, $backup_id);
			if (count($arr)==1){
				$path = $arr[key($arr)];
				return $obj->get_url_for_file($path);
			} else {
				return '';
			}			
			break;
			
		case 'amazon':
			if (!class_exists('IndeedAmazonS3')){
				require_once IBK_PATH . 'classes/API/IndeedAmazonS3.class.php';
			}
			$obj = new IndeedAmazonS3($destination_id);
			$arr = ibk_return_amazon_files_arr_for_backup_id($obj, $backup_id);
			if (count($arr)==1){
				$path = $arr[key($arr)];
				return $obj->get_url_for_file($path);				
			} else {
				return '';
			}
			break;
		case 'onedrive':
			if (!class_exists('IndeedOneDrive')){
				require_once IBK_PATH . 'classes/API/IndeedOneDrive.class.php';				
			}			
			$obj = new IndeedOneDrive($destination_id);
			$arr = ibk_return_onedrive_files_for_backup_id($obj, $backup_id);
			if (count($arr)==1){
				$path = $arr[key($arr)];
				return $obj->get_url_for_file($path);
			} else {
				return '';
			}			
			break;
		case 'copy':
			if (!class_exists('IndeedOneDrive')){
				require_once IBK_PATH . 'classes/API/IndeedCopyDotCom.class.php';
				$obj = new IndeedCopyDotCom($destination_id);
				$obj->login();
				$arr = ibk_return_copydotcom_files_for_backup_id($obj, $backup_id);
				if (count($arr)==1){
					$path = $arr[key($arr)];
					return $obj->get_download_link($path);
				} else {
					return '';
				}
			}
			break;
	}
}

function ibk_get_google_files_for_backup_destination_id($obj, $backup_id){
	/*
	 * @param obj, int
	 * @return array
	 */
	$return = array();
	$data = $obj->retrieveAllFiles();	
	foreach ($data as $file_obj){
		if (preg_match("#^superbackup(.*)$#i", $file_obj->title)){
			//it contains indeed
			$is_zip_data = explode('.', $file_obj->title);
			if (isset($is_zip_data[1]) && $is_zip_data[1]=='zip'){
				//it's a zip file
				$file_name_data = explode('_', $is_zip_data[0]);
				if ($file_name_data[2]==$backup_id && $file_name_data[1]==md5('superbackup_indeed') ){
					//it's a instance of our snapshot
					$return[$file_name_data[3]]['fileId'] = $file_obj->id;
					$return[$file_name_data[3]]['title'] = $file_obj->title;
				}
			}
		}
	}	
	return $return;
}

function ibk_return_dropbox_files_arr_for_backup_id($obj, $backup_id){
	/*
	 * @param object, int
	 * @return array
	 */
	$return_arr = array();
	$data = $obj->get_files();
	foreach ($data as $file){
		if (preg_match("#superbackup(.*)$#i", $file)){
			//it contains indeed
			$is_zip_data = explode('.', basename($file));
			if (isset($is_zip_data[1]) && $is_zip_data[1]=='zip'){
				//it's a zip file
				$file_name_data = explode('_', $is_zip_data[0]);
				if ($file_name_data[2]==$backup_id && $file_name_data[1]==md5('superbackup_indeed') ){
					$return_arr[$file_name_data[3]]	= $file;//it's a instance of our snapshot
				}
			}
		}
	}
	return $return_arr;
}

function ibk_return_amazon_files_arr_for_backup_id($obj, $backup_id){
	/*
	 * @param object, int
	 * @return array;
	 */
	$return_arr = array();
	$data = $obj->get_files_list();
	foreach ($data as $file){
		if (preg_match("#superbackup(.*)$#i", $file)){
			//it contains indeed
			$is_zip_data = explode('.', basename($file));
			if (isset($is_zip_data[1]) && $is_zip_data[1]=='zip'){
				//it's a zip file
				$file_name_data = explode('_', $is_zip_data[0]);
				if ($file_name_data[2]==$backup_id && $file_name_data[1]==md5('superbackup_indeed') ){
					//it's a instance of our snapshot
					$return_arr[$file_name_data[3]]	= $file;
				}
			}
		}
	}
	return $return_arr;
}

function ibk_return_onedrive_files_for_backup_id($obj, $backup_id){
	/*
	 * @param object, int
	 * @return array;
	 */
	$return_arr = array();
	$data = $obj->return_all_files();
	foreach ($data as $file_data){
		$file = $file_data['name'];
		if (preg_match("#superbackup(.*)$#i", $file)){
			//it contains indeed
			$is_zip_data = explode('.', basename($file));
			if (isset($is_zip_data[1]) && $is_zip_data[1]=='zip'){
				//it's a zip file
				$file_name_data = explode('_', $is_zip_data[0]);
				if ($file_name_data[2]==$backup_id && $file_name_data[1]==md5('superbackup_indeed') ){
					//it's a instance of our snapshot
					$return_arr[$file_name_data[3]]	= $file;
				}
			}
		}
	}
	return $return_arr;
}

function ibk_return_copydotcom_files_for_backup_id($obj, $backup_id){
	/*
	 * @param object, int
	 * @return array;
	 */
	$return_arr = array();
	$data = $obj->get_all_files();
	foreach ($data as $file){
		if (preg_match("#superbackup(.*)$#i", $file)){
			//it contains indeed
			$is_zip_data = explode('.', basename($file));
			if (isset($is_zip_data[1]) && $is_zip_data[1]=='zip'){
				//it's a zip file
				$file_name_data = explode('_', $is_zip_data[0]);
				if ($file_name_data[2]==$backup_id && $file_name_data[1]==md5('superbackup_indeed') ){
					//it's a instance of our snapshot
					$return_arr[$file_name_data[3]]	= $file;
				}
			}
		}
	}
	return $return_arr;	
}

function ibk_return_ftp_link_to_file($destination_id, $path){
	/*
	 * @param int, string
	 * @return string
	 */
	$destination_metas = ibk_return_metas_from_custom_db('destinations', $destination_id);
	if (!empty($destination_metas['username']) && !empty($destination_metas['password']) && !empty($destination_metas['server_address'])){
		return "ftp://" . urldecode($destination_metas['username']) . ":".$destination_metas['password']."@".$destination_metas['server_address'].":21" . $path;
	}
	return '';	
}

function ibk_return_local_files_for_destination_backup($destination_id, $backup_id){
	/*
	 * @param int, int
	 * @return array
	 */
	$return = array();
	$destination_metas = ibk_return_metas_from_custom_db('destinations', $destination_id); 
	$source_dir = $destination_metas['local_folder_target'];
	$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source_dir), RecursiveIteratorIterator::SELF_FIRST);
	foreach ($files as $file){
		$file = str_replace('\\', '/', $file);
		$file_h = basename($file);
		if (preg_match("#^superbackup(.*)$#i", $file_h)){
			//it contains indeed
			$is_zip_data = explode('.', $file_h);
			if (isset($is_zip_data[1]) && $is_zip_data[1]=='zip'){
				//it's a zip file
				$file_name_data = explode('_', $is_zip_data[0]);
	
				if ($file_name_data[2]==$backup_id && $file_name_data[1]==md5('superbackup_indeed') ){
					//it's a instance of our snapshot
					$return[$file_name_data[3]]	= $file;
				}
			}
		}
	}
	return $return;
}

function ibk_make_url_for_local_snapshot($str){
	/*
	 * from local path to url
	 * @param string
	 * @return string
	 */
	if (strpos($str, WP_CONTENT_DIR)!==FALSE){
		$data = explode(WP_CONTENT_DIR, $str);
		if (!empty($data[1])){
			if (is_multisite()){
				$base = network_site_url() . 'wp-content';
			} else {
				$base = get_option('siteurl') . '/wp-content';
			}
			return $base . $data[1];
		}
	}
}

function ibk_get_last_destination_instance($type = 'onedrive'){
	/*
	 * @param string (onedrive || copy)
	 * @return int ( id of one drive last instance )
	 */
	global $wpdb;
	$data = $wpdb->get_results("SELECT id FROM " . $wpdb->base_prefix . "indeed_destinations WHERE type='" . $type . "' ORDER BY create_date DESC LIMIT 1;");
	if (!empty($data[0]) && !empty($data[0]->id)){
		return $data[0]->id;
	}
	return 0;//nothing found
}