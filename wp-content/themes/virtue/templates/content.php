 <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="" itemtype="http://schema.org/BlogPosting">
        <div class="row">
        <?php         

        global $post, $virtue; 
            $postsummery  = get_post_meta( $post->ID, '_kad_post_summery', true );
            $height       = get_post_meta( $post->ID, '_kad_posthead_height', true );
            $swidth       = get_post_meta( $post->ID, '_kad_posthead_width', true );
            if (!empty($height)){
                $slideheight = $height;
            } else {
                $slideheight = apply_filters('kt_post_excerpt_image_height', 400);
            }
            if (!empty($swidth)){
                $slidewidth = $swidth;
            } else {
                $slidewidth = $slidewidth = apply_filters('kt_post_excerpt_image_width', 846);
            }
            if(empty($postsummery) || $postsummery == 'default') {
                if(!empty($virtue['post_summery_default'])) {
                    $postsummery = $virtue['post_summery_default'];
                } else {
                    $postsummery = 'img_portrait';
                }
            }
            $portraitwidth = apply_filters('kt_post_excerpt_image_width_portrait', 365);
            $portraitheight = apply_filters('kt_post_excerpt_image_height_portrait', 365);
                        
            if($postsummery == 'img_landscape') { 
                $textsize = 'col-md-12'; 
                if (has_post_thumbnail( $post->ID ) ) {
                    $image_id = get_post_thumbnail_id( $post->ID );
                    $image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); 
                    $thumbnailURL = $image_url[0];
                    $image = aq_resize($thumbnailURL, $slidewidth, $slideheight, true);
                    if(empty($image)) { $image = $thumbnailURL; }
                    ?>
                    <div class="col-md-12">
                        <div class="imghoverclass img-margin-center">
                            <a href="<?php the_permalink()  ?>" title="<?php echo esc_attr(get_the_title()); ?>">
                                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" itemprop="image"  class="iconhover" style="display:block;">
                            </a> 
                        </div>
                    </div>
                    <?php $image = null; $thumbnailURL = null; 
                } else {
                        $thumbnailURL = virtue_post_default_placeholder();
                        $image = aq_resize($thumbnailURL, $slidewidth, $slideheight, true);
                        if(empty($image)) { $image = $thumbnailURL; } ?>
                        <div class="col-md-12">
                        <div class="imghoverclass img-margin-center">
                          <a href="<?php the_permalink()  ?>" title="<?php echo esc_attr(get_the_title()); ?>">
                                  <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" itemprop="image"  class="iconhover" style="display:block;">
                              </a> 
                           </div>
                       </div>
                      <?php $image = null; $thumbnailURL = null; 
                } 
            } elseif($postsummery == 'img_portrait') { 
                $textsize = 'col-md-7'; 
                if (has_post_thumbnail( $post->ID ) ) {
                    $image_url = wp_get_attachment_image_src( 
                    get_post_thumbnail_id( $post->ID ), 'full' ); 
                    $thumbnailURL = $image_url[0]; 
                    $image = aq_resize($thumbnailURL, $portraitwidth, $portraitheight, true);
                    if(empty($image)) { $image = $thumbnailURL; } ?>
                    <div class="col-md-5 post-image-container">
                        <div class="imghoverclass img-margin-center">
                            <a href="<?php the_permalink()  ?>" title="<?php echo esc_attr(get_the_title()); ?>">
                                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" itemprop="image"  class="iconhover" style="display:block;">
                            </a> 
                         </div>
                     </div>
                    <?php $image = null; $thumbnailURL = null; 
                } else {
                  $thumbnailURL = virtue_post_default_placeholder();
                  $image = aq_resize($thumbnailURL, $portraitwidth, $portraitheight, true);
                  if(empty($image)) { $image = $thumbnailURL; } ?>
                  <div class="col-md-5 post-image-container">
                    <div class="imghoverclass img-margin-center">
                        <a href="<?php the_permalink()  ?>" title="<?php echo esc_attr(get_the_title()); ?>">
                            <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" itemprop="image"  class="iconhover" style="display:block;">
                        </a> 
                     </div>
                 </div>
                <?php $image = null; $thumbnailURL = null; 
                } 
            } elseif($postsummery == 'slider_landscape') {
                $textsize = 'col-md-12'; ?>
                <div class="col-md-12">
                    <div class="flexslider kt-flexslider loading" style="max-width:<?php echo esc_attr($slidewidth);?>px;" data-flex-speed="7000" data-flex-anim-speed="400" data-flex-animation="fade" data-flex-auto="true">
                        <ul class="slides">
                            <?php
                            $image_gallery = get_post_meta( $post->ID, '_kad_image_gallery', true );
                            if(!empty($image_gallery)) {
                                $attachments = array_filter( explode( ',', $image_gallery ) );
                                if ($attachments) {
                                    foreach ($attachments as $attachment) {
                                        $attachment_url = wp_get_attachment_url($attachment , 'full');
                                        $image = aq_resize($attachment_url, $slidewidth, $slideheight, true);
                                        $alt = get_post_meta($attachment, '_wp_attachment_image_alt', true);
                                        if(empty($image)) {$image = $attachment_url;} ?>
                                            <li>
                                                <a href="<?php the_permalink() ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                                                    <img src="<?php echo esc_attr($image); ?>" itemprop="image" alt="<?php echo esc_attr($alt);?>"  class="" />
                                            </a>
                                        </li>
                                    <?php 
                                    }
                                  }
                                } ?>                                   
                        </ul>
                    </div> <!--Flex Slides-->
                </div>
            <?php 
            } elseif($postsummery == 'slider_portrait') { ?>
                <?php $textsize = 'col-md-7'; ?>
                <div class="col-md-5 post-image-container">
                    <div class="flexslider kt-flexslider loading" data-flex-speed="7000" data-flex-anim-speed="400" data-flex-animation="fade" data-flex-auto="true">
                        <ul class="slides">
                            <?php global $post;
                            $image_gallery = get_post_meta( $post->ID, '_kad_image_gallery', true );
                                if(!empty($image_gallery)) {
                                    $attachments = array_filter( explode( ',', $image_gallery ) );
                                    if ($attachments) {
                                        foreach ($attachments as $attachment) {
                                            $attachment_url = wp_get_attachment_url($attachment , 'full');
                                            $image = aq_resize($attachment_url, $portraitwidth, $portraitheight, true);
                                            $alt = get_post_meta($attachment, '_wp_attachment_image_alt', true);
                                            if(empty($image)) {$image = $attachment_url;} ?>
                                            <li>
                                                <a href="<?php the_permalink() ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                                                    <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($alt);?>" itemprop="image" class="" />
                                                </a>
                                            </li>
                                        <?php 
                                        }
                                    }
                                } ?>           
                        </ul>
                    </div> <!--Flex Slides-->
                </div>
            <?php 
            } elseif($postsummery == 'video') {
                    $textsize = 'col-md-12'; ?>
                    <div class="col-md-12">
                        <div class="videofit">
                            <?php global $post; echo get_post_meta( $post->ID, '_kad_post_video', true ); ?>
                        </div>
                    </div>
            <?php 
            } else { 
                $textsize = 'col-md-12 kttextpost'; 
            } ?>

            <div class="<?php echo esc_attr($textsize);?> post-text-container postcontent">
                <?php get_template_part('templates/post', 'date'); ?> 
                <header>
                    <a href="<?php the_permalink() ?>">
                        <h2 class="entry-title" itemprop="name headline">
                            <?php the_title(); ?> 
                        </h2>
                    </a>
                    <?php get_template_part('templates/entry', 'meta-subhead'); ?>    
                </header>
                <div class="entry-content" itemprop="articleBody">
                    <?php 
                        do_action( 'kadence_post_excerpt_content_before' );
                        
                        the_excerpt(); 
                        
                        do_action( 'kadence_post_excerpt_content_after' );
                    ?>
                </div>
                <footer>
                    <?php $tags = get_the_tags(); if ($tags) { ?>
                        <span class="posttags color_gray"><i class="icon-tag"></i> <?php the_tags('', ', ', ''); ?></span>
                    <?php } ?>
                </footer>
            </div><!-- Text size -->
        </div><!-- row-->
    </article> <!-- Article -->