<?php 
if(!elgg_is_xhr()){
       system_message('ajax only');
       forward();

 }
//get the chat between the current user and the user he/she is chatting with
$c_user = elgg_get_logged_in_user_guid();
$json = array();
$friends_guid = (int)get_input('ugid');
$friend = get_entity($friends_guid);
$count =0;
//we get the all the chats that are associated to the current user
$c_user_chats  = elgg_get_entities_from_relationship(array(
	'relationship' => 'chat_of',
	'relationship_guid' => $c_user,
	'inverse_relationship' => true
	));
//we first check if chats exist for the user
if(count($c_user_chats)<=0){
 echo json_encode(array('status' =>'noChats',
 						'username' => $friend->username,
 						'friend_gid' => $friend->guid,
 						'chat' =>array()));
}else{
	//we compare the friends guid to the guid stored in the chat
forEach( $c_user_chats as $chat){
   //we check if chat was don with current user
	if($chat->receiver_guid == $friends_guid || $chat->sender_guid == $friends_guid){
       //we extract all the chats and put them in a jason object
		++$count;
		array_unshift($json, array('date_created' => elgg_get_friendly_time($chat->date_created),
									'description' => $chat->description));
		
	}

}
 if($count>0){
 	//we json encode our array and echo
 	echo json_encode(array('status' =>'chat',
 							'username' =>$friend->username,
 							'chat' => $json,
 							'friend_gid' => $friend->guid
 							));

 }else{
 	echo json_encode(array('status' =>'noChats',
 						'username' => $friend->username,
 						'friend_gid' => $friend->guid,
 						'chat' =>array()));
 }

}