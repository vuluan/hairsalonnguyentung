<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hair Salon Nguyễn Tùng - 190 Trần Quốc Thảo, Phường 7, Quận 3, TP Hồ Chí Minh</title>
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.ico" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/css/master.css">
    <!--[if lt IE 9]>
    <script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <?php wp_head(); ?>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-105760029-1', 'auto');
        ga('send', 'pageview');
    </script>
</head>
<body>
<div id="overlay"></div>
<?php 
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $url_news = site_url( '/tin-tuc', 'http' );
    $url_intro = site_url( '/gioi-thieu', 'http' );
    $url_collection = site_url( '/bo-suu-tap', 'http' );
    $url_service = site_url( '/dich-vu', 'http' );
    $url_cosmetic = site_url( '/my-pham', 'http' );
    $url_course = site_url( '/khoa-hoc', 'http' );
    $url_contact = site_url( '/lien-he', 'http' );
    $check_homepage = is_home() ? "active" : "";
    $check_news = strpos($actual_link, $url_news) !== false ? "active" : "";
    $check_intro = strpos($actual_link, $url_intro) !== false ? "active" : "";
    $check_collection = strpos($actual_link, $url_collection) !== false ? "active" : "";
    $check_service = strpos($actual_link, $url_service) !== false ? "active" : "";
    $check_cosmetic = strpos($actual_link, $url_cosmetic) !== false ? "active" : "";
    $check_course = strpos($actual_link, $url_course) !== false ? "active" : "";
    $check_contact = strpos($actual_link, $url_contact) !== false ? "active" : "";
?>
<div id="mobile-menu">
    <ul>
        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="<?php echo $check_homepage; ?>">Trang Chủ</a></li>
        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>tin-tuc" class="<?php echo $check_news; ?>">Tin Tức</a></li>
        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>gioi-thieu" class="<?php echo $check_intro; ?>">Giới Thiệu</a></li>
        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>bo-suu-tap" class="<?php echo $check_collection; ?>">Bộ Sưu tập</a></li>
        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>dich-vu" class="<?php echo $check_service; ?>">Bảng Giá Dịch Vụ</a></li>
        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>my-pham" class="<?php echo $check_cosmetic; ?>">Mỹ Phẩm</a></li>
        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>khoa-hoc" class="<?php echo $check_course; ?>">Khoá Học</a></li>
        <!-- <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>lien-he" class="<?php echo $check_contact; ?>">Liên Hệ</a></li> -->
    </ul>
</div>
<div id="page">
    <header id="pagetop">
        <nav <?php echo is_user_logged_in() ? "style='top: 32px;'" : ""; ?> >
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="logo page-scroll">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <?php echo get_bloginfo('name'); ?>
                        </a>
                        </div>
                        <div class="mm-toggle-wrap">
                            <div class="mm-toggle"> <i class="icon-menu"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/menu-icon.png" alt="Menu"></i></div>
                        </div>
                        <ul class="menu">
                            <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="<?php echo $check_homepage; ?>">Trang Chủ</a></li>
                            <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>tin-tuc" class="<?php echo $check_news; ?>">Tin Tức</a></li>
                            <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>gioi-thieu" class="<?php echo $check_intro; ?>">Giới Thiệu</a></li>
                            <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>bo-suu-tap" class="<?php echo $check_collection; ?>">Bộ Sưu tập</a></li>
                            <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>dich-vu" class="<?php echo $check_service; ?>">Bảng Giá Dịch Vụ</a></li>
                            <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>my-pham" class="<?php echo $check_cosmetic; ?>">Mỹ Phẩm</a></li>
                            <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>khoa-hoc" class="<?php echo $check_course; ?>">Khoá Học</a></li>
                            <!-- <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>lien-he" class="<?php echo $check_contact; ?>">Liên Hệ</a></li> -->
                        </ul>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </nav>
    </header>