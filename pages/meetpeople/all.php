
<?php
elgg_gatekeeper();
//we get the entities
//get the type of the meetpeople
$body = "<div>".elgg_view('page/elements/meetpeople/meetpeople_menu_view', $vars)."</div>";
$entities = elgg_get_entities(array(
'type' => 'user'
));
$body .='<div id="btsm">';
$body .= "<ul class='row'>";
forEach($entities as $item){
	$vars['title'] = "";
	$vars['all_meetpeople'] = $item;
	$body.=elgg_view('page/elements/meetpeople/meetpeople_list_view',$vars);

}
$body .="</ul></div>";
set_input('content',$body);
set_input('nogrid',true);
$allbody = elgg_view_layout('mutumbu_main',$vars);

 echo elgg_view_page('Meet People',$allbody);

 ?>
