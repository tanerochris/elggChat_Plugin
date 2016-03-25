<?php


if(!elgg_is_xhr()){
       system_message('ajax only');
       forward();

 }

//this action file is used to update the chats of users
 //array to store all charts
 $final_array = array();
 //we get all the chat active chat windows
 $active_chats = get_input('activeChats');
  $active_chats = json_decode($active_chats);
 //we get the current user entity
 $user = elgg_get_logged_in_user_entity();
 
 //we all the chats of the logged in user
 $all_chats = elgg_get_entities_from_relationship(array(
    	'relationship' => 'chat_of',
    	'relationship_guid' => $user->guid,
    	'inverse_relationship' =>true
   ));
//we loop through the active chats 
 forEach( $active_chats as $chat){
  
  $count = 0;
  $temp_Array = array();
  
  //we get the the  friends guid
 	$friend = get_entity($chat->gid);
 	//we get all the chat with our active friends
 	//we loop through the chat array
 	forEach( $all_chats as $chats){
 		if($chats->sender_guid == $friend->guid || $chats->receiver_guid == $friend->guid ){

 			//we get the chat and add it to our array
 			array_unshift($temp_Array,array('date_created' => elgg_get_friendly_time($chats->date_created),
 				'description' => $chats->description));
              ++$count;
 		}

 	} 
      if($count>0){
 	//we json encode our array and echo
 	array_push($final_array, array('status' =>'chat',
 					  'username' =>$friend->username,
 						'chat' => $temp_Array,
 						'friend_gid' => $friend->guid
 					)
 	);

 }else{
 	array_push($final_array,array('status' =>'noChats',
 						'username' => $friend->username,
 						'friend_gid' => $friend->guid,
 						'chat' =>array( array( 'date_created' => '',
 							 'description' => '')) ));
 }

 }
  echo json_encode($final_array);

 


 ?>