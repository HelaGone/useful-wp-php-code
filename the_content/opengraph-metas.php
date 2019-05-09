<?php
/**
 * [eza_meta_og] Esta función facilita escribir los meta tags necesarios para openGraph
 * @param $prop Se refiere al tipo del atributo de property
 * @param $content Refiere al contenido del atributo content
 * @return Hace echo del meta tag que se genera
 * Se usa para generar los meta tags en la función [eza_open_graph_meta]
*/
function eza_meta_og($prop, $content){
	if( !is_string($prop)||!is_string($content) ){
		return;
	}
	echo "<meta property='" . esc_attr( $prop ) . "' content='" . esc_attr( $content ) . "' />\n";
}

/**
 * [eza_meta_og_twitter] Esta función facilita escribir los meta tags necesarios para openGraph
 * @param $prop Se refiere al tipo del atributo de property
 * @param $content Refiere al contenido del atributo content
 * @return Hace echo del meta tag que se genera
 * Se usa para generar los meta tags en la función [eza_open_graph_meta]
*/
function eza_meta_og_twitter($name, $content){
	if( !is_string($name)||!is_string($content) ){
		return;
	}
	echo "<meta property='" . esc_attr( $name ) . "' content='" . esc_attr( $content ) . "' />\n";	
}

/**
 * [eza_open_graph_meta] Esta función se encarga de añadir los meta tags de openGraph 
 * al tag head para cada una de las distintas secciones del sitio
 * @param [null]
 * @return [null]
 * Esta función se ejecuta en la acción wp_head
*/
function eza_open_graph_meta(){
	global $post, $query_vars;
	$cat_name = $query_vars["category_name"];
	$cat_id = get_cat_ID($cat_name);

	$site_name = get_bloginfo("name");
	$locale = get_locale();

	//Generales
	eza_meta_og("og:locale", $locale);
	eza_meta_og("og:site_name", $site_name);

	if(is_front_page()){
		eza_meta_og("og:type", "website");
		eza_meta_og("og:title", get_bloginfo("description") );
		eza_meta_og("og:description", get_post_meta($post->ID, "_meta_title", true));
		eza_meta_og("og:url", get_bloginfo("url"));

		//twitter
		eza_meta_og_twitter("twitter:card", "summary_large_image");
		eza_meta_og_twitter("twitter:description", get_post_meta($post->ID, "_meta_title", true));
		eza_meta_og_twitter("twitter:title", get_bloginfo("description"));
		eza_meta_og_twitter("twitter:site", "@ErizosMx");

	}else if(is_category()){

		eza_meta_og("og:type", "object");
		eza_meta_og("og:title", single_term_title(get_bloginfo("name")." - ", false));
		eza_meta_og("og:url", get_category_link($cat_id));
		eza_meta_og("og:site_name", get_bloginfo("name"));

	}else if((is_single()||is_page())&&!is_front_page()){
		$post_id = get_queried_object_id();
		$post_object = get_post($post_id);
		$url = get_permalink($post_id);
		$title = get_the_title($post_id);
		$description = get_post_meta($post_id, '_meta_description', true);
		$updated_time = $post_object->post_modified;

		$image = get_the_post_thumbnail_url($post_id);
		$image_id = get_post_thumbnail_id();
		$image_alt = get_post_meta($image_id, "_wp_attachment_image_alt", true);
		$image_metadata = wp_get_attachment_metadata($image_id);
		$image_width = $image_metadata["width"];
		$image_height = $image_metadata["height"];

		eza_meta_og("og:type", "article");
		eza_meta_og("og:title", esc_attr($title)." | ".esc_attr($site_name));
		eza_meta_og("og:description", esc_attr($description));
		eza_meta_og("og:url", esc_url($url));
		if($image) eza_meta_og("og:image", esc_url($image));
		eza_meta_og("og:updated_time", $updated_time);
		eza_meta_og("og:image:alt", $image_alt);
		eza_meta_og("og:image:width", $image_width);
		eza_meta_og("og:image:height", $image_height);

	}
}
//add_action("wp_head", "eza_open_graph_meta");


