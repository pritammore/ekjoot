<?php
/*
Template Name: Contribute
*/

/**
 * @package WordPress
 * @subpackage Petition
 */

$current_user = wp_get_current_user();
if (!is_user_logged_in()) {
    wp_redirect(home_url());
}

global $post;
global $current_user;
get_header();

    if (isset($_GET['petition_id']) && $_GET['petition_id'] != '') {
        $petition_id = sanitize_text_field($_GET['petition_id']);

        $args = array(
            'p' => $petition_id,
            'post_type' => 'petition',
            'post_status' => array('publish', 'pending')
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while($query->have_posts()) {
                $query->the_post();
                $link = get_permalink($petition_id);
                $title = get_the_title($petition_id);
                $content = get_the_content($petition_id);
                $form_id = get_post_meta($petition_id, 'petition_contribute', true);
                $status = get_post_status($form_id);

                // get form option
                $give_prefix = '_give_';
                $goal_option = get_post_meta($form_id, $give_prefix . 'goal_option', true);
                $set_goal = get_post_meta($form_id, $give_prefix . 'set_goal', true);
                $set_goal = give_format_decimal( give_maybe_sanitize_amount( $set_goal ), false, false );
                $goal_format = get_post_meta($form_id, $give_prefix . 'goal_format', true);
                $close_form_when_goal_achieved = get_post_meta($form_id, $give_prefix . 'close_form_when_goal_achieved', true);
                $goal_achieved_message = get_post_meta($form_id, $give_prefix . 'form_goal_achieved_message', true);
                $custom_amount_minimum = get_post_meta($form_id, $give_prefix . 'custom_amount_minimum', true);
                $custom_amount_minimum = give_format_decimal( give_maybe_sanitize_amount( $custom_amount_minimum ), false, false );
                $donation_levels = get_post_meta($form_id, $give_prefix . 'donation_levels', true);
                $reveal_label = get_post_meta($form_id, $give_prefix . 'reveal_label', true);
                $form_content = get_post_meta($form_id, $give_prefix . 'form_content', true);

                $goal_format_selection = array('amount' => __('Amount', 'petition'), 'percentage' => __('Percentage', 'petition'));
                $button_label_selection = array(__('Contribute', 'petition'), __('Donate', 'petition'), __('Support', 'petition'));
                $close_form_selection = array('enabled' => __('Enable', 'petition'), 'disabled' => __('Disable', 'petition'));

                // get currency format
                $currency_position = give_get_option( 'currency_position', 'before' );
                $currency_symbol = give_currency_symbol();
            }
        }
        wp_reset_postdata();
        wp_reset_query();
    } else {
        $petition_id = isset($_GET['petition_id']) ? sanitize_text_field($_GET['petition_id']) : '';
        $link = get_permalink($petition_id);
    }
    $post_author_id = get_post_field( 'post_author', $petition_id );
?>
<?php if ( $petition_id != '' && ($post_author_id == $current_user->ID || current_user_can('editor') || current_user_can('administrator')) ) { ?>
    <div id="wrapper" class="wrapper">
        <div class="color silver">
            <div class="ui large secondary pointing grey menu" id="control-menu">
                <div class="ui container">
                		<!-- Campaign link -->
                        <a href="<?php echo isset($link) ? $link : '' ?>" class="item" data-bjax><?php _e('Campaign', 'petition') ?></a>

                        <!-- Dashboard link -->
                        <?php
                            $args = array(
                                'post_type' => 'page',
                                'post_status' => 'publish',
                                'meta_key' => '_wp_page_template',
                                'meta_value' => 'dashboard-petition.php'
                            );

                            $query = new WP_Query($args);

                            while($query->have_posts()) {
                                $query->the_post();
                                $page_id = get_the_ID();
                                $page_link = get_permalink($page_id);
                                $page_link = add_query_arg(array('edit_id' => $petition_id), $page_link);
                            }
                            wp_reset_postdata();
                            wp_reset_query();
                        ?>
                        <a href="<?php echo ($page_link ? $page_link : '') ?>" class="item" data-bjax><?php _e('Dashboard', 'petition') ?></a>

                        <!-- Update petition link -->
                        <?php
                            $args = array(
                                'post_type' => 'page',
                                'post_status' => 'publish',
                                'meta_key' => '_wp_page_template',
                                'meta_value' => 'add-update.php'
                            );

                            $query = new WP_Query($args);

                            while($query->have_posts()) {
                                $query->the_post();
                                $page_id = get_the_ID();
                                $page_link = get_permalink($page_id);
                                $page_link = add_query_arg(array('petition_id' => $petition_id, 'type' => 'update'), $page_link);
                            }
                            wp_reset_postdata();
                            wp_reset_query();
                        ?>
                        <a href="<?php echo ($page_link ? $page_link : '') ?>" class="item" data-bjax><?php _e('Update', 'petition') ?></a>

                        <!-- Contribute link -->
                        <a href="#" class="active item"><?php _e('Contribute', 'petition') ?></a>

                        <!-- Edit petition link -->
                        <?php
                            $args = array(
                                'post_type' => 'page',
                                'post_status' => 'publish',
                                'meta_key' => '_wp_page_template',
                                'meta_value' => 'edit-petition.php'
                            );

                            $query = new WP_Query($args);

                            while($query->have_posts()) {
                                $query->the_post();
                                $page_id = get_the_ID();
                                $page_link = get_permalink($page_id);
                                $page_link = add_query_arg(array('edit_id' => $petition_id), $page_link);
                            }
                            wp_reset_postdata();
                            wp_reset_query();
                        ?>
                        <a href="<?php echo ($page_link ? $page_link : '') ?>" class="item" data-bjax><?php _e('Edit', 'petition') ?></a>
                </div>
            </div>
        </div>
		<div class="ui container submit-petition">
			<div class="ui center aligned header submit-petition-title">
                <div class="content">
                    <?php the_title() ?>
                </div>
            </div>
			<div class="ui centered grid">
		        <div class="sixteen wide mobile fourteen wide tablet ten wide computer left aligned column">
		            <?php if ($status == 'pending') { ?>
		                <div class="ui large warning message">
		                    <i class="warning icon"></i>
		                    <?php _e('Contribute & Donation is pending approval!', 'petition') ?>
		                </div>
		            <?php } ?>
		        	<div id="save-response" class="respon-message"></div>
		        	<div class="ui form">
		        		<?php wp_nonce_field('submit_contribute_ajax_nonce', 'securitySubmitContribute', true); ?>
		        		<input type="hidden" id="form_id" name="form_id" value="<?php echo ($form_id ? esc_attr($form_id) : '') ?>">
		        		<input type="hidden" id="petition_id" name="petition_id" value="<?php echo ($petition_id ? esc_attr($petition_id) : '') ?>">
		        		<input type="hidden" id="petition_title" name="petition_title" value="<?php echo ($title ? esc_attr($title) : '') ?>">
		        		<div class="fields ui large message">
		        			<div class="eleven wide field">
							  	<div class="ui toggle checkbox<?php echo ($goal_option && $goal_option === 'enabled' ? ' checked' : '') ?>" id="goal_option">
						        	<input type="checkbox" tabindex="0" name="goal_option" class="hidden" <?php echo ($goal_option && $goal_option === 'enabled' ? ' checked' : '') ?>>
						        	<label><?php _e('Show Goal', 'petition') ?></label>
						      	</div>
                            </div>
                            <?php if ($form_id != '' && $status != 'pending') { ?>
                            <div class="five wide field">
                                <div class="ui <?php echo ($status == 'draft' ? 'checked ' : '') ?>checkbox" id="draft_status">
                                    <input type="checkbox" tabindex="0" name="draft_status" class="hidden" <?php echo ($status == 'draft' ? 'checked' : '') ?>>
                                    <label><?php _e("Don't show Contribute", "petition") ?></label>
                                </div>
					      	</div>
                            <?php } else { ?>
                                <input type="hidden" name="draft_status" id="draft_status" value="">
                            <?php } ?>
				      	</div>

				      	<div class="two fields">
					      	<div class="required field">
				      			<label><?php _e('Goal', 'petition') ?></label>
					      		<div class="ui <?php echo ($currency_position == 'after' ? 'right' : 'left') ?> labeled large input">
								  	<?php if ($currency_position == 'before') { ?>
                                        <label for="set_goal" class="ui label"><?php echo esc_html($currency_symbol) ?></label>
                                    <?php } ?>
								        <input type="number" placeholder="Amount of Goal" name="set_goal" id="set_goal" value="<?php echo ($set_goal ? esc_attr($set_goal) : '') ?>">
                                    <?php if ($currency_position == 'after') { ?>
                                        <label for="set_goal" class="ui label"><?php echo esc_html($currency_symbol) ?></label>
                                    <?php } ?>
								</div>
				      		</div>
			      			<div class="field">
					  			<label><?php _e('Goal format', 'petition') ?></label>
					  			<select class="ui dropdown large fluid input" name="goal_format" id="goal_format">
					  				<?php foreach ($goal_format_selection as $key => $format) { ?>
					  					<option value="<?php echo esc_attr($key) ?>" <?php echo ($goal_format == $key ? 'selected' : '') ?>><?php  echo esc_html($format) ?></option>
					  				<?php } ?>
								</select>
							</div>
						</div>

				      	<div class="two fields">
							<div class="field">
	                        	<label><?php _e('Button label', 'petition') ?></label>
	                        	<select class="ui dropdown large fluid input" name="button_label" id="button_label">
	                        		<?php foreach ($button_label_selection as $label) { ?>
					  					<option value="<?php echo esc_attr($label) ?>" <?php echo ($reveal_label == $label ? 'selected' : '') ?>><?php echo esc_html($label) ?></option>
					  				<?php } ?>
								</select>
							</div>
				      		<div class="field">
				      			<label><?php _e('Close when met goal', 'petition') ?></label>
					  			<select class="ui dropdown large fluid input" name="close_form_when_goal_achieved" id="close_form_when_goal_achieved">
					  				<?php foreach ($close_form_selection as $key => $option) { ?>
					  					<option value="<?php echo esc_attr($key) ?>" <?php echo ($close_form_when_goal_achieved == $option ? 'selected' : '') ?>><?php echo esc_html($option) ?></option>
					  				<?php } ?>
								</select>
				      		</div>
				      	</div>

				      	<h2 class="ui dividing header">
                            <div class="content"><?php _e('Contribute level', 'petition') ?>
                        </h2>
				      	<div class="input-fields-wrap">
                            <div class="ui grid search">
                                <div class="sixteen wide mobile eight wide tablet eight wide computer column">
                                    <div class="required field">
                                        <label><?php _e('Amount', 'petition') ?></label>
                                        <div class="ui large fluid <?php echo ($currency_position == 'after' ? 'right' : 'left') ?> labeled input">
                                            <?php if ($currency_position == 'before') { ?>
                                        	   <label for="amount_level" class="ui label"><?php echo esc_html($currency_symbol) ?></label>
                                            <?php } ?>
                                                <input type="number" id="amount_level" name="amount_level[]" placeholder="<?php _e('Amount of level', 'petition'); ?>" value="<?php echo isset($donation_levels[0]['_give_amount']) ? give_format_decimal( give_maybe_sanitize_amount( $donation_levels[0]['_give_amount'] ), false, false ) : ''; ?>">
                                            <?php if ($currency_position == 'after') { ?>
                                                <label for="amount_level" class="ui label"><?php echo esc_html($currency_symbol) ?></label>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="sixteen wide mobile eight wide tablet eight wide computer column">
                                    <div class="required field">
                                        <?php if (!wp_is_mobile()) { ?>
                                            <label><?php _e('Title', 'petition') ?></label>
                                        <?php } ?>
                                        <div class="ui large fluid input">
                                            <input type="text" id="name_level" name="name_level[]" placeholder="<?php _e('Level name', 'petition'); ?>" value="<?php echo isset($donation_levels[0]['_give_text']) ? $donation_levels[0]['_give_text'] : ''; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

	                        <?php if(isset($donation_levels) && $donation_levels != '') { 
	                            foreach ($donation_levels as $key => $level) { 
	                                if ($level['_give_amount'] && $key != 0) { ?>
	                                <div class="ui grid search">
	                                    <div class="sixteen wide mobile eight wide tablet eight wide computer column">
	                                        <div class="required field">
	                                            <div class="ui large fluid <?php echo ($currency_position == 'after' ? 'right' : 'left') ?> labeled input">
	                                                <?php if ($currency_position == 'before') { ?>
                                                        <label for="amount_level" class="ui label"><?php echo esc_html($currency_symbol) ?></label>
                                                    <?php } ?>
	                                                   <input type="number" id="amount_level" name="amount_level[]" value="<?php echo isset($level['_give_amount']) ? give_format_decimal( give_maybe_sanitize_amount( $level['_give_amount'] ), false, false ) : ''; ?>">
                                                    <?php if ($currency_position == 'after') { ?>
                                                        <label for="amount_level" class="ui label"><?php echo esc_html($currency_symbol) ?></label>
                                                    <?php } ?>
	                                            </div>
	                                        </div>
	                                    </div>
	                                    <div class="sixteen wide mobile eight wide tablet eight wide computer column">
	                                        <div class="required field">
	                                            <div class="ui large fluid input">
	                                                <input type="text" id="name_level" name="name_level[]" value="<?php echo isset($level['_give_text']) ? $level['_give_text'] : ''; ?>">
	                                            </div>
	                                        </div>
	                                    </div>
	                                    <a href="#" class="remove-field"><i class="inverted circular close link icon"></i></a>
	                                </div>
	                        <?php   }
	                            }
	                        } ?>
	                    </div>

                        <div class="ui basic segment" style="padding: 0">
                            <button class="ui primary tiny right floated button add-level-button"><i class="plus icon"></i><?php _e('Add', 'petition') ?></button>
                        </div>

                        <div class="required field">
			      			<label><?php _e('Minimum', 'petition') ?></label>
				      		<div class="ui <?php echo ($currency_position == 'after' ? 'right' : 'left') ?> labeled large input">
							  	<?php if ($currency_position == 'before') { ?>
                                    <label for="custom_amount_minimum" class="ui label"><?php echo esc_html($currency_symbol) ?></label>
                                <?php } ?>
							  	  <input type="number" placeholder="Amount of minimum" name="custom_amount_minimum" id="custom_amount_minimum" value="<?php echo esc_attr($custom_amount_minimum) ?>">
                                <?php if ($currency_position == 'after') { ?>
                                    <label for="custom_amount_minimum" class="ui label"><?php echo esc_html($currency_symbol) ?></label>
                                <?php } ?>
							</div>
			      		</div>

			      		<div class="required field">
			      			<label><?php _e('Goal Achieved Message', 'petition') ?></label>
    						<textarea name="goal_achieved_message" id="goal_achieved_message" rows="3" maxlength="300"><?php echo ($goal_achieved_message ? esc_textarea($goal_achieved_message) : _e('Thank you to all our donors, we have met our fundraising goal.', 'petition')) ?></textarea>
			      		</div>

			      		<div class="field">
			      			<label><?php _e('Content or Tips', 'petition') ?></label>
    						<textarea name="form_content" id="form_content" rows="3" maxlength="300"><?php echo ($form_content ? esc_textarea($form_content) : '') ?></textarea>
			      		</div>

			      		<div class="ui right floated header" style="margin-right: 0">
                            <button class="ui primary large button" id="submit-contribute"><?php _e('Save', 'petition') ?></button>
                        </div>
					</div>
		        </div>
		    </div>
		</div>
	</div>
<?php } else { ?>
    <?php get_template_part('404') ?>
<?php } ?>
<?php get_footer(); ?>