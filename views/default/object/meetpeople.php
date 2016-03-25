<?php 
   //we check the context of the entity ,the  
	echo "we are in the object file";
    echo elgg_view_title($vars['entity']->title);
    echo elgg_view('output/longtext', array('value' => $vars['entity']->description));
    echo elgg_view('output/text', array('value' => $vars['entity']->name));
    echo elgg_view('output/text', array('value' => $vars['entity']->seriesname));
  ?>