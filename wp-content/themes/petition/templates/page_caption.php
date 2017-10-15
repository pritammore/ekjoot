<?php
/**
 * @package WordPress
 * @subpackage Petition
 */
?>

<div class="page-caption">
	<div class="ui container">
<?php
	if ( is_author() || is_page_template('my-petitions.php') ) {
		if (is_author()) {
			$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
		} else {
			$curauth = wp_get_current_user();
		} 
		// Avatar
	    if($curauth->avatar_orginal != '') {
	        $avatar = $curauth->avatar_orginal;
	    } elseif ($curauth->avatar != '') {
	    	$avatar = $curauth->avatar;
	    } else {
	        $avatar = get_template_directory_uri().'/images/avatar-lg.png';
	    }
	    $avatar = conikal_get_avatar_url( $curauth->ID, array('size' => 116, 'default' => $avatar) );

	    // follow user
	    $user = wp_get_current_user();
	    $follow_user = get_user_meta($user->ID, 'follow_user', true);
?>

	<div class="ui grid">
		<div class="four wide mobile three wide tablet two wide computer column">
			<img class="ui small avatar bordered image" alt="<?php echo esc_attr($curauth->display_name) ?>" src="<?php echo esc_attr($avatar) ?>">
		</div>
		<div class="twelve wide mobile thirteen wide tablet fourteen wide computer column">
			<div class="ui basic vertical segment">
				<div class="ui inverted header petition-title">
					<div class="content">
						<?php echo esc_html($curauth->display_name) ?>
						<div class="sub header">
							<?php if ($curauth->user_country || $curauth->user_state || $curauth->user_city) { ?>
							<i class="marker icon"></i>
							<?php echo ($curauth->user_city ? $curauth->user_city . ', ' : '') . ($curauth->user_state ? $curauth->user_state . ', ' : '') . ($curauth->user_country ? $curauth->user_country : '') ?>
							<?php } ?>
						</div>
					</div>
				</div>
				<?php if(is_user_logged_in()) {
                	if($follow_user != '') {
						if(in_array($curauth->ID, $follow_user) === false) { ?>
							<a href="javascript:void(0)" id="follow-user-<?php echo esc_attr($curauth->ID); ?>" class="ui tiny inverted circular button follow-profile follow" data-id="<?php echo esc_attr($curauth->ID); ?>"><i class="plus icon"></i><?php _e('Follow', 'petition') ?></a>
						<?php } else { ?>
							<a href="javascript:void(0)" id="follow-user-<?php echo esc_attr($curauth->ID); ?>" class="ui tiny primary circular button follow-profile following" data-id="<?php echo esc_attr($curauth->ID); ?>"><i class="checkmark icon"></i><?php _e('Following', 'petition') ?></a>
					<?php } 
						} else { ?>
						<a href="javascript:void(0)" id="follow-user-<?php echo esc_attr($curauth->ID); ?>" class="ui tiny inverted circular button signin-btn follow-topic follow"><i class="plus icon"></i><?php _e('Follow', 'petition') ?></a>
					<?php }
					wp_nonce_field('follow_ajax_nonce', 'securityFollow', true);
				} else { ?>
					<a href="javascript:void(0)" class="ui tiny inverted circular button signin-btn"><i class="plus icon"></i><?php _e('Follow', 'petition') ?></a>
				<?php } ?>
				<button class="ui tiny inverted circular button" id="contact-btn"><i class="mail outline icon"></i><?php _e('Contact', 'petition') ?></button>
			</div>
		</div>
	</div>
<?php } elseif (is_page()) { ?>
	<div class="page-title"><?php the_title(); ?></div>
<?php } elseif (is_category()) { ?>
	<div class="page-title"><?php single_cat_title(); ?></div>
<?php } elseif (is_tag()) { ?>
	<div class="page-title"><?php single_tag_title(); ?></div>
<?php } elseif (is_tax()) {
		$term = get_queried_object();
		$current_user = wp_get_current_user();
		$follow_topics = get_user_meta($current_user->ID, 'follow_topics', true); 
	?>
	<div class="page-title"><?php single_term_title(); ?>
		<p class="font small text white"><?php echo esc_html($term->count) . ' ' . __('petitions', 'petition') ?></p>
	</div>
	<?php if ($term->taxonomy === 'petition_topics') { ?>
	<div class="ui center aligned basic segment">
		<?php if( is_user_logged_in()  ) { ?>
	        <?php if($follow_topics != '') { ?>
	            <?php if(in_array($term->term_id, $follow_topics) === false) { ?>
	            	<a href="javascript:void(0)" id="follow-topic-<?php echo esc_attr($term->term_id) ?>'" class="ui tiny inverted circular button follow-topic follow" data-id="<?php echo esc_attr($term->term_id) ?>"><i class="plus icon"></i><?php _e('Follow', 'petition') ?></a>
	            <?php } else { ?>
	            	<a href="javascript:void(0)" id="follow-topic-<?php echo esc_attr($term->term_id) ?>'" class="ui tiny primary circular button follow-topic following" data-id="<?php echo esc_attr($term->term_id) ?>"><i class="plus icon"></i><?php _e('Following', 'petition') ?></a>
	            <?php }
	        } else { ?>
	        	<a href="javascript:void(0)" id="follow-topic-<?php echo esc_attr($term->term_id) ?>'" class="ui tiny inverted circular button follow-topic following" data-id="<?php echo esc_attr($term->term_id) ?>"><i class="plus icon"></i><?php _e('Follow', 'petition') ?></a>
	        <?php }
	    } else { ?>
	    	<a href="javascript:void(0)" class="ui tiny inverted circular button signin-btn"><i class="plus icon"></i><?php _e('Follow', 'petition') ?></a>
	    <?php } ?>
	</div>
	<?php } ?>
<?php } else { ?>
	<div class="page-title"><?php single_term_title(); ?></div>
<?php } ?>
	</div>
</div>

<?php if ( is_author() || is_page_template('my-petitions.php') ) { ?>
	<div class="ui small modal" id="contact-user">
	    <div class="header">
	        <?php _e('Send an email', 'petition') ?>
	    </div>
	    <div class="content">
	        <div class="respon-message" id="contact-response"></div>
	        <form class="ui form">
	            <input type="hidden" id="user_email" name="user_email" value="<?php echo esc_attr($curauth->user_email); ?>">
	            <?php if (!is_user_logged_in()) { ?>
	            <div class="fields">
	                <div class="eight wide required field">
	                       <label><?php esc_html_e('Name', 'petition'); ?></label>
	                       <input type="text" id="contact_name" name="contact_name" placeholder="<?php esc_html_e('Enter your name', 'petition'); ?>">
	                 </div>
	                <div class="eight wide required field">
	                        <label><?php esc_html_e('Email', 'petition'); ?></label>
	                        <input type="text" id="contact_email" name="contact_email" placeholder="<?php esc_html_e('Enter your email', 'petition'); ?>">
	                </div>
	            </div>
	            <?php } else { ?>
	            	<input type="hidden" id="contact_name" name="contact_name" value="<?php echo esc_html($user->display_name); ?>">
	            	<input type="hidden" id="contact_email" name="contact_email" value="<?php echo esc_html($user->user_email); ?>">
	            <?php } ?>
	            <div class="required field">
	                        <label><?php esc_html_e('Subject', 'petition'); ?></label>
	                        <input type="text" id="contact_subject" name="contact_subject" placeholder="<?php esc_html_e('Enter the subject', 'petition'); ?>">
	            </div>
	            <div class="required field">
	                        <label><?php esc_html_e('Message', 'petition'); ?></label>
	                        <textarea id="contact_message" name="contact_message" placeholder="<?php esc_html_e('Type your message', 'petition'); ?>" rows="5"></textarea>
	            </div>
	            <div class="field">
	                <a href="javascript:void(0);" class="ui primary button" id="sendBtn"><?php esc_html_e('Send an Email', 'petition'); ?></a>
	            </div>
	            <?php wp_nonce_field('contact_user_ajax_nonce', 'securityContactUser', true); ?>
	        </form>
	    </div>
	</div>

	<div class="ui small modal" id="request-issue-support">
	    <div class="header">
	        <?php _e('Request support for an issue', 'petition') ?>
	    </div>
	    <div class="content">
	        <div class="respon-message" id="request-issue-support-response"></div>
	        <form class="ui form">
	            <input type="hidden" id="req_user_email" name="req_user_email" value="<?php echo esc_attr($curauth->user_email); ?>">
	            <?php if (!is_user_logged_in()) { ?>
	            <div class="fields">
	                <div class="eight wide required field">
	                       <label><?php esc_html_e('Name', 'petition'); ?></label>
	                       <input type="text" id="req_contact_name" name="req_contact_name" placeholder="<?php esc_html_e('Enter your name', 'petition'); ?>">
	                 </div>
	                <div class="eight wide required field">
	                        <label><?php esc_html_e('Email', 'petition'); ?></label>
	                        <input type="text" id="req_contact_email" name="req_contact_email" placeholder="<?php esc_html_e('Enter your email', 'petition'); ?>">
	                </div>
	            </div>
	            <?php } else { ?>
	            	<input type="hidden" id="req_contact_name" name="req_contact_name" value="<?php echo esc_html($user->display_name); ?>">
	            	<input type="hidden" id="req_contact_email" name="req_contact_email" value="<?php echo esc_html($user->user_email); ?>">
	            <?php } ?>
	            <div class="required field">
	                        <label><?php esc_html_e('Unique Issue Code (UIC)', 'petition'); ?></label>
	                        <input type="text" id="req_contact_subject" name="req_contact_subject" placeholder="<?php esc_html_e('Enter the Issue UIC', 'petition'); ?>">
	            </div>
	            <div class="required field">
	                        <label><?php esc_html_e('Message', 'petition'); ?></label>
	                        <textarea id="req_contact_message" name="req_contact_message" placeholder="<?php esc_html_e('Type your message', 'petition'); ?>" rows="5"></textarea>
	            </div>
	            <div class="field">
	                <a href="javascript:void(0);" class="ui primary button" id="sendBtnToSUpportIssue"><?php esc_html_e('Request', 'petition'); ?></a>
	            </div>
	            <?php wp_nonce_field('contact_user_ajax_nonce', 'securityContactUser', true); ?>
	        </form>
	    </div>
	</div>
<?php } ?>
