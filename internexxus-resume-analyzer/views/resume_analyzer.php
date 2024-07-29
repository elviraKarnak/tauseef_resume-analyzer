<!-- <style>body {font-size: 20px !important}</style> -->
<?php 
ob_start(); 

$current_user_id = get_current_user_id();

$resumeID = get_user_meta($current_user_id, 'working_cv_id', true);

//echo $resumeID; 
$attachment_url = wp_get_attachment_url($resumeID);

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://ngo00si22c.execute-api.us-west-1.amazonaws.com/default/resume_analyser',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{"url": "'.$attachment_url.'"}',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $responseBody = json_decode($response);

        $responseBody = json_decode($responseBody->body);
    
        $skills = getScoreByCategory($responseBody, 'skills');
        $experience = getScoreByCategory($responseBody, 'experience');
        $education = getScoreByCategory($responseBody, 'Education');
        //$skills = getScoreByCategory($responseBody, 'skills');
        $key = getScoreByCategory($responseBody, 'Keyword Usage');
        $rsr = getScoreByCategory($responseBody, 'Resume Structure and Readability');


        // setcookie('skills_score', $skills, time() + 86400, "/");
        // setcookie('experience_score', $experience, time() + 86400, "/");
        // setcookie('education_score', $education, time() + 86400, "/");
        // setcookie('resumeBody', json_encode($responseBody), time() + 86400, "/");

        update_user_meta($current_user_id, 'working_cv_body', json_encode($responseBody));


        $toolTip = get_field('tool_tip_description_ra','option');



     
?>

<div class="page_loader resume_analyzer_loader">
    <span class="loader"></span>  
  </div>

<div
      class="sectionSpacing-3 inner_hero-banner"
      style="background-image: url(<?php echo Internexxus_Resume_Analyzer_URL;?>/assets/images/hero-inner-wide-bg.svg)"
    >
      <div class="container">
        <div class="row">
          <div class="col-md-6 order-2 order-lg-1">
            <div class="hero_content upload_file-wrapper">

            <?php if(!empty(get_field('title_rap1','option'))){?>
                  <h2 class="title"><?php echo get_field('title_rap1','option'); ?></h2>
            <?php } ?>
      
            <?php if(!empty(get_field('description_rap1','option'))){?>
                  <p><?php echo get_field('description_rap1','option'); ?></p>
            <?php } ?>

              <div class="hero_button-group">
              <?php 
                $improveScore = get_field('button__rap1','option');
                if( $improveScore ): 
                    $improveScore_url = $improveScore['url'];
                    $improveScore_title = $improveScore['title'];
                    $improveScore_target = $improveScore['target'] ? $improveScore['target'] : '_self';
                    ?>
                    <a class="btnPrime btnDark" href="<?php echo esc_url( $improveScore_url ); ?>" target="<?php echo esc_attr( $improveScore_target ); ?>"><?php echo esc_html( $improveScore_title ); ?></a>
                <?php endif; ?>

              </div>
              <div class="score_broken-analyze">
              <?php if(!empty(get_field('title_rap1','option'))){?>
                  <h3 class="title"><?php echo get_field('score_break_down_title_rap1','option'); ?></h3>
              <?php } ?>
                <div class="row">
                  <div class="col-md-6">
                    <div class="score_break-colmn">
                      <div class="score_value <?php echo getScoreClass($skills); ?>"><?php echo $skills; ?></div>
                      <div class="score_area">Skills
                      <span class="custom-tooltips"
                       tooltip="<?php echo $toolTip[0]['description_sin_tooltip']; ?>" alt="">
                        <img src="<?php echo get_field('tooltip_image_ra','option') ['url']; ?>" alt="tooltip">
                      </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="score_break-colmn">
                      <div class="score_value <?php echo getScoreClass($experience); ?>"><?php echo $experience; ?></div>
                      <div class="score_area">Experience
                      <span class="custom-tooltips"
                       tooltip="<?php echo $toolTip[1]['description_sin_tooltip']; ?>" alt="">
                        <img src="<?php echo get_field('tooltip_image_ra','option') ['url']; ?>" alt="tooltip">
                      </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="score_break-colmn">
                      <div class="score_value <?php echo getScoreClass($education); ?>"><?php echo $education; ?></div>
                      <div class="score_area">Education
                      <span class="custom-tooltips"
                       tooltip="<?php echo $toolTip[2]['description_sin_tooltip']; ?>" alt="">
                        <img src="<?php echo get_field('tooltip_image_ra','option') ['url']; ?>" alt="tooltip">
                      </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="score_break-colmn">
                      <div class="score_value <?php echo getScoreClass($key); ?>"><?php echo $key; ?></div>
                      <div class="score_area">Keyword Usage
                      <span class="custom-tooltips"
                       tooltip="<?php echo $toolTip[3]['description_sin_tooltip']; ?>" alt="">
                        <img src="<?php echo get_field('tooltip_image_ra','option') ['url']; ?>" alt="tooltip">
                      </span>
                      
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="score_break-colmn">
                      <div class="score_value <?php echo getScoreClass($rsr); ?>"><?php echo $rsr; ?></div>
                      <div class="score_area">
                        Resume Structure and Readability
                        <span class="custom-tooltips"
                       tooltip="<?php echo $toolTip[4]['description_sin_tooltip']; ?>" alt="">
                        <img src="<?php echo get_field('tooltip_image_ra','option') ['url']; ?>" alt="tooltip">
                      </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

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

          <div class="col-md-6 order-1 order-lg-2">
            <div class="resume_upload_display">
                <object width="100%" height="800px" type="application/pdf" data="<?php echo $attachment_url;  ?>#scrollbar=0&toolbar=0&navpanes=0">
            </div>
          </div>
        </div>
      </div>
    </div>





<script>
      jQuery(document).ready(function($){

         var airl = '<?php echo $attachment_url; ?>';
        console.log(airl);
              // Add the class when the page loads
              $(".resume_analyzer_loader").addClass('show_loader');

              // Remove the class after 10 seconds (10000 milliseconds)
              setTimeout(function() {
                  $('.resume_analyzer_loader').removeClass('show_loader');
              }, 10000);


              $('.custom-tooltips').append("<span></span>");
$('.custom-tooltips:not([tooltip-position])').attr('tooltip-position','top');


$(".custom-tooltips").mouseenter(function(){
 $(this).find('span').empty().append($(this).attr('tooltip'));
});    

          });


 

    </script>
 

<?php echo ob_get_clean();?>