<?php

elgg_register_event_handler('init','system','meetpeople_init');
function meetpeople_init(){
elgg_register_ajax_view('meetpeople/meetfriends');
elgg_register_ajax_view('meetpeople/friendsonline');
  elgg_register_ajax_view('meetpeople/viewall');
  elgg_register_ajax_view('meetpeople/getNotifications');
  elgg_register_page_handler('meetpeople', 'meetpeople_page_handler');
  elgg_require_js('meetpeople/meetpeople');
  elgg_register_action("friendRequest", elgg_get_plugins_path().'meetpeople/actions/friendRequest.php');
  elgg_register_action("sendChat", elgg_get_plugins_path().'meetpeople/actions/sendChat.php');
   elgg_register_action("updateChat", elgg_get_plugins_path().'meetpeople/actions/updateChat.php');
  elgg_register_action("confirmFriendRequest", elgg_get_plugins_path().'meetpeople/actions/confirmFriendRequest.php');
   elgg_register_action("getChat", elgg_get_plugins_path().'meetpeople/actions/getChat.php');
   elgg_register_action("getNotifications", elgg_get_plugins_path().'meetpeople/actions/getNotifications.php');
  elgg_register_library('helpers', elgg_get_plugins_path().'meetpeople/lib/meetpeople/helper.php');
  elgg_load_library('helpers');

}
function meetpeople_page_handler($segments){

    if($segments[0]==='all'|| $segments[0]==='/' ){
         include elgg_get_plugins_path().'meetpeople/pages/meetpeople/all.php';
        return true;
		}
    return false;
}
