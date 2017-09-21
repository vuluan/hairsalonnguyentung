<?php get_header(); ?>
<?php 
    $loop = getListPost("services"); 
?>
<section id="services" class="blog margin-bottom-90">
    <div class="pagetitle wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-sm-6">
                    <h1>Bảng giá dịch vụ</h1>
                    <div class="breadcrumb">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang Chủ</a> / Bảng giá dịch vụ
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="blogpost">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <?php if($loop->have_posts()) : while($loop->have_posts()) : $loop->the_post(); ?>
                        <?php 
                            $url = wp_get_attachment_image_url( get_field('service_image', $loop->ID), "full" );
                        ?>
                        <div class="blogfull wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                            <div class="blogimg"><img src="<?php echo $url ? $url : dummyImage(900, 716); ?>" class="img-responsive img-center">
                            </div>
                            <div class="blogfullcontent">
                                <div class="blogtitle">
                                    <h2><?php echo the_title(); ?></h2>
                                </div>
                                <?php echo the_content(); ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <?php else: ?>
                    <?php endif ?>
                    <div class="text-center">
                        <?php
                            if (function_exists(custom_pagination)) {
                                custom_pagination($loop->max_num_pages,"",$paged);
                            }
                        ?>
                        <?php wp_reset_postdata(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>