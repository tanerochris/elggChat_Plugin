<?php
//we get the view of the friends online 
if(!elgg_is_xhr()){
       system_message('ajax only');
       forward();

 }
 $start ='<div><ul>';
 $end ='</ul></div>';
 //we get the current user and we get the friends relationship
 $u_guid = elgg_get_logged_in_user_guid();
 $current_time = time();
 //we get the frienship relationshps
 $friends = elgg_get_entities_from_relationship(array(
 	'relationship' => 'friend',
 	'relationship_guid'=>$u_guid,
 	'inverse_relationship' => true));
 //we check if we have friends
 if(count($friends) <= 0){
   echo 'noFriends';
 }
 else{
 	//we loop through friends entity and we get the friends with last action time less than 2mins
 	forEach($friends as $friend ){
 		if(($current_time-((double)$friend->last_action)) < 600 && $friend->guid != $u_guid){
            $start.='<a href="#" class="friend-chat" data-gid="'.$friend->guid.'" ><div class="col-sm-12 " id="friend-chat"><div class="col-sm-3" id="img-friend"><img class="img-responsive img-circle" src="mod/kiff_theme/graphics/image/drake.png"></div><div class="col-sm-9" id="name-friend">'.$friend->username.'</div><div class="col-sm-9" id="statut" style=" color: rgba(250,250,250,0.7);"><span style="margin:0px 5px 0px 0px;  " class="fa fa-user"></span>Online</div></div>';

 		}
      
 	}
 	 echo $start.$end;
 }


?>