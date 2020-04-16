<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://m.sendbox.co/
 * @since      1.0.0
 *
 * @package    Sendbox_Fa
 * @subpackage Sendbox_Fa/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Sendbox_Fa
 * @subpackage Sendbox_Fa/public
 * @author     Sendbox <admin@sendbox.ng>
 */
class Sendbox_Fa_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sendbox_Fa_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sendbox_Fa_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/sendbox-fa-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sendbox_Fa_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sendbox_Fa_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/sendbox-fa-public.js', array( 'jquery' ), $this->version, false );
		 
		wp_localize_script(
			$this->plugin_name,
			'sendbox_fa_ajax_object',
			[
				'sendbox_fa_ajax_url' => admin_url('admin-ajax.php'),
				//'wooss_ajax_security' => wp_create_nonce('wooss-ajax-security-nonce'),
			]
		);
	} 

	/***
	 * This function creates the page shortcode 
	 */ 

	/*  function sendbox_shortcode(){

		return '<form> 
		       <input type="text" placeholder="Enter your tracking code">
		        <button>Track</button>
				  </form>
				  ';
	 } 

	 function add_sendbox_shortcode(){
		add_shortcode('sendbox_track', array($this, "sendbox_shortcode"));
	 } */

	 function add_sendbox_page(){

		$sendbox_page = array(
			'post_title'    => 'Tracking',
			'post_content'  => 'Track your shipment
			<br/>

            <form method="post" action="">
			<input type="text" name="sendbox_track" id="sendbox_track" placeholder="Enter your tracking code">
             <button id="sendbox_track_btn" type="submit">Track</button>
            </form>
			',
			'post_status'   => 'publish',
			'post_author'   => 1,
			'post_type' => 'page'
			 );

		  if(!get_option('sendbox_tracking_page_id')){
			$id =  wp_insert_post( $sendbox_page);
			update_option('sendbox_tracking_page_id',  $id);
		}

		
		 //var_dump($id);
         

	} 


	/***
	 * Function to call tracking.
	 */ 

	 function track_sendbox_shipment(){
		if (isset($_POST['data'])) {
			$tracking_code    = sanitize_text_field($data['sendbox_track']);
			$payload_data = new stdClass();
			$payload_data->code      = $tracking_code; 

			$sendbox_obj = new Sendbox_API();
			$url = $sendbox_obj->get_sendbox_api_url('tracking'); 
	        $api_key = get_option('auth_token');
	        $type = "application/json";
	
         	$request_headers = array(
		    "Content-Type: " .$type,
		     "Authorization: " .$api_key,
	       );
	
	      $track_data = wp_json_encode($payload_data);
	      $tracking_res = $sendbox_obj->post_on_api_by_curl($url,$track_data,$api_key);
	      $tracking_obj = json_decode($tracking_res);
	      var_dump($tracking_obj);


		}

	 }


}
