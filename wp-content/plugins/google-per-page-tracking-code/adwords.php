<?php
/*
Plugin Name: Adwords Tracking Code
Plugin URI: http://www.geoguerrilla.com
Description: Allows Adwords Tracking Code To Be Added To Page
Version: 1.0
Author: Dustin Twyman
Author URI: http://www.geoguerrilla.com
/* ----------------------------------------------*/

$new_meta_boxes =
array(
"image" => array(
"name" => "adwords",
"std" => "",
"title" => "Adwords Tracking",
"description" => "Add Your Tracking Code")
);

function new_meta_boxes() {
global $post, $new_meta_boxes;
 
foreach($new_meta_boxes as $meta_box) {
$meta_box_value = get_post_meta($post->ID, $meta_box['name'].'_value', true);
 
if($meta_box_value == "")
$meta_box_value = $meta_box['std'];
 
echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
 
echo'<p><label for="'.$meta_box['name'].'_value">'.$meta_box['description'].'</label></p>'; 
echo'<textarea name="'.$meta_box['name'].'_value" cols="60" rows="8" style="width:97%">'.$meta_box_value.'</textarea>';

}
}

function create_meta_box() {
global $theme_name;
if ( function_exists( 'get_post_types' ) ) {
		$post_types = get_post_types( array(), 'objects' );
		foreach ( $post_types as $post_type ) {
			if ( $post_type->show_ui ) {
				add_meta_box( 'new-meta-boxes', 'Google Adwords Tracking Code', 'new_meta_boxes', $post_type->name, 'normal', 'high' );	
			}
		}
	} else {
		add_meta_box( 'new-meta-boxes', 'Google Adwords Tracking Code', 'new_meta_boxes', 'post', 'normal', 'high' );
		add_meta_box( 'new-meta-boxes', 'Google Adwords Tracking Code', 'new_meta_boxes', 'page', 'normal', 'high' );
	}
}

function save_postdata( $post_id ) {
global $post, $new_meta_boxes;
 
foreach($new_meta_boxes as $meta_box) {
// Verify
if ( !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) )) {
return $post_id;
}
 
$data = $_POST[$meta_box['name'].'_value'];
 
if(get_post_meta($post_id, $meta_box['name'].'_value') == "")
add_post_meta($post_id, $meta_box['name'].'_value', $data, true);
elseif($data != get_post_meta($post_id, $meta_box['name'].'_value', true))
update_post_meta($post_id, $meta_box['name'].'_value', $data);
elseif($data == "")
delete_post_meta($post_id, $meta_box['name'].'_value', get_post_meta($post_id, $meta_box['name'].'_value', true));
}
}

function disp_meta_boxes()
{
	global $post;
	$postID = $post->ID;
	$meta_values = get_post_meta($postID, 'adwords_value', true); 
	if (!isset($meta_values) || '' === $meta_values)
	return 0;
	echo $meta_values ; 
}

add_action('admin_menu', 'create_meta_box');
add_action('save_post', 'save_postdata');
add_action('wp_footer','disp_meta_boxes');

?>