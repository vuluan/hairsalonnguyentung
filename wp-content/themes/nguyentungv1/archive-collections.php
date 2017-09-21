<?php get_header(); ?>
<?php 
    $collectiontypes = getTaxonomy("collectiontype");
    $loop = getListPost("collections");
    $loop_counter = 0;
?>
<section class="blog">
    <div class="pagetitle wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-sm-6">
                    <h1>Bộ sưu tập</h1>
                    <div class="breadcrumb">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang Chủ</a> / Bộ sưu tập
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="blogpost">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-sm-12 col-md-12">
                    <?php if($loop->have_posts()) : ?>
                        <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                            <?php $url = wp_get_attachment_image_url( get_field('collection_image', $loop->ID), "full" ); ?>
                            <?php if ($loop_counter == 0 || $loop_counter % 3 == 0): ?>
                                <div class="row margin-bottom-20">
                            <?php endif ?>
                                <div class="col-md-4">
                                    <div>
                                        <a href="<?php echo get_permalink($loop->ID); ?>">
                                            <img src="<?php echo $url ? resizeImage($url, 400, 463) : dummyImage(400, 463); ?>" class="img-responsive">
                                        </a>
                                    </div>
                                    <div class="team">
                                        <h5><?php the_title(); ?></h5>
                                    </div>
                                </div>
                            <?php if ($loop_counter == $loop->post_count - 1 || ($loop_counter + 1) % 3 == 0): ?>
                                </div>
                            <?php endif ?>
                            <?php 
                                $loop_counter ++;
                            ?>
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
                <div class="col-lg-4 col-sm-4 col-md-4">
                    <div class="blogright">
                    	<div class="rightsidebar wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
	                    	<h4>Các Bộ Sưu Tập</h4>
	                        <div class="listbg">
	                        	<ul class="listitem">
                                    <?php foreach ($collectiontypes as $key => $collectiontype): ?>
                                        <li><a href="<?php echo get_term_link($collectiontype); ?>"><?php echo $collectiontype->name; ?></a></li>
                                    <?php endforeach ?>
	                            </ul>
	                        </div>
	                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>