<?php 
//we check thet it is an ajax call
if(elgg_is_xhr()){ 
	//echo 'hello';
//we start by getting our usrss entities
$user_entities = elgg_get_entities(array(
'type' => 'user'
));
$curr_user_guid = trim(get_input('guid'));
$type = trim(get_input('type'));
$start ='<div class="container-fluid" <ul class="row-fluid">';
$end='</ul></div>';
//we check if it is a search 
if( strtolower($type) == 'friends'){
   		//we check for users having a relationship with current user
	//as test we present all users as list 
	forEach( $user_entities as $user){
		$username = $user->username;
		$guid = $user->guid;
		$friends_in_common_count=0;
	
	
		//we get the friends in common count 
		$userfriends = elgg_get_entities_from_relationship(array('relationship' => 'friend_of',
                                                                'relationship_guid' => $user,
                                                                'inverse_relationship' => true));
		$friends_in_common_count = mayknow($userfriends,$curr_user_guid);
		
		//we check the relationship that exist between the current user and other users
      	 $start.= formPersonHtml($username,$guid,'','',$friends_in_common_count,'');
	}
	

} 
 echo $start.$end;


}


//echo 'we are in';



?>