<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Stokla.net | Stock İçeriğin Tek Adresi | Uygun Fiyatlı Premium İçerikler</title>

    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">

    <!--Color Switcher Mockup-->
    <link href="{{asset('lan/css/color-switcher-design.css')}}" rel="stylesheet">
    <!-- Color Themes -->
    <link id="theme-color-file" href="{{asset('lan/css/color-themes/default-color.css')}}" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="https://www.stokla.net/v4Assets/images/neptune.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="https://www.stokla.net/v4Assets/images/neptune.png" />
    <!-- Responsive -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <!-- Stylesheets -->
    <link href="{{asset('lan/css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('lan/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('lan/css/responsive.css')}}" rel="stylesheet">

    <style>
        a{
            color:white!important;
        }
    </style>

</head>

<body class="body-bg-color">

<div class="page-wrapper">

    <!-- Preloader -->
    <div class="preloader"></div>
    <!-- End Preloader -->

    <!-- Cursor -->
    <div class="cursor"></div>
    <div class="cursor-follower"></div>
    <!-- Cursor End -->




    <!-- Main Header -->
    <header class="main-header main-header-one">

        <!-- Header Lower -->
        <div class="header-lower">

            <div class="main-menu__wrapper">
                <div class="inner-container d-flex align-items-center justify-content-between">

                    <!-- Logo Box -->
                    <div class="main-header-one__logo-box">
                        <a href="/"><img src="https://www.stokla.net/assets/img/Logo-Site.png" alt=""></a>
                    </div>

                    <div class="nav-outer">

                        <!-- Main Menu -->
                        <nav class="main-menu show navbar-expand-md">
                            <div class="navbar-header">
                                <button class="navbar-toggler" type="button" data-toggle="collapse"
                                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                        aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>

                            <div class="navbar-collapse collapse clearfix" id="navbarSupportedContent">

                            </div>

                        </nav>
                        <!-- Main Menu End-->

                    </div>

                    <!-- Outer Box -->
                    <div class="outer-box d-flex align-items-center">

                        <ul class="main-header__login-sing-up">
                            <li><a href="/login">Giriş</a></li>
                            <li><a href="/register">Kayıt</a></li>
                        </ul>



                    </div>
                    <!-- End Outer Box -->

                </div>

            </div>
        </div>
        <!-- End Header Lower -->

        <!-- Mobile Menu  -->
        <div class="mobile-menu">
            <div class="menu-backdrop"></div>
            <div class="close-btn"><span class="icon far fa-times fa-fw"></span></div>
            <nav class="menu-box">
                <div class="nav-logo"><a href="/"><img src="https://www.stokla.net/assets/img/Logo-Site.png" alt="" title=""></a></div>
                <!-- Search -->
                <div class="search-box">
                    <form method="post" action="/login">
                        <div class="form-group">
                            <input type="search" name="search-field" value="" placeholder="SEARCH HERE" required>
                            <button type="submit"><span class="icon far fa-search fa-fw"></span></button>
                        </div>
                    </form>
                </div>
                <div class="menu-outer">
                    <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                </div>
            </nav>
        </div>
        <!-- End Mobile Menu -->
    </header>
    <!-- End Main Header -->


    <!-- Feature One Start -->
    <section class="feature-one">
        <div class="container">
            <div class="feature-one__inner">
                <h2 class="feature-one__title">Lisanslı ve anında stock içerikler indirmenin <br>
                    En kolay ve hızlı yolu <span>Stokla.net</span> </h2>
                <div class="feature-one__btn-box">
                    <a href="/login" class="thm-btn feature-one__btn"> <i class="fal fa-check"></i> Hemen Deneyimle</a>
                </div>
                <div class="feature-one__main-content-box">
                    <div class="feature-one__color-overly-1 flaot-bob-y"></div>
                    <div class="feature-one__color-overly-2 flaot-bob-x"></div>
                    <div class="feature-one__color-overly-3 img-bounce"></div>
                    <div class="feature-one__main-content-top">
                        <ul class="feature-one__list">
                            <li>
                                <div class="feature-one__single">
                                    <div class="feature-one__icon">
                                        <img src="{{asset('lan/images/icons/ai-content-writing.png')}}" alt="">
                                    </div>
                                    <h5 class="feature-one__title-2"><a >Makaleleriniz için</a></h5>
                                </div>
                            </li>
                            <li>
                                <div class="feature-one__single">
                                    <div class="feature-one__icon">
                                        <img src="{{asset('lan/images/icons/ai-image.png')}}" alt="">
                                    </div>
                                    <h5 class="feature-one__title-2"><a >İçerikleriniz İçin</a></h5>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="feature-one__main-content-middle">
                        <div class="feature-one__start-1 zoominout">
                            <img src="{{asset('lan/images/shapes/feature-one-star-1.png')}}" alt="">
                        </div>
                        <div class="feature-one__start-2 float-bob-x">
                            <img src="{{asset('lan/images/shapes/feature-one-star-2.png')}}" alt="">
                        </div>
                        <div class="feature-one__start-3 float-bob-y">
                            <img src="{{asset('lan/images/shapes/feature-one-star-3.png')}}" alt="">
                        </div>

                        <div class="feature-one__start-5 zoominout">
                            <img src="{{asset('lan/images/shapes/feature-one-star-5.png')}}" alt="">
                        </div>
                        <div class="feature-one__start-6 float-bob-x">
                            <img src="{{asset('lan/images/shapes/feature-one-star-6.png')}}" alt="">
                        </div>
                        <div class="feature-one__start-7 float-bob-y">
                            <img src="{{asset('lan/images/shapes/feature-one-star-7.png')}}" alt="">
                        </div>

                        <div class="feature-one__ai-pack">
                            <h3>Stokla.net</h3>
                        </div>
                        <ul class="feature-one__list">
                            <li>
                                <div class="feature-one__single">
                                    <div class="feature-one__icon">
                                        <img src="{{asset('lan/images/icons/ai-code.png')}}" alt="">
                                    </div>
                                    <h5 class="feature-one__title-2"><a >Yazılımlarınız için</a>
                                    </h5>
                                </div>
                            </li>
                            <li>
                                <div class="feature-one__cpu-icon-box">
                                    <img src="https://www.stokla.net/v4Assets/images/neptune.png" alt="">
                                </div>
                            </li>
                            <li>
                                <div class="feature-one__single">
                                    <div class="feature-one__icon">
                                        <img src="{{asset('lan/images/icons/ai-chat.png')}}" alt="">
                                    </div>
                                    <h5 class="feature-one__title-2"><a >Botlarınız İçin</a></h5>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="feature-one__main-content-bottom">
                        <div class="feature-one__start-4 zoominout">
                            <img src="{{asset('lan/images/shapes/feature-one-star-4.png')}}" alt="">
                        </div>
                        <div class="feature-one__start-8 float-bob-x">
                            <img src="{{asset('lan/images/shapes/feature-one-star-8.png')}}" alt="">
                        </div>
                        <ul class="feature-one__list">
                            <li>
                                <div class="feature-one__single">
                                    <div class="feature-one__icon">
                                        <img src="{{asset('lan/images/icons/ai-audio.png')}}" alt="">
                                    </div>
                                    <h5 class="feature-one__title-2"><a >Reklamlarınız için</a>
                                    </h5>
                                </div>
                            </li>
                            <li>
                                <div class="feature-one__single">
                                    <div class="feature-one__icon">
                                        <img src="{{asset('lan/images/icons/ai-speech.png')}}" alt="">
                                    </div>
                                    <h5 class="feature-one__title-2"><a >Tüm Çalışmalarınız için</a>
                                    </h5>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="feature-one__rating-box">
                    <ul class="feature-one__rating">
                        <li>
                            <div class="feature-one__rating-icon">
                                <img src="{{asset('lan/images/icons/rateing.png')}}" alt="">
                            </div>
                            <div class="feature-one__rating-star-and-text">
                                <div class="feature-one__rating-star">
                                    <span class="icon-star"></span>
                                    <span class="icon-star"></span>
                                    <span class="icon-star"></span>
                                    <span class="icon-star"></span>
                                    <span class="icon-star"></span>
                                </div>
                                <p class="feature-one__rating-text">Rated 4.8 . 1,000+ Reviews</p>
                            </div>
                        </li>
                        <li>
                            <div class="feature-one__rating-icon">
                                <img src="{{asset('lan/images/icons/send.png')}}" alt="">
                            </div>
                            <div class="feature-one__rating-star-and-text feature-one__rating-star-and-text--two">
                                <div class="feature-one__rating-star">
                                    <span class="icon-star"></span>
                                    <span class="icon-star"></span>
                                    <span class="icon-star"></span>
                                    <span class="icon-star"></span>
                                    <span class="icon-star"></span>
                                </div>
                                <p class="feature-one__rating-text">Rated 4.8 . 1,000+ Reviews</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- Feature One End -->

    <!-- Solutions One Start -->
    <section class="solutions-one">
        <div class="container">
            <div class="section-title text-center">
                <div class="section-title__tagline-box">
                    <span class="section-title__tagline">Tüm Platformlar İçin</span>
                </div>
                <h2 class="section-title__title">Tüm Çalışmalarınız İçin Stock Fotoğraf,Video veya Ses içerikleri</h2>
            </div>
            <div class="solutions-one__carousel owl-carousel owl-theme thm-owl__carousel" data-owl-options='{
					"loop": true,
					"autoplay": true,
					"margin": 24,
					"nav": false,
					"dots": false,
					"smartSpeed": 500,
					"autoplayTimeout": 10000,
					"navText": ["<span class=\"fa fa-angle-left\"></span>","<span class=\"fa fa-angle-right\"></span>"],
					"responsive": {
						"0": {
							"items": 1
						},
						"768": {
							"items": 2
						},
						"992": {
							"items": 3
						},
						"1350": {
							"items": 4
						}
					}
				}'>
                <div class="item">
                    <div class="solutions-one__single">
                        <div class="solutions-one__icon">
                            <img src="{{asset('lan/images/icons/ai-speech.png')}}" alt="">
                        </div>
                        <h4 class="solutions-one__title"><a >Tüm Çalışmalarınız için</a></h4>

                    </div>
                </div>
                <div class="item">
                    <div class="solutions-one__single">
                        <div class="solutions-one__icon">
                            <img src="{{asset('lan/images/icons/ai-content-writing.png')}}" alt="">
                        </div>
                        <h4 class="solutions-one__title"><a >Makaleleriniz için</a></h4>
                    </div>
                </div>
                <div class="item">
                    <div class="solutions-one__single">
                        <div class="solutions-one__icon">
                            <img src="{{asset('lan/images/icons/ai-chat.png')}}" alt="">
                        </div>
                        <h4 class="solutions-one__title"><a >Botlarınız İçin</a></h4>
                    </div>
                </div>
                <div class="item">
                    <div class="solutions-one__single">
                        <div class="solutions-one__icon">
                            <img src="{{asset('lan/images/icons/ai-image.png')}}" alt="">
                        </div>
                        <h4 class="solutions-one__title"><a >İçerikleriniz İçin</a></h4>
                    </div>
                </div>
                <div class="item">
                    <div class="solutions-one__single">
                        <div class="solutions-one__icon">
                            <img src="{{asset('lan/images/icons/ai-audio.png')}}" alt="">
                        </div>
                        <h4 class="solutions-one__title"><a >Tüm Çalışmalarınız için</a></h4>
                    </div>
                </div>
                <div class="item">
                    <div class="solutions-one__single">
                        <div class="solutions-one__icon">
                            <img src="{{asset('lan/images/icons/ai-code.png')}}" alt="">
                        </div>
                        <h4 class="solutions-one__title"><a >Yazılımlarınız için</a></h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Solutions One End -->


    <!-- Solutions Two Start -->
    <section class="solutions-two">
        <div class="container">
            <div class="section-title text-center">
                <div class="section-title__tagline-box">
                    <span class="section-title__tagline">Kullanımı Kolay</span>
                </div>
                <h2 class="section-title__title">Sistem kullanımı oldukça kolay sadece içerik adresini kopyala ve <span>Stokla.net</span> adresine yapıştır ve dosyanız anında indirilsin.</h2>
            </div>
            <div class="solutions-two__content-one wow fadeInUp" data-wow-delay="100ms">
                <div class="solutions-two__shape-1"
                     style="background-image: url({{asset('lan/images/shapes/solutions-two-shape-1.png')}});"></div>
                <div class="row">
                    <div class="col-xl-6 col-lg-6">
                        <div class="solutions-two__content-one-left">
                            <div class="solutions-two__shape-2 zoominout">
                                <img src="{{asset('lan/images/shapes/solutions-two-shape-2.png')}}" alt="">
                            </div>
                            <div class="solutions-two__content-one-title-box">
                                <p>Kolay Kullanım</p>
                                <h3>Sadece bağlantıyı kopyalayın ve stokla.net sistemine yapıştırın hepsi bu kadar.
                                </h3>
                            </div>
                            <p class="solutions-two__content-one-text-1">İndirme işleminiz saniyeler içinde başlamış olacaktır.</p>

                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="solutions-two__content-one-right">
                            <div class="solutions-two__content-one-img-box">
                                <div class="solutions-two__content-one-img">
                                    <img src="{{asset('lan/images/resource/solutions-two-content-one-img-1.jpg')}}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="solutions-two__content-two">
                <div class="row">
                    <!--Solutions Two Single Start-->
                    <div class="col-xl-6 col-lg-6 wow fadeInLeft" data-wow-delay="100ms">
                        <div class="solutions-two__content-two-single">
                            <div class="solutions-two__content-two-top">
                                <div class="solutions-two__content-two-title-box">
                                    <p>Envato Elements</p>
                                    <h3>Envato Elements indirmelerini tüm envato elements'i kapsayacak şekilde desteklemekteyiz üstelik bu işlemler sadece 1 saniye içinde yapılmaktadır.</h3>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--Solutions Two Single End-->
                    <!--Solutions Two Single Start-->
                    <div class="col-xl-6 col-lg-6 wow fadeInRight" data-wow-delay="100ms">
                        <div class="solutions-two__content-two-single solutions-two__content-two-single-2">
                            <div class="solutions-two__content-two-top">
                                <div class="solutions-two__content-two-title-box">
                                    <p>Freepik Premium İndirmeleri</p>
                                    <h3>Tüm Freepik indirmelerini sadece destekleyip bir kaç saniye içinde indirmekle kalmayıp üstüne birde video kalitesini seçme olanağı sağlamaktayız.</h3>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--Solutions Two Single End-->
                </div>
            </div>
            <div class="solutions-two__content-three wow fadeInUp" data-wow-delay="100ms">
                <div class="solutions-two__content-three-shape-1"
                     style="background-image: url({{asset('lan/images/shapes/solutions-two-content-three-shape-1.png')}});"></div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="solutions-two__content-three-right">
                            <div class="solutions-two__content-three-title-box">
                                <p>Tam Destek !</p>
                                <h3>Shutterstock 'da Vektör ve Fotoğraf indirmelerini destekliyoruz. 🌄</h3>
                            </div>
                            <p class="solutions-two__content-three-text-1">Shutterstock üzerindeki vektör ve fotoğraf haricinde video indirmek isterseniz bize sadece WhatsApp destek hattından yazmanız yeterlidir.</p>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Solutions Two End -->

    <!-- Brand One Start -->
    <section class="brand-one">
        <div class="container">
            <div class="brand-one__title-box">
                <div class="brand-one__shape-1 zoominout">
                    <img src="{{asset('lan/images/shapes/brand-one-shape-1.png')}}" alt="">
                </div>
                <div class="brand-one__shape-2 float-bob-x">
                    <img src="{{asset('lan/images/shapes/brand-one-shape-2.png')}}" alt="">
                </div>
                <div class="brand-one__title count-box">
                    <span class="count-text" data-stop="10.8" data-speed="1500">00</span><span>k+</span>
                    Kullanıcımız bizimle uygun fiyata içerik ihtiyacını karşılamaktadır.  Stokla.net 4.Yaşındadır !</div>
            </div>

        </div>
    </section>
    <!-- Brand One End -->


    <!-- Faq One Start -->
    <section class="faq-one">
        <div class="container">
            <div class="section-title text-center">
                <div class="section-title__tagline-box">
                    <span class="section-title__tagline">Bazı Soruların Cevapları</span>
                </div>
                <h2 class="section-title__title">Sıkça Sorulan Sorular <br>
                    ​​​​​​​Ve Cevapları</h2>
            </div>
            <div class="faq-one__inner">
                <div class="accrodion-grp" data-grp-name="faq-one-accrodion">
                    <div class="accrodion">
                        <div class="accrodion-title">
                            <h4>Freepik ve Envato Elements Dosyaları İçin Lisans İndirebilir miyim ?</h4>
                        </div>
                        <div class="accrodion-content">
                            <div class="inner">
                                <p>Freepik premium'da video ve ikon hariç tüm içeriklerde lisans dosyası indirmesi yapılabilir.<br>
                                    Envato elements içinse tüm dosyalar için lisans sağlanmaktadır.</p>
                            </div><!-- /.inner -->
                        </div>
                    </div>
                    <div class="accrodion ">
                        <div class="accrodion-title">
                            <h4>Envato Elements'de tüm içerik türlerini indirebilir miyim ?</h4>
                        </div>
                        <div class="accrodion-content">
                            <div class="inner">
                                <p>Evet, Envato Elements için tüm içerik türlerini saniyeler içinde indirebilirsiniz.</p>
                            </div><!-- /.inner -->
                        </div>
                    </div>
                    <div class="accrodion">
                        <div class="accrodion-title">
                            <h4>Freepik Premium'da hangi içerikleri indirebilirim ?</h4>
                        </div>
                        <div class="accrodion-content">
                            <div class="inner">
                                <p>3D içeriklerin(toplamda 10,20 tane vardır) indirilmesi desteklenmemektedir. Haricindeki video,ikon,vektör ve psd gibi tüm içerikleri indirebilirsiniz.</p>
                            </div><!-- /.inner -->
                        </div>
                    </div>
                    <div class="accrodion">
                        <div class="accrodion-title">
                            <h4>Shutterstock üzerinde hangi içerikleri indirebilirim ?</h4>
                        </div>
                        <div class="accrodion-content">
                            <div class="inner">
                                <p>Sistemde bulunan otomasyon üzerinden sadece vektör ve fotoğraf indirmelerini yapabilirsiniz ve bu içeriklerin standart lisans paketinde olması gerekmektedir.<br>
                                    Video indirmeleri içni lütfen whatsapp üzerinden iletişime geçiniz.</p>
                            </div><!-- /.inner -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- Faq One End -->



    <!-- Main Footer Start -->
    <footer class="main-footer">
        <div class="main-footer__shape-1 img-bounce"></div>

        <div class="main-footer__bottom">
            <div class="container">
                <div class="main-footer__bottom-inner">
                    <p class="main-footer__bottom-text">Copyright © 2024 Stokla.net . All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    <!-- Main Footer End -->

</div>
<!-- End PageWrapper -->

<!-- Scroll To Top -->
<div class="scroll-to-top scroll-to-target" data-target="html"><span class="fas fa-arrow-up fa-fw"></span></div>

<script src="{{asset('lan/js/jquery.js')}}"></script>
<script src="{{asset('lan/js/01-bootstrap.min.js')}}"></script>
<script src="{{asset('lan/js/02-bootstrap-select.min.js')}}"></script>
<script src="{{asset('lan/js/03-color-settings.js')}}"></script>
<script src="{{asset('lan/js/04-owl.js')}}"></script>
<script src="{{asset('lan/js/05-jarallax.min.js')}}"></script>
<script src="{{asset('lan/js/06-isotope.js')}}"></script>
<script src="{{asset('lan/js/07-wow.js')}}"></script>
<script src="{{asset('lan/js/08-validate.js')}}"></script>
<script src="{{asset('lan/js/09-appear.js')}}"></script>
<script src="{{asset('lan/js/10-swiper.min.js')}}"></script>
<script src="{{asset('lan/js/11-jquery.easing.min.js')}}"></script>
<script src="{{asset('lan/js/12-gsap.min.js')}}"></script>
<script src="{{asset('lan/js/13-odometer.js')}}"></script>
<script src="{{asset('lan/js/14-tilt.jquery.min.js')}}"></script>
<script src="{{asset('lan/js/15-magnific-popup.min.js')}}"></script>
<script src="{{asset('lan/js/16-jquery-ui.js')}}"></script>
<script src="{{asset('lan/js/17-marquee.min.js')}}"></script>
<script src="{{asset('lan/js/18-jquery.circleType.js')}}"></script>
<script src="{{asset('lan/js/19-jquery.lettering.min.js')}}"></script>



<script src="{{asset('lan/js/script.js')}}"></script>


<!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script><![endif]-->
<!--[if lt IE 9]><script src="js/respond.js"></script><![endif]-->

</body>

</html>