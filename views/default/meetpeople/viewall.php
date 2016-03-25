<?php
//subsequently we will do the checking of the value of cat
//buy buttons may be added subsequently
//also for the image path we will have to use the owner guid ,that is the user who created the file
if(elgg_is_xhr()){

$img ='';
  $body='';
  $end='';
  $start = "<div>".elgg_view('page/elements/meetpeople/meetpeople_menu_view', $vars)."</div><div id='btsm'>";
  if(trim(get_input('sbar'))==true){
    $body .=$start;
    $end.='</div>';
}
    forEach($entities as $user){
        switch($cat){
         case 'popular':
            $following = elgg_entities_from_relationship(array('relationship'=>'follows',
                                                              'relationship_guid' => $user->guid ));
            if(count($following) >= 4 ){
                $prof_pic = elgg_get_entities_from_relationship(array('relationship' => 'prof_pic_of',
                                                 'relationship_guid'=>$user->guid,
'inverse_relationship' => true ) );
//get the profile image pic

        //we check the stats of the artist
        if($user->stats !== NULL && $user->stats == 'artist'){
            $artist = "<h5 class='job' style='text-align : center;color:#fecba3;'>ARTIST</h5>";
        }else $artist='';
        $img = getimg($prof_pic);
                //we declare and initialise all params we will be needing
        $body .= ajaxbody($img,$user->username,$user->guid,$artist);
            }
            break;
        case 'mayknow':
        $prof_pic = elgg_get_entities_from_relationship(array('relationship' => 'prof_pic_of',
                                         'relationship_guid'=>$user->guid,
'inverse_relationship' => true ) );
              $img = getimg($prof_pic);
            //we get the all the users that folows the currrent user
            if($user->stats !== NULL && $user->stats == 'artist'){
                $artist = "<h5 class='job' style='text-align : center;color:#fecba3;'>ARTIST</h5>";
            }else $artist='';
            $userfollowers = elgg_get_entities_from_relationship(array('relationship' => 'follows',
                                                                'relationship_guid' => $curruser,
                                                                'inverse_relationship' => true));
            //loop through the users followers
            if(mayknow($userfollowers,$user)){
                $body .= ajaxbody($img,$user->username,$user->guid,$artist);
            }

            break;
        case 'closer':

            echo 'closer';
            break;
        case 'search':
            $strlen = strlen(trim(get_input('searchval')));
            $usernamesubstr = substr(strtolower($user->username),0,$strlen);
            $namesubstr = substr(strtolower($user->name),0,$strlen);
            if( ($usernamesubstr === strtolower(trim(get_input('searchval')))) || ($usernamesubstr === strtolower(trim(get_input('searchval'))) ) ){
              $prof_pic = elgg_get_entities_from_relationship(array('relationship' => 'prof_pic_of',
                                               'relationship_guid'=>$user->guid,
'inverse_relationship' => true ) );
             $img = getimg($prof_pic);
             if($user->stats !== NULL && $user->stats == 'artist'){
                 $artist = "<h5 class='job' style='text-align : center;color:#fecba3;'>ARTIST</h5>";
             }else $artist='';
             $body .= ajaxbody($img,$user->username,$user->guid,$artist);

            }
            break;
        default :
         if($user->stats == 'artist'){
           $img = getimg($prof_pic);
           $artist = "<h5 class='job' style='text-align : center;color:#fecba3;'>ARTIST</h5>";
           $userfollowers = elgg_get_entities_from_relationship(array('relationship' => 'follows',
                                                               'relationship_guid' => $curruser,
                                                               'inverse_relationship' => true));
           $body .= ajaxbody($img,$user->username,$user->guid,$artist);

         }

}
    }

$body.='</ul>'.$end;
    echo $body;
}
function ajaxbody($img,$username,$userguid,$artist){
    $body =<<<__BODY
    <liv class="col-md-6" style='padding:10px 10px;'>
    <div class='media'>
     <div class="media-left">
            $img
        </div>
        <div class='media-body'>
            <h5 class="media-heading" style='text-align : center' >
            $username
            </h5>
            $artist
            <div class='row' >
                <button style='border-radius :none;margin-left :2px;height :45%;background-color:#6595ac;' class="btn btn-primary follow col-md-5" data-u ="$userguid" >follow</button>&nbsp;&nbsp;&nbsp;&nbsp;
    <button style='border-radius :none;margin-left :2px;height :45%;background-color:#7adf9c;'  class="btn btn-primary follow chat col-md-5" data-u ="$userguid" >chat</button>
            </div>
        </div>
    </div>
</liv>
__BODY;
 return $body;

}
function getimg($pic){
    if(count($pic) >=1){
        $dir_lenth = strlen($pic[0]->filename);
        $img_length= strlen(basename($pic[0]->filename));
        $str = substr($pic[0]->filename,0,$dir_lenth - $img_length);
        $img ='<img alt="a photo" src="http://localhost/1/38/'.$str.'/'.$pic[0]->thumbnail.'" />';
        }else{
$img ='<img alt="a photo"src="http://localhost/elgg/elgg1.11.4/mod/meetpeople/_graphics/defaultmedium.gif" class="img-thumbnail" />';
             }

}
function mayknow($currfoll,$userguid){
     //we get the user all the users that follow the current
    $count =0;
    forEach( $currfoll as $foll){
        if(check_entity_relationship($foll->guid,'follows',$userguid->guid)){
          $count++;
        }
        //we check if there is an inverse realtionship
        if(check_entity_relationship($userguid->guid,'follows',$foll->guid)){
          $count++;
        }
        //we check if our count is more than 15
        if($count >= 15){
          return true;
          }
    }
    return false;
  }
