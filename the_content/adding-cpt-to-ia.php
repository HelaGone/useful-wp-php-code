<?php
/*INSTANT ARTICLES INCLUDE POST TYPES*/
add_filter( 'instant_articles_post_types', 'add_post_types', 10,1 );
function add_post_types($post_type_array){
    $post_type_array = array();
    array_push($post_type_array,'cpt_1');
    array_push($post_type_array,'cpt_2');
    array_push($post_type_array,'post');
	return $post_type_array;
}