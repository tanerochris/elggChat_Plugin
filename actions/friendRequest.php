<?php 
 if(!elgg_is_xhr()){
       system_message('ajax only');
       forward();

 }
//we get the paramerters from our post
 $cgid = (int)trim(get_input('cgid'));
  $ugid = (int)trim(get_input('ugid'));
  //we get the entity of current user
  $curr_user = get_user($cgid);
  //we get the current user name 
  $username = $curr_user->username;

 //we check if the users are already friends 
  
  if(check_entity_relationship($cgid,'friend_of',$ugid) && check_entity_relationship($ugid,'friend_of',$cgid)){
      echo 'alreadyFriends';  
  }else if(check_entity_relationship($cgid,'sent_request',$ugid)){
  	  echo 'requestSent' ;
  }else{

    //if the user and current user are not yet friends we create a friend request relationship
  		$requestSent = add_entity_relationship($cgid,'sent_request',$ugid);
  		//we notify both users about the request
  		if($requestSent){
  			$subject = '<div><span class="h6">Friend request</span></div>';
  				//send a notification to the user that 
  			$body = '<div class=""><div class=""></div><div class=""><span class="h4">'.$username.'</span><span class="btn btn-info friend-confirm pull-right" id="'.$ugid.'">Confirm</span></div></div>';
  			//we create a notification object 
  			$notify = new ElggObject();
  			$notify->subtype ='notification';
  			$notify->title = $subject;
  			$notify->description = $body;
  			$notify->save();
  			$notify->status = 'notRead';
  	  //we a create a relationship between the notifications object and the user we are sending friend request
  	     if(add_entity_relationship($notify->guid,'notification_of',$cgid))  
  			echo 'requestSent';
  		else echo 'userNotNotified';
  		}

  }






?>