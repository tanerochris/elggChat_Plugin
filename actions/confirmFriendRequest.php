<?php


if(!elgg_is_xhr()){
       system_message('ajax only');
       forward();

 }
 //this confirms friends request 
//we get the guid and of the person requesting friendship 
$ugid = (int)trim(get_input('ugid'));
$u_entity = get_entity($ugid);
//we get the current user entity
$c_entity = elgg_get_logged_in_user_entity();
$username = $u_entity->username;
//we create a friendship relationship relationship between both users
  if($u_entity->addFriend($c_entity->guid) && $c_entity->addFriend($u_entity->guid)){
       //we delete existing friend_request relationship
  	remove_entity_relationship($u_entity->guid,'sent_request',$c_entity->guid);
       $subject = 'Request confirmed';
  				//send a notification to the user that 
  			$body = '<div class="row"><div class="col-md-2"></div><div class="col-md-8"><span class="h3">'.$username.'</span></div></div>';
  			//we create a notification object 
  			$notify = new ElggObject();
  			$notify->subtype ='notification';
  			$notify->title = $subject;
  			$notify->description = $body;
  			$notify->save();
  			$notify->status = 'notRead';
  	  //we a create a relationship between the notifications object and the user we are sending friend request
  	     if(add_entity_relationship($notify->guid,'notification_of',$ugid))  
             echo 'nowFriends';

  }
  else{
  	echo 'tryAgain';
  }





?>