<?php 

function resizeImage($src,$w=0,$h=0,$zc=1){
  if($w!=0 && $h!=0){
    return esc_url( home_url( '/' ) ).'imgresize.php?w='.$w.'&h='.$h.'&src='.$src.'&zc='.$zc;
  }elseif($w!=0){
    return esc_url( home_url( '/' ) ).'imgresize.php?w='.$w.'&src='.$src.'&zc='.$zc;
  }elseif($h!=0){
    return esc_url( home_url( '/' ) ).'imgresize.php?h='.$h.'&src='.$src.'&zc='.$zc;
  }
}


if ( ! function_exists('pr')){
	function pr($data,$type=0)
	{
		print '<pre>';
		print_r($data);
		print '</pre>';
		if($type!=0){
			exit();
		}
	}
}
	
function getBanner($amount = 3) {
	$args = array(
		'post_type' => 'banners',
    	'posts_per_page' => $amount,
		'meta_query' => array(
	        array(
	            'key' => 'banner_show',
	            'value' => true,
	            'compare' => '='
	        )
        ),
	);
	$the_query = new WP_Query($args);
	return $the_query;
}

function getTaxonomy($taxonomy) {
	$terms = get_terms(array(
	    'taxonomy' => $taxonomy,
	    'hide_empty' => false,
	));
	return $terms;
}

function getListPost($post_type) {
  $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
  $default_posts_per_page = get_option( 'posts_per_page' );
  $query_args = array(
    'post_type' => $post_type,
    'posts_per_page' => $default_posts_per_page,
    'paged' => $paged
  );
  $loop = new WP_Query($query_args);
  return $loop;
}

function getListPostTaxonomy($post_type, $post_taxonomy) {
  $taxonomy = get_queried_object();
  $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
  $default_posts_per_page = get_option( 'posts_per_page' );
  $query_args = array(
      'tax_query' => array(
          array(
              'taxonomy' => $post_taxonomy,
              'field' => 'ID',
              'terms' => $taxonomy->term_id
          )
      ),
      'post_type' => $post_type,
      'posts_per_page' => $default_posts_per_page,
      'paged' => $paged
  );
  $loop = new WP_Query($query_args);
  return $loop;
}

// custom paging link
function custom_paginate_links( $args = '' ) {
  global $wp_query, $wp_rewrite;
  // Setting up default values based on the current URL.
  $pagenum_link = html_entity_decode( get_pagenum_link() );
  $url_parts    = explode( '?', $pagenum_link );
  // Get max pages and current page out of the current query, if available.
  $total   = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
  $current = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
  // Append the format placeholder to the base URL.
  $pagenum_link = trailingslashit( $url_parts[0] ) . '%_%';
  // URL base depends on permalink settings.
  $format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
  $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';
  $defaults = array(
    'base' => $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
    'format' => $format, // ?page=%#% : %#% is replaced by the page number
    'total' => $total,
    'current' => $current,
    'show_all' => false,
    'prev_next' => true,
    'prev_text' => __('&laquo; Previous'),
    'next_text' => __('Next &raquo;'),
    'end_size' => 1,
    'mid_size' => 2,
    'type' => 'plain',
    'add_args' => array(), // array of query args to add
    'add_fragment' => '',
    'before_page_number' => '',
    'after_page_number' => ''
  );
  $args = wp_parse_args( $args, $defaults );
  if ( ! is_array( $args['add_args'] ) ) {
    $args['add_args'] = array();
  }
  // Merge additional query vars found in the original URL into 'add_args' array.
  if ( isset( $url_parts[1] ) ) {
    // Find the format argument.
    $format = explode( '?', str_replace( '%_%', $args['format'], $args['base'] ) );
    $format_query = isset( $format[1] ) ? $format[1] : '';
    wp_parse_str( $format_query, $format_args );
    // Find the query args of the requested URL.
    wp_parse_str( $url_parts[1], $url_query_args );
    // Remove the format argument from the array of query arguments, to avoid overwriting custom format.
    foreach ( $format_args as $format_arg => $format_arg_value ) {
      unset( $url_query_args[ $format_arg ] );
    }
    $args['add_args'] = array_merge( $args['add_args'], urlencode_deep( $url_query_args ) );
  }
  // Who knows what else people pass in $args
  $total = (int) $args['total'];
  if ( $total < 2 ) {
    return;
  }
  $current  = (int) $args['current'];
  $end_size = (int) $args['end_size']; // Out of bounds?  Make it the default.
  if ( $end_size < 1 ) {
    $end_size = 1;
  }
  $mid_size = (int) $args['mid_size'];
  if ( $mid_size < 0 ) {
    $mid_size = 2;
  }
  $add_args = $args['add_args'];
  $r = '';
  $page_links = array();
  $dots = false;
  if ( $args['prev_next'] && $current && 1 < $current ) :
    $link = str_replace( '%_%', 2 == $current ? '' : $args['format'], $args['base'] );
    $link = str_replace( '%#%', $current - 1, $link );
    if ( $add_args )
      $link = add_query_arg( $add_args, $link );
    $link .= $args['add_fragment'];
    /**
     * Filters the paginated links for the given archive pages.
     *
     * @since 3.0.0
     *
     * @param string $link The paginated link URL.
     */
    $page_links[] = '<a class="prev pagination__page btn-squae" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '">' . $args['prev_text'] . '</a>';
  endif;
  for ( $n = 1; $n <= $total; $n++ ) :
    if ( $n == $current ) :
      $page_links[] = "<span class='pagination__page btn-squae active'>" . $args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number'] . "</span>";
      $dots = true;
    else :
      if ( $args['show_all'] || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size ) ) :
        $link = str_replace( '%_%', 1 == $n ? '' : $args['format'], $args['base'] );
        $link = str_replace( '%#%', $n, $link );
        if ( $add_args )
          $link = add_query_arg( $add_args, $link );
        $link .= $args['add_fragment'];
        /** This filter is documented in wp-includes/general-template.php */
        $page_links[] = "<a class='pagination__page btn-squae' href='" . esc_url( apply_filters( 'paginate_links', $link ) ) . "'>" . $args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number'] . "</a>";
        $dots = true;
      elseif ( $dots && ! $args['show_all'] ) :
        $page_links[] = '<span class="pagination__page btn-squae dots">' . __( '&hellip;' ) . '</span>';
        $dots = false;
      endif;
    endif;
  endfor;
  if ( $args['prev_next'] && $current && $current < $total ) :
    $link = str_replace( '%_%', $args['format'], $args['base'] );
    $link = str_replace( '%#%', $current + 1, $link );
    if ( $add_args )
      $link = add_query_arg( $add_args, $link );
    $link .= $args['add_fragment'];
    /** This filter is documented in wp-includes/general-template.php */
    $page_links[] = '<a class="next pagination__page btn-squae" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '">' . $args['next_text'] . '</a>';
  endif;
  switch ( $args['type'] ) {
    case 'array' :
      return $page_links;
    case 'list' :
      $r .= "<ul class='page-numbers'>\n\t<li>";
      $r .= join("</li>\n\t<li>", $page_links);
      $r .= "</li>\n</ul>\n";
      break;
    default :
      $r = join("\n", $page_links);
      break;
  }
  return $r;
}

function custom_pagination($numpages = '', $pagerange = '', $paged='') {

  if (empty($pagerange)) {
    $pagerange = 2;
  }

  /**
   * This first part of our function is a fallback
   * for custom pagination inside a regular loop that
   * uses the global $paged and global $wp_query variables.
   * 
   * It's good because we can now override default pagination
   * in our theme, and use this function in default quries
   * and custom queries.
   */
  global $paged;
  if (empty($paged)) {
    $paged = 1;
  }
  if ($numpages == '') {
    global $wp_query;
    $numpages = $wp_query->max_num_pages;
    if(!$numpages) {
        $numpages = 1;
    }
  }

  /** 
   * We construct the pagination arguments to enter into our paginate_links
   * function. 
   */
  $pagination_args = array(
    'base'            => get_pagenum_link(1) . '%_%',
    'format'          => 'page/%#%',
    'total'           => $numpages,
    'current'         => $paged,
    'show_all'        => False,
    'end_size'        => 1,
    'mid_size'        => $pagerange,
    'prev_next'       => True,
    'prev_text'       => __('&laquo;'),
    'next_text'       => __('&raquo;'),
    'type'            => 'array',
    'add_args'        => false,
    'add_fragment'    => ''
  );

  $paginate_links = custom_paginate_links($pagination_args);

   if (is_array($paginate_links)) {
        $current_page = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
        echo '<nav class="col-md-12"><ul class="pagination">';
        foreach ($paginate_links as $i => $page) {
            if ($current_page == 1 && $i == 0) {
                echo "<li><span class='pagination__page btn-squae active'>$page</li>";
            } else {
                if ($current_page != 1 && $current_page == $i) {
                    echo "<li><span class='pagination__page btn-squae active'>$page</li>";
                } else {
                    echo "<li>$page</li>";
                }
            }
        }
        echo '</ul></nav>';
    }

}

function dummyImage($width, $height) {
  return "https://placeholdit.imgix.net/~text?txtsize=20&txt=No%20Image&w=$width&h=$height";
}

function themename_custom_logo_setup() {
    $defaults = array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
    );
    add_theme_support( 'custom-logo', $defaults );
}
add_action( 'after_setup_theme', 'themename_custom_logo_setup' );

/**
 * Register widget area.
 */
function nguyentungv1_widgets_init() {
  // register_sidebar( array(
  //   'name'          => __( 'Homepage Overview Images', 'nguyentungv1' ),
  //   'id'            => 'wg-homepage-overview-image',
  //   'description'   => __( 'Add widgets here to appear in home page', 'nguyentungv1' ),
  //   'before_widget' => '<section id="salon" class="col-padtop wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;"><div class="container"><div class="row">',
  //   'after_widget'  => '</div></div></section>',
  //   'before_title'  => '',
  //   'after_title'   => '',
  // ));

  register_sidebar( array(
    'name'          => __( 'Homepage Introduction', 'nguyentungv1' ),
    'id'            => 'wg-homepage-introduction',
    'description'   => __( 'Add widgets here to appear in home page', 'nguyentungv1' ),
    'before_widget' => '',
    'after_widget'  => '',
    'before_title'  => '',
    'after_title'   => '',
  ));

  register_sidebar( array(
    'name'          => __( 'Homepage Market Content', 'nguyentungv1' ),
    'id'            => 'wg-homepage-market-content',
    'description'   => __( 'Add widgets here to appear in home page', 'nguyentungv1' ),
    'before_widget' => '',
    'after_widget'  => '',
    'before_title'  => '',
    'after_title'   => '',
  ));
}
add_action( 'widgets_init', 'nguyentungv1_widgets_init' );

class NT_Introduction_Widget extends WP_Widget {
 
  public function __construct() {
      $widget_ops = array('classname' => 'NT_Introduction_Widget', 'description' => 'Displays an Introduct Content!' );
      $this->WP_Widget('NT_Introduction_Widget', 'Nguyen Tung Introduction', $widget_ops);
  }
  
  function widget($args, $instance) {
    // PART 1: Extracting the arguments + getting the values
    extract($args, EXTR_SKIP);
    $text = empty($instance['text']) ? '' : $instance['text'];
   
    // Before widget code, if any
    echo (isset($before_widget)?$before_widget:'');

    if (!empty($text))
      echo "<p>". $text ."</p>";
   
    // After widget code, if any  
    echo (isset($after_widget)?$after_widget:'');
  }
 
  public function form( $instance ) {
   
     // PART 1: Extract the data from the instance variable
     $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
     $text = $instance['text'];   
   
     // PART 2-3: Display the fields
     ?>
   
     <!-- PART 3: Widget Text field START -->
     <p>
      <label for="<?php echo $this->get_field_id('text'); ?>">Text: 
        <textarea class="widefat" id="<?php echo $this->get_field_id('text'); ?>" 
               name="<?php echo $this->get_field_name('text'); ?>" rows="20" cols="50"><?php echo attribute_escape($text); ?></textarea>
      </label>
      </p>
      <!-- Widget Text field END -->
     <?php
   
  }
 
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['text'] = $new_instance['text'];
    return $instance;
  }
  
}

add_action( 'widgets_init', create_function('', 'return register_widget("NT_Introduction_Widget");') );

class NT_MartketContent_Widget extends WP_Widget {
 
  public function __construct() {
      $widget_ops = array('classname' => 'NT_MartketContent_Widget', 'description' => 'Displays an Market Content!' );
      $this->WP_Widget('NT_MartketContent_Widget', 'Nguyen Tung Market Content', $widget_ops);
  }
  
  function widget($args, $instance) {
    // PART 1: Extracting the arguments + getting the values
    extract($args, EXTR_SKIP);
    $title = empty($instance['title']) ? '' : $instance['title'];
    $text = empty($instance['text']) ? '' : $instance['text'];
   
    // Before widget code, if any
    echo (isset($before_widget)?$before_widget:'');

    if (!empty($title))
      echo "<h2>". $title ."</h2>";

    if (!empty($text))
      echo "<p>". $text ."</p>";
   
    // After widget code, if any  
    echo (isset($after_widget)?$after_widget:'');
  }
 
  public function form( $instance ) {
   
     // PART 1: Extract the data from the instance variable
     $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
     $title = $instance['title'];   
     $text = $instance['text'];   
   
     // PART 2-3: Display the fields
     ?>
   
     <!-- PART 3: Widget Text field START -->
     <p>
      <label for="<?php echo $this->get_field_id('title'); ?>">Title: 
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo attribute_escape($title); ?>"> 
      </label>
      </p>
     <p>
      <label for="<?php echo $this->get_field_id('text'); ?>">Text: 
        <textarea class="widefat" id="<?php echo $this->get_field_id('text'); ?>" 
               name="<?php echo $this->get_field_name('text'); ?>" rows="20" cols="50"><?php echo attribute_escape($text); ?></textarea>
      </label>
      </p>
      <!-- Widget Text field END -->
     <?php
   
  }
 
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['text'] = $new_instance['text'];
    return $instance;
  }
  
}

add_action( 'widgets_init', create_function('', 'return register_widget("NT_MartketContent_Widget");') );


class NT_Homepage_Images_Widget extends WP_Widget {
 
  function __construct() {
 
     // Add Widget scripts
     add_action('admin_enqueue_scripts', array($this, 'scripts'));
     $widget_ops = array('classname' => 'NT_Homepage_Images_Widget', 'description' => 'NT Widget with media files' );
      $this->WP_Widget('NT_Homepage_Images_Widget', 'NT Overview Images', $widget_ops);
  }
  
  public function widget( $args, $instance ) {
   $image_left = ! empty( $instance['image_left'] ) ? $instance['image_left'] : '';
   $image_tright = ! empty( $instance['image_tright'] ) ? $instance['image_tright'] : '';
   $image_bright = ! empty( $instance['image_bright'] ) ? $instance['image_bright'] : '';
 
   ob_start();
   echo $args['before_widget'];
   ?>
            
    <div class="col-sm-6 col-md-6 col-lg-6 col-padright-none wow fadeInLeft" style="visibility: visible; animation-name: fadeInLeft;">
      <?php if($image_left): ?>
        <img src="<?php echo resizeImage(esc_url($image_left), 580, 494); ?>" alt="">
      <?php else: ?>
        <img src="<?php echo dummyImage(580, 494); ?>" alt="">
      <?php endif; ?>
    </div>
   
    <div class="col-sm-6 col-md-6 col-lg-6 col-padleft-none wow fadeInRight" style="visibility: visible; animation-name: fadeInRight;">
      <?php if($image_tright): ?>
        <img src="<?php echo resizeImage(esc_url($image_tright), 580, 247); ?>" alt="">
      <?php else: ?>
        <img src="<?php echo dummyImage(580, 247); ?>" alt="">
      <?php endif; ?>
    </div>
    
    <div class="col-sm-6 col-md-6 col-lg-6 col-padleft-none wow fadeInRight" style="visibility: visible; animation-name: fadeInRight;">
      <?php if($image_bright): ?>
        <img src="<?php echo resizeImage(esc_url($image_bright), 580, 247); ?>" alt="">
      <?php else: ?>
        <img src="<?php echo dummyImage(580, 247); ?>" alt="">
      <?php endif; ?>
    </div>
 
   <?php
   echo $args['after_widget'];
   ob_end_flush();
  }
 
  public function form( $instance ) {
      $image_left = ! empty( $instance['image_left'] ) ? $instance['image_left'] : '';
      $image_tright = ! empty( $instance['image_tright'] ) ? $instance['image_tright'] : '';
      $image_bright = ! empty( $instance['image_bright'] ) ? $instance['image_bright'] : '';
     ?>
      <p>
        <label for="<?php echo $this->get_field_id( 'image_left' ); ?>"><?php _e( 'Image Left:' ); ?></label>
        <img id="preview-image-left" src="<?php echo $image_left !== "" ? esc_url($image_left) : dummyImage(300, 200) ?>" width=300>
        <input class="widefat" id="<?php echo $this->get_field_id('image_left'); ?>" name="<?php echo $this->get_field_name('image_left'); ?>" type="hidden" value="<?php echo esc_url($image_left); ?>" />
        <button type="button" class="browser button button-hero upload_image_button" style="display: inline-block; position: relative; z-index: 1; width: 100%;">Select Image Left</button>
      </p>
      <p>
        <label for="<?php echo $this->get_field_id( 'image_tright' ); ?>"><?php _e( 'Image Top Right:' ); ?></label>
        <img id="preview-image-tright" src="<?php echo $image_tright !== "" ? esc_url($image_tright) : dummyImage(300, 200) ?>" width=300>
        <input class="widefat" id="<?php echo $this->get_field_id('image_tright'); ?>" name="<?php echo $this->get_field_name('image_tright'); ?>" type="hidden" value="<?php echo esc_url($image_tright); ?>" />
        <button type="button" class="browser button button-hero upload_image_button" style="display: inline-block; position: relative; z-index: 1; width: 100%;">Select Image Top Right</button>
      </p>
      <p>
        <label for="<?php echo $this->get_field_id( 'image_bright' ); ?>"><?php _e( 'Image Bottom Right:' ); ?></label>
        <img id="preview-image-bright" src="<?php echo $image_bright !== "" ? esc_url($image_bright) : dummyImage(300, 200) ?>" width=300>
        <input class="widefat" id="<?php echo $this->get_field_id('image_bright'); ?>" name="<?php echo $this->get_field_name('image_bright'); ?>" type="hidden" value="<?php echo esc_url($image_bright); ?>" />
        <button type="button" class="browser button button-hero upload_image_button" style="display: inline-block; position: relative; z-index: 1; width: 100%;">Select Image Bottom Right</button>
      </p>
     <?php
  }
 
  public function update( $new_instance, $old_instance ) {
     $instance = array();
     $instance['image_left'] = ( ! empty( $new_instance['image_left'] ) ) ? $new_instance['image_left'] : '';
     $instance['image_tright'] = ( ! empty( $new_instance['image_tright'] ) ) ? $new_instance['image_tright'] : '';
     $instance['image_bright'] = ( ! empty( $new_instance['image_bright'] ) ) ? $new_instance['image_bright'] : '';
     return $instance;
  }
  
  public function scripts()
  {
     wp_enqueue_script( 'media-upload' );
     wp_enqueue_media();
     wp_enqueue_script('our_admin', get_template_directory_uri() . '/assets/js/our_admin.js', array('jquery'));
  }
}

add_action( 'widgets_init', create_function('', 'return register_widget("NT_Homepage_Images_Widget");') );


//canonical - old domain to new domain
add_filter('wpseo_canonical', 'swpseo_canonical_domain_replace');
function swpseo_canonical_domain_replace($url){
    $domain = 'hairsalonnguyentung.com';
    $parsed = parse_url(home_url());
    $current_site_domain = $parsed['host'];
    return str_replace($current_site_domain, $domain, $url);
}
