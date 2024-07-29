<?php 
if( !class_exists( 'Internexxus_ResumeAnalyzer_Shortcodes') ){

    class Internexxus_ResumeAnalyzer_Shortcodes {
        public function __construct(){
            add_shortcode('resume-analyzer-landing', array($this,'resume_analyzer_landing_cb')); 
            add_shortcode('resume-analyzer', array($this,'resume_analyzer_cb')); 
            add_shortcode('subscription-plans', array($this,'subscription_plans_cb')); 
            add_shortcode('resume-analyzer_s1', array($this,'resume_analyzer_s1_cb')); 
            add_shortcode('resume-analyzer-fullview', array($this,'resume_analyzer_fullview_cb')); 
        }


        function resume_analyzer_landing_cb(){
            require_once( Internexxus_Resume_Analyzer_PATH . 'views/landing-page.php' );
        }

        function resume_analyzer_cb(){
            require_once( Internexxus_Resume_Analyzer_PATH . 'views/resume_checker.php' );
        }

        function subscription_plans_cb(){
            require_once( Internexxus_Resume_Analyzer_PATH . 'views/subscription_plans.php' );
        }

        function resume_analyzer_s1_cb(){
            require_once( Internexxus_Resume_Analyzer_PATH . 'views/resume_analyzer.php' );
        }

        function resume_analyzer_fullview_cb(){
            require_once( Internexxus_Resume_Analyzer_PATH . 'views/analyzer-fullview.php' );
        }



    }
}