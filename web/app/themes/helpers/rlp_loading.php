<?php

function getACFImage( $imagename,$size = 'xs',$class = null, $width = '100%' ) {
    $image = get_field($imagename);
    return '<img class="'.$class.'" src="'.$image['sizes'][$size].'" width="'.$width.'" alt=""  data-media-width="'.$image['width'].'" data-media-height="'.$image['height'].'">';
}

function getFeaturedImage( $id,$size = 'xs',$class = null, $width = '100%' ) {
    $image = wp_get_attachment_metadata($id);
    $url   = wp_get_attachment_image_url($id,$size);
    return '<img class="'.$class.'" src="'.$url.'" alt=""  width="'.$width.'" data-media-width="'.$image['width'].'" data-media-height="'.$image['height'].'">';
}
