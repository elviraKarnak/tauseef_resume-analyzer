<?php ob_start(); ?>

<div
      class="sectionSpacing-3 inner_hero-banner"
      style="background-image: url(<?php echo  get_field( 'banner_image_urb', 'option' )['url']; ?>)"
    >
      <div class="container">
        <div class="row">
          <div class="col-md-6 order-2 order-lg-1">
            <div class="hero_content upload_file-wrapper">
            <?php if(!empty(get_field('title_urb','option'))){?>
                <h2 class="title"><?php echo get_field('title_urb','option'); ?></h2>
            <?php } ?>
            <?php if(!empty(get_field('description_urb','option'))){?>
                <p><?php echo get_field('description_urb','option'); ?></p>
            <?php } ?>
              <div class="hero_resume-upload-col">
                <div class="uplaodFile-col">
                  <button class="btn">
                    <i class="icon"
                      ><img src="<?php echo Internexxus_Resume_Analyzer_URL;?>/assets/images/choose-file-icon.svg" alt="" /></i
                    >Choose file
                  </button>
                  <input type="file" name="resume-file" id="resume-file" />
                </div>
                <div class="file_exmp">
                <?php if(!empty(get_field('upload_description_urb','option'))){?>
                <p><?php echo get_field('upload_description_urb','option'); ?></p>
                <?php } ?>
                </div>
              </div>
              <div class="loader_upload_cv">
              <span class="loader"></span>
              </div>
              <div class="hero_button-group">
                <a id="scan-resume" href="#" class="btnPrime btnDark">
                <?php if(!empty(get_field('upload_button_text_urb','option'))){?>
                    <?php echo get_field('upload_button_text_urb','option'); ?>
                <?php } ?>
                </a>
              </div>
            </div>
          </div>

          <div class="col-md-6 order-1 order-lg-2">
            <div class="hero_image_thumb">
              <div class="main_img-block">
                <?php if(get_field( 'section_image_urb', 'option' )): ?>
                  <img src="<?php echo get_field( 'section_image_urb', 'option' )['url']; ?>" alt="<?php echo get_field( 'section_image_urb', 'option' )['alt']; ?>">
                <?php endif; ?>
              </div>

              <div class="ellipise_right">
                <img
                  src="<?php echo Internexxus_Resume_Analyzer_URL;?>/assets/images/green-small-ellipse.svg"
                  alt=""
                  class="vert-move"
                />
              </div>
              <div class="ellipise_left">
                <img
                  src="<?php echo Internexxus_Resume_Analyzer_URL;?>/assets/images/blue_small-ellipse.svg"
                  alt=""
                  class="vert-move"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <section class="sectionSpacing-3">
      <div class="container">
        <div class="how_its-work-wrap">
        <ul class="upload_resume-timeline time_line-pointer">
          <li class="timeline_hiw">
            <div class="timeline_row align-items-center">
              <div class="left_block text-cnter">
              <?php if(get_field( 'section_image_hiw_rb', 'option' )): ?>
                  <img src="<?php echo get_field( 'section_image_hiw_rb', 'option' )['url']; ?>" alt="<?php echo get_field( 'section_image_hiw_rb', 'option' )['alt']; ?>">
                <?php endif; ?>
              </div>
              <div class="content_block">
              <?php if(!empty(get_field('title_hiw_rb','option'))){?>
                <h4 class="sub_title"><?php echo get_field('title_hiw_rb','option'); ?></h4>
              <?php } ?>
              
              <?php if(!empty(get_field('description_hiw_rb','option'))){?>
                <p><?php echo get_field('description_hiw_rb','option'); ?></p>
              <?php } ?>
                
              </div>
            </div>
          </li>
          <?php if (have_rows('how_it_works_hiw_rrb','option')): while (have_rows('how_it_works_hiw_rrb','option')): the_row(); ?>
            <li>
              <div class="timeline_row">
                <div class="left_block">
                  <h4 class="col-title">
                    <i class="icon_features">
                    <img src="<?php echo get_sub_field('icon_hiw_sin') ['url']; ?>" alt="<?php echo get_sub_field('icon_hiw_sin')['alt']; ?>" title="<?php echo get_sub_field('icon_hiw_sin')['title']; ?>">
                    </i>
                      <?php echo get_sub_field('title_hiw_sin'); ?>
                  </h4>
                </div>
                <div class="content_block timeline_pointer">
                  <ul class="recomended_list">
                    <?php if (have_rows('description_hiw_sin','option')): while (have_rows('description_hiw_sin','option')): the_row(); ?>
                      <li><?php echo get_sub_field('description_sin_hwitworks'); ?></li>
                    <?php endwhile; endif; ?>
                  </ul>
                </div>
              </div>
            </li>
          <?php endwhile; endif; ?>
          </ul>
        </div>
      </div>
    </section>




<div class="custom_alert_box">
   <div id="alert_fire" class="modal-wrapper">
       <div class="modal">
          <a href="#close" title="Close" class="alert_close"><i class="fa-solid fa-xmark"></i></a>
          <div class="modal-header">
             <h2>Warning!!</h2>
          </div>
          <div class="modal-alert-content">
          <i class="icon-alert fa-solid fa-exclamation"></i>
             <p class="alert alert-warning required_text" role="role"></p>
          </div>
       </div>
    </div>
</div>

  
<?php echo ob_get_clean();?>