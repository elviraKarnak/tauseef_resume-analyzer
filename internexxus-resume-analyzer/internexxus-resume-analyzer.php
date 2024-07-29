<?php
/**
 * Plugin Name: Internexxus Resume Analyzer
 * Plugin URI: https://dev-internexxus.elvirainfotech.live//
 * Description: Custom Extension For Job Board Plugin.
 * Author: Raihan Reza
 * Version: 1.0.0
 * Requires at least: 5.6
 * Tested up to: 6.4.2
 * Text Domain: internexxus-resume-analyzer
 * License: GPL v2 or later
 * License URI:https://www.gnu.org/licenses/gpl-2.0.html
 * @author    Raihan Reza
 * @category  Genarel
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL v2 or later
 */

 /*
Internexxus Resume Analyzer is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with Internexxus Resume Analyzers. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( !class_exists( 'Internexxus_Resume_Analyzer' )){
    class Internexxus_Resume_Analyzer {
        function __construct() {
			$this->define_constants(); 

            require_once( Internexxus_Resume_Analyzer_PATH . 'inc/additional_functions.php' ); 

            require_once( Internexxus_Resume_Analyzer_PATH . 'inc/shortcodes/resume_analyzer-shortcode.php' );
            $Internexxus_ResumeAnalyzer_Shortcodes = new Internexxus_ResumeAnalyzer_Shortcodes();


            add_action( 'load_internexxus_resume_analyzer_script', array( $this, 'internexxus_resume_analyzer_script'));
            add_filter( 'pmpro_pages_custom_template_path', array( $this,'my_pmpro_pages_custom_template_path'),10, 2);
        }

        public function define_constants(){
			define( 'Internexxus_Resume_Analyzer_PATH', plugin_dir_path( __FILE__ ) );
			define( 'Internexxus_Resume_Analyzer_URL', plugin_dir_url( __FILE__ ) );
			define( 'Internexxus_Resume_Analyzer_VERSION', '1.0.0' );
		}

        public static function activate(){
        }

        public static function deactivate(){
            flush_rewrite_rules();
        }

        public function internexxus_resume_analyzer_script(){
            //style sheets
            wp_enqueue_style( 'internexxus_ra_bs5', Internexxus_Resume_Analyzer_URL.'/assets/styles/bootstrap.min.css', [],time());
            //wp_enqueue_style( 'internexxus_ra_custom_css_old', Internexxus_Resume_Analyzer_URL.'/assets/styles/custom_old.css', [],time());
            wp_enqueue_style( 'internexxus_ra_custom_css', Internexxus_Resume_Analyzer_URL.'/assets/styles/custom.css', [],time());
        
            //scripts
            wp_enqueue_script('internexxus_ra_bs5', Internexxus_Resume_Analyzer_URL.'/assets/js/bootstrap.bundle.min.js', [],time(), false); 
            wp_enqueue_script('internexxus_ra_custom_js', Internexxus_Resume_Analyzer_URL.'/assets/js/custom.js', [],time(), false); 
            wp_localize_script('internexxus_ra_custom_js', 'ajax_object', array('ajaxurl' => admin_url('admin-ajax.php'),'security' => wp_create_nonce('file_upload_nonce')));
        }

        // public function internexxus_resume_analyzer_deqscript(){
        //     //style sheets
        //     wp_dequeue_style( 'bootstrap-css' );
        //     wp_dequeue_script( 'bootstrap-js' );
        // }

        function my_pmpro_pages_custom_template_path( $templates, $page_name ) {		
            $templates[] = Internexxus_Resume_Analyzer_PATH . 'views/pmpro_templates/' . $page_name . '.php';	
            
            return $templates;
        }
       
        
    }   
}

        if( class_exists( 'Internexxus_Resume_Analyzer' ) ){
            register_activation_hook( __FILE__, array( 'Internexxus_Resume_Analyzer', 'activate' ) );
            register_deactivation_hook( __FILE__, array( 'Internexxus_Resume_Analyzer', 'deactivate' ) );
            register_uninstall_hook( __FILE__, array( 'Internexxus_Resume_Analyzer', 'uninstall' ) );

            $Internexxus_Resume_Analyzer = new Internexxus_Resume_Analyzer();
        }