<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://m.sendbox.co/
 * @since      1.0.0
 *
 * @package    Sendbox_Fa
 * @subpackage Sendbox_Fa/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sendbox_Fa
 * @subpackage Sendbox_Fa/admin
 * @author     Sendbox <admin@sendbox.ng>
 */
class Sendbox_Fa_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/sendbox-fa-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/sendbox-fa-admin.js', array( 'jquery' ), $this->version, false );

	} 

	function my_admin_menu() {
		add_menu_page(
			__( 'Sample page', 'my-textdomain' ),
			__( 'Sendbox-Forminator', 'my-textdomain' ),
			'manage_options',
			'sample-page',
		    array($this,'my_admin_page_contents'),
			'dashicons-plugins-checked',
			3
		);
	}  

	/***
	 * This function creates a new table in the db to store auth and refresh token
	 * 
	 */ 

	/*  public function sendbox_table(){
		global $wpdb;

		//declear table name 
		$table_name = $wpdb->prefix . 'sendbox';


	 } */ 


	 //check what page you are on 
	 public function sendbox_forminator(){
		If (isset($_GET['page']) && $_GET['page']=='forminator-entries'){
			
			//echo "nah man you be";
	 }
	}

	/**
		 * This function creates static url for sendbox oauth
		 * 
		 */
		public function register_routes()
		{
			register_rest_route(
				'sfa/v2',
				'/sendbox',
				array(
					'methods'  => 'GET',
					'callback' => array($this, 'sendbox_oauth'),
				)
			);
		}  

		/***
		 * This function handles getting code params from oauth url
		 */

		public function sendbox_oauth(){
		   
			$server_obj = ($_SERVER);
			$get_state = ($_GET["state"]);
		   $get_code = ($_GET["code"]);
	   
		   $new_url = $get_state."&code=" .$get_code;

			
		   header('Location:'.$new_url);
		   die();
			
		}

	function my_admin_page_contents() {
		?>
			<h1>
				<?php esc_html_e( 'Welcome to Sendbox Forminator Addon', 'my-plugin-textdomain' ); ?>
			</h1>
			
			<?php
			
			$sendbox_obj = new Sendbox_API();
			$server_obj = $_SERVER;
			$url_params = $server_obj['REQUEST_URI'];
			$domain = $server_obj['HTTP_HOST'];
			$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
			$static_url = get_site_url() . '/wp-json/sfa/v2/sendbox'; 
			$state = $protocol.$domain.$url_params;
			$scopes= "profile";
			$app_id = "5e4f996322a6b20724c9559e";
			$client_secret = "9cd808e9c64fdod9920d78025972d6f18462d5104eeb20f5f62ae998e60bcbc8e602d31a8bc71139062e960322b884c3074fcb58477675b9e95727b5faf708f";
			$sendbox_url = 'https://api.sendbox.co/oauth/access?app_id='.$app_id.'&scopes='.$scopes.'&redirect_url='.$static_url.'&state='.$state; 

			$server_res = ($_SERVER);
			$str = $server_res["REQUEST_URI"];
			parse_str($str, $output);
			//THIS IS WHERE IT STARTS O anyhow, lets go
		   if(isset($output['code'])){
			 $sendbox_code = $output['code'];
			 $s_url = 'https://api.sendbox.co/oauth/access/access_token?';
			 $url_oauth = $s_url.'app_id='.$app_id.'&redirect_url='.$static_url.'&client_secret='.$client_secret.'&code='.$sendbox_code.'';
			 $oauth_res = $sendbox_obj->get_api_response_by_curl($url_oauth);
			 $oauth_obj = json_decode($oauth_res);
			 //var_dump($oauth_obj);
			 $oauth_token = ""; 
			 $refresh_token = ""; 
			 
			 if(isset($oauth_obj->access_token)){
				 $oauth_token = $oauth_obj->access_token;
			 }
			 if(isset($oauth_obj->refresh_token)){
				 $refresh_token = $oauth_obj->refresh_token;
			 }

			 if(!get_option('auth_token')){
				add_option('auth_token',  $oauth_token);
			}

			if(!get_option('refresh_token')){
				add_option('refresh_token', $refresh_token);
			}

			 echo __('Connection to Sendbox Successful!!');
			  
			 echo "<script type='text/javascript'>
			document.getElementById(`sendbox-btn`).style.display = `none`;
            </script>";
 
		   }
  
		   
			?>  
			
			

			<button id="sendbox-btn">
			<a href="<?php echo($sendbox_url);?>" >
            <?php echo __('Connect to Sendbox') ?>
            </a>
			</button> 
			
		<?php
	}

}

