<?php 
//register chat send by users
if(!elgg_is_xhr()){
       system_message('ajax only');
       forward();

 }
//we get all entities
 //we get friends entity 
 $friend = get_entity((int)get_input('fid'));
 //we get the users entity
 $user = elgg_get_logged_in_user_entity();
 //we the chat msg
 $chat_msg = get_input('chat_msg');
 //for the time we use the unix timestamp 
 $chat_time = time();
 //we create two chat objects
 $chat = new ElggObject();
 //$chat_friend = new ElggObject();
 //we populate our chats 
 $chat->description = $chat_msg;
 $chat->date_created =$chat_time;
$chat->save();
 $chat->sender_guid = $user->guid;
 $chat->receiver_guid =$friend->guid;
  
 //we create a relationship between chat and both users
 $chat_rel1 = add_entity_relationship($chat->guid,'chat_of',$user->guid);
 $chat_rel2 = add_entity_relationship($chat->guid,'chat_of',$friend->guid);
  //we check if relationships were established
 if($chat_rel1 && $chat_rel2){
 	echo 'success';
 }else{
 	
 	echo 'error';
 }




 ?>