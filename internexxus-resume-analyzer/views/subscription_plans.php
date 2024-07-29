<?php ob_start(); ?>
<section class="sectionSpacing-3 subscribe_bg_wrap" style="background-image:url('https://dev.internexxus.com/wp-content/uploads/2024/01/hero-wide-bg.webp')">
	<div class="container">
            <div class="resume-inner-section">
                <div class="text-left title_wrap">
                   <h3 class="title">Choose your plan</h3>
                   <p class="sub_title">Unlock the full power of Internexxus</p>
                </div>              
            </div>

            <div class="plans-select-wrap">
                 <div class="row">
                 	<?php $levels = pmpro_getAllLevels(); // Fetch levels in descending order by ID
                 	$l=1;
					foreach ($levels as $level) {
					    $level_price = pmpro_getLevelCost($level, true, true);
					    $level_price=explode('<strong>',$level_price);
						$level_price=explode('per',$level_price[2]);
						$level_price=explode('&#36;',$level_price[0]);
						$level_price=$level_price[1];
						$level_price=trim($level_price);
					    ?>
					    <div class="col-md-3 d-flex">
					        <div class="plan__column">
					        	<?php if($l==3) { ?>
					        	<label class="recomend_tag">Best Value</label>
					        	<?php } ?>
					            <label class="plan_name"> <span class="plan_name-tag"><?php echo $level->name; ?></span></label>
					            <?php if (!empty($level_price)) : ?>
					                <h4 class="plan_value"><?php echo pmpro_formatPrice($level_price); ?><sub>/mo</sub></h4>
					            <?php else : ?>
					                <h4 class="plan_value"><?php echo pmpro_formatPrice(0); ?><sub>/mo</sub></h4>
					            <?php endif; ?>
					            <a href="<?php echo pmpro_url('checkout', '?level=' . $level->id); ?>" class="plan_tag">Get <?php echo $level->name; ?></a>
					            <?php echo $level->description; ?>
					        </div>
					    </div>
					    <?php
					    $l++;
					 } ?>


                     </div>
                 </div>
            
           
				 </div>
          </div>
    </section>
<?php echo ob_get_clean();?>