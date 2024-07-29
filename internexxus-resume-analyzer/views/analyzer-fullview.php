<?php ob_start(); 

//$getresumeBody = $_COOKIE['resumeBody'];
$current_user_id = get_current_user_id();
$getresumeBody = get_user_meta($current_user_id, 'working_cv_body', true);

$jsonString = stripslashes($getresumeBody);
$resumeBody = json_decode($jsonString, true);

//print_r($resumeBody);

$totalScore = 0;
$count = 0;

// Iterate over the array to sum the scores
foreach ($resumeBody as $item) {

    $totalScore += $item['score'];
    $count++;
}

//echo $totalScore;
// Calculate the average score
$averageScore = round($totalScore / $count);

?>

  <div class="page_loader resume_analyzer_loader">
    <span class="loader"></span>  
  </div>

<div
      class="sectionSpacing-3 inner_hero-banner"
      style="background-image: url(<?php echo Internexxus_Resume_Analyzer_URL;?>/assets/images/hero-inner-wide-bg.svg)"
    >
      <div class="container">
        <div class="resume_score-wrapper">
        <?php if(!empty(get_field('title_dp_p2','option'))){?>
          <h3 class="title"><?php echo get_field('title_dp_p2','option'); ?></h3>
        <?php } ?>
          <div class="row">
            <div class="col-md-3">
            <div class="circle_percent <?php echo getScoreClass($averageScore); ?>" data-percent="<?php echo $averageScore; ?>">
                <div class="circle_inner">
                    <div class="round_per"></div>
                  </div>
              </div>
            </div>
            <div class="col-md-5">
              <div class="resume_score-details">
                <?php if(!empty(get_field('title_2_dp_p2','option'))){?>
                  <h4 class="subtitle"><?php echo get_field('title_2_dp_p2','option'); ?></h4>
                        <?php } ?>
                        <?php if(!empty(get_field('description_dp_p2','option'))){?>
                            <?php echo get_field('description_dp_p2','option'); ?>
                        <?php } ?>
              </div>
            </div>
            <div class="col-md-4">
            <ul class="score_chart-list">
              <?php if (have_rows('score_break_down_rap1','option')): while (have_rows('score_break_down_rap1','option')): the_row(); ?> 
                <li>
                  <label class="chart_point <?php echo get_sub_field('color_sin_score_break_down_rap1'); ?>"></label>
                  <p><?php echo get_sub_field('label_sin_score_break_down_rap1'); ?></p>
                </li>
                <?php endwhile; endif; ?>
              </ul>
            </div>
          </div>
        </div>

        <div class="selectall_wrap">
          <button class="selectall">
            Select All
          </button>
        </div>

        <div class="recomended-data_wrap">
          <h3 class="title"><?php echo get_field('text_3__dp_p2'); ?></h3>
          <div class="row  justify-content-center">
          <?php 
          foreach ($resumeBody as $item) { 
              $category = $item['category'];

              if($category == "Skills"){

                $imgName = 'skills.svg';

              } elseif($category == "Experience"){
                $imgName = 'experince.svg';

              }elseif($category == "Education"){

                $imgName = 'education.svg';

              }elseif($category == "Keyword Usage"){

                $imgName = 'keyword.svg';

              }elseif($category == "Resume Structure and Readability"){
                $imgName = 'resume-structure.svg';
              }

            ?>
            
            <div class="col-md-6 d-flex">
              <div class="recomended_colmn">
                <div class="form-group-check">
                  <input type="checkbox" value="<?php echo $category; ?>"  name="resume_points" id="<?php echo preg_replace('/\.svg$/', '', $imgName); ?>" />
                  <label for="<?php echo preg_replace('/\.svg$/', '', $imgName); ?>"></label>
                </div>
                <h4 class="col-title">
                  <i class="icon_features">
                    <img src="<?php echo Internexxus_Resume_Analyzer_URL;?>/assets/images/<?php echo $imgName; ?>" alt="" />
                    </i>
                    <?php echo $category; ?>
                </h4>
                <ul class="recomended_list">
                  <?php foreach ($item['issues'] as $issue) {?>
                    <li><?php echo $issue; ?></li>
                  <?php } ?>
                </ul>
              </div>
            </div>

          <?php } ?>
          </div>
        </div>

        <?php  
         global $current_user;
     
        if(is_user_logged_in()) {
          global $current_user;

            $userId = $current_user->ID;
            $userMembershipLevel = pmpro_getMembershipLevelForUser($userId);
            
              if(!empty($userMembershipLevel->id) && ($userMembershipLevel->id != '4' )){ 

                if($userMembershipLevel->id == '5'){
                
                      global $wpdb;
                      $tablename = $wpdb->prefix.'pmpro_membership_orders';
          
                         // Replace with the desired user ID
                      $query = $wpdb->prepare("
                      SELECT `timestamp` 
                          FROM $tablename 
                          WHERE user_id = %d 
                          ORDER BY id DESC 
                          LIMIT 1
                      ", $userId);
          
                      $latest_timestamp = $wpdb->get_var($query);
        
                      $timestamp = strtotime($latest_timestamp);
          
                      $defineLimit = get_field('basic_plan_limit_dpp2', 'option');

                     
        
                      $lastP_year = date('Y', $timestamp);
                      $lastP_month = date('F', $timestamp);
                    
                      $current_year = date('Y');
                      $current_month = date('F');
          
                      if($lastP_year == $current_year && $lastP_month == $current_month){
          
                        $meta_key = 'download_limit_'.$lastP_month.'_'.$lastP_year;
          
                        $getLimit = get_user_meta($userId, $meta_key, true) ? get_user_meta($userId, $meta_key, true) : 0 ;
          
                         $limtleft = (intval($defineLimit) - intval($getLimit));

          
                      } else{
                        $limtleft = 0;
                      }

                        if($limtleft > 0){
                          $disabled_button = ''; 
                        }else{
                          $disabled_button = 'disabled_button';
                        }
                      ?>

                      <div class="bottom_button-group">
                        <div class="button_left">
                          <a href="#" id="preview_ai_resume" class="btnPrime btnDark"><?php echo get_field('button_preview_text_dpp2','option'); ?></a>
                        </div>
                        <div class="button_right">
                          <a href="#" id="download_ai_resume" class="btnPrime btnlight <?php echo $disabled_button; ?>"><?php echo get_field('button_download_text_dpp2','option'); ?></a>
                          <p class="note_add"><small>You have <span id="time_reaming_basic"><?php echo $limtleft ?></span> downloads remaining this month.</small></p>
                        </div>
                     
                      
                    </div>
    
                    <div id="pdfModal" style="display:none;">
                      <div id="pdfModalContent">
                          <span id="closeModal">&times;</span>
                          <!-- <iframe id="pdfFrame" style="width:100%;height:100vh;" frameborder="0"></iframe> -->
                           <div class="html_cv"></div>
                      </div>
                  </div>

                <?php }else{ ?>

                <div class="bottom_button-group">
                  <div class="button_left">
                    <a href="#" id="preview_ai_resume" class="btnPrime btnDark"><?php echo get_field('button_preview_text_dpp2','option'); ?></a>
                  </div>
                  <div class="button_right">
                    <a href="#" id="download_ai_resume" class="btnPrime btnlight"><?php echo get_field('button_download_text_dpp2','option'); ?></a>
                  </div>
                </div>

                <div id="pdfModal" style="display:none;">
                  <div id="pdfModalContent">
                      <span id="closeModal">&times;</span>
                      <!-- <iframe id="pdfFrame" style="width:100%;height:100vh;" frameborder="0"></iframe> -->
                       <div class="html_cv"></div>
                  </div>
              </div>
            <?php }} elseif(!empty($userMembershipLevel->id)){ ?>
                <div class="bottom_button-group">
                <div class="button_left">
                  <a href="#" id="preview_ai_resume" class="btnPrime btnDark"><?php echo get_field('button_preview_text_dpp2','option'); ?></a>
                </div>
                 <?php 
                                    $ralb_btn_2 = get_field('upgrade_plan_dpp2','option');
                                    if( $ralb_btn_2 ): 
                                        $ralb_btn_2_url = $ralb_btn_2['url'];
                                        $ralb_btn_2_title = $ralb_btn_2['title'];
                                        $ralb_btn_2_target = $ralb_btn_2['target'] ? $ralb_btn_2['target'] : '_self';
                                    ?>
                                  <div class="button_right">
                                    <a class="btnPrime btnlight" href="<?php echo esc_url( $ralb_btn_2_url ); ?>" target="<?php echo esc_attr( $ralb_btn_2_target ); ?>"><?php echo esc_html( $ralb_btn_2_title ); ?></a>
                                  <p class="note_add">Upgrade Your Plan</p>  
                                  </div>
                                    <?php endif; ?>
                </div>

                <div id="pdfModal" style="display:none;">
                <div id="pdfModalContent">
                    <span id="closeModal">&times;</span>
                    <!-- <iframe id="pdfFrame" style="width:100%;height:100vh;" frameborder="0"></iframe> -->
                    <div class="html_cv"></div>
                </div>
                </div>
          <?php   }

             }?>

      </div>
    </div>



    <script>
      jQuery(document).ready(function($){

        $('.selectall').click(function() {
            $('input[name="resume_points"]').prop('checked', true);
        });

      // Add the class when the page loads
      $(".resume_analyzer_loader").addClass('show_loader');
      // Remove the class after 10 seconds (10000 milliseconds)
      setTimeout(function() {
          $('.resume_analyzer_loader').removeClass('show_loader');
      }, 10000);
   
        $(".circle_percent").each(function() {
            var $this = $(this),
            $dataV = $this.data("percent"),
            $dataDeg = $dataV * 3.6,
            $round = $this.find(".round_per");
          $round.css("transform", "rotate(" + parseInt($dataDeg + 180) + "deg)");	
          $this.append('<div class="circle_inbox"><span class="percent_text"></span></div>');
          $this.prop('Counter', 0).animate({Counter: $dataV},
          {
            duration: 2000, 
            easing: 'swing', 
            step: function (now) {
                    $this.find(".percent_text").text(Math.ceil(now)+"%");
                }
            });
          if($dataV >= 51){
            $round.css("transform", "rotate(" + 360 + "deg)");
            setTimeout(function(){
              $this.addClass("percent_more");
            },1000);
            setTimeout(function(){
              $round.css("transform", "rotate(" + parseInt($dataDeg + 180) + "deg)");
            },1000);
          } 
        });

        


      });
    </script>
    <?php echo ob_get_clean();?>