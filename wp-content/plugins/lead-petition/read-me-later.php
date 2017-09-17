<?php
/**
 * Plugin Name: Lead Petition
 * Plugin URI: http://pritammore.com
 * Description: This plugin allow Leader to Lead an Issue/Petition
 * Version: 1.0.0
 * Author: Pritam More
 * Author URI: http://pritammore.com
 * License: GPL3
 */

define( 'LP_DIR', plugin_dir_path( __FILE__ ) );
require(LP_DIR.'widgets.php');

class ReadMeLater {
	
    /**
     * Action hooks
     */
	public function run() {
		
		// Enqueue plugin styles and scripts
        add_action( 'plugins_loaded', array( $this, 'lp_scripts' ) );
        add_action( 'plugins_loaded', array( $this, 'lp_styles' ) );
		
		// Setup filter hook to show Read Me Later link
		add_filter( 'the_excerpt', array( $this, 'lp_button' ) );
		add_filter( 'the_content', array( $this, 'lp_button' ) );

		// Setup Ajax action hook
		add_action( 'wp_ajax_read_me_later', array( $this, 'read_me_later' ) );
		
	} 
	
    /**
     * Register plugin styles and scripts
     */
	public function register_lp_scripts() {
		wp_register_script( 'rml-script', plugins_url( 'js/read-me-later.js', __FILE__ ), array('jquery'), null, true );
		wp_register_style( 'rml-style', plugin_dir_url( __FILE__ ) .'css/read-me-later.css' );
	}
	
    /**
     * Enqueues plugin-specific scripts.
     */
    public function lp_scripts() {        
        wp_enqueue_script( 'rml-script' );
		wp_localize_script( 'rml-script', 'lp_obj', array( 'ajax_url' => admin_url('admin-ajax.php'), 'check_nonce' => wp_create_nonce('rml-nonce') ) );
    } 
	
    /**
     * Enqueues plugin-specific styles.
     */
    public function lp_styles() {         
        wp_enqueue_style( 'rml-style' ); 
    } 
    
        /**
         * Adds a read me later button at the bottom of each post excerpt that allows logged in users
         * to save those posts in their read me later list.
         *
	 * @param string $content
	 * @return string
	 */
	public function lp_button( $content ) {
		
		// Show read me later link only when user is logged in
		// global $ultimatemember;
		// $um_user_role = get_user_meta( wp_get_current_user()->ID,'role',true);


		
		
		/*if( is_user_logged_in() && get_post_type() == post && ($um_user_role == 'leader' || $um_user_role == 'admin')) {
			$ids = get_post_meta(get_the_id(), 'lp_post_ids', true );
			// echo "<pre>"; print_r($ids); echo "</pre>";
			if((!empty($ids) &&  !in_array(wp_get_current_user()->ID, $ids)) || empty($ids)) { // 
			$html .= '<a href="#" class="lp_bttn" data-id="' . get_the_id() . '">Lead Petition</a>';
			$content .= $html;
			}

		}*/
		return $content;
		
	} 
		
	/**
	 * Hook into wp_ajax_ to save post ids, then display those posts using get_posts() function
	 *
	 * @access public
	 * @return mixed
	 */
	public function read_me_later() {
		global $ultimatemember;
		$um_user_role = get_user_meta( wp_get_current_user()->ID,'user_type',true);
		
		check_ajax_referer( 'rml-nonce', 'security' );
		$lp_post_id = $_POST['post_id']; 
		$echo = array();
		/* Starts */
		if($um_user_role == 'decisioner' || current_user_can('administrator')) :
			if( get_post_meta( $lp_post_id, 'lp_approve_decisioners', true ) !== null ) {
				$value = get_post_meta( $lp_post_id, 'lp_approve_decisioners', true );
			}

			if( $value ) {
				$echo = $value;
				array_push( $echo, wp_get_current_user()->ID );
			}
			else {
				$echo = array( wp_get_current_user()->ID );
			}
			
			update_post_meta( $lp_post_id, 'lp_approve_decisioners', $echo );
			/*$ids = get_post_meta( $lp_post_id, 'lp_post_ids', true );

			//echo '<div class="lp_leader_list">';
			// $ids = get_post_meta(  $lp_post_id, 'lp_post_ids', true );
			if(!empty($ids)) 
			{
				$users = get_users( array( 'fields' => array( 'ID' ) ) );
				foreach($ids as $user_id)
				{
					$current_user = get_userdata($user_id);
					$current_user_avatar = $current_user->avatar;
				    if (!$current_user_avatar) {
				        $current_user_avatar = get_template_directory_uri().'/images/avatar.svg';
				    }
				    $current_user_avatar = conikal_get_avatar_url( $user_id, array('size' => 35, 'default' => $current_user_avatar) );
		        	$user_info = $current_user;
	    ?>
			    	<div style="float: left; width:33%;margin-bottom: 1em;">
			    		<a href="#" title="<?php echo $user_info->first_name." ".$user_info->last_name ; ?>"><img class="ui avatar bordered image" src="<?php echo esc_url($current_user_avatar) ?>">
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
		    //echo "</div>";*/
    	endif;
		/* Ends */

		/*echo "</pre>------------------------------";

		if( get_user_meta( wp_get_current_user()->ID, 'lp_post_ids', true ) !== null ) {
			$value = get_user_meta( wp_get_current_user()->ID, 'lp_post_ids', true );
		}
		
		if( $value ) {
			$echo = $value;
			array_push( $echo, $lp_post_id );
		}
		else {
			$echo = array( $lp_post_id );
		}
		//echo "<pre>"; print_r($echo);  exit;
		update_user_meta( wp_get_current_user()->ID, 'lp_post_ids', $echo );
		$ids = get_user_meta( wp_get_current_user()->ID, 'lp_post_ids', true );*/
		
		function limit_words($string, $word_limit) {
			$words = explode(' ', $string);
			return implode(' ', array_slice($words, 0, $word_limit));
		}
		
		// Query read me later posts
		/*$args = array( 
			'post_type' => 'post',
			'orderby' => 'DESC', 
			'posts_per_page' => -1, 
			'numberposts' => -1,
			'post__in' => $ids
		);
		
		$rmlposts = get_posts( $args );
		if( $ids ) :
			global $post;
			foreach ( $rmlposts as $post ) :
				setup_postdata( $post );
				$img = wp_get_attachment_image_src( get_post_thumbnail_id() ); 
				?>			
				<div class="lp_posts">					
					<div class="lp_post_content">
						<h5><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></h5>
						<p><?php echo limit_words(get_the_excerpt(), '20'); ?></p>
					</div>
					<img src="<?php echo $img[0]; ?>" alt="<?php echo get_the_title(); ?>" class="lp_img">					
				</div>
			<?php 
			endforeach; 
			wp_reset_postdata(); 
		endif;	*/	

		// Always die in functions echoing Ajax content
		die();
		
	} 	
}
$rml = new ReadMeLater();
$rml->register_lp_scripts();
$rml->run();
?>
