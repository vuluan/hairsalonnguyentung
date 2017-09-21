<?php
/**
Plugin Name: Hair Salon Nguyen Tung
Plugin URI: http://nguyenvuluan.info/
Description: This is a plugin made for hair salon nguyen tung
Version: 1.0
Author: Luan Nguyen
Author URI: http://nguyenvuluan.info/
*/


// REMOVE POST FROM ADMIN MENU
function nvl_change_post_object() {
    global $wp_post_types;
    $wp_post_types['post']->show_in_menu = false;
}

add_action( 'init', 'nvl_change_post_object' );
// REMOVE POST FROM ADMIN MENU

// ------------------- BANNERS --------------------
function nvl_custom_post_type_banners() {
    $labels = array(
        'name'                => _x( 'Banners', 'Post Type General Name', 'hairsalonnguyentung' ),
        'singular_name'       => _x( 'Banner', 'Post Type Singular Name', 'hairsalonnguyentung' ),
        'menu_name'           => __( 'Banners', 'hairsalonnguyentung' ),
        'parent_item_colon'   => __( 'Parent Banner', 'hairsalonnguyentung' ),
        'all_items'           => __( 'All Banners', 'hairsalonnguyentung' ),
        'view_item'           => __( 'View Banner', 'hairsalonnguyentung' ),
        'add_new_item'        => __( 'Add New Banner', 'hairsalonnguyentung' ),
        'add_new'             => __( 'Add New', 'hairsalonnguyentung' ),
        'edit_item'           => __( 'Edit Banner', 'hairsalonnguyentung' ),
        'update_item'         => __( 'Update Banner', 'hairsalonnguyentung' ),
        'search_items'        => __( 'Search Banner', 'hairsalonnguyentung' ),
        'not_found'           => __( 'Not Found', 'hairsalonnguyentung' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'hairsalonnguyentung' ),
    );
    $args = array(
        'label'               => __( 'banners', 'hairsalonnguyentung' ),
        'description'         => __( 'Add title here', 'hairsalonnguyentung' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor'),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    register_post_type( 'banners', $args );
    flush_rewrite_rules();
}
add_action( 'init', 'nvl_custom_post_type_banners', 0);

// add field in list
function add_banner_image_columns($defaults) {
    return array(
        'cb' => '<input type="checkbox" />',
        'banner_image' => __('Banner Image'),
        'title' => __('Title'),
        'show' => __('Show'),
        'date' => __('Date'),
        'author' => __('Author'),
    );
}
add_filter('manage_banners_posts_columns' , 'add_banner_image_columns');

function banner_custom_columns( $column, $post_id ) {
    switch ( $column ) {
        case 'banner_image' :
            $attachment_id = get_field('banner_image', $post_id);
            if ($attachment_id) {
                $image = wp_get_attachment_image( $attachment_id, "thumbnail" );
                echo $image;
            } else {
                echo '<img src="http://placehold.it/150x150">';
            }
            break;
        case 'show' :
            $banner_show = get_field('banner_show', $post_id);
            echo $banner_show ? "Yes" : "No";
            break;
    }
}
add_action('manage_banners_posts_custom_column' , 'banner_custom_columns', 10, 2 );
// add field in list
// ------------------- BANNERS --------------------

// ------------------- NEWS --------------------
function nvl_custom_post_type_news() {
    $labels = array(
        'name'                => _x( 'News', 'Post Type General Name', 'hairsalonnguyentung' ),
        'singular_name'       => _x( 'News', 'Post Type Singular Name', 'hairsalonnguyentung' ),
        'menu_name'           => __( 'News', 'hairsalonnguyentung' ),
        'parent_item_colon'   => __( 'Parent News', 'hairsalonnguyentung' ),
        'all_items'           => __( 'All News', 'hairsalonnguyentung' ),
        'view_item'           => __( 'View News', 'hairsalonnguyentung' ),
        'add_new_item'        => __( 'Add New News', 'hairsalonnguyentung' ),
        'add_new'             => __( 'Add New', 'hairsalonnguyentung' ),
        'edit_item'           => __( 'Edit News', 'hairsalonnguyentung' ),
        'update_item'         => __( 'Update News', 'hairsalonnguyentung' ),
        'search_items'        => __( 'Search News', 'hairsalonnguyentung' ),
        'not_found'           => __( 'Not Found', 'hairsalonnguyentung' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'hairsalonnguyentung' ),
    );
    $args = array(
        'label'               => __( 'News', 'hairsalonnguyentung' ),
        'description'         => __( 'Add title here', 'hairsalonnguyentung' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor'),
        'rewrite'             => array( 'slug' => 'tin-tuc' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    register_post_type( 'news', $args );
    flush_rewrite_rules();
}
add_action( 'init', 'nvl_custom_post_type_news', 0);
// add field in list
function add_news_columns($defaults) {
    return array(
        'cb' => '<input type="checkbox" />',
        'news_image' => __('News Image'),
        'title' => __('Title'),
        'news_show' => __('Show'),
        'news_highlight' => __('Highlight'),
        'date' => __('Date'),
        'author' => __('Author'),
    );
}
add_filter('manage_news_posts_columns' , 'add_news_columns');
function news_custom_columns( $column, $post_id ) {
    switch ( $column ) {
        case 'news_image' :
            $attachment_id = get_field('news_image', $post_id);
            if ($attachment_id) {
                $image = wp_get_attachment_image( $attachment_id, "thumbnail" );
                echo $image;
            } else {
                echo '<img src="http://placehold.it/150x150">';
            }
            break;
        case 'news_show' :
            $news_show = get_field('news_show', $post_id);
            if ($news_show) {
                echo "Yes";
            } else {
                echo "No";
            }
            break;
        case 'news_highlight' :
            $news_highlight = get_field('news_highlight', $post_id);
            if ($news_highlight) {
                echo "Yes";
            } else {
                echo "No";
            }
            break;
    }
}
add_action('manage_news_posts_custom_column' , 'news_custom_columns', 10, 2 );
// add field in list
// ------------------- NEWS --------------------


// ------------------- SERVICES --------------------
function nvl_custom_post_type_service() {
    $labels = array(
        'name'                => _x( 'Services', 'Post Type General Name', 'hairsalonnguyentung' ),
        'singular_name'       => _x( 'Service', 'Post Type Singular Name', 'hairsalonnguyentung' ),
        'menu_name'           => __( 'Services', 'hairsalonnguyentung' ),
        'parent_item_colon'   => __( 'Parent Service', 'hairsalonnguyentung' ),
        'all_items'           => __( 'All Services', 'hairsalonnguyentung' ),
        'view_item'           => __( 'View Service', 'hairsalonnguyentung' ),
        'add_new_item'        => __( 'Add New Service', 'hairsalonnguyentung' ),
        'add_new'             => __( 'Add New', 'hairsalonnguyentung' ),
        'edit_item'           => __( 'Edit Service', 'hairsalonnguyentung' ),
        'update_item'         => __( 'Update Service', 'hairsalonnguyentung' ),
        'search_items'        => __( 'Search Service', 'hairsalonnguyentung' ),
        'not_found'           => __( 'Not Found', 'hairsalonnguyentung' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'hairsalonnguyentung' ),
    );
    $args = array(
        'label'               => __( 'Services', 'hairsalonnguyentung' ),
        'description'         => __( 'Add title here', 'hairsalonnguyentung' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor'),
        'rewrite'             => array( 'slug' => 'dich-vu' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    register_post_type( 'services', $args );
    flush_rewrite_rules();
}
add_action( 'init', 'nvl_custom_post_type_service', 0);
// add field in list
function add_service_columns($defaults) {
    return array(
        'cb' => '<input type="checkbox" />',
        'service_image' => __('Service Image'),
        'title' => __('Title'),
        'service_show' => __('Show'),
        'date' => __('Date'),
        'author' => __('Author'),
    );
}
add_filter('manage_services_posts_columns' , 'add_service_columns');
function service_custom_columns( $column, $post_id ) {
    switch ( $column ) {
        case 'service_image' :
            $attachment_id = get_field('service_image', $post_id);
            if ($attachment_id) {
                $image = wp_get_attachment_image( $attachment_id, "thumbnail" );
                echo $image;
            } else {
                echo '<img src="http://placehold.it/150x150">';
            }
            break;
        case 'service_show' :
            $service_show = get_field('service_show', $post_id);
            if ($service_show) {
                echo "Yes";
            } else {
                echo "No";
            }
            break;
    }
}
add_action('manage_services_posts_custom_column' , 'service_custom_columns', 10, 2 );
// add field in list
// ------------------- SERVICES --------------------

// ------------------- COLLECTION --------------------
function nvl_custom_post_type_collection() {
    $labels = array(
        'name'                => _x( 'Collections', 'Post Type General Name', 'hairsalonnguyentung' ),
        'singular_name'       => _x( 'Collection', 'Post Type Singular Name', 'hairsalonnguyentung' ),
        'menu_name'           => __( 'Collections', 'hairsalonnguyentung' ),
        'parent_item_colon'   => __( 'Parent Collection', 'hairsalonnguyentung' ),
        'all_items'           => __( 'All Collections', 'hairsalonnguyentung' ),
        'view_item'           => __( 'View Collection', 'hairsalonnguyentung' ),
        'add_new_item'        => __( 'Add New Collection', 'hairsalonnguyentung' ),
        'add_new'             => __( 'Add New', 'hairsalonnguyentung' ),
        'edit_item'           => __( 'Edit Collection', 'hairsalonnguyentung' ),
        'update_item'         => __( 'Update Collection', 'hairsalonnguyentung' ),
        'search_items'        => __( 'Search Collection', 'hairsalonnguyentung' ),
        'not_found'           => __( 'Not Found', 'hairsalonnguyentung' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'hairsalonnguyentung' ),
    );
    $args = array(
        'label'               => __( 'Collections', 'hairsalonnguyentung' ),
        'description'         => __( 'Add title here', 'hairsalonnguyentung' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor'),
        'rewrite'             => array( 'slug' => 'bo-suu-tap' ),
        // You can associate this CPT with a taxonomy or custom taxonomy.
        // 'taxonomies'  => array( 'category' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    register_post_type( 'collections', $args );
    flush_rewrite_rules();
}
add_action( 'init', 'nvl_custom_post_type_collection', 0);
// add field in list
function add_collection_columns($defaults) {
    return array(
        'cb' => '<input type="checkbox" />',
        'collection_image' => __('Collection Image'),
        'title' => __('Title'),
        'collection_show' => __('Show'),
        'date' => __('Date'),
        'author' => __('Author'),
    );
}
add_filter('manage_collections_posts_columns' , 'add_collection_columns');
function collection_custom_columns( $column, $post_id ) {
    switch ( $column ) {
        case 'collection_image' :
            $attachment_id = get_field('collection_image', $post_id);
            if ($attachment_id) {
                $image = wp_get_attachment_image( $attachment_id, "thumbnail" );
                echo $image;
            } else {
                echo '<img src="http://placehold.it/150x150">';
            }
            break;
        case 'collection_show' :
            $collection_show = get_field('collection_show', $post_id);
            if ($collection_show) {
                echo "Yes";
            } else {
                echo "No";
            }
            break;
    }
}
add_action('manage_collections_posts_custom_column' , 'collection_custom_columns', 10, 2 );
// add field in list

//hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_collectiontype_hierarchical_taxonomy', 0 );

//create a custom taxonomy name it topics for your posts

function create_collectiontype_hierarchical_taxonomy() {

// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI

    $labels = array(
        'name' => _x( 'Collections Type', 'taxonomy general name' ),
        'singular_name' => _x( 'Collections Type', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Collections Type' ),
        'all_items' => __( 'All Collections Type' ),
        'parent_item' => __( 'Parent Collections Type' ),
        'parent_item_colon' => __( 'Parent Collections Type:' ),
        'edit_item' => __( 'Edit Collections Type' ),
        'update_item' => __( 'Update Collections Type' ),
        'add_new_item' => __( 'Add New Collections Type' ),
        'new_item_name' => __( 'New Topic Name' ),
        'menu_name' => __( 'Collections Type' ),
    );

// Now register the taxonomy

    register_taxonomy('collectiontype', array('collections'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'bo-suu-tap-toc' ),
    ));

}


// ------------------- COLLECTION --------------------

// ------------------- COSMETIC --------------------
function nvl_custom_post_type_cosmetic() {
    $labels = array(
        'name'                => _x( 'Cosmetics', 'Post Type General Name', 'hairsalonnguyentung' ),
        'singular_name'       => _x( 'Cosmetic', 'Post Type Singular Name', 'hairsalonnguyentung' ),
        'menu_name'           => __( 'Cosmetics', 'hairsalonnguyentung' ),
        'parent_item_colon'   => __( 'Parent Cosmetic', 'hairsalonnguyentung' ),
        'all_items'           => __( 'All Cosmetics', 'hairsalonnguyentung' ),
        'view_item'           => __( 'View Cosmetic', 'hairsalonnguyentung' ),
        'add_new_item'        => __( 'Add New Cosmetic', 'hairsalonnguyentung' ),
        'add_new'             => __( 'Add New', 'hairsalonnguyentung' ),
        'edit_item'           => __( 'Edit Cosmetic', 'hairsalonnguyentung' ),
        'update_item'         => __( 'Update Cosmetic', 'hairsalonnguyentung' ),
        'search_items'        => __( 'Search Cosmetic', 'hairsalonnguyentung' ),
        'not_found'           => __( 'Not Found', 'hairsalonnguyentung' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'hairsalonnguyentung' ),
    );
    $args = array(
        'label'               => __( 'Cosmetics', 'hairsalonnguyentung' ),
        'description'         => __( 'Add title here', 'hairsalonnguyentung' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor'),
        'rewrite'             => array( 'slug' => 'my-pham' ),
        // You can associate this CPT with a taxonomy or custom taxonomy.
        'taxonomies'  => array( 'cosmetictype' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    register_post_type( 'cosmetics', $args );
    flush_rewrite_rules();
}
add_action( 'init', 'nvl_custom_post_type_cosmetic', 0);
// add field in list
function add_cosmetic_columns($defaults) {
    return array(
        'cb' => '<input type="checkbox" />',
        'cosmetic_image' => __('Image'),
        'title' => __('Title'),
        'cosmetic_show' => __('Show'),
        'date' => __('Date'),
        'author' => __('Author'),
    );
}
add_filter('manage_cosmetics_posts_columns' , 'add_cosmetic_columns');
function cosmetic_custom_columns( $column, $post_id ) {
    switch ( $column ) {
        case 'cosmetic_image' :
            $attachment_id = get_field('cosmetic_image', $post_id);
            if ($attachment_id) {
                $image = wp_get_attachment_image( $attachment_id, "thumbnail" );
                echo $image;
            } else {
                echo '<img src="http://placehold.it/150x150">';
            }
            break;
        case 'cosmetic_show' :
            $cosmetic_show = get_field('cosmetic_show', $post_id);
            if ($cosmetic_show) {
                echo "Yes";
            } else {
                echo "No";
            }
            break;
    }
}
add_action('manage_cosmetics_posts_custom_column' , 'cosmetic_custom_columns', 10, 2 );
// add field in list


//hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_cosmetictype_hierarchical_taxonomy', 0 );

//create a custom taxonomy name it topics for your posts

function create_cosmetictype_hierarchical_taxonomy() {

// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI

    $labels = array(
        'name' => _x( 'Cosmetic Type', 'taxonomy general name' ),
        'singular_name' => _x( 'Cosmetic Type', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Cosmetic Type' ),
        'all_items' => __( 'All Cosmetic Type' ),
        'parent_item' => __( 'Parent Cosmetic Type' ),
        'parent_item_colon' => __( 'Parent Cosmetic Type:' ),
        'edit_item' => __( 'Edit Cosmetic Type' ),
        'update_item' => __( 'Update Cosmetic Type' ),
        'add_new_item' => __( 'Add New Cosmetic Type' ),
        'new_item_name' => __( 'New Topic Name' ),
        'menu_name' => __( 'Cosmetic Type' ),
    );

// Now register the taxonomy

    register_taxonomy('cosmetictype',array('cosmetics'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'cac-loai-my-pham' ),
    ));

}

// ------------------- COSMETIC --------------------

// ------------------- COURSES --------------------
function nvl_custom_post_type_courses() {
    $labels = array(
        'name'                => _x( 'Courses', 'Post Type General Name', 'hairsalonnguyentung' ),
        'singular_name'       => _x( 'Course', 'Post Type Singular Name', 'hairsalonnguyentung' ),
        'menu_name'           => __( 'Course', 'hairsalonnguyentung' ),
        'parent_item_colon'   => __( 'Parent Course', 'hairsalonnguyentung' ),
        'all_items'           => __( 'All Courses', 'hairsalonnguyentung' ),
        'view_item'           => __( 'View Course', 'hairsalonnguyentung' ),
        'add_new_item'        => __( 'Add New Course', 'hairsalonnguyentung' ),
        'add_new'             => __( 'Add New', 'hairsalonnguyentung' ),
        'edit_item'           => __( 'Edit Course', 'hairsalonnguyentung' ),
        'update_item'         => __( 'Update Course', 'hairsalonnguyentung' ),
        'search_items'        => __( 'Search Course', 'hairsalonnguyentung' ),
        'not_found'           => __( 'Not Found', 'hairsalonnguyentung' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'hairsalonnguyentung' ),
    );
    $args = array(
        'label'               => __( 'Courses', 'hairsalonnguyentung' ),
        'description'         => __( 'Add title here', 'hairsalonnguyentung' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt'),
        'rewrite'             => array( 'slug' => 'khoa-hoc' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 3,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    register_post_type( 'courses', $args );
    flush_rewrite_rules();
}
add_action( 'init', 'nvl_custom_post_type_courses', 0);
// add field in list
function add_courses_columns($defaults) {
    return array(
        'cb' => '<input type="checkbox" />',
        'course_image' => __('Image'),
        'title' => __('Title'),
        'course_show' => __('Show'),
        'date' => __('Date'),
        'author' => __('Author'),
    );
}
add_filter('manage_courses_posts_columns' , 'add_courses_columns');
function course_custom_columns( $column, $post_id ) {
    switch ( $column ) {
        case 'course_image' :
            $attachment_id = get_field('course_image', $post_id);
            if ($attachment_id) {
                $image = wp_get_attachment_image( $attachment_id, "thumbnail" );
                echo $image;
            } else {
                echo '<img src="http://placehold.it/150x150">';
            }
            break;
        case 'course_show' :
            $news_show = get_field('course_show', $post_id);
            if ($news_show) {
                echo "Yes";
            } else {
                echo "No";
            }
            break;
    }
}
add_action('manage_courses_posts_custom_column' , 'course_custom_columns', 10, 2 );
// add field in list
// ------------------- NEWS --------------------