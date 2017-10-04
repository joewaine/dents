<?php
class PO_Ajax {
	var $PO;
	function __construct($PO) {
		$this->PO = $PO;
	}

	function save_order() {
		if ( !$this->PO->verify_nonce($_POST['PO_nonce'])) {
			print "You dont have permissions to access this page.";
			die();
		}
		$returnStatus = "";
		if ( current_user_can( 'activate_plugins' ) ) {
			$plugins = $this->PO->get_active_plugins();
			if (preg_match("/^(([0-9])+[,]*)*$/", implode(",", $_POST['orderList'])) && preg_match("/^(([0-9])+[,]*)*$/", implode(",", $_POST['startOrder']))) {
				$newPlugArray = $_POST['orderList'];
				$startOrderArray = $_POST['startOrder'];
				if (sizeof(array_unique($newPlugArray)) == sizeof($plugins) && sizeof(array_unique($startOrderArray)) == sizeof($plugins)) {
					array_multisort($startOrderArray, $newPlugArray);
					array_multisort($newPlugArray, $plugins);
					update_option("active_plugins", $plugins);
					update_option("PO_plugin_order", $plugins);
					$returnStatus = "The plugin load order has been changed.";
				} else {
					$returnStatus = "The order values were not unique so no changes were made.";
				}
			} else {
				$returnStatus = "Did not recieve the proper variables.  No changes made.";
			}
		} else {
			$returnStatus = "You dont have permissions to access this page.";
		}
		print $returnStatus;
		die();
	}



	function create_group() {
		if ( !$this->PO->verify_nonce($_POST['PO_nonce']) || !current_user_can('activate_plugins')) {
			print "You dont have permissions to access this page.";
			die();
		}
		$returnStatus = "";
		$plugins = $this->PO->get_active_plugins();
		if (is_array($_POST['PO_group_list']) && $this->PO->validate_field('PO_group_name')) {
			$groupID = wp_insert_post(array('post_title'=>$_POST['PO_group_name'], 'post_type'=>'plugin_group', 'post_status'=>'publish'));
			if (!is_wp_error($groupID)) {
				update_post_meta($groupID, '_PO_group_members', $_POST['PO_group_list']);
				$returnStatus = "The " . get_the_title($groupID) . " group was created and the selected plugins have been added to it.<br />";
			} else {
				$returnStatus = "There was a problem creating the group.<br />";
			}
			
		} else {
			$returnStatus = "Did not recieve the proper variables.  No changes made.<br />";
		}
		print $returnStatus;
		die();
	}


	function delete_group() {
		if ( !$this->PO->verify_nonce($_POST['PO_nonce']) || !current_user_can('activate_plugins')) {
			print "You dont have permissions to access this page.";
			die();
		}
		$returnStatus = "";
		if (is_array($_POST['PO_group_ids'])) {
			foreach($_POST['PO_group_ids'] as $groupID) {
				if (is_numeric($groupID)) {
					$groupName = get_the_title($groupID);
					$result = wp_delete_post($groupID, true);
					if ($result) {
						$returnStatus .= "The " . $groupName . " plugin group has been deleted.<br />";
					} else {
						$returnStatus .= "There was a problem deleting the " . $groupName . " plugin group.<br />";
					}
				}
			}
		}
		print $returnStatus;
		die();
	}

	function remove_plugins_from_group() {
		if ( !$this->PO->verify_nonce($_POST['PO_nonce']) || !current_user_can('activate_plugins')) {
			print "You dont have permissions to access this page.";
			die();
		}
		$returnStatus = "";
		if (is_array($_POST['PO_group_ids']) && is_array($_POST['PO_group_list'])) {
			foreach($_POST['PO_group_ids'] as $groupID) {
				if (is_numeric($groupID)) {
					$members = get_post_meta($groupID, '_PO_group_members', $single=true);
					if (!is_array($members)) {
						$members = array();
					}
					foreach($_POST['PO_group_list'] as $key=>$pluginToRemove) {
						if (array_search($pluginToRemove, $members) !== FALSE) {
							unset($members[array_search($pluginToRemove, $members)]);
						}
					}
					$members = array_values($members);
					if ($members === get_post_meta($groupID, '_PO_group_members', $single=true)) {
						$returnStatus .= "The selected plugins were not found in the " . get_the_title($groupID) . " group.<br />";
					} else {
						$result = update_post_meta($groupID, "_PO_group_members", $members);
						if ($result) {
							$returnStatus .= "The selected plugins were removed from the " . get_the_title($groupID) . " group.<br />";
						} else {
							$returnStatus .= "There was a problem removing the plugins from the " . get_the_title($groupID) . " group.<br />";
						}
					}
				}
			}
		}
		print $returnStatus;
		die();

	}

	function add_to_group() {
		if ( !$this->PO->verify_nonce($_POST['PO_nonce']) || !current_user_can('activate_plugins')) {
			print "You dont have permissions to access this page.";
			die();
		}
		$returnStatus = "";
		$plugins = $this->PO->get_active_plugins();
		if (is_array($_POST['PO_group_list']) && is_array($_POST['PO_group_ids'])) {
			foreach($_POST['PO_group_ids'] as $groupID) {
				if (is_numeric($groupID)) {
					$members = get_post_meta($groupID, '_PO_group_members', $single=true);
					$members = stripslashes_deep($members);
					if (!is_array($members)) {
						$members = array();
					}
					
					foreach($_POST['PO_group_list'] as $newGroupMember) {
						#print $newGroupMember . " - " . array_search($newGroupMember, $members) . "\n";
						if (array_search($newGroupMember, $members) === FALSE) {
							$members[]=$newGroupMember;
						}
					}
					if ($members === get_post_meta($groupID, '_PO_group_members', $single=true)) {
						$returnStatus .= "The selected plugins were not added to the " . get_the_title($groupID) . " group because they already belong to it.<br />";
					} else {
						update_post_meta($groupID, "_PO_group_members", $members);
						$returnStatus .= "The selected plugins were added to the " . get_the_title($groupID) . " group.<br />";
					}
				}
			}
		} else {
			$returnStatus = "Did not recieve the proper variables.  No changes made.";
		}
		print $returnStatus;
		die();
	}

	function edit_plugin_group_name() {
		if ( !$this->PO->verify_nonce($_POST['PO_nonce']) || !current_user_can( 'activate_plugins' ) ) {
			print "You dont have permissions to access this page.";
			die();
		}
		$returnStatus = "";
		if (is_numeric($_POST['PO_group_id']) && $this->PO->validate_field('PO_group_name')) {
			$oldGroupTitle = get_the_title($_POST['PO_group_id']);
			$post_id = wp_update_post(array('ID'=>$_POST['PO_group_id'], 'post_title'=>$_POST['PO_group_name']));
			if ($post_id > 0) {
				$newGroupTitle = get_the_title($_POST['PO_group_id']);
				$returnStatus = "The " . $oldGroupTitle . " group was successfully changed to " . $newGroupTitle . ".<br />";
			} else {
				$returnStatus = "There was an error and the " . $oldGroupTitle . " group was not changed.<br />";
			}
		} else {
			$returnStatus = "No changes were made because the correct variables were not received.<br />";
		}
		print $returnStatus;
		die();
	}

	function save_global_plugins() {
		global $wpdb;
		if ( !$this->PO->verify_nonce($_POST['PO_nonce'])) {
			print "You dont have permissions to access this page.";
			die();
		}
		$returnStatus = "";
		if ( current_user_can( 'activate_plugins' ) ) {
			if (isset($_POST['PO_disabled_std_plugin_list']) && is_array($_POST['PO_disabled_std_plugin_list']) && $_POST['PO_disabled_std_plugin_list'][0] != 'EMPTY') {
				$disabledPlugins = $_POST['PO_disabled_std_plugin_list'];
			} else {
				$disabledPlugins = array();
			}
			
			if (isset($_POST['PO_disabled_std_group_list']) && is_array($_POST['PO_disabled_std_group_list']) && $_POST['PO_disabled_std_group_list'][0] != 'EMPTY') {
				$disabledGroups = $_POST['PO_disabled_std_group_list'];
			} else {
				$disabledGroups = array();
			}
			
			if (get_option('PO_disable_mobile_plugins') == 1) {
				if (isset($_POST['PO_disabled_mobile_plugin_list']) && is_array($_POST['PO_disabled_mobile_plugin_list']) && $_POST['PO_disabled_mobile_plugin_list'][0] != 'EMPTY') {
					$disabledMobilePlugins = $_POST['PO_disabled_mobile_plugin_list'];
				} else {
					$disabledMobilePlugins = array();
				}

				if (isset($_POST['PO_disabled_mobile_group_list']) && is_array($_POST['PO_disabled_mobile_group_list']) && $_POST['PO_disabled_mobile_group_list'][0] != 'EMPTY') {
					$disabledMobileGroups = $_POST['PO_disabled_mobile_group_list'];
				} else {
					$disabledMobileGroups = array();
				}
			} else {
				$disabledMobilePlugins = array();
				$disabledMobileGroups = array();
			}

			$globalPluginsExist = ($wpdb->get_var("SELECT count(*) FROM ".$wpdb->prefix."po_plugins WHERE post_type='global_plugin_lists' AND post_id=0") > 0) ? 1 : 0;
		
			if ($globalPluginsExist == 1) {
				$result = $wpdb->update($wpdb->prefix."po_plugins", array("enabled_plugins"=>serialize(array()), "disabled_plugins"=>serialize($disabledPlugins), "enabled_mobile_plugins"=>serialize(array()), "disabled_mobile_plugins"=>serialize($disabledMobilePlugins), "enabled_groups"=>serialize(array()), "disabled_groups"=>serialize($disabledGroups), "enabled_mobile_groups"=>serialize(array()), "disabled_mobile_groups"=>serialize($disabledMobileGroups)), array("post_type"=>"global_plugin_lists", "post_id"=>0));
			} else {
				$result = $wpdb->insert($wpdb->prefix."po_plugins", array("post_id"=>0, "enabled_plugins"=>serialize(array()), "disabled_plugins"=>serialize($disabledPlugins), "enabled_mobile_plugins"=>serialize(array()), "disabled_mobile_plugins"=>serialize($disabledMobilePlugins), "enabled_groups"=>serialize(array()), "disabled_groups"=>serialize($disabledGroups), "enabled_mobile_groups"=>serialize(array()), "disabled_mobile_groups"=>serialize($disabledMobileGroups), "post_type"=>"global_plugin_lists"));
			}

			if ($result === false) {
				$returnStatus .= "There was an error saving the global plugin lists.";
			} else {
				$returnStatus .= "Global plugins successfully saved.";
			}
		} else {
			$returnStatus .= "You dont have permissions to access this page.<br />";
		}
		print $returnStatus;
		die();
	}

	function save_search_plugins() {
		global $wpdb;
		if ( !$this->PO->verify_nonce($_POST['PO_nonce'])) {
			print "You dont have permissions to access this page.";
			die();
		}
		
		$availableRoles = $this->PO->get_available_roles();
		
		foreach($availableRoles as $roleID=>$roleName) {
			
			$submittedPlugins = $this->PO->get_submitted_plugin_lists($roleID);
		
			$searchPluginsExist = ($wpdb->get_var($wpdb->prepare("SELECT count(*) FROM ".$wpdb->prefix."po_plugins WHERE post_type='search_plugin_lists' AND post_id=0 AND user_role=%s", $roleID)) > 0) ? 1 : 0;
		
			if ($searchPluginsExist == 1) {
				$wpdb->update($wpdb->prefix."po_plugins", array("enabled_plugins"=>serialize($submittedPlugins[1]), "disabled_plugins"=>serialize($submittedPlugins[0]), "enabled_mobile_plugins"=>serialize($submittedPlugins[3]), "disabled_mobile_plugins"=>serialize($submittedPlugins[2]), "enabled_groups"=>serialize($submittedPlugins[5]), "disabled_groups"=>serialize($submittedPlugins[4]), "enabled_mobile_groups"=>serialize($submittedPlugins[7]), "disabled_mobile_groups"=>serialize($submittedPlugins[6])), array("post_type"=>"search_plugin_lists", "post_id"=>0, "user_role"=>$roleID));
			} else {
				$wpdb->insert($wpdb->prefix."po_plugins", array("post_id"=>0, "enabled_plugins"=>serialize($submittedPlugins[1]), "disabled_plugins"=>serialize($submittedPlugins[0]), "enabled_mobile_plugins"=>serialize($submittedPlugins[3]), "disabled_mobile_plugins"=>serialize($submittedPlugins[2]), "enabled_groups"=>serialize($submittedPlugins[5]), "disabled_groups"=>serialize($submittedPlugins[4]), "enabled_mobile_groups"=>serialize($submittedPlugins[7]), "disabled_mobile_groups"=>serialize($submittedPlugins[6]), "post_type"=>"search_plugin_lists", "user_role"=>$roleID));
			}
		}
		
		print "Search plugins updated!";
		die();
	}

	function save_pt_plugins() {
		global $wpdb;
		$availableRoles = $this->PO->get_available_roles();
			
		$returnVals = array('success'=>0, 'msg'=>'', 'total'=>0, 'offset'=>0);
		if ( !$this->PO->verify_nonce($_POST['PO_nonce'])) {
			$returnVals['msg'] = "You dont have permissions to access this page.";
			print json_encode($returnVals);
			die();
		}

		if (isset($_POST['selectedPostType']) && $_POST['selectedPostType'] != '') {
			$postType = $_POST['selectedPostType'];
		} else {
			$returnVals['msg'] = "Plugins were not updated because no post type was recieved!";
			print json_encode($returnVals);
			die();
		}

		$supportedPostTypes = get_option("PO_custom_post_type_support");
		if (!is_array($supportedPostTypes)) {
			$supportedPostTypes = array();
		}
		
		if (is_numeric($_POST['PO_post_offset'])) {
			$returnVals['offset'] = $_POST['PO_post_offset'];
		} else {
			$returnVals['msg'] = "Plugins were not updated because there was a problem calculating the number of posts to update.";
			print json_encode($returnVals);
			die();
		}
		
		if (!in_array($postType, $supportedPostTypes)) {
			$returnVals['msg'] = "Plugins were not updated because you have not selected this post type on the settings page.";
			print json_encode($returnVals);
			die();
		}
		
		$submittedPlugins = array();
		
		
		
		if ($returnVals['offset'] == 0) {
			foreach($availableRoles as $roleID=>$roleName) {
				$postTypeExists = ($wpdb->get_var($wpdb->prepare("SELECT count(*) FROM ".$wpdb->prefix."po_plugins WHERE post_type=%s AND post_id=0 AND user_role=%s", "pt_".$postType."_plugin_lists", $roleID)) > 0) ? 1 : 0;

				$submittedPlugins[$roleID] = $this->PO->get_submitted_plugin_lists($roleID);
				
				if ($postTypeExists == 1) {
					$wpdb->update($wpdb->prefix."po_plugins", array("enabled_plugins"=>serialize($submittedPlugins[$roleID][1]), "disabled_plugins"=>serialize($submittedPlugins[$roleID][0]), "enabled_mobile_plugins"=>serialize($submittedPlugins[$roleID][3]), "disabled_mobile_plugins"=>serialize($submittedPlugins[$roleID][2]), "enabled_groups"=>serialize($submittedPlugins[$roleID][5]), "disabled_groups"=>serialize($submittedPlugins[$roleID][4]), "enabled_mobile_groups"=>serialize($submittedPlugins[$roleID][7]), "disabled_mobile_groups"=>serialize($submittedPlugins[$roleID][6])), array("post_type"=>"pt_".$postType."_plugin_lists", "post_id"=>0, "user_role"=>$roleID));
				} else {
					$wpdb->insert($wpdb->prefix."po_plugins", array("post_id"=>0, "enabled_plugins"=>serialize($submittedPlugins[$roleID][1]), "disabled_plugins"=>serialize($submittedPlugins[$roleID][0]), "enabled_mobile_plugins"=>serialize($submittedPlugins[$roleID][3]), "disabled_mobile_plugins"=>serialize($submittedPlugins[$roleID][2]), "enabled_groups"=>serialize($submittedPlugins[$roleID][5]), "disabled_groups"=>serialize($submittedPlugins[$roleID][4]), "enabled_mobile_groups"=>serialize($submittedPlugins[$roleID][7]), "disabled_mobile_groups"=>serialize($submittedPlugins[$roleID][6]), "post_type"=>"pt_".$postType."_plugin_lists", "user_role"=>$roleID));
				}
			}

				
			$ptStored = get_option('PO_pt_stored');
			if (!is_array($ptStored)) {
				$ptStored = array();
			}
			
			if (!in_array($postType, $ptStored)) {
				$ptStored[] = $postType;
				update_option('PO_pt_stored', $ptStored);
			}
		} else {
			foreach($availableRoles as $roleID=>$roleName) {
				$sql = "SELECT disabled_plugins, enabled_plugins, disabled_mobile_plugins, enabled_mobile_plugins, disabled_groups, enabled_groups, disabled_mobile_groups, enabled_mobile_groups FROM ".$wpdb->prefix."po_plugins WHERE post_type=%s AND post_id=0 AND user_role=%s";
				$storedPluginLists = $wpdb->get_row($wpdb->prepare($sql, "pt_".$postType."_plugin_lists", $roleID), ARRAY_A);
				
				$submittedPlugins[$roleID] = array();
				$submittedPlugins[$roleID][] = (is_array(@unserialize($storedPluginLists['disabled_plugins'])))? @unserialize($storedPluginLists['disabled_plugins']):array();
				$submittedPlugins[$roleID][] = (is_array(@unserialize($storedPluginLists['enabled_plugins'])))? @unserialize($storedPluginLists['enabled_plugins']):array();
				$submittedPlugins[$roleID][] = (is_array(@unserialize($storedPluginLists['disabled_mobile_plugins'])))? @unserialize($storedPluginLists['disabled_mobile_plugins']):array();
				$submittedPlugins[$roleID][] = (is_array(@unserialize($storedPluginLists['enabled_mobile_plugins'])))? @unserialize($storedPluginLists['enabled_mobile_plugins']):array();
				$submittedPlugins[$roleID][] = (is_array(@unserialize($storedPluginLists['disabled_groups'])))? @unserialize($storedPluginLists['disabled_groups']):array();
				$submittedPlugins[$roleID][] = (is_array(@unserialize($storedPluginLists['enabled_groups'])))? @unserialize($storedPluginLists['enabled_groups']):array();
				$submittedPlugins[$roleID][] = (is_array(@unserialize($storedPluginLists['disabled_mobile_groups'])))? @unserialize($storedPluginLists['disabled_mobile_groups']):array();
				$submittedPlugins[$roleID][] = (is_array(@unserialize($storedPluginLists['enabled_mobile_groups'])))? @unserialize($storedPluginLists['enabled_mobile_groups']):array();
			}
		}

		if (!is_numeric($_POST['PO_total_post_count']) || $_POST['PO_total_post_count'] == 0) {
			$query = "SELECT COUNT(*) AS num_posts FROM ".$wpdb->posts." WHERE post_type = %s";
			$returnVals['total'] = $wpdb->get_var($wpdb->prepare($query, $postType));
		} else {
			$returnVals['total'] = $_POST['PO_total_post_count'];
		}
		
		$allPosts = get_posts(array('post_type'=>$postType, 'posts_per_page'=>100, 'offset'=>$returnVals['offset'], 'orderby'=>'post_id'));
		foreach($allPosts as $post) {
			$postStatus = get_post_status($post->ID);
			if (!$postStatus) {
				$postStatus = 'publish';
			}

			$ptOverride = $wpdb->get_var($wpdb->prepare("SELECT pt_override FROM ".$wpdb->prefix."po_plugins WHERE post_id=%d", $post->ID));

			$secure=0;
			if (preg_match('/^.{1,5}:\/\//', get_permalink($post->ID), $matches)) {
				switch ($matches[0]) {
					case "https://":
						$secure=1;
						break;
					default:
						$secure=0;
				}
			}
			$permalink = preg_replace('/^.{1,5}:\/\//', '', get_permalink($post->ID));
				
			$permalinkNoArgs = preg_replace('/\?.*$/', '', $permalink);
		
			$dirCount = substr_count($permalink, "/");
			foreach($availableRoles as $roleID=>$roleName) {
				
				if ($ptOverride == '0') {
					$postTypeExists = ($wpdb->get_var($wpdb->prepare("SELECT count(*) FROM ".$wpdb->prefix."po_plugins WHERE post_id=%d AND user_role=%s", $post->ID, $roleID)) > 0) ? 1 : 0;
					if ($postTypeExists == '1') {
						$wpdb->update($wpdb->prefix."po_plugins", array("permalink"=>$permalink, "permalink_hash"=>md5($permalinkNoArgs), "permalink_hash_args"=>md5($permalink), "enabled_plugins"=>serialize($submittedPlugins[$roleID][1]), "disabled_plugins"=>serialize($submittedPlugins[$roleID][0]), "enabled_mobile_plugins"=>serialize($submittedPlugins[$roleID][3]), "disabled_mobile_plugins"=>serialize($submittedPlugins[$roleID][2]), "enabled_groups"=>serialize($submittedPlugins[$roleID][5]), "disabled_groups"=>serialize($submittedPlugins[$roleID][4]), "enabled_mobile_groups"=>serialize($submittedPlugins[$roleID][7]), "disabled_mobile_groups"=>serialize($submittedPlugins[$roleID][6]), "secure"=>$secure, "post_type"=>get_post_type($post->ID), "status"=>$postStatus, "dir_count"=>$dirCount), array("post_id"=>$post->ID, "user_role"=>$roleID));
					} else {
						$wpdb->insert($wpdb->prefix."po_plugins", array("post_id"=>$post->ID, "permalink"=>$permalink, "permalink_hash"=>md5($permalinkNoArgs), "permalink_hash_args"=>md5($permalink), "enabled_plugins"=>serialize($submittedPlugins[$roleID][1]), "disabled_plugins"=>serialize($submittedPlugins[$roleID][0]), "enabled_mobile_plugins"=>serialize($submittedPlugins[$roleID][3]), "disabled_mobile_plugins"=>serialize($submittedPlugins[$roleID][2]), "enabled_groups"=>serialize($submittedPlugins[$roleID][5]), "disabled_groups"=>serialize($submittedPlugins[$roleID][4]), "enabled_mobile_groups"=>serialize($submittedPlugins[$roleID][7]), "disabled_mobile_groups"=>serialize($submittedPlugins[$roleID][6]), "secure"=>$secure, "post_type"=>get_post_type($post->ID), "status"=>$postStatus, "dir_count"=>$dirCount, "user_role"=>$roleID));
					}
				} else if ($ptOverride == '') {
					$wpdb->insert($wpdb->prefix."po_plugins", array("post_id"=>$post->ID, "permalink"=>$permalink, "permalink_hash"=>md5($permalinkNoArgs), "permalink_hash_args"=>md5($permalink), "enabled_plugins"=>serialize($submittedPlugins[$roleID][1]), "disabled_plugins"=>serialize($submittedPlugins[$roleID][0]), "enabled_mobile_plugins"=>serialize($submittedPlugins[$roleID][3]), "disabled_mobile_plugins"=>serialize($submittedPlugins[$roleID][2]), "enabled_groups"=>serialize($submittedPlugins[$roleID][5]), "disabled_groups"=>serialize($submittedPlugins[$roleID][4]), "enabled_mobile_groups"=>serialize($submittedPlugins[$roleID][7]), "disabled_mobile_groups"=>serialize($submittedPlugins[$roleID][6]), "secure"=>$secure, "post_type"=>get_post_type($post->ID), "status"=>$postStatus, "dir_count"=>$dirCount, "user_role"=>$roleID));
				}
			}
		}
		
		$returnVals['success'] = 1;
		$returnVals['msg'] = "Plugins updated for " . $_POST['selectedPostType'] . ".";
		print json_encode($returnVals);
		die();
	}

	function get_pt_plugins() {
		global $wpdb;
		if ( !$this->PO->verify_nonce($_POST['PO_nonce'])) {
			print "You dont have permissions to access this page.";
			die();
		}
		if (!isset($_POST['selectedPostType']) || !in_array($_POST['selectedPostType'], get_option('PO_custom_post_type_support'))) {
			print "post_type_not_supported";
			die();
		} else {
			$postType=$_POST['selectedPostType'];
		}
		
		$availableRoles = $this->PO->get_available_roles();
		
		$pluginLists = array();
		foreach($availableRoles as $roleID=>$roleName) {
			$sql = "SELECT disabled_plugins, enabled_plugins, disabled_mobile_plugins, enabled_mobile_plugins, disabled_groups, enabled_groups, disabled_mobile_groups, enabled_mobile_groups FROM ".$wpdb->prefix."po_plugins WHERE post_type=%s AND post_id=0 AND user_role=%s";
			$storedPluginLists = $wpdb->get_row($wpdb->prepare($sql, "pt_".$postType."_plugin_lists", $roleID), ARRAY_A);
			
			$pluginLists[$roleID] = array();
			$pluginLists[$roleID][] = (is_array(@unserialize($storedPluginLists['disabled_plugins'])))? @unserialize($storedPluginLists['disabled_plugins']):array();
			$pluginLists[$roleID][] = (is_array(@unserialize($storedPluginLists['enabled_plugins'])))? @unserialize($storedPluginLists['enabled_plugins']):array();
			$pluginLists[$roleID][] = (is_array(@unserialize($storedPluginLists['disabled_mobile_plugins'])))? @unserialize($storedPluginLists['disabled_mobile_plugins']):array();
			$pluginLists[$roleID][] = (is_array(@unserialize($storedPluginLists['enabled_mobile_plugins'])))? @unserialize($storedPluginLists['enabled_mobile_plugins']):array();
			$pluginLists[$roleID][] = (is_array(@unserialize($storedPluginLists['disabled_groups'])))? @unserialize($storedPluginLists['disabled_groups']):array();
			$pluginLists[$roleID][] = (is_array(@unserialize($storedPluginLists['enabled_groups'])))? @unserialize($storedPluginLists['enabled_groups']):array();
			$pluginLists[$roleID][] = (is_array(@unserialize($storedPluginLists['disabled_mobile_groups'])))? @unserialize($storedPluginLists['disabled_mobile_groups']):array();
			$pluginLists[$roleID][] = (is_array(@unserialize($storedPluginLists['enabled_mobile_groups'])))? @unserialize($storedPluginLists['enabled_mobile_groups']):array();
		}
		print json_encode($pluginLists);
		die();
	}

	function reset_pt_settings() {
		global $wpdb;
		if ( !$this->PO->verify_nonce($_POST['PO_nonce'])) {
			print "You dont have permissions to access this page.";
			die();
		}
		if (!isset($_POST['selectedPostType']) || !in_array($_POST['selectedPostType'], get_option('PO_custom_post_type_support'))) {
			print "post_type_not_supported";
			die();
		} else {
			$postType=$_POST['selectedPostType'];
		}
		
		$wpdb->delete($wpdb->prefix."po_plugins", array("post_type"=>"pt_".$postType."_plugin_lists", "post_id"=>0));

		$ptStored = get_option('PO_pt_stored');
		if (!is_array($ptStored)) {
			$ptStored = array();
		}
		
		if (in_array($postType, $ptStored)) {
			unset($ptStored[array_search($postType, $ptStored)]);
			update_option('PO_pt_stored', array_values($ptStored));
		}
		
		print "Plugin settings have been reset to default for the " . htmlentities(strip_tags($postType)) . " post type.<br />";
		if (isset($_POST['PO_reset_all_pt']) && $_POST['PO_reset_all_pt'] == "1") {
			$wpdb->delete($wpdb->prefix."po_plugins", array("post_type"=>$postType, "pt_override"=>0));

			print "<br />Plugin settings were also reset on each " . $postType . ".<br />";
		}
		
		die();
	}
	
	function redo_permalinks() {
		global $wpdb;
		if (!empty($_POST['old_site_address'])) {
			$oldSiteAddress = preg_quote($this->PO->fix_trailng_slash($_POST['old_site_address']), "/");
		} else {
			$oldSiteAddress = "";
		}

		if (!empty($_POST['new_site_address'])) {
			$newSiteAddress = $this->PO->fix_trailng_slash($_POST['new_site_address']);
		} else {
			$newSiteAddress = "";
		}
		
		$failedCount = 0;
		$updatedCount = 0;
		$noUpdateCount = 0;
		if ( !current_user_can( 'activate_plugins' ) || !$this->PO->verify_nonce($_POST['PO_nonce'])) {
			print "You dont have permissions to access this page.";
			die();
		}
		$postIDsCountQuery = "SELECT count(DISTINCT post_id) FROM ".$wpdb->prefix."po_plugins WHERE post_type != 'plugin_filter' AND post_id != 0";
		$postIDsCount = $wpdb->get_var($postIDsCountQuery);
		
		$postIDsQuery = "SELECT post_id FROM ".$wpdb->prefix."po_plugins WHERE post_type != 'plugin_filter' AND post_id != 0 AND permalink NOT LIKE %s GROUP BY post_id";
		$postIDs = $wpdb->get_results($wpdb->prepare($postIDsQuery, $_POST['new_site_address'].'%'), ARRAY_A);
		foreach ($postIDs as $postID) {
			$post = get_post($postID['post_id']);
			if (!is_null($post)) {
				$secure=0;
				if (preg_match('/^.{1,5}:\/\//', get_permalink($post->ID), $matches)) {
					switch ($matches[0]) {
						case "https://":
							$secure=1;
							break;
						default:
							$secure=0;
					}
				}
				$permalink = preg_replace('/^.{1,5}:\/\//', '', get_permalink($post->ID));
				
				$dirCount = substr_count($permalink, "/");
				$storedPermalink = $wpdb->get_row("SELECT permalink, permalink_hash, permalink_hash_args FROM ".$wpdb->prefix."po_plugins WHERE post_id=".$post->ID, ARRAY_A);
				if (!is_null($storedPermalink) && ($permalink != $storedPermalink['permalink'] || md5($permalink) != $storedPermalink['permalink_hash'] || md5($permalink) != $storedPermalink['permalink_hash_args'])) {
					
					if($wpdb->update($wpdb->prefix."po_plugins", array('permalink'=>$permalink, 'permalink_hash'=>md5($permalink), 'permalink_hash_args'=>md5($permalink), 'secure'=>$secure, "dir_count"=>$dirCount), array("post_id"=>$post->ID))) {
						$updatedCount++;
					} else {
						$failedCount++;
					}
				}
			} else {
				$failedCount++;
			}
		}

		$noUpdateCount = $postIDsCount - $updatedCount - $failedCount;
		
		if ($oldSiteAddress != "" && $newSiteAddress != "") {
			$filterQuery = "SELECT * FROM ".$wpdb->prefix."po_plugins WHERE post_type = 'plugin_filter'";
			$filters = $wpdb->get_results($filterQuery, ARRAY_A);
			foreach ($filters as $filter) {
				$filterObject = get_post($filter['post_id']);
				if (!is_null($filterObject)) {
					if (preg_match('/^'.$oldSiteAddress.'/', $filter['permalink'])) {
						$permalink = preg_replace("/^".$oldSiteAddress."/", "".$newSiteAddress."", $filter['permalink']);
						$dirCount = substr_count($permalink, "/");
						if ($wpdb->update($wpdb->prefix."po_plugins", array('permalink'=>$permalink, 'permalink_hash'=>md5($permalinkNoArgs), 'permalink_hash_args'=>md5($permalink), "dir_count"=>$dirCount), array("post_id"=>$filter['post_id']))) {
							$updatedCount++;
						} else {
							$failedCount++;
						}
					} else {
						$noUpdateCount++;
					}
				}
			}
		} else {
			print "Plugin Filters were not updated since the new or old address was blank.<br />";
		}

		if ($failedCount > 0) {
			print $failedCount . " permalinks failed to update!<br />";
			print $updatedCount . " permalinks were updated successfully.<br />";
			print $noUpdateCount . " permalinks were already up to date.<br />";
		} else {
			print $updatedCount . " permalinks were updated successfully.<br />";
			print $noUpdateCount . " permalinks were already up to date.<br />";
		}
		die();
	}

	function manage_mu_plugin() {
		if ( !current_user_can( 'activate_plugins' ) || !$this->PO->verify_nonce($_POST['PO_nonce'])) {
			print "You dont have permissions to access this page.";
			die();
		}
		$result = "";
		if ($_POST['selected_action'] == 'delete') {
			if (file_exists(WPMU_PLUGIN_DIR . "/PluginOrganizerMU.class.php")) {
				if (@unlink(WPMU_PLUGIN_DIR . "/PluginOrganizerMU.class.php")) {
					$result = "The MU plugin component has been removed.";
				} else {
					$result = "There was an issue removing the MU plugin component!";
				}
			} else {
				$result = "There was an issue removing the MU plugin component!";
			}
		} else if ($_POST['selected_action'] == 'move') {
			if (!file_exists(WPMU_PLUGIN_DIR)) {
				@mkdir(WPMU_PLUGIN_DIR);
			}
			if (file_exists($this->PO->pluginDirPath . "/" . plugin_basename(dirname(__FILE__)) . "/PluginOrganizerMU.class.php")) {
				@unlink(WPMU_PLUGIN_DIR . "/PluginOrganizerMU.class.php");
				@copy($this->PO->pluginDirPath . "/" . plugin_basename(dirname(__FILE__)) . "/PluginOrganizerMU.class.php", WPMU_PLUGIN_DIR . "/PluginOrganizerMU.class.php");
			}
			if (file_exists(WPMU_PLUGIN_DIR . "/PluginOrganizerMU.class.php")) {
				$result = "The MU plugin component has been moved to the mu-plugins folder.";
			} else {
				$result = "There was an issue moving the MU plugin component!";
			}
		}
		print $result;
		die();
	}

	function reset_plugin_order() {
		$activePlugins = $this->PO->get_active_plugins();
		usort($activePlugins, array($this, 'custom_sort_plugins'));
		$sortedPlugins = array();
		foreach ($activePlugins as $plugin) {
			if (is_plugin_active_for_network($plugin)) {
				$sortedPlugins[] = $plugin;
			}
		}

		foreach ($activePlugins as $plugin) {
			if (!is_plugin_active_for_network($plugin)) {
				$sortedPlugins[] = $plugin;
			}
		}
		update_option("active_plugins", $sortedPlugins);
		update_option("PO_plugin_order", $sortedPlugins);
		print "The order has been reset.";
		die();
	}

	function save_mobile_user_agents() {
		if ( !current_user_can( 'activate_plugins' ) || !$this->PO->verify_nonce($_POST['PO_nonce'])) {
			print "You dont have permissions to access this page.";
			die();
		}
		
		$userAgents = preg_replace("/\\r\\n/", "\n", $_POST['PO_mobile_user_agents']);
		$userAgents = explode("\n", $userAgents);
		if (!is_array($userAgents)) {
			$userAgents = array();
		}
		foreach ($userAgents as $key=>$agent) {
			if ($agent == '') {
				unset($userAgents[$key]);
			}
		}
		
		if (get_option('PO_mobile_user_agents') == $userAgents) {
			print "The user agent list matches the database.";
		} else if (update_option('PO_mobile_user_agents', $userAgents)) {
			print "The user agents were saved.";
		} else {
			print "There was a problem saving the user agents.";
		}
		die();
	}

	function disable_admin_notices() {
		update_option('PO_disable_admin_notices', 1);
		die();
	}
	
	function submit_admin_css_settings() {
		if ( !current_user_can( 'activate_plugins' ) || !$this->PO->verify_nonce($_POST['PO_nonce'])) {
			print "You dont have permissions to access this page.";
			die();
		}
		
		$result = '';
		$POAdminStyles = get_option('PO_admin_styles');
		if (!is_array($POAdminStyles)) {
			$POAdminStyles = array();
		}
		
		if (preg_match("/^(#[0-9A-Za-z]{0,6}|)$/", $_POST['PO_network_plugins_bg_color'])) {
			$POAdminStyles['network_plugins_bg_color'] = $_POST['PO_network_plugins_bg_color'];
		} else {
			$result .= "The text submitted for Network Plugin Background is not a valid css hex color.<br />";
		}

		if (preg_match("/^(#[0-9A-Za-z]{0,6}|)$/", $_POST['PO_network_plugins_font_color'])) {
			$POAdminStyles['network_plugins_font_color'] = $_POST['PO_network_plugins_font_color'];
		} else {
			$result .= "The text submitted for Network Plugin Font is not a valid css hex color.<br />";
		}

		if (preg_match("/^(#[0-9A-Za-z]{0,6}|)$/", $_POST['PO_active_plugins_bg_color'])) {
			$POAdminStyles['active_plugins_bg_color'] = $_POST['PO_active_plugins_bg_color'];
		} else {
			$result .= "The text submitted for Active Plugin Background is not a valid css hex color.<br />";
		}

		if (preg_match("/^(#[0-9A-Za-z]{0,6}|)$/", $_POST['PO_active_plugins_font_color'])) {
			$POAdminStyles['active_plugins_font_color'] = $_POST['PO_active_plugins_font_color'];
		} else {
			$result .= "The text submitted for Active Plugin Font is not a valid css hex color.<br />";
		}

		if (preg_match("/^(#[0-9A-Za-z]{0,6}|)$/", $_POST['PO_active_plugins_border_color'])) {
			$POAdminStyles['active_plugins_border_color'] = $_POST['PO_active_plugins_border_color'];
		} else {
			$result .= "The text submitted for Active Plugin Border is not a valid css hex color.<br />";
		}

		if (preg_match("/^(#[0-9A-Za-z]{0,6}|)$/", $_POST['PO_inactive_plugins_bg_color'])) {
			$POAdminStyles['inactive_plugins_bg_color'] = $_POST['PO_inactive_plugins_bg_color'];
		} else {
			$result .= "The text submitted for Inactive Plugin Background is not a valid css hex color.<br />";
		}

		if (preg_match("/^(#[0-9A-Za-z]{0,6}|)$/", $_POST['PO_inactive_plugins_font_color'])) {
			$POAdminStyles['inactive_plugins_font_color'] = $_POST['PO_inactive_plugins_font_color'];
		} else {
			$result .= "The text submitted for Inactive Plugin Font is not a valid css hex color.<br />";
		}

		if (preg_match("/^(#[0-9A-Za-z]{0,6}|)$/", $_POST['PO_inactive_plugins_border_color'])) {
			$POAdminStyles['inactive_plugins_border_color'] = $_POST['PO_inactive_plugins_border_color'];
		} else {
			$result .= "The text submitted for Inactive Plugin Border is not a valid css hex color.<br />";
		}

		if (preg_match("/^(#[0-9A-Za-z]{0,6}|)$/", $_POST['PO_plugin_groups_bg_color'])) {
			$POAdminStyles['plugin_groups_bg_color'] = $_POST['PO_plugin_groups_bg_color'];
		} else {
			$result .= "The text submitted for Plugin Group Background is not a valid css hex color.<br />";
		}

		if (preg_match("/^(#[0-9A-Za-z]{0,6}|)$/", $_POST['PO_plugin_groups_font_color'])) {
			$POAdminStyles['plugin_groups_font_color'] = $_POST['PO_plugin_groups_font_color'];
		} else {
			$result .= "The text submitted for Plugin Group Font is not a valid css hex color.<br />";
		}

		if (preg_match("/^(#[0-9A-Za-z]{0,6}|)$/", $_POST['PO_plugin_groups_border_color'])) {
			$POAdminStyles['plugin_groups_border_color'] = $_POST['PO_plugin_groups_border_color'];
		} else {
			$result .= "The text submitted for Plugin Group Border is not a valid css hex color.<br />";
		}
		
		if (preg_match("/^(#[0-9A-Za-z]{0,6}|)$/", $_POST['PO_global_plugins_bg_color'])) {
			$POAdminStyles['global_plugins_bg_color'] = $_POST['PO_global_plugins_bg_color'];
		} else {
			$result .= "The text submitted for Global Plugin Background is not a valid css hex color.<br />";
		}

		if (preg_match("/^(#[0-9A-Za-z]{0,6}|)$/", $_POST['PO_global_plugins_font_color'])) {
			$POAdminStyles['global_plugins_font_color'] = $_POST['PO_global_plugins_font_color'];
		} else {
			$result .= "The text submitted for Global Plugin Font is not a valid css hex color.<br />";
		}

		if (preg_match("/^(#[0-9A-Za-z]{0,6}|)$/", $_POST['PO_global_plugins_border_color'])) {
			$POAdminStyles['global_plugins_border_color'] = $_POST['PO_global_plugins_border_color'];
		} else {
			$result .= "The text submitted for Global Plugin Border is not a valid css hex color.<br />";
		}



		if (preg_match("/^(#[0-9A-Za-z]{0,6}|)$/", $_POST['PO_selected_plugins_bg_color'])) {
			$POAdminStyles['selected_plugins_bg_color'] = $_POST['PO_selected_plugins_bg_color'];
		} else {
			$result .= "The text submitted for Selected Plugin Background is not a valid css hex color.<br />";
		}

		if (preg_match("/^(#[0-9A-Za-z]{0,6}|)$/", $_POST['PO_selected_plugins_font_color'])) {
			$POAdminStyles['selected_plugins_font_color'] = $_POST['PO_selected_plugins_font_color'];
		} else {
			$result .= "The text submitted for Selected Plugin Font is not a valid css hex color.<br />";
		}

		if (preg_match("/^(#[0-9A-Za-z]{0,6}|)$/", $_POST['PO_selected_plugins_border_color'])) {
			$POAdminStyles['selected_plugins_border_color'] = $_POST['PO_selected_plugins_border_color'];
		} else {
			$result .= "The text submitted for Selected Plugin Border is not a valid css hex color.<br />";
		}




		##Buttons 
		
		if (preg_match("/^(#[0-9A-Za-z]{0,6}|)$/", $_POST['PO_on_btn_bg_color'])) {
			$POAdminStyles['on_btn_bg_color'] = $_POST['PO_on_btn_bg_color'];
		} else {
			$result .= "The text submitted for On Button Background is not a valid css hex color.<br />";
		}

		if (preg_match("/^(#[0-9A-Za-z]{0,6}|)$/", $_POST['PO_on_btn_font_color'])) {
			$POAdminStyles['on_btn_font_color'] = $_POST['PO_on_btn_font_color'];
		} else {
			$result .= "The text submitted for On Button Font is not a valid css hex color.<br />";
		}

		if (preg_match("/^(#[0-9A-Za-z]{0,6}|)$/", $_POST['PO_off_btn_bg_color'])) {
			$POAdminStyles['off_btn_bg_color'] = $_POST['PO_off_btn_bg_color'];
		} else {
			$result .= "The text submitted for Off Button Background is not a valid css hex color.<br />";
		}

		if (preg_match("/^(#[0-9A-Za-z]{0,6}|)$/", $_POST['PO_off_btn_font_color'])) {
			$POAdminStyles['off_btn_font_color'] = $_POST['PO_off_btn_font_color'];
		} else {
			$result .= "The text submitted for Off Button Font is not a valid css hex color.<br />";
		}

		if (preg_match("/^(#[0-9A-Za-z]{0,6}|)$/", $_POST['PO_yes_btn_bg_color'])) {
			$POAdminStyles['yes_btn_bg_color'] = $_POST['PO_yes_btn_bg_color'];
		} else {
			$result .= "The text submitted for Yes Button Background is not a valid css hex color.<br />";
		}

		if (preg_match("/^(#[0-9A-Za-z]{0,6}|)$/", $_POST['PO_yes_btn_font_color'])) {
			$POAdminStyles['yes_btn_font_color'] = $_POST['PO_yes_btn_font_color'];
		} else {
			$result .= "The text submitted for Yes Button Font is not a valid css hex color.<br />";
		}

		if (preg_match("/^(#[0-9A-Za-z]{0,6}|)$/", $_POST['PO_no_btn_bg_color'])) {
			$POAdminStyles['no_btn_bg_color'] = $_POST['PO_no_btn_bg_color'];
		} else {
			$result .= "The text submitted for No Button Background is not a valid css hex color.<br />";
		}

		if (preg_match("/^(#[0-9A-Za-z]{0,6}|)$/", $_POST['PO_no_btn_font_color'])) {
			$POAdminStyles['no_btn_font_color'] = $_POST['PO_no_btn_font_color'];
		} else {
			$result .= "The text submitted for No Button Font is not a valid css hex color.<br />";
		}



		update_option('PO_admin_styles', $POAdminStyles);
		
		if ($result == '') {
			print "All settings saved successfully!";
		} else {
			print $result;
		}
		die();
	}
		
	function reset_post_settings() {
		global $wpdb;
		if ( !current_user_can( 'activate_plugins' ) || !$this->PO->verify_nonce($_POST['PO_nonce'])) {
			print "You dont have permissions to access this page.";
			die();
		}

		if (is_numeric($_POST['postID'])) {
			if ($wpdb->get_var($wpdb->prepare("SELECT count(*) FROM ".$wpdb->prefix."po_plugins WHERE post_id=%d", $_POST['postID'])) > 0) {
				$deletePluginQuery = "DELETE FROM ".$wpdb->prefix."po_plugins WHERE post_id = %d";
				if ($wpdb->query($wpdb->prepare($deletePluginQuery, $_POST['postID'])) === false) {
					print 0;
				} else {
					print 1;
				}
			} else {
				print -1;
			}
		}
		die();
	}
	
	function save_gen_settings() {
		if ( !current_user_can( 'activate_plugins' ) || !$this->PO->verify_nonce($_POST['PO_nonce'])) {
			print "You dont have permissions to access this page.";
			die();
		}
		$result = "";
		
		##Fuzzy URL matching
		if ($_POST['PO_fuzzy_url_matching'] == "1") {
			update_option("PO_fuzzy_url_matching", 1);
			$result .= "Fuzzy URL matching is enabled.<br /><br />";
		} else {
			update_option("PO_fuzzy_url_matching", 0);
			$result .= "Fuzzy URL matching is disabled.<br /><br />";
		}

		##Ignore protocol
		if ($_POST['PO_ignore_protocol'] == "1") {
			update_option("PO_ignore_protocol", 1);
			$result .= "URL Protocol will be ignored.  http:// will be treated the same as https://<br /><br />";
		} else {
			update_option("PO_ignore_protocol", 0);
			$result .= "URL Protocol will NOT be ignored.  http:// will NOT be treated the same as https://<br /><br />";
		}
		
		
		##Ignore arguments
		if ($_POST['PO_ignore_arguments'] == "1") {
			update_option("PO_ignore_arguments", 1);
			$result .= "URL Arguments will be ignored.  " . home_url() . "?test=test will be treated the same as " . home_url() . "<br /><br />";
		} else {
			update_option("PO_ignore_arguments", 0);
			$result .= "URL Arguments will NOT be ignored.  " . home_url() . "?test=test will NOT be treated the same as " . home_url() . "<br /><br />";
		}

		##Network admin access
		if ($_POST['PO_order_access_net_admin'] == "1") {
			update_option('PO_order_access_net_admin', 1);
			$result .= "Only network admins will be able to change the plugin load order.<br /><br />";
		} else {
			update_option('PO_order_access_net_admin', 0);
			$result .= "Any admin will be able to change the plugin load order.<br /><br />";
		}

		##Auto trailing slash
		if ($_POST['PO_auto_trailing_slash'] == "1") {
			update_option("PO_auto_trailing_slash", 1);
			$result .= "Trailing slashes will automatically be removed or added based on your premalink structure.<br /><br />";
		} else {
			update_option("PO_auto_trailing_slash", 0);
			$result .= "Trailing slashes will NOT automatically be removed or added.<br /><br />";
		}


		##Custom post type support
		if (isset($_POST['PO_cutom_post_type']) && is_array($_POST['PO_cutom_post_type'])) {
			$submittedPostTypes = $_POST['PO_cutom_post_type'];
		} else {
			$submittedPostTypes = array();
		}
		
		update_option("PO_custom_post_type_support", $submittedPostTypes);
		if (sizeof(array_diff(get_option("PO_custom_post_type_support"), $submittedPostTypes)) == 0) {
			$result .= "Post types saved.<br /><br />";
		} else {
			$result .= "Saving post types failed!<br /><br />";
		}

		##Role support
		if (isset($_POST['PO_supported_roles']) && is_array($_POST['PO_supported_roles'])) {
			$submittedRoles = $_POST['PO_supported_roles'];
		} else {
			$submittedRoles = array();
		}

		update_option("PO_enabled_roles", $submittedRoles);
		if (sizeof(array_diff(get_option("PO_enabled_roles"), $submittedRoles)) == 0) {
			$result .= "Enabled roles saved.<br /><br />";
		} else {
			$result .= "Saving enabled roles failed!<br /><br />";
		}
		
		##Selective Plugin Loading
		if ($_POST['PO_disable_plugins'] == "1") {
			update_option("PO_disable_plugins", 1);
			$result .= "Selective Plugin Loading is enabled.<br />";
		} else {
			update_option("PO_disable_plugins", 0);
			$result .= "Selective Plugin Loading is disabled.<br />";
		}

		##Selective Mobile Plugin Loading
		if ($_POST['PO_disable_mobile_plugins'] == "1") {
			update_option("PO_disable_mobile_plugins", 1);
			$result .= "Selective Mobile Plugin loading is enabled.<br />";
		} else {
			update_option("PO_disable_mobile_plugins", 0);
			$result .= "Selective Mobile Plugin loading is disabled.<br />";
		}

		##Selective Admin Plugin Loading
		if ($_POST['PO_admin_disable_plugins'] == "1") {
			update_option("PO_admin_disable_plugins", 1);
			$result .= "Selective Admin Plugin Loading is enabled.<br />";
		} else {
			update_option("PO_admin_disable_plugins", 0);
			$result .= "Selective Admin Plugin Loading is disabled.<br />";
		}

		##Disable By Role
		if ($_POST['PO_disable_by_role'] == "1") {
			update_option("PO_disable_by_role", 1);
			$result .= "Disable Plugins By Role is enabled.<br />";
		} else {
			update_option("PO_disable_by_role", 0);
			$result .= "Disable Plugins By Role is disabled.<br />";
		}
		
		print $result;
		die();
	}

	function get_plugin_group_container() {
		$groups = get_posts(array('post_type'=>'plugin_group', 'posts_per_page'=>-1));
		$assignedGroups = "";
		foreach($groups as $group) {
			$members = $this->PO->get_group_members($group->ID);
			$members = stripslashes_deep($members);
			if (is_array($members) && array_search($_POST['PO_plugin_path'], $members) !== FALSE) {
				$assignedGroups .= '<a href="'.get_admin_url().'plugins.php?PO_group_view='.$group->ID.'">'.$group->post_title.'</a><br /><hr>';
			}
		}
		print $assignedGroups;
		die();
	}

	function get_group_list() {
		$groups = get_posts(array('post_type'=>'plugin_group', 'posts_per_page'=>-1));
		$groupNames = array();
		foreach($groups as $group) {
			$groupNames[] = array($group->ID, $group->post_title);
		}
		print json_encode($groupNames);
		die();
	}
	
	function perform_plugin_search() {
		global $wpdb;
		$returnArray = array();
		$availableRoles = array('_');
		if (isset($_POST['PO_searchable_roles']) && is_array($_POST['PO_searchable_roles']) && count($_POST['PO_searchable_roles']) > 0) {
			$availableRoles = $_POST['PO_searchable_roles'];
		} else if (get_option("PO_disable_by_role") == '1') {
			$availableRoles = get_option("PO_enabled_roles");
			
			$availableRoles = array_merge(array('_', '-'), $availableRoles);
		}

		$groups = get_posts(array('post_type'=>'plugin_group', 'posts_per_page'=>-1));
		$assignedGroups = array();
		foreach($groups as $group) {
			$members = $this->PO->get_group_members($group->ID);
			$members = stripslashes_deep($members);
			if (is_array($members) && array_search($_POST['PO_plugin_path'], $members) !== FALSE) {
				$assignedGroups[] = '"'.$group->ID.'"';
			}
		}

		$groupSearch = '';
		if (count($assignedGroups) > 0) {
			$groupSearch = " OR disabled_groups REGEXP '(".implode('|', $assignedGroups).")' OR disabled_mobile_groups REGEXP '(".implode('|', $assignedGroups).")'";
		}
		
		$sql = $this->PO->prepare_in("SELECT COUNT(*) FROM ".$wpdb->prefix."po_plugins WHERE post_type='global_plugin_lists' AND post_id=0 AND user_role IN ([R_IN]) AND (disabled_plugins LIKE %s OR disabled_mobile_plugins LIKE %s".$groupSearch.")", $availableRoles, '[R_IN]');
		$pluginSearchResult = $wpdb->get_var($wpdb->prepare($sql, "%".$_POST['PO_plugin_path']."%", "%".$_POST['PO_plugin_path']."%"));

		if ($pluginSearchResult > 0) {
			$returnArray[] = array('name'=>'Global Plugins', 'url'=>get_admin_url().'admin.php?page=PO_global_plugins');
		}
		
		$sql = $this->PO->prepare_in("SELECT COUNT(*) FROM ".$wpdb->prefix."po_plugins WHERE post_type='search_plugin_lists' AND post_id=0 AND user_role IN ([R_IN]) AND (disabled_plugins LIKE %s OR disabled_mobile_plugins LIKE %s".$groupSearch.")", $availableRoles, '[R_IN]');
		$pluginSearchResult = $wpdb->get_var($wpdb->prepare($sql, "%".$_POST['PO_plugin_path']."%", "%".$_POST['PO_plugin_path']."%"));

		if ($pluginSearchResult > 0) {
			$returnArray[] = array('name'=>'Search Plugins', 'url'=>get_admin_url().'admin.php?page=PO_search_plugins');
		}

		$sql = $this->PO->prepare_in("SELECT post_id FROM ".$wpdb->prefix."po_plugins WHERE post_id!=0 AND user_role IN ([R_IN]) AND (disabled_plugins LIKE %s OR disabled_mobile_plugins LIKE %s".$groupSearch.") GROUP BY post_id", $availableRoles, '[R_IN]');
		$pluginSearchResult = $wpdb->get_results($wpdb->prepare($sql, "%".$_POST['PO_plugin_path']."%", "%".$_POST['PO_plugin_path']."%"), ARRAY_A);

		if ($pluginSearchResult  !== false) {
			foreach($pluginSearchResult as $postDetail) {
				$returnArray[] = array('name'=>get_the_title($postDetail['post_id']), 'url'=>get_edit_post_link($postDetail['post_id']));
			}
		}

		print json_encode($returnArray);
		die();
	}
	
	function custom_sort_plugins($a, $b) { 
		$aData = get_plugin_data($this->PO->pluginDirPath.'/'.$a);
		$bData = get_plugin_data($this->PO->pluginDirPath.'/'.$b);
		return strcasecmp($aData['Name'], $bData['Name']);
	}
}
?>