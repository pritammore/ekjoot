<?php
// Read me later widget
class LP_Widget extends WP_Widget {	
	
    function __construct() {
        parent::__construct(
            'lp_widget', // Base ID
            __( 'Read Me Later', 'text_domain' ), // Name
            array( 'classname' => 'lp_widgt', 'description' => __( 'Read Me Later widget for displaying saved posts', 'text_domain' ), ) // Args
        );
    }

	public function form( $instance ) {
        if ( isset( $instance['title'] ) ) {
            $title = $instance['title'];
        } else {
            $title = __( 'Read Me Later Posts', 'text_domain' );
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
                   name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
                   value="<?php echo esc_attr( $title ); ?>">
        </p>
    <?php
    }

	public function update( $new_instance, $old_instance ) {
        $instance          = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
 
        return $instance;
    }
	
	public function widget( $args, $instance ) {
		
		$title = apply_filters( 'widget_title', $instance['title'] );
 
        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

		echo '
			<div class="lp_contents">
				<div class="ui secondary segment">
					<h3 class="font medium">Leaders</h3>
					<div class="lp_body">
					<div class="lp_leader_list">
			';
		/*function limit_words($string, $word_limit) {
			$words = explode(' ', $string);
			return implode(' ', array_slice($words, 0, $word_limit));
		}*/
		$ids = get_post_meta( get_the_id(), 'lp_post_ids', true );
		if(!empty($ids)) {
			$users = get_users( array( 'fields' => array( 'ID' ) ) );
			foreach($ids as $user_id){
				$current_user = get_userdata($user_id);
				$current_user_avatar = $current_user->avatar;
			    if (!$current_user_avatar) {
			        $current_user_avatar = get_template_directory_uri().'/images/avatar.svg';
			    }
			    $current_user_avatar = conikal_get_avatar_url( $user_id, array('size' => 35, 'default' => $current_user_avatar) );
	        	$user_info = $current_user;

	        	$user_login_name = $current_user->data->user_login;
			    $file = home_url( '/' );
			    $link = $file . 'author/'. $user_login_name;

	    ?>
	    	<div class="leader_avtar">
	    		<a href="<?php echo $link; ?>" title="<?php echo $user_info->first_name." ".$user_info->last_name ; ?>"> <img class="ui avatar bordered image" src="<?php echo esc_url($current_user_avatar) ?>">
	    		<span style="font-family: Lato,'Helvetica Neue',Arial,Helvetica,sans-serif;font-weight: 700;color: rgba(0,0,0,.87);padding-right: 5px;line-height: 7px;"><?php echo $user_info->first_name." ".$user_info->last_name ; ?></span>
	    		</a>
	    	</div>
	    <?php
	    	}
	    }
	    else
	    {
	    	echo '<p>No Leaders Supporting This Issue.</p>';
	    }
	    echo "</div></div></div></div>";

	    $html = "";
	    $petition_id = get_the_ID();
		$um_user_role = get_user_meta( wp_get_current_user()->ID,'user_type',true);
		$status = get_post_meta($petition_id, 'petition_status', true);
		$goal = get_post_meta($petition_id, 'petition_goal', true);
    	$sign_num = get_post_meta($petition_id, 'petition_sign', true);
    	$sign_num = isset($sign_num) ? intval($sign_num) : 0;

		if( is_user_logged_in() && get_post_type() == "petition" && ( $status == 0 ) && ( $sign_num < $goal ) ) {

			$lp_post_ids = get_post_meta(get_the_id(), 'lp_post_ids', true );
			$ids = $lp_post_ids;
			// echo "<pre>"; echo "IDS:"; print_r($ids); echo "<pre>"; echo "lp_approve_decisioners: "; print_r($lp_approve_decisioners); echo "</pre>"; echo "Current:  ". wp_get_current_user()->ID; 
			// || ((!empty($lp_approve_decisioners_ids) &&  !in_array(wp_get_current_user()->ID, $lp_approve_decisioners_ids)) || empty($lp_approve_decisioners_ids))
			$lp_approve_decisioners_ids = get_post_meta(get_the_id(), 'lp_approve_decisioners', true );

			if(!empty($ids) && !empty($lp_approve_decisioners_ids)) {
				$ids = array_merge($ids, $lp_approve_decisioners_ids);
				$ids = array_values($ids);
			} else if(empty($ids)) {
				$ids = $lp_approve_decisioners_ids;
			} else if(empty($lp_approve_decisioners_ids)) {
				$ids = $ids;
			} else {
				$ids = array();
			}

			$html = '<div class="ui secondary segment"><h3 class="font medium">Lead This Issue</h3>
						<div class="lp_body">
						<p>If you think you can contribute in resolving this issue with your expertise, please lead this issue and help the grievant</p>
						<div id="lp_content">';

			if( ((!empty($ids) && !in_array(wp_get_current_user()->ID, $ids)) || empty($ids)) )
			{ 
				$html .= '<a href="#" class="ui large primary fluid button lp_bttn" data-id="' . get_the_id() . '">
				<i class="checkmark icon"></i>Lead This Issue</a></div>';
			}
			elseif((!empty($lp_approve_decisioners_ids) &&  in_array(wp_get_current_user()->ID, $lp_approve_decisioners_ids))) 
			{
				$html .= '<a href="#" class="ui large danger fluid button disabled">
						  <i class="warning icon"></i>Request for Approval is send</a></div>';
			}
			elseif ((!empty($lp_post_ids) &&  in_array(wp_get_current_user()->ID, $lp_post_ids)))
			{
				$html .= '<a href="#" class="ui large home-cta-button fluid button">
						  <i class="warning icon"></i>This issue is lead by you.</a></div>';
			}	
			$html .="</div></div>";

			
		} else if( !is_user_logged_in() && get_post_type() == "petition") {
			$html = '<div class="ui secondary segment"><h3 class="font medium">Lead This Issue</h3>
						<div class="lp_body">
						<p>If you think you can contribute in resolving this issue with your expertise, please lead this issue and help the grievant</p>
						<div id="lp_content">';
						$html .= '<a href="#" class="signup-btn ui large primary fluid button">
						  <i class="warning icon"></i>Signup / SignIn to lead this issue.</a></div>';
			$html .="</div></div>";
		}
		echo $html;	
	}
}
add_action( 'widgets_init', function(){ register_widget( 'LP_Widget' ); } );
?>