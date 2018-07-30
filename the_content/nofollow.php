<?php
//NO FOLLOW FOR <a> TAGS
function nofollow_enternal_links( $content ) {

    $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>";
    if(preg_match_all("/$regexp/siU", $content, $matches, PREG_SET_ORDER)) {
        if( !empty($matches) ) {
            $srcUrl = get_option('home');
            for ($i=0; $i < count($matches); $i++){
                $tag = $matches[$i][0];
                $tag2 = $matches[$i][0];
                $url = $matches[$i][0];
                $noFollow = '';

                $pattern = '/rel\s*=\s*"\s*[n|d]ofollow\s*"/';
                preg_match($pattern, $tag2, $match, PREG_OFFSET_CAPTURE);

                if( count($match) == 0 ){
                    $noFollow .= ' rel="nofollow" ';
                }

                $pos = strpos($url,$srcUrl);
                if ($pos === false) {

                    if( preg_match('(rel=["noopener]+)', $tag, $coinc) ){
                    	// print_r( $coinc[0] );
                    }else{
                    	$tag = rtrim ($tag,'>');
                    	$tag .= $noFollow.'>';
                    	$content = str_replace($tag2,$tag,$content);
                    }
                }
            }
        }
    }
    $content = str_replace(']]>', ']]&gt;', $content);
    return $content;
}
//add_filter( 'the_content', 'nofollow_enternal_links');