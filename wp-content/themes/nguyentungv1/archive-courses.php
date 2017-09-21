<?php get_header(); ?>
<?php 
    $loop = getListPost("courses"); 
    $query_args = array(
        'post_type' => "collections",
        'posts_per_page' => 3,
    );
    $loop_collection = new WP_Query($query_args);
?>
<section class="blog">
    <div class="pagetitle wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-sm-6">
                    <h1>Khoá Học</h1>
                    <div class="breadcrumb">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang Chủ</a> / Khoá Học
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="blogpost">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-sm-12 col-md-8">
                	<?php if($loop->have_posts()) : ?>
                		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                			<?php $url = wp_get_attachment_image_url(get_field('course_image', $loop->ID), "full" ); ?>
                			<div class="blogbox wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
		                        <div class="blogimg"><img src="<?php echo $url ? $url : dummyImage(665, 465); ?>" class="img-responsive img-center">
		                        </div>
		                        <div class="blogcontent">
		                            <div class="blogtitle">
		                                <h2><?php the_title(); ?></h2>
		                                <span><?php echo the_date(); ?></span>
		                            </div>
		                            <?php the_excerpt(); ?>
		                            <a class="btn btn-default" href="<?php echo get_permalink($loop->ID); ?>">Xem Chi Tiết</a>
		                        </div>
		                    </div>
                		<?php endwhile; ?>
                	<?php else: ?>
                		<div class="blogbox wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;"> Không có tin tức nào!
                		</div>
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
                <div class="col-lg-5 col-sm-12 col-md-4">
                    <div class="blogright">
                        <div class="rightsidebar wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                            <h4>Bộ Sưu Tập Mới Nhất</h4>
                            <div class="listbg">
                                <?php if($loop_collection->have_posts()) : ?>
                                    <?php while ( $loop_collection->have_posts() ) : $loop_collection->the_post(); ?>
                                        <?php $url = wp_get_attachment_image_url(get_field('collection_image', $loop_collection->ID), "full" ); ?>
                                        <div class="postdiv wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                                            <a href="<?php echo get_permalink($loop_collection->ID); ?>">
                                                <h5><?php the_title(); ?></h5>
                                                <div class="rightpostimg"><img src="<?php echo $url ? resizeImage($url, 420, 300)  : dummyImage(420, 300); ?>" class="img-responsive">
                                                </div>
                                            </a>
                                        </div>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <div class="blogbox wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;"> Không có khoá học nào!
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>