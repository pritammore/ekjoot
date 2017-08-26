<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

$conikal_home_settings = get_option('conikal_home_settings','');
$home_victory = isset($conikal_home_settings['conikal_home_victory_field']) ? $conikal_home_settings['conikal_home_victory_field'] : '';
$home_victory_hide_logined = isset($conikal_home_settings['conikal_home_victory_hide_logined_field']) ? $conikal_home_settings['conikal_home_victory_hide_logined_field'] : '';
$home_spotlight = isset($conikal_home_settings['conikal_home_spotlight_field']) ? $conikal_home_settings['conikal_home_spotlight_field'] : '';
$home_spotlight_hide_logined = isset($conikal_home_settings['conikal_home_spotlight_hide_logined_field']) ? $conikal_home_settings['conikal_home_spotlight_hide_logined_field'] : '';
$home_spotlight_title = isset($conikal_home_settings['conikal_home_spotlight_title_field']) ? $conikal_home_settings['conikal_home_spotlight_title_field']: '';
$home_spotlight_text = isset($conikal_home_settings['conikal_home_spotlight_text_field']) ? $conikal_home_settings['conikal_home_spotlight_text_field'] : '';

$margin_spotlight = 'margin-top: 30px';
if($home_victory && $home_victory_hide_logined) {
    if (!is_user_logged_in()) {
        $margin_spotlight = '';
    }
} else if ($home_victory) {
    $margin_spotlight = '';
}
?>

<div class="ui grid">
	<div class="sixteen wide column tablet computer only">
		<div class="home-spotlight" style="<?php echo esc_attr($margin_spotlight) ?>">
			<?php if ($home_spotlight && $home_spotlight_hide_logined) { ?>
				<?php if (!is_user_logged_in()) { ?>
					<div class="ui container">
						<div class="ui very padded segment">
							<h2 class="ui center aligned header">
						    	<div class="content">
						    		<?php echo esc_html($home_spotlight_title); ?>
						    		<div class="sub header"><?php echo esc_html($home_spotlight_text); ?></div>
						    	</div>
						    </h2>
						    <div class="ui basic center aligned segment">
						    <?php 
								$terms = get_terms( array(
								    'taxonomy' => 'petition_topics',
								    'orderby' => 'count',
								    'order' => 'DESC',
								    'hide_empty' => true,
								    'number' => 10
								) );
								if  ($terms) {
								  foreach ($terms as $term ) { ?>
								  	<a href="<?php echo esc_html( get_term_link($term->term_id ) ) ?>" data-bjax>
								    	<span class="ui label"><?php echo esc_html($term->name) ?></span>
								    </a>
							<?php 	}
								}
							?>
							</div>
						</div>
					</div>
				<?php } ?>
			<?php } elseif ($home_spotlight) { ?>
				<div class="ui container">
					<div class="ui very padded segment">
						<h2 class="ui center aligned header">
					    	<div class="content">
					    		<?php echo esc_html($home_spotlight_title); ?>
					    		<div class="sub header"><?php echo esc_html($home_spotlight_text); ?></div>
					    	</div>
					    </h2>
					    <div class="ui basic center aligned segment">
					    <?php 
							$terms = get_terms( array(
							    'taxonomy' => 'petition_topics',
							    'orderby' => 'count',
							    'order' => 'DESC',
							    'hide_empty' => true,
							    'number' => 10
							) );
							if  ($terms) {
							  foreach ($terms  as $term ) { ?>
							  	<a href="<?php echo esc_html( get_term_link($term->term_id ) ) ?>" data-bjax>
							    	<span class="ui label"><?php echo esc_html($term->name) ?></span>
							    </a>
						<?php 	}
							}
						?>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
