<?php 
	
	/* ---------------------------------------------------------------------
	// UNUSED FUNCTIONS 
	---------------------------------------------------------------------- */
	/**
	 * UNUSED FUNCTION 
	*/
	/*
	function get_featured_category_post_home($slug, $duplicate){
		$args = array('exclude' => $duplicate, 'posts_per_page' => 1, 'post_status' => 'publish', 'orderby' => 'date', 'order' => 'DESC', 'category_name' => $slug, 'meta_key'=>'cat_top_home', 'meta_value'=> 'true', 'meta_compare'=>'IN');
		$feat_post_home = get_posts($args);
		return $feat_post_home;
	}*/

	// HELPER FUNCTIONS FOR OLD COVER OPTIONS /////////////////////////////////////////////////////
	/*
	function news_get_select_posts( $group_name = NULL, $input_name = NULL, $selected = NULL){
		$html = "<select class = 'enhanced_select' name='{$group_name}[{$input_name}]' id='{$group_name}[{$input_name}]'>";
		$args = array(
					"post_type" 		=> array('post'),
					"posts_per_page" 	=> 1000,
					"post_status" 		=> "publish",
					"orderby"			=> "date",
					"order"				=> "DESC"
				);
		$posts = new WP_Query($args);
		$html .= "<option value=''>Espacio vac&iacute;o</option>";
		while ( $posts->have_posts() ) {
			$posts->the_post();
			$selected_echo = selected(get_the_ID(), $selected, FALSE);
			$html .= "<option value='". get_the_ID() . "' {$selected_echo}> ". sanitize_title(get_the_title()) . "</option>";
		}
		$html .= "</select>";
		return $html;
	}
	function news_get_select_posts_b( $group_name = NULL, $input_name = NULL, $selected = NULL){
		$html = "<select class = 'enhanced_select' name='{$group_name}[{$input_name}]' id='{$group_name}[{$input_name}]'>";
		$args = array(
					"post_type" 		=> array('post'),
					"posts_per_page" 	=> 300,
					"post_status" 		=> "publish",
					"orderby"			=> "date",
					"order"				=> "DESC"
				);
		$posts = new WP_Query($args);
		$html .= "<option value=''>Espacio vac&iacute;o</option>";
		while ( $posts->have_posts() ) {
			$posts->the_post();
			$selected_echo = selected(get_the_ID(), $selected, FALSE);
			$html .= "<option value='". get_the_ID() . "' {$selected_echo}> ". sanitize_title(get_the_title()) . "</option>";
		}
		$html .= "</select>";	
		return $html;
	}
	function news_get_select_posts_c( $group_name = NULL, $input_name = NULL, $selected = NULL){
		$html = "<select class = 'enhanced_select' name='{$group_name}[{$input_name}]' id='{$group_name}[{$input_name}]'>";
		$args = array(
					"post_type" 		=> array('post'),
					"posts_per_page" 	=> 300,
					"post_status" 		=> "publish",
					"orderby"			=> "date",
					"order"				=> "DESC"
				);
		$posts = new WP_Query($args);
		$html .= "<option value=''>Espacio vac&iacute;o</option>";
		while ( $posts->have_posts() ) {
			$posts->the_post();
			$selected_echo = selected(get_the_ID(), $selected, FALSE);
			$html .= "<option value='". get_the_ID() . "' {$selected_echo}> ". sanitize_title(get_the_title()) . "</option>";
		}
		$html .= "</select>";
		return $html;
	}*/
	// END HELPER FUNCITONS FOR OLD COVER OPTIONS /////////////////////////////////////////////////

	/*
	//DEPRECATED FUNCTION
	// GET GRAFICOS FROM CERO CERO AND INSERT NEW POST WITH FEATURED IMAGE
	function pleyers_insert_post_and_attachment(){
		$url = 'http://cerocero.mx/api/';
		$graficos = file_get_contents($url);
		$json = json_decode($graficos, true);

		$args = array(
				'post_type'			=> 'post',
				'posts_per_page'	=> -1
			);
		$posts_in_db = get_posts($args);
		$ids_in_db = array();
		foreach($posts_in_db as $post):
			setup_postdata($post);
			$ids_in_db[] = get_post_meta($post->ID, 'id_cerocero', true);
		endforeach;

		foreach($json as $item) {
			$ceroceroid 	= $item['id'];
			$title 			= $item['name'];
			$date 			= $item['date'];
			$img 			= $item['thumbnail'];
			$grafico = array(
				'post_date' 		=> $date,
				'post_title' 		=> $title,
				'post_type'			=> 'graficos',
				'post_status'		=> 'publish',
			);
			if (!in_array($ceroceroid, $ids_in_db)) {
				$post_id = wp_insert_post( $grafico );
				$filename = basename($img);
				$upload_file = wp_upload_bits($filename, null, file_get_contents($img));
				$wp_filetype = wp_check_filetype($filename, null );
				$attachment = array(
					'post_mime_type' => $wp_filetype['type'],
					'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
					'post_content' => '',
					'post_status' => 'inherit'
				);
				$attachment_id = wp_insert_attachment( $attachment, $upload_file['file'] );
				require_once(ABSPATH . "wp-admin" . '/includes/image.php');
				$attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
				wp_update_attachment_metadata( $attachment_id, $attachment_data );
				update_post_meta($post_id, 'id_cerocero', $ceroceroid, '');
				set_post_thumbnail($post_id, $attachment_id);
		 	}
		}
		return;
	}
	add_action( 'publish_post', 'pleyers_insert_post_and_attachment', 10, 2); */

	/*
	// INSERTAR POST THUMBNAIL DESDE URL /////////////////////////////////////////////////
	function set_featured_image( $image_url, $post_id  ){
	    $upload_dir = wp_upload_dir();
	    $image_data = file_get_contents($image_url);
	    $filename = basename($image_url);
	    $file = (wp_mkdir_p($upload_dir['path'])) ? $upload_dir['path'].'/'.$filename : $upload_dir['basedir'].'/'.$filename;
	    file_put_contents($file, $image_data);
	    $wp_filetype = wp_check_filetype($filename, null );
	    $attachment = array(
	        'post_mime_type' => $wp_filetype['type'],
	        'post_title' => sanitize_file_name($filename),
	        'post_content' => '',
	        'post_status' => 'inherit'
	    );
	    $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
	    require_once(ABSPATH . 'wp-admin/includes/image.php');
	    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
	    $res1= wp_update_attachment_metadata( $attach_id, $attach_data );
	    $res2= set_post_thumbnail( $post_id, $attach_id );
	}
	*/

	/**
	 * Imprime una lista separada por commas de todos los terms asociados al post id especificado
	 * los terms pertenecen a la taxonomia especificada. Default: Category
	 *
	 * @param  int     $post_id
	 * @param  string  $taxonomy
	 * @return string
	 */
	/*function print_the_terms($post_id, $taxonomy = 'category'){
		$terms = get_the_terms( $post_id, $taxonomy );

		if ( $terms and ! is_wp_error($terms) ){
			$names = wp_list_pluck($terms ,'name');
			echo implode(', ', $names);
		}
	}*/

	/**
	 * Regresa la url del attachment especificado
	 * @param  int     $post_id
	 * @param  string  $size
	 * @return string  url de la imagen
	 */
	/*function attachment_image_url($post_id, $size){
		$image_id   = get_post_thumbnail_id($post_id);
		$image_data = wp_get_attachment_image_src($image_id, $size, true);
		if(!empty($image_data)){
			echo isset($image_data[0]) ? $image_data[0] : '';
		}
	}*/

	/**
	 * Echoes active if the page showing is associated with the parameter
	 * @param  [string] $compare, Array $compare
	 * @param  [Bool] $echo use FALSE to use with php, default is TRUE to echo value
	 * @return [string] active || false
	 */
	/*function nav_is($compare = array(), $echo = TRUE){
		$query = get_queried_object();
		$inner_array = array();
		if(gettype($compare) == 'string'){
			$inner_array[] = $compare;
		}else{
			$inner_array = $compare;
		}
		foreach ($inner_array as $value) {
			if( isset($query->slug) AND preg_match("/$value/i", $query->slug)
				OR isset($query->name) AND preg_match("/$value/i", $query->name)
				OR isset($query->rewrite) AND preg_match("/$value/i", $query->rewrite['slug'])
				OR isset($query->post_name) AND preg_match("/$value/i", $query->post_name)
				OR isset($query->post_title) AND preg_match("/$value/i", remove_accents(str_replace(' ', '-', $query->post_title) ) ) )
			{
				if($echo){
					echo 'active';
				}else{
					return 'active';
				}
				return false;
			}
		}
		return false;
	}*/

	/**
	 * [add_tags_categories] Hace accesibles los tags para el CPT episodios
	 * @param [none]
	 * @return [none]
	 * UNUSED 
	 * El post type episodios ya no existe más
	*/
	/*
	function add_tags_categories() {
		register_taxonomy_for_object_type('post_tag', 'episodios');
	}
	//add_action('init', 'add_tags_categories');
	*/

	/**
	 * [multiexplode] Convierte strings a arrays
	 * @param [Array] $delimiters
	 * @param [String] $string
	 * UNUSED 
	*/
	/*function multiexplode ($delimiters,$string) {
	    $ready = str_replace($delimiters, $delimiters[0], $string);
	    $launch = explode($delimiters[0], $ready);
	    return  $launch;
	}*/

	/**
	 * [sc_dato] Anade información en el contenido de la nota
	 * @param [Object] $params 
	 * @param [Object] $content
	 * UNUSED
	*/
	/*function sc_dato($params, $content = null) {
		// default parameters
		extract(shortcode_atts(array(
			'style' => ''
		), $params));
	  return "<div class='sc_dato'><h4>DATO</h4>" . do_shortcode($content) . "</div>";
	}
	//add_shortcode('dato','sc_dato');*/


	/**
	 * [sc_referencia] Anade información en el contenido de la nota
	 * @param [Object] $params 
	 * @param [Object] $content
	 * UNUSED
	*/
	/*function sc_referencia($params, $content = null) {
		extract(shortcode_atts(array(
			'style' => ''
		), $params));
	  return "<span class='sc_referencia' data='" . do_shortcode($content) . "'>i</span>";
	}
	//add_shortcode('referencia','sc_referencia');*/

	// BANNER DE CODIGO ESPAGUETI COMO SHORTCODE
	/**
	 * [pleyers_banner_ce] Anade un banner de código espagueti en el contenido de la nota
	 * Ahora se puede hacer por medio del block de imagen de Gutenberg
	 * @param [Object] $params 
	 * @param [Object] $content
	 * UNUSED
	*/
	/*function pleyers_banner_ce($atts, $content = null) {
		$a = shortcode_atts( array(
		        'title' => 'default_title',
		        'link'  =>  'default_link'
		    ), $atts );

		return '<div class="contentdor-banner_ce" title="'.esc_attr($a['title']).'" link="'.esc_attr($a['link']).'"><a href="'.esc_attr($a['link']).'" target="_blank" rel="noopener"><ul id="ce_banner_sc"><li><img class="logo_codesp" src="'.get_template_directory_uri().'/images/logos-codigoespagueti.png" /></li><li><div class="centrado-banner_ce" style="color: #00a7ce; "> '.do_shortcode($content).'</div></li></ul></a></div>';
	}
	// add_shortcode('banner_ce','pleyers_banner_ce');*/

	/**
	 * [pleyers_lectura_center] Interrumpe el flujo del layout y permite que se inserten imágenes a full with
	 * mientras se mantiene el texto centrado
	 * Ahora se puede hacer por medio del block de imagen de Gutenberg con la propiedad align-wide
	 * @param [Object] $params 
	 * @param [Object] $content
	 * UNUSED
	*/
	/*function pleyers_lectura_center($params, $content = null) {
		// default parameters
		extract(shortcode_atts(array(
			'style' => ''
		), $params));
	  return
		"<div class='contenido capital reading_container'>" . do_shortcode($content) . "</div>";
	}
	//add_shortcode('centrar-lectura','pleyers_lectura_center');*/