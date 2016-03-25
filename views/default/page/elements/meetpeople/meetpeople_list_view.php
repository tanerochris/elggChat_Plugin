<?php 
//we get the profile pic 
//this will be subsequently transformed as a function
$prof_pic = elgg_get_entities_from_relationship(array(
'relationship' => 'prof_pic_of',
'relationship_guid'=> $vars['all_meetpeople']->guid,
'inverse_relationship' => true ) );
//get the profile image pic 
if(count($prof_pic) >=1){
$dir_lenth = strlen($prof_pic[0]->filename);
$img_length= strlen(basename($prof_pic[0]->filename));
$str = substr($prof_pic[0]->filename,0,$dir_lenth - $img_length);
$img ='<img alt="a photo" src="http://localhost/1/38/'.$str.'/'.$prof_pic[0]->thumbnail.'" />';
}else $img ='<img alt="a photo" src="http://localhost/elgg/elgg-1.11.4/mod/meetpeople/_graphics/defaultmedium.gif" class="img-thumbnail" />';
//we check the stats of the artist 
if($vars['all_meetpeople']->stats !== NULL && $vars['all_meetpeople']->stats == 'artist'){
    $artist = "<h5 class='job' style='text-align : center;color:#fecba3;'>ARTIST</h5>";
}
?>

<liv class="col-md-6" style='padding:10px 10px;'>
<div class='media'>
 <div class="media-left">
		<?php echo $img ; ?>
	</div>
    <div class='media-body'>
        <h5 class="media-heading" style='text-align : center' > <?php echo $vars['all_meetpeople']->username; ?> </h5>
        <div class='row' >
            <button style='border-radius :none;margin-left :2px;height :45%;background-color:#6595ac;' class="btn btn-primary follow col-md-5" data-u = <?php echo $vars['all_meetpeople']->guid; ?> >follow</button>&nbsp;&nbsp;&nbsp;&nbsp;
<button style='border-radius :none;margin-left :2px;height :45%;background-color:#7adf9c;'  class="btn btn-primary follow chat col-md-5" data-u = <?php echo $vars['all_meetpeople']->guid; ?> >chat</button>
        </div>
	</div>  
</div>
	
    
</liv>