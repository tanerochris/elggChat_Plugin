<?php 

function formPersonHtml($username,$guid,$pic_path,$friends_count,$friends_common,$friends_prof){
	$start = '<li class="col-md-3" ><div style="text-align: center;" ><img /> <br /><span>Friends in common:</span><span>'.$friends_common.'</span><br /><span class="add-friend btn btn-primary" id="'.$guid.'">Friend Request</span></div>';
	$end = '</li>';
	//
   return $start.$end;

}
function mayknow($currfriend,$userguid){
    $count =0;
    forEach( $currfoll as $foll){
        if(check_entity_relationship($foll->guid,'friend_of',(int)$userguid) || check_entity_relationship((int)$userguid,'friend_of',$foll->guid)){
          $count++;
        }
        
        //we check if our count is more than 0 friend
        
    }
    if($count > 0){
          return $count;
          }else return 0;
  }

  ?>