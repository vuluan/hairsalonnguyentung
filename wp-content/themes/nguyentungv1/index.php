<?php get_header(); ?>
    <?php 
        $list_banner = getBanner();
        $query_args = array(
            'post_type' => "collections",
            'posts_per_page' => 10,
        );
        $loop_collection = new WP_Query($query_args);

        $query_args = array(
            'post_type' => "cosmetics",
            'posts_per_page' => 12,
        );
        $loop_cosmetic = new WP_Query($query_args);
    ?>
    <?php if($list_banner->have_posts()) : ?>
        <div class="sliderfull">
            <div id="rev_slider_4_1_wrapper" class="rev_slider_wrapper fullwidthbanner-container" data-alias="classicslider1" style="margin:0px auto;background-color:transparent;padding:0px;margin-top:0px;margin-bottom:0px;">
                <!-- START REVOLUTION SLIDER 5.0.7 auto mode -->
                <div id="rev_slider_4_1" class="rev_slider fullwidthabanner" style="display:none;" data-version="5.0.7">
                    <ul>
                        <?php while($list_banner->have_posts()) : $list_banner->the_post(); ?>
                        <?php  
                            $url = wp_get_attachment_image_url(get_field('banner_image', $post->ID), "full");
                        ?>
                        <!-- SLIDE  -->
                        <li data-index="rs-16" data-transition="zoomout" data-slotamount="default"  data-easein="Power4.easeInOut" data-easeout="Power4.easeInOut" data-masterspeed="2000"  data-rotate="0"  data-fstransition="fade" data-fsmasterspeed="1500" data-fsslotamount="7" data-saveperformance="off"  data-title="Intro" data-description="">
                            <!-- MAIN IMAGE -->
                            <img src="<?php echo $url; ?>" alt="slider" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina>
                        </li>
                        <?php endwhile; ?>
                        
                    </ul>
                    <div class="tp-static-layers"></div>
                    <div class="tp-bannertimer" style="height: 7px; background-color: rgba(255, 255, 255, 0.25);"></div>
                </div>
            </div>
        </div>
        <section class="slider-titile">
            <div class="container">
                <div class="row">
                    <div class="col-lg-11 pull-right">
                        <div class="sliderarrow">
                            <a class="left rev-leftarrow">Left</a>
                            <a class="right rev-rightarrow">Right</a>
                        </div>
                        <div class="titile-bg">
                            <?php 
                                $custom_logo_id = get_theme_mod('custom_logo');
                                $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                                if (has_custom_logo()) {
                                    echo '<img src="'. resizeImage(esc_url($logo[0]), 300) .'">';
                                } else {
                                    echo '<h1>'. get_bloginfo( 'name' ) .'</h1>';
                                }
                            ?>
                        </div>
                        <div class="white-bg">
                            <?php if ( is_active_sidebar( 'wg-homepage-introduction' ) ) : ?>
                                <?php dynamic_sidebar( 'wg-homepage-introduction' ); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section id="ourteam" class="wow fadeInUp">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <h2>10 Bộ sưu tập mới nhất từ Hair Salon Nguyễn Tùng</h2>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-8">
                    <div class="responsive">
                        <?php if ($loop_collection->have_posts()): ?>
                            <?php while ( $loop_collection->have_posts() ) : $loop_collection->the_post(); ?>
                                <?php $url = wp_get_attachment_image_url(get_field('collection_image', $loop_collection->ID), "full" ); ?>
                                <div>
                                    <div>
                                        <a href="<?php echo get_permalink($loop_collection->ID); ?>">
                                            <img src="<?php echo $url ? resizeImage($url, 300, 347) : dummyImage(245, 283); ?>" class="img-responsive">
                                        </a>
                                    </div>
                                    <div class="team">
                                        <h5><?php the_title(); ?></h5>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </section>
    <section class="excellence wow fadeInUp">
        <div id="parallax-2" class="parallax fixed fixed-desktop">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-md-5 col-lg-5 pull-right col-pad5 bg-white">
                        <?php if ( is_active_sidebar( 'wg-homepage-market-content' ) ) : ?>
                            <?php dynamic_sidebar( 'wg-homepage-market-content' ); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </section>
    <?php 
        $loop = getListPost("cosmetics");
        $loop_counter = 0;
    ?>
    <section class="blog">
        <div class="blogpost margin-bottom-90">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center margin-bottom-20">
                      <h2>Mỹ Phẩm mới nhất từ Salon Nguyễn Tùng</h2>
                    </div>
                    <div class="col-lg-12 col-sm-12 col-md-12">
                        <?php if($loop_cosmetic->have_posts()) : ?>
                            <?php while ( $loop_cosmetic->have_posts() ) : $loop_cosmetic->the_post(); ?>
                                <?php $url = wp_get_attachment_image_url( get_field('cosmetic_image', $loop_cosmetic->ID), "full" ); ?>
                                <?php if ($loop_counter == 0 || $loop_counter % 4 == 0): ?>
                                    <div class="row margin-bottom-20">
                                <?php endif ?>
                                    <div class="col-md-3">
                                        <div>
                                            <a href="<?php echo get_permalink($loop_cosmetic->ID); ?>">
                                                <img src="<?php echo $url ? resizeImage($url, 400, 463) : dummyImage(384, 444); ?>" class="img-responsive">
                                            </a>
                                        </div>
                                        <div class="team">
                                            <h5><?php the_title(); ?></h5>
                                        </div>
                                    </div>
                                <?php if ($loop_counter == $loop_cosmetic->post_count - 1 || ($loop_counter + 1) % 4 == 0): ?>
                                    </div>
                                <?php endif ?>
                                <?php 
                                    $loop_counter ++;
                                ?>
                            <?php endwhile; ?>
                        <?php else: ?>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php get_footer(); ?>
