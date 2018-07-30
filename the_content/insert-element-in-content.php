<?php
	// ADDING DIV FOR ADS WITHIN THE CONTENT
	add_filter( 'the_content', 'prefix_insert_post_ads' );
	/**
	 * Insert code for ads after n(3) paragraph of single post content.
	 * @param  string $content Post content
	 * @return string Amended content
	 */
	function prefix_insert_post_ads( $content ) {
		$ad_code = '<div id="div-id"><p>More elements inside div</p></div>';
		if ( is_single() && ! is_admin() ) {
			return prefix_insert_after_paragraph( $ad_code, 1, $content );
		}
		return $content;
	}
	/**
	 * Insert something after a specific paragraph in some content.
	 * @param  string $insertion    Likely HTML markup, ad script code etc.
	 * @param  int    $paragraph_id After which paragraph should the insertion be added. Starts at 1.
	 * @param  string $content      Likely HTML markup.
	 * @return string               Likely HTML markup.
	 */
	function prefix_insert_after_paragraph( $insertion, $paragraph_id, $content ) {
		$closing_p = '</p>';
		$paragraphs = explode( $closing_p, $content );
		$numParagraphs = count($paragraphs);
		foreach ($paragraphs as $index => $paragraph) {
			// Only add closing tag to non-empty paragraphs
			if ( trim( $paragraph ) ) {
				// Adding closing markup now, rather than at implode, means insertion
				// is outside of the paragraph markup, and not just inside of it.
				$paragraphs[$index] .= $closing_p;
			}
			// + 1 allows for considering the first paragraph as #1, not #0.
 			if ( $paragraph_id == $index + 1 ) {
				$paragraphs[ ceil($numParagraphs/2) ] .= $insertion;
			}
		}
		return implode( '', $paragraphs );
	}