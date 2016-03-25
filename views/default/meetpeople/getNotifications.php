<?php
if(!elgg_is_xhr()){
       system_message('ajax only');
       forward();

 }
 $start = '<div class="container-fluid"><ul class="list-group">';
 $end ='</ul></div>';
//get the notifications of current user
$offset= (int)get_input('offset');

$cgid = elgg_get_logged_in_user_guid();
$notifications = elgg_get_entities_from_relationship(array(
	'relationship' => 'notification_of',
	'relationship_guid' => $cgid,
	'inverse_relationship' => true,
	'limit' => 15,
	'offset' => $offset)
);
if(!count($notifications)){
		echo $start.'<li class="list-group-item">0 notifications</li>'.$end;
}else{

	//we loop through the relationships
	forEach( $notifications as $notification){
			//we construct our notifications li
		$bgColor ='';
		if($notification->status =='notRead'){
			$bgColor = 'grey';

		}
		$start.='<li style="background-color :'.$bgColor.'" class="list-group-item">'.'<div><span class="h6">'.$notification->title.'</span></div>'.$notification->description.'</li>';

	}
	echo $start.$end;
}


?>