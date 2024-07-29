<?php ob_start(); 

if(!is_user_logged_in()) {
       // $ralb_btn_procucts_url = get_field('not_login_ralp', 'option');
        $triggerClass = "trigger_4";
    }else{
       // $ralb_btn_procucts_url = $ralb_btn_procucts['url'];
        $triggerClass = "";
    } ?>

<div class="sectionSpacing-3 hero_section" style="background-image: url(<?php echo  get_field( 'section_bg_image_rsb', 'option' )['url']; ?>);">
       <div class="container">
            <div class="row align-items-center">                
                  <div class="col-md-6 order-2 order-lg-1">
                      <div class="hero_content">
                        <?php if(!empty(get_field('title_rsb','option'))){?>
                            <h2 class="title"><?php echo get_field('title_rsb','option'); ?></h2>
                        <?php } ?>
                        <?php if(!empty(get_field('descriptions_rsb','option'))){?>
                            <p><?php echo get_field('descriptions_rsb','option'); ?></p>
                        <?php } ?>
                          <div class="hero_button-group">
                          <?php
                                $ralb_btn_1 = get_field('button_rsb_1','option');
                                if( $ralb_btn_1 ): 
                                    $ralb_btn_1_url = $ralb_btn_1['url'];
                                    $ralb_btn_1_title = $ralb_btn_1['title'];
                                    $ralb_btn_1_target = $ralb_btn_1['target'] ? $ralb_btn_1['target'] : '_self';
                                    ?>
                                     <a class="btnPrime btnDark" href="<?php echo esc_url( $ralb_btn_1_url ); ?>" target="<?php echo esc_attr( $ralb_btn_1_target ); ?>"><?php echo esc_html( $ralb_btn_1_title ); ?></a>
                                <?php endif; ?>
                                <?php 
                                    $ralb_btn_2 = get_field('button_rsb_2','option');
                                    if( $ralb_btn_2 ): 
                                       // $ralb_btn_2_url = $ralb_btn_2['url'];
                                        $ralb_btn_2_title = $ralb_btn_2['title'];
                                        $ralb_btn_2_target = $ralb_btn_2['target'] ? $ralb_btn_2['target'] : '_self';
                                    ?>

                                    <?php

                                        if(is_user_logged_in()) {
                                               
                                                global $current_user;
                                                $current_user->membership_level = pmpro_getMembershipLevelForUser($current_user->ID);
                                                $userMembershipLevel = pmpro_getMembershipLevelForUser($current_user->ID);
                                                //var_dump($userMembershipLevel->name);
                                            
                                                if(!empty($userMembershipLevel->id)){
                                                $ralb_btn_2_url = $ralb_btn_2['url'];
                                                
                                            } else{
                                                $ralb_btn_2_url = get_field('member_ship_page_dpp2','option');

                                            }
                                        }
                                        ?>
                                    <a class="btnPrime btnlight <?php echo $triggerClass; ?>" href="<?php echo esc_url( $ralb_btn_2_url ); ?>" target="<?php echo esc_attr( $ralb_btn_2_target ); ?>"><?php echo esc_html( $ralb_btn_2_title ); ?></a>
                                    <?php endif; ?>
                          </div>
                      </div>
                  </div>

                  <div class="col-md-6 order-1 order-lg-2">
                    <div class="hero_image_thumb">
                        <div class="main_img-block">
                            <img src="<?php echo get_field( 'section_image_rsb', 'option' )['url']; ?>" alt="<?php echo get_field( 'section_image_rsb', 'option' )['alt']; ?>">  
                        </div>
                     
                        <div class="ellipise_right">
                            <img src="<?php echo Internexxus_Resume_Analyzer_URL;?>/assets/images/ellipse-green.svg" alt="" class="vert-move">
                        </div>
                        <div class="ellipise_left">
                            <img src="<?php echo Internexxus_Resume_Analyzer_URL;?>/assets/images/ellipse-blue.svg" alt="" class="vert-move">
                        </div>

                    </div>
               </div>

            </div>
        </div>
    </div>
    <section class="sectionSpacing-1 sectionProducts">
          <div class="container">
            <?php if(!empty(get_field('title_sec_products','option'))){?>
                <h3 class="title"><?php echo get_field('title_sec_products','option'); ?></h2>
            <?php } ?>
            <div class="row">
            <?php if (have_rows('products_ralp','option')): while (have_rows('products_ralp','option')): the_row(); ?>  
                <div class="col-md-4">   
                        <div class="product_column">
                            <div class="image_thumb">
                                <img src="<?php echo get_sub_field('product_image_sinp_ralp') ['url']; ?>" alt="<?php echo get_sub_field('product_image_sinp_ralp')['alt']; ?>" title="<?php echo get_sub_field('product_image_sinp_ralp')['title']; ?>"> 
                            </div>
                            <div class="pro_content-wrap">
                                <h3 class="block_title">
                                <label class="icon">
                                <img src="<?php echo get_sub_field('product_icon_sinp_ralp') ['url']; ?>" alt="<?php echo get_sub_field('product_icon_sinp_ralp')['alt']; ?>" title="<?php echo get_sub_field('product_icon_sinp_ralp')['title']; ?>"> 
                                </label><?php echo get_sub_field('product_title_sinp_ralp'); ?></h3>
                                <p><?php echo get_sub_field('product_description_sinp_ralp'); ?></p>
                                <?php 
                                    $ralb_btn_procucts = get_sub_field('product_url_sinp_ralp');
                                    if( $ralb_btn_procucts ): 
                                      //  $ralb_btn_procucts_url = $ralb_btn_procucts['url'];
                                        $ralb_btn_procucts_title = $ralb_btn_procucts['title'];
                                        $ralb_btn_procucts_target = $ralb_btn_procucts['target'] ? $ralb_btn_procucts['target'] : '_self';
                                    ?>

                                        <?php

                                        if(is_user_logged_in()) {
                                                //$ralb_btn_procucts_url = get_field('not_login_ralp', 'option');
                                                global $current_user;
                                                $current_user->membership_level = pmpro_getMembershipLevelForUser($current_user->ID);
                                                $userMembershipLevel = pmpro_getMembershipLevelForUser($current_user->ID);
                                            if(!empty($userMembershipLevel)){
                                                $ralb_btn_procucts_url = $ralb_btn_procucts['url'];
                                            } else{
                                                $ralb_btn_procucts_url = get_field('member_ship_page_dpp2','option');
                                            }
                                        }?>
                        <a href="<?php echo $ralb_btn_procucts_url; ?>"  target="<?php echo esc_attr( $ralb_btn_procucts_target ); ?>" class="btn_pro <?php echo $triggerClass; ?>"><?php echo $ralb_btn_procucts_title; ?></a>
                                 <?php endif; ?>
                            </div>
                        </div>              
                    </div>
                <?php endwhile; endif; ?>
            </div>
          </div>
    </section>



<!-- <div class="custom-modal">
    <div class="custom-modal-content">
        <span class="close-button modal_reg_close">&times;</span>
        <?php //echo do_shortcode('[elementor-template id="41756"]'); ?>
    </div>
    </div> -->


    <div class="custom-modal">
            <div class="custom-modal-content">
                <span class="close-button modal_reg_close bodyhidden">&times;</span>
                <?php //echo //do_shortcode('[elementor-template id="40602"]'); ?>


                <div class="tabs">

                <div id="tabs-content">
                    <div id="login_tab" class="tab-content" style="display">
                    <h2 class="elementor-heading-title elementor-size-default">Please Login To Analyze <br>Your Resume By AI <span style="width:25px; display:inline-block"><img data-src="https://dev.internexxus.com/wp-content/plugins/internexxus-resume-analyzer/assets/images/icon_ai.svg" src="https://dev.internexxus.com/wp-content/plugins/internexxus-resume-analyzer/assets/images/icon_ai.svg" class=" lazyloaded"><noscript><img data-src="https://dev.internexxus.com/wp-content/plugins/internexxus-resume-analyzer/assets/images/icon_ai.svg" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" class="lazyload"><noscript><img src="https://dev.internexxus.com/wp-content/plugins/internexxus-resume-analyzer/assets/images/icon_ai.svg"></noscript></span></h2>
                        <?php echo do_shortcode( '[wp_job_board_pro_login popup="true"]' ); ?>
                    </div>
                    <div id="registration_tab" class="tab-content">
                    <h2 class="elementor-heading-title elementor-size-default">Create a free Account To Analyze <br>Your Resume By AI <span style="width:25px; display:inline-block"><img data-src="https://dev.internexxus.com/wp-content/plugins/internexxus-resume-analyzer/assets/images/icon_ai.svg" src="https://dev.internexxus.com/wp-content/plugins/internexxus-resume-analyzer/assets/images/icon_ai.svg" class=" lazyloaded"><noscript><img data-src="https://dev.internexxus.com/wp-content/plugins/internexxus-resume-analyzer/assets/images/icon_ai.svg" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" class="lazyload"><noscript><img src="https://dev.internexxus.com/wp-content/plugins/internexxus-resume-analyzer/assets/images/icon_ai.svg"></noscript></span></h2>
                        <?php echo do_shortcode( '[wp_job_board_pro_register popup="true"]' ); ?>
                    </div>


                </div> <!-- END tabs-content -->
        <ul id="tabs-nav">
            <li><a href="#login_tab">Already have an account? <span>Login</a></li>
            <li><a href="#registration_tab">Don't you have an account? <span>Register</span></a></li>
        </ul> 
            
        </div>
            </div>
    </div>

    <script>
            jQuery(document).ready(function($) {
                $(".trigger_4").click(function(e){
                    e.preventDefault();
                    $(".custom-modal").addClass("show-custom-modal");
                })
                $(".modal_reg_close").click(function(e){
                    e.preventDefault();
                    $(".custom-modal").removeClass("show-custom-modal");

                    });

                    $(".apus-user-login").on('click',function(e){
                        $(".modal_reg_close").click();
                    })

                    $('#tabs-nav li:first-child').addClass('active');

                    $('.tab-content').hide();
                    $('#login_tab').show();

                    // Click function
                    $('#tabs-nav li').click(function(){
                    $('#tabs-nav li').removeClass('active');
                    $(this).addClass('active');
                    $('.tab-content').hide();
                    
                    var activeTab = $(this).find('a').attr('href');
                    $(activeTab).fadeIn();
                    return false;
                    });
            });
        </script>



<?php echo ob_get_clean();?>