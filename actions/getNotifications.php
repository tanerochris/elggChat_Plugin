<?php
if(!elgg_is_xhr()){
       system_message('ajax only');
       forward();

 }
 

$counter = 0;
$cgid = elgg_get_logged_in_user_guid();
$notifications = elgg_get_entities_from_relationship(array(
	'relationship' => 'notification_of',
	'relationship_guid' => $cgid,
	'inverse_relationship' => true
	)
);
if(count($notifications) == 0){
		echo  $counter;
}else{

	//we loop through the relationships
	forEach( $notifications as $notification){
			//we construct our notifications li
		if($notification->status =='notSeen'){
			 ++$counter;

		}
		
	}
	echo  $counter;
}


?>