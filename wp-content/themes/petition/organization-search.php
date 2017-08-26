<?php

/*
Template Name: Organization Search
*/

/**
 * @package WordPress
 * @subpackage Petition
 */

$keyword = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';

$type_taxonomies = array( 
    'decisionmakers_organization'
);
$type_args = array(
    'orderby'           => 'name', 
    'order'             => 'ASC',
    'hide_empty'        => false,
    'search'            => $keyword
);
$type_terms = get_terms($type_taxonomies, $type_args);
$topics = array();
$topics['results'] = array();

if ($type_terms) {
    $topics['topics'] = true;
    $count = 0;
    foreach ($type_terms as $type_term) {
    	array_push($topics['results'], array('name' => $type_term->name, 'value' => $type_term->name));
    }
    echo json_encode($topics);
} else {
    echo json_encode(array('topics'=>false, 'message'=>__('Not found topics.', 'petition')));
}

?>