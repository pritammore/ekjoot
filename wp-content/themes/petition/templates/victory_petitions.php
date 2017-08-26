<?php 

/**
 * @package WordPress
 * @subpackage Petition
 */
$conikal_general_settings = get_option('conikal_general_settings','');
$minimum_signature = isset($conikal_general_settings['conikal_minimum_signature_field']) ? $conikal_general_settings['conikal_minimum_signature_field'] : '';
$conikal_home_settings = get_option('conikal_home_settings','');
$home_header = isset($conikal_home_settings['conikal_home_header_field']) ? $conikal_home_settings['conikal_home_header_field'] : '';
$home_header_hight = isset($conikal_home_settings['conikal_hight_slideshow_field']) ? $conikal_home_settings['conikal_hight_slideshow_field'] : '675';
$home_header_hight = intval($home_header_hight) - 130;
$home_header_hide_logined = isset($conikal_home_settings['conikal_home_header_hide_logined_field']) ? $conikal_home_settings['conikal_home_header_hide_logined_field'] : ''; 

$args = array(
        'posts_per_page'   => 7,
        'post_type'        => 'petition',
        'orderby'          => 'post_date',
        'order'            => 'DESC',
        'meta_key'         => 'petition_victory',
        'meta_value'       => '1',
        'post_status'      => 'publish' );

$args['meta_query'] = array('relation' => 'AND');

if ($minimum_signature != 0) {
    array_push($args['meta_query'], array(
        'key'     => 'petition_sign',
        'value'   => $minimum_signature,
        'type'    => 'NUMERIC',
        'compare' => '>='
    ));
}
    array_push($args['meta_query'], array(
        'key'     => 'petition_status',
        'value'   => '2',
        'compare' => '!='
    ));

$victorys = get_posts($args);


// hight slideshow
$home_feature_class = ' none-hero';
$hight_slideshow = '';
if ( ($home_header != 'none') && ($home_header_hide_logined != '') ) {
    if (!is_user_logged_in()) {
        $hight_slideshow = $home_header_hight . 'px';
        $home_feature_class = '';
    }
} else if ($home_header != 'none') {
    $hight_slideshow = $home_header_hight . 'px';
    $home_feature_class = '';
}
?>
<?php if ($victorys) { ?>
<div class="ui grid tablet computer only">
	<div class="home-feature<?php echo esc_attr($home_feature_class) ?>" style="top: <?php echo esc_attr($hight_slideshow); ?>">
		<div class="sixteen wide column" style="margin-left: 30px;">
			<div class="ui container">
				<div class="ui raised segment" style="padding: 0;">
					<div class="feature-petition">
						<?php foreach($victorys as $victory) : setup_postdata($victory);
			                $id = $victory->ID;
			                $link = get_permalink($id);
			                $title = get_the_title($id);
			                $category =  wp_get_post_terms($id, 'petition_category', true);
			                $excerpt = conikal_get_excerpt_by_id($id);
			                $comments = wp_count_comments($id);
			                $gallery = get_post_meta($id, 'petition_gallery', true);
			                $images = explode("~~~", $gallery);
			                $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'petition-medium' );
			                $address = get_post_meta($id, 'petition_address', true);
			                $city = get_post_meta($id, 'petition_city', true);
			                $state = get_post_meta($id, 'petition_state', true);
			                $neighborhood = get_post_meta($id, 'petition_neighborhood', true);
			                $zip = get_post_meta($id, 'petition_zip', true);
			                $country = get_post_meta($id, 'petition_country', true);
			                $lat = get_post_meta($id, 'petition_lat', true);
			                $lng = get_post_meta($id, 'petition_lng', true);
			                $receiver = get_post_meta($id, 'petition_receiver', true);
			                $receiver = explode(',', $receiver);
			                $position = get_post_meta($id, 'petition_position', true);
			                $position = explode(',', $position);
			                $goal = get_post_meta($id, 'petition_goal', true);
			                $sign = get_post_meta($id, 'petition_sign', true);
			                $updates = get_post_meta($id, 'petition_update', true);
			                $thumb = get_post_meta($id, 'petition_thumb', true);
			                $status = get_post_meta($id, 'petition_status', true);

			                $user_avatar = get_the_author_meta('avatar' , get_the_author_meta('ID'));
			                if($user_avatar != '') {
			                    $avatar = $user_avatar;
			                } else {
			                    $avatar = get_template_directory_uri().'/images/avatar.svg';
			                }
			                $avatar = conikal_get_avatar_url( get_the_author_meta('ID'), array('size' => 28, 'default' => $avatar) );

						?>
				        <div style="margin: 0">
			                <div class="ui grid">
			                	<div class="sixteen wide mobile eight wide tablet eight wide computer column">
			                        <a class="ui fluid image" href="<?php echo esc_url($link) ?>" data-bjax>
			                        	<?php if ($sign >= $goal || $status == '1') { ?>
				                        <div class="ui primary large ribbon label victory-label" style="z-index: 1; overflow: hidden;">
				                                <i class="flag icon"></i>
				                                <?php esc_html_e('Victory!', 'petition') ?>
				                        </div>
				                        <?php } ?>
			                            <?php
				                            if ($gallery) { 
				                                if (has_post_thumbnail()) { ?>
				                                <img class="ui fluid image" src="<?php echo esc_url($thumbnail[0]) ?>" alt="<?php echo esc_attr($title) ?>">
				                                <?php } elseif ($gallery) { ?>
				                                <img class="ui fluid image" src="<?php echo esc_url($images[1]) ?>" alt="<?php echo esc_attr($title) ?>">
				                                <?php } ?>
				                            <?php } elseif ($thumb) { ?>
				                                <img class="ui fluid image" src="<?php echo esc_url($thumb) ?>" alt="<?php echo esc_attr($title) ?>">
				                            <?php } else { ?>
				                                <img class="ui fluid bordered image" src="<?php echo esc_url(get_template_directory_uri() . '/images/thumbnail.svg') ?>" alt="<?php echo esc_attr($title) ?>">
				                        <?php } ?>
			                        </a>
			                    </div>
			                    <div class="sixteen wide mobile eight wide tablet eight wide computer column">
			                    	<div class="ui basic segment" style="padding-left: 0">
			                    		<div class="feature-content">
				                    		<div class="ui grid">
	                                            <div class="sixteen wide column">
	                                                <div class="ui header victory-title">
	                                                    <div class="content">
	                                                        <div class="sub header truncate"><i class="send icon"></i><?php esc_html_e('Petition to', 'petition') ?> <?php echo esc_html($receiver[0]) ?></div>
	                                                        <a href="<?php echo esc_url($link) ?>" data-bjax><?php echo esc_html($title) ?></a>
	                                                    </div>
	                                                </div>
	                                            </div>
	                                            <div class="sixteen wide column tablet computer only" style="padding-top: 0; padding-bottom: 0;">
	                                                <div class="text grey"><?php echo esc_html($excerpt) ?></div>
	                                            </div>
	                                        </div>
							            </div>
							            <div class="ui grid computer only">
								            <div class="feature-footer">
							                    <div class="sixteen wide column">
								                    <span class="text grey"><i class="marker icon"></i><?php echo ($city ? esc_html($city) . ', ' : '') . ($state ? esc_html($state) . ', ' : '') . ($country ? esc_html($country) : '') ?></span>
							                        <div class="ui indicating tiny primary progress petition-goal" data-value="<?php echo esc_html($sign) ?>" data-total="<?php echo ($status == '1' ? esc_html($sign) : esc_html($goal) ) ?>">
									                    <div class="bar">
									                        <div class="progress"></div>
									                    </div>
									                </div>
									            </div>
									            <div class="sixteen wide">
							                        <a class="ui large primary label" href="<?php echo esc_url($link) ?>" data-bjax>
								                		<i class="user icon"></i><?php echo conikal_format_number('%!,0i', $sign) ?> 
						                        		<?php _e('supporters', 'petition') ?>
					                        		</a>
				                                	<span class="ui large label">
						                            	<i class="comments icon"></i><?php echo conikal_format_number('%!,0i', $comments->approved); ?>
					                        		</span>
							                		<?php if($category) { ?>
							                            <a class="ui large label" href="<?php echo get_category_link($category[0]->term_id) ?>" data-bjax>
							                            	<i class="star icon"></i><?php echo esc_html($category[0]->name); ?>
							                            </a>
							                        <?php } ?>
							                        <a style="float: right" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' )); ?>" data-bjax>
							                            <img class="ui avatar bordered image" src="<?php echo esc_url($avatar) ?>" alt="<?php the_author() ?>" />
							                            <?php //the_author() ?>
							                        </a>
						                        </div>
						                    </div>
						                </div>
				                    </div>
			                    </div>
			                </div>
			            </div>
				    	<?php endforeach; ?>
				    </div>
			    </div>

			    <div class="feature-navigation">
			    	<?php 
			    	$i = 0;
			    	foreach($victorys as $victory) : setup_postdata($victory);
			                $id = $victory->ID;
			                $link = get_permalink($id);
			                $title = get_the_title($id);
			                $gallery = get_post_meta($id, 'petition_gallery', true);
			                $images = explode("~~~", $gallery);
			                $thumb = get_post_meta($id, 'petition_thumb', true);

			                if(has_post_thumbnail($id)) {
				                $thumb_id = get_post_thumbnail_id($id);
				                $thumbnail = wp_get_attachment_image_src($thumb_id, 'petition-small', true);
				                $thumbnail = $thumbnail[0];
				            } elseif ($gallery) {
				                $thumbnail = $images[1];
				            } elseif ($thumb) {
				                $thumbnail = $thumb;
				            } else {
				                $thumbnail = get_template_directory_uri() . '/images/thumbnail-small.svg';
				            }
						?>
					<div>
			        	<img class="ui fluid image" src="<?php echo esc_url($thumbnail) ?>" alt="<?php echo esc_attr($title) ?>">
		                <!--<p class="text grey truncate"><?php echo esc_html($title) ?></p>-->
				    </div>
			        <?php $i++ ?>
			        <?php endforeach; ?>
			    </div>
			</div>
		</div>
	</div>
</div>
<?php } ?>