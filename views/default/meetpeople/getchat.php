<?php 
if(!elgg_is_xhr()){
       system_message('ajax only');
       forward();

 }
//get the chat between the current user and the user he/she is chatting with
$c_user = elgg_get_logged_in_user_guid();
$json = array();
$friends_guid = (int)get_input('ugid');
$count =0;
//we get the all the chats that are associated to the current user
$c_user_chats  = elgg_get_entities_relationship(array(
	'relationship' => 'chat',
	'relationship_guid' => $c_user,
	'inverse_relationship' => true
	));
//we first check if chats exist for the user
if(count($c_user_chats)<=0){
  echo 'noChats';

}else{
	//we compare the friends guid to the guid stored in the chat
forEach( $c_user_chats as $chat){
   //we check if chat was don with current user
	if($chat->friend_guid == $friends_guid){
       //we extract all the chats and put them in a jason object
		++$count;
		array_unshift($json, array(
			'date_created' => $chat->date_created,
			'description' =>$chat->description,
			'friend_id' => $chat->friend_guid));
		
	}

}
 if($count>0){
 	//we json encode our array and echo
 	echo json_encode($json);

 }else{
 	echo 'noChats';
 }

}



?>