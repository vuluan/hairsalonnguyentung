<?php get_header(); ?>
<section class="blog">
    <div class="pagetitle wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <h1><?php echo the_title(); ?></h1>
                    <div class="breadcrumb">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang Chủ</a> / <a href="<?php echo esc_url( home_url( '/' ) ); ?>my-pham">Mỹ Phẩm</a> / <?php echo the_title(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="blogpost">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
                        <?php 
                            $url = wp_get_attachment_image_url( get_field('cosmetic_image', get_the_ID()), "full" );
                        ?>
                        <div class="blogfull wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                            <div class="blogimg"><img src="<?php echo $url ? $url : dummyImage(900, 716); ?>" class="img-responsive img-center">
                            </div>
                            <div class="blogfullcontent">
    							<?php 
    								echo the_content();
    							?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <?php else: ?>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>