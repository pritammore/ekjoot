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
	 * Hook into wp_ajax_ to save post ids, then display those posts using get_posts() function
	 *
	 * @access public
	 * @return mixed
	 */
	public function read_me_later() {
		
		$trueDecisioner=false;
		$um_user_role = get_user_meta( wp_get_current_user()->ID,'user_type',true);
		$decision_id = get_user_meta(wp_get_current_user()->ID, 'user_decision', true);
		$decision_status = get_post_status( $decision_id );

		if ($um_user_role == 'decisioner' && $decision_status == 'publish') {
			$trueDecisioner=true;
		}

		check_ajax_referer( 'rml-nonce', 'security' );
		$lp_post_id = $_POST['post_id']; 
		$echo = array();

		if(is_user_logged_in() && ( $trueDecisioner || current_user_can('administrator')) ) {
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
			$result['error'] = false;
		} else if($um_user_role == 'petitioner') {
			$result['error'] = true;
			$result['model'] = "makeDecisioner";
		} else if ($um_user_role == 'decisioner' && !$trueDecisioner) {
			$result['error'] = true;
			$result['model'] = "requestForDecisionerWaiting";
			
		}
		echo json_encode($result);
		// Always die in functions echoing Ajax content
		die();
		
	} 	
}

$rml = new ReadMeLater();
$rml->register_lp_scripts();
$rml->run();
?>
