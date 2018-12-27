<?php
function disallow_insert_term($term, $taxonomy) {

    $user = wp_get_current_user();

    if ( $taxonomy === 'post_tag' && in_array('somerole', $user->roles) ) {

        return new WP_Error(
            'disallow_insert_term', 
            __('Your role does not have permission to add terms to this taxonomy')
        );

    }

    return $term;

}

add_filter('pre_insert_term', 'disallow_insert_term', 10, 2);