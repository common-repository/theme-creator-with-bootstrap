<?php

define("theme_dir",dirname(__DIR__, 2));

function TC4B_copydir($source,$destination){
    	
    if(!is_dir($destination)){
        wp_mkdir_p($destination);
    }
    $dir_handle = @opendir($source) or die("Unable to open");
    while ($file = readdir($dir_handle)) 
    {
        if($file!="." && $file!=".." && !is_dir("$source/$file"))
            copy("$source/$file","$destination/$file");
    }
    closedir($dir_handle);
}

function TC4B_generate_base($dir){
	$basedir = dirname(__DIR__, 4);

	$ok = wp_mkdir_p($basedir. '/themes/'.$dir.'');
	if (!$ok){
		 
            echo "<div class='notice notice-error is-dismissible'>
                <p><b>Error</b>: Cannot create theme directory <br>
                Check <i>'/wp-content/themes'</i> permissions: make sure it's writable!</p>
                </div>";
		die;
	}

    TC4B_copydir(theme_dir."/bootstrap/css",$basedir. '/themes/'.$dir.'/css');
    TC4B_copydir(theme_dir."/bootstrap/js",$basedir. '/themes/'.$dir.'/js');
    return $basedir;
}

function TC4B_generate_layout_std($name,$dir,$page_option){
	$basedir = TC4B_generate_base($dir);	
    
    $index = fopen($basedir. '/themes/'.$dir.'/index.php','w');
    $style = fopen($basedir. '/themes/'.$dir.'/style.css','w');
    $page = fopen($basedir. '/themes/'.$dir.'/page.php','w');
    $header = fopen($basedir. '/themes/'.$dir.'/header.php','w');
    $footer = fopen($basedir. '/themes/'.$dir.'/footer.php','w');   
    $single = fopen($basedir. '/themes/'.$dir.'/single.php','w');
    $archive = fopen($basedir. '/themes/'.$dir.'/archive.php','w');
    $functions = fopen($basedir. '/themes/'.$dir.'/functions.php','w');
    $customizer_php = fopen($basedir. '/themes/'.$dir.'/customizer.php', 'w');
    $customizer_js = fopen($basedir. '/themes/'.$dir.'/js/customizer.js', 'w');
    $scripts = fopen($basedir. '/themes/'.$dir.'/js/scripts.js', 'w');
              

  	fwrite($style, "/*
Theme name: ".$name."
Author: Theme Creator for Bootstrap
Version: 1.0
*/

/* BEGIN STANDARD STYLE */

body{
	padding: 0;
}

.navigation {
	list-style-type: none;
    padding: 0 0 0 0;
}

.menu-item:hover {
	backdrop-filter: brightness(85%);
    -webkit-backdrop-filter: brightness(85%);
    color: white;
}

.menu-item > a {
	display: block;
	text-decoration: none;
    padding: 10px 10px 10px 10px;
}

.current-menu-item {
	backdrop-filter: brightness(70%);
    -webkit-backdrop-filter: brightness(70%);
}

.navbar-light .navbar-collapse{
	justify-content: flex-end;
}

.navbar-light, .navbar-expand-lg {
	padding: 0 16px 0 16px;
}

.card-body{
	display: flex;
    flex-direction: column;
}

.card-body > p{
	text-align:justify;
}

#top, #center, #low {
  	width: 30px;
    height: 2px;
    border-radius: 5px;
    margin: 7px 0;
    transition: .2s;
}

.change #top {
  -webkit-transform: rotate(-45deg) translate(-6px, 5.5px);
  transform: rotate(-45deg) translate(-6px, 5.5px);
}

.change #center {opacity: 0;}

.change #low {
  -webkit-transform: rotate(45deg) translate(-7px, -7px);
  transform: rotate(45deg) translate(-7px, -7px);
}

.navbar-light .navbar-toggler{
	border: none;
    padding: 0 0 0 0;
}

.hamburger{
    padding: 1px 0 1px 0;
}

.btn{
	border:none;
    color: white;
    margin-top: auto;
}

.btn:hover{
	filter: brightness(85%);
    color: white;
}

.card-img-top {
    width: 100%;
    height: 20vw;
    object-fit: cover;
}

.article{
	padding: 0 40px 0 40px;
}

.archive-img {
	width: 100%;
    height: 100%;
    object-fit: cover;
}

.archive-card{
	transition: transform .3s;
}

.archive-card:hover{
	transform: scale(1.05);
}

@media screen and (max-width: 768px){
	.card-img-top {
      height: 35vw;
  }
}

@media screen and (max-width: 576px){
	.archive-img {
    	height: 20vw;
	}
}

#toTopBtn{
  display: none;
  position: sticky; 
  bottom: 20px;
  right: 20px;
  z-index: 99; /* Make sure it does not overlap */
  border: none; 
  outline: none; 
  cursor: pointer; 
  padding: 0px; /* Some padding */
  border-radius: 7px; /* Rounded corners */
  margin-left: auto;
  margin-bottom: 3px;
}

#toTopBtn > a {
	color: white;
    padding: 12px;
    display: block;
}

#toTop {
  border: solid;
  border-width: 0 3px 3px 0;
  padding: 3px;
  -webkit-transform: rotate(-135deg);
  transform: rotate(-135deg);
}

.internal{
	border: 1px solid rgba(0,0,0,.125);
    border-radius: .25rem;
}

/* BEGIN LAYOUT SPECIFIC STYLE */

");
    
    fwrite($header, "<!DOCTYPE html>
<html <?php language_attributes(); ?> id='up'>
<head>
    
<title><?php bloginfo('name'); ?> </title>
<meta name='description' content='<?php bloginfo('description'); ?>'>
<meta name='keywords' content='responsive, demo, ppmproject, bootstrap'>
<meta name='viewport' content='width=device-width, initial-scale=1'>

<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

<nav class='navbar navbar-light navbar-expand-lg fixed-top' id='navbar'>
	  <a class='navbar-brand' id='home' href='<?php echo home_url(); ?>'><?php echo get_theme_mod('custom_text_nav','Home'); ?></a>
		
      <button class='navbar-toggler'
                    type='button'
                    data-target='#navbarSupportedContent'
                    data-toggle='collapse'
                    aria-controls='navbarSupportedContent'
                    aria-expanded='false'
                    aria-label='Toggle Navigation'>
                    <div class='hamburger' onclick='myFunction(this)'>
                    	<div id='top'></div>
						<div id='center'></div>
						<div id='low'></div>
                    </div>
                    <script>
						function myFunction(x) {
  							x.classList.toggle('change');
						}
					</script>
		</button>

      <div class='collapse navbar-collapse' id='navbarSupportedContent'>
          <?php wp_nav_menu(array('theme_location' =>'top-menu','menu_class' =>'navbar-nav navigation','container' => ''));?>
      </div>
</nav>");

	fwrite($footer, "
    
<button id='toTopBtn' class='btn'><a href='#up'><div id='toTop'></div></a></button>
<script>
    var mybutton = document.getElementById('toTopBtn');
    window.onscroll = function() {TC4B_scrollFunction()};

    function TC4B_scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
          	mybutton.style.display = 'block';
        } else {
          	mybutton.style.display = 'none';
        }
    }

</script>


<footer id='bottom' class='page-footer font-small'>
  <div id='footer' class='footer-copyright text-center'>
    <?php echo get_theme_mod('custom_text_footer','Theme Creator for Bootstrap'); ?>
    <?php wp_footer(); ?>
  </div>
</footer>
</body>
</html>");

	fwrite($scripts, "jQuery(document).ready(function(){
 		var docHeight = jQuery(window).height();
      	var footerHeight = jQuery('#bottom').height();
      	var footerTop = jQuery('#bottom').position().top + footerHeight;

        if (footerTop < docHeight)
        	jQuery('#bottom').css('margin-top', (docHeight - footerTop) + 'px');
                        
        jQuery('a').on('click', function(event) {

          if (this.hash !== '') {     
            event.preventDefault();
            var hash = this.hash;

            jQuery('html, body').animate({
              scrollTop: jQuery(hash).offset().top
            }, 800, function(){
              window.location.hash = hash;
            });
          } 
       
        });
});
");

fwrite($functions, "<?php
include('customizer.php');

function TC4B_load_stylesheets(){
	
    wp_register_style('bootstrap', get_template_directory_uri().'/css/bootstrap.min.css',array(), false, 'all');
    wp_enqueue_style('bootstrap');

    wp_register_style('style', get_template_directory_uri().'/style.css',array(), false, 'all');
    wp_enqueue_style('style');
     
}

function TC4B_load_js(){
	//Le dipendenze si mettono dentro array()
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), 1, true );
    wp_enqueue_script('bootstrap');

    wp_register_script('customjs',  get_template_directory_uri().'/js/scripts.js', array( 'jquery' ) , 1, true);
    wp_enqueue_script('customjs');
    
}

function TC4B_custom_excerpt_length( \$length ) {
    return 30;
}

add_action('wp_enqueue_scripts', 'TC4B_load_stylesheets');
add_action('wp_enqueue_scripts', 'TC4B_load_js'); 

add_filter( 'excerpt_length', 'TC4B_custom_excerpt_length', 999 );

add_theme_support('menus'); 
add_theme_support('post-thumbnails');
add_theme_support('customize-selective-refresh-widgets');

register_nav_menus(array('top-menu' => __('Top Menu', 'theme'),'footer-menu' => __('Footer Menu', 'theme')));

add_image_size('smallest', 400, 300, true);
add_image_size('large', 600, 400, true);
add_image_size('largest', 800, 600, true);
add_image_size('huge', 1200, 800, true);
add_image_size('square', 400, 400, true);

?>");

	fwrite($customizer_php, "<?php 
    
add_action('customize_register', 'TC4B_customizer_settings');

function TC4B_customizer_settings(\$wp_customize) {
	\$wp_customize->add_section('TC4B_colors', array(
    'title'      => 'Colors',
    'priority'   => 30
	));
	
	\$wp_customize->add_setting( 'background_color' , array(
    'default'     => '#ffffff',
    'transport'   => 'postMessage'
	));
    
    \$wp_customize->add_control( new WP_Customize_Color_Control( \$wp_customize, 'background_color', array(
	'label'        => 'Background Color',
	'section'    => 'TC4B_colors',
	'settings'   => 'background_color'
	)));
    
    \$wp_customize->add_setting( 'text_color' , array(
    'default'     => '#000000',
    'transport'   => 'postMessage'
	));
    
    \$wp_customize->add_control( new WP_Customize_Color_Control( \$wp_customize, 'text_color', array(
	'label'      => 'Text Color',
	'section'    => 'TC4B_colors',
	'settings'   => 'text_color'
	)));
    
    \$wp_customize->add_setting( 'navbar_color' , array(
    'default'     => '#006bac',
    'transport'   => 'postMessage'
	));
    
    \$wp_customize->add_control( new WP_Customize_Color_Control( \$wp_customize, 'navbar_color', array(
	'label'      => 'Navbar Color',
	'section'    => 'TC4B_colors',
	'settings'   => 'navbar_color'
	)));   
    
    \$wp_customize->add_setting( 'navbar_text_color' , array(
    'default'     => '#ffffff',
    'transport'   => 'postMessage'
	));
    
    \$wp_customize->add_control( new WP_Customize_Color_Control( \$wp_customize, 'navbar_text_color', array(
	'label'      => 'Navbar Text Color',
	'section'    => 'TC4B_colors',
	'settings'   => 'navbar_text_color'
	)));    
    
    \$wp_customize->add_setting( 'post_color' , array(
    'default'     => '#ffffff',
    'transport'   => 'postMessage'
	));
    
    \$wp_customize->add_control( new WP_Customize_Color_Control( \$wp_customize, 'post_color', array(
	'label'      => 'Post Background Color',
	'section'    => 'TC4B_colors',
	'settings'   => 'post_color'
	)));    
    
    \$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
    \$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
    
    \$wp_customize->add_section( 'TC4B_text_location' , array(
          'title'      => 'Title Location',
          'priority'   => 20
      ) );

      \$wp_customize->add_setting( 'text_loc' , array(
          'default'     => 'left',
          'transport'   => 'postMessage'
      ) );

      \$wp_customize->add_control( 'text_loc', array(
          'label' => 'Title Location',
          'section' => 'TC4B_text_location',
          'settings' => 'text_loc',
          'type' => 'radio',
          'choices' => array(
          'left' => 'Left',
          'center' => 'Center',
          'right' => 'Right'
      ) ) );
      
      \$wp_customize->add_section( 'TC4B_custom_text_section' , array(
          'title'      => 'Add Website Info',
          'priority'   => 20
      ) );
      
      \$wp_customize->add_setting( 'custom_text_nav' , array(
          'default'     => 'Home',
          'transport'   => 'postMessage'
      ) );
      
      \$wp_customize->add_control( 'custom_text_nav', array(
          'label' => 'Navbar Text',
          'section' => 'TC4B_custom_text_section',
          'settings' => 'custom_text_nav',
          'type' => 'text'
          ) );
          
      \$wp_customize->add_setting( 'custom_text_footer' , array(
          'default'     => 'Theme Creator for Bootstrap',
          'transport'   => 'postMessage'
      ) );
      
      \$wp_customize->add_control( 'custom_text_footer', array(
          'label' => 'Footer Text',
          'section' => 'TC4B_custom_text_section',
          'settings' => 'custom_text_footer',
          'type' => 'text'
          ) );
          
} 

add_action( 'wp_head', 'TC4B_customizer_css');
function TC4B_customizer_css()
{
    ?>
         <style type='text/css'>
             body { background: #<?php echo get_theme_mod('background_color', '#ffffff'); ?>;
             		color: <?php echo get_theme_mod('text_color', '#000000'); ?>;}
                    
             #navbar { background-color: <?php echo get_theme_mod('navbar_color', '#006bac');  ?>;}
             .btn {background-color: <?php echo get_theme_mod('navbar_color', '#006bac');  ?>;}
             #bottom {background-color: <?php echo get_theme_mod('navbar_color', '#006bac');  ?>;}
             
             .menu-item > a	{color: <?php echo get_theme_mod('navbar_text_color', '#ffffff');  ?>;}
             #top, #center, #low {background-color: <?php echo get_theme_mod('navbar_text_color', '#ffffff');  ?>;}
             #home {color: <?php echo get_theme_mod('navbar_text_color', '#ffffff');  ?>;}
             .btn {color: <?php echo get_theme_mod('navbar_text_color', '#ffffff');  ?>;}
             .btn:hover {color: <?php echo get_theme_mod('navbar_text_color', '#ffffff');  ?>;}
             #bottom {color: <?php echo get_theme_mod('navbar_text_color', '#ffffff');  ?>;}
             #toTop {color: <?php echo get_theme_mod('navbar_text_color', '#ffffff');  ?>;}
             
             .card {background-color: <?php echo get_theme_mod('post_color', '#ffffff');  ?>;}
             .internal {background-color: <?php echo get_theme_mod('post_color', '#ffffff');  ?>;}
             
             #blog-title {text-align: <?php echo get_theme_mod('text_loc', 'left');  ?>;}
             #blog-description {text-align: <?php echo get_theme_mod('text_loc', 'left');  ?>;}
         </style>
    <?php
}

add_action( 'customize_preview_init', 'TC4B_customizer' );
function TC4B_customizer() {
	  wp_enqueue_script(
  		  'TC4B_customizer',
  		  get_template_directory_uri() . '/js/customizer.js',
  		  array( 'jquery','customize-preview' ),
  		  '',
  		  true);
}
?>");

	fwrite($customizer_js, "jQuery(document).ready( function( $ ) {

  wp.customize( 'background_color', function( value ) {
		value.bind( function( newval ) {
			$( 'body' ).css( 'background', newval );
		} );
	} );
    
  wp.customize( 'text_color', function( value ) {
		value.bind( function( newval ) {
			$( 'body' ).css( 'color', newval );
		} );
	} );
    
  wp.customize( 'navbar_color', function( value ) {
		value.bind( function( newval ) {
            $( '#navbar' ).css('background-color', newval);
            $( '.btn' ).css('background-color', newval);
            $( '#bottom' ).css('background-color', newval);
		} );
	} );
    
    wp.customize( 'navbar_text_color', function( value ) {
		value.bind( function( newval ) {
            $( '.menu-item > a' ).css('color', newval);
            $( '#home' ).css('color', newval);
            $( '#top, #center, #low' ).css('background-color', newval);
            $( '.btn' ).css('color', newval);
            $( '.btn:hover' ).css('color', newval);
            $( '#bottom' ).css('color', newval);
            $( '#toTop' ).css('color', newval);
		} );
	} );
    
    wp.customize( 'blogname', function( value ) {
      value.bind( function( newval ) {
        $( '#blog-title' ).html( newval );
      } );
    } );

    wp.customize( 'blogdescription', function( value ) {
      value.bind( function( newval ) {
        $( '#blog-description' ).html( newval );
      } );
    } );
    
    wp.customize( 'text_loc', function( value ) {
      value.bind( function( newval ) {
        $( '#blog-title' ).css('text-align', newval);
        $( '#blog-description' ).css('text-align', newval);
      } );
    } );
    
    wp.customize( 'post_color', function( value ) {
      value.bind( function( newval ) {
        $( '.card' ).css('background-color', newval);
        $( '.internal' ).css('background-color', newval);
      } );
    } );
    
    wp.customize( 'custom_text_nav', function( value ) {
      value.bind( function( newval ) {
        $( '#home' ).html( newval );
      } );
    } );
    
    wp.customize( 'custom_text_footer', function( value ) {
      value.bind( function( newval ) {
        $( '#footer' ).html( newval );
      } );
    } );

} );");

fwrite($single, "<?php get_header(); ?>
<div class='container article pt-5 pb-5 pr-3 pl-3'>
	<?php if (have_posts()) : while(have_posts()) : the_post();?>
    <div class='row'>
    	<div class='col-md-2 col-sm-1'>
        </div>
        <div class='col-md-8 col-sm-10 col-12'>
        	<div class='card'>
                  <?php if(has_post_thumbnail()):?>
                      <img src='<?php the_post_thumbnail_url('largest');?>' class='card-img-top img-fluid'>
                  <?php endif;?>
                  <div class='card-body'>
                      <h1 class='card-title' href='<?php the_permalink(); ?>'><?php the_title(); ?></h1>
                      <p class='card-text'> <?php the_content(); ?> </p>
                  </div>
              </div>
        </div>
    	<div class='col-md-2 col-sm-1'>
        </div>
   </div>  
   <?php endwhile; endif;?>
</div>
<?php get_footer(); ?>  
");

fwrite($archive, "<?php get_header(); ?>

<div class='flex-container pt-5 pb-5 mr-3 ml-3'>
	<h1 style='text-align: center;'><?php single_cat_title(); ?></h1>
    <div class='row'>
      <div class='col-md-2 col-sm-1'>
      </div>
      <div class='col-md-8 col-sm-10 col-12'>
      <?php if (have_posts()) : while(have_posts()) : the_post();?>	
          <div class='card mb-4 archive-card'>
            <div class='row no-gutters'>
              <?php if(has_post_thumbnail()){?>
                  <div class='col-sm-4'>
                      <img src='<?php the_post_thumbnail_url('largest');?>' class='img-fluid archive-img'>
                  </div>
                  <div class='col-sm-8'>
                    <div class='card-body'>
                      <h5 class='card-title'><?php the_title(); ?></h5>
                      <p class='card-text'><?php the_excerpt(); ?></p>
                    </div>
                  </div>
              <?php }else{ ?>
                  <div class='col-sm-12'>
                    <div class='card-body'>
                      <h5 class='card-title'><?php the_title(); ?></h5>
                      <p class='card-text'><?php the_excerpt(); ?></p>
                    </div>
                  </div>
              <?php } ?>
            </div>
            <a href='<?php the_permalink(); ?>' class='link-tag' style='position: absolute; top: 0; right: 0; bottom: 0; left: 0; width: 100%; height: 100%;'></a>
          </div>
      <?php endwhile; endif;?>
      </div>
      <div class='col-md-2 col-sm-1'>
      </div>
    </div>
</div>

    
<?php get_footer(); ?>");

if ($page_option == 'page1'){

	//First page option
  fwrite($page, "<?php get_header(); ?>
<div class='container page pt-5 pb-5'>
	<?php if (have_posts()) : while(have_posts()) : the_post();?>
    <div class='row'>
    	<?php \$wpb_all_query = new WP_Query(array('post_type'=>'post', 'post_status'=>'publish', 'posts_per_page'=>0)); ?>

    	<?php if ( \$wpb_all_query->have_posts() ) : ?>
            <div class='col-md-4 col-12 order-md-1 order-12'>
                <div class='internal'>
                    <h3>Latest Posts </h3>
                    <?php \$n = 1; ?>
                    <ul>
                    <?php while ( \$wpb_all_query->have_posts() ) : \$wpb_all_query->the_post(); ?>
                        <?php if(  \$n < 6 ){?>
                            <li>
                            <a href='<?php the_permalink(); ?>' ><?php the_title(); ?></a>
                            </li>
                        <?php } ?>
                        <?php \$n += 1; ?>
                    <?php endwhile; ?>
                    </ul>
                </div>
            </div>
         <?php wp_reset_postdata(); ?>
 
         <?php else : ?>
             <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
         <?php endif; ?>       
        
        <div class='col-md-8 col-12 order-md-12 order-1 mb-3'>
        	<div class='card'>
                 <?php if(has_post_thumbnail()):?>
                      	<img src='<?php the_post_thumbnail_url('largest');?>' class='card-img-top img-fluid'>
                 <?php endif;?>
                 <div class='card-body'>
                      <h1 class='card-title' href='<?php the_permalink(); ?>'><?php the_title(); ?></h1>
                      <p class='card-text'> <?php the_content(); ?> </p>
                 </div>
         	</div>
         </div>
	</div>  
    <?php endwhile; endif;?>
</div>
    
<?php get_footer(); ?>
");
          
}elseif($page_option == 'page2'){

	//Second Page Option
    fwrite($page, "<?php get_header(); ?>
<div class='container page pt-5 pb-5'>
	<?php if (have_posts()) : while(have_posts()) : the_post();?>
    <div class='row'>
    	<?php \$wpb_all_query = new WP_Query(array('post_type'=>'post', 'post_status'=>'publish', 'posts_per_page'=>0)); ?>
        
        <div class='col-md-8 col-12 mb-3'>
        	<div class='card'>
                 <?php if(has_post_thumbnail()):?>
                      	<img src='<?php the_post_thumbnail_url('largest');?>' class='card-img-top img-fluid'>
                 <?php endif;?>
                 <div class='card-body'>
                      <h1 class='card-title' href='<?php the_permalink(); ?>'><?php the_title(); ?></h1>
                      <p class='card-text'> <?php the_content(); ?> </p>
                 </div>
         	</div>
         </div>
         
         <?php if ( \$wpb_all_query->have_posts() ) : ?>
            <div class='col-md-4 col-12'>
                <div class='internal'>
                    <h3>Latest Posts </h3>
                    <?php \$n = 1; ?>
                    <ul>
                    <?php while ( \$wpb_all_query->have_posts() ) : \$wpb_all_query->the_post(); ?>
                        <?php if(  \$n < 6 ){?>
                            <li>
                            <a href='<?php the_permalink(); ?>' ><?php the_title(); ?></a>
                            </li>
                        <?php } ?>
                        <?php \$n += 1; ?>
                    <?php endwhile; ?>
                    </ul>
                </div>
            </div>
         <?php wp_reset_postdata(); ?>
 
         <?php else : ?>
             <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
         <?php endif; ?>       
         
	</div>  
    <?php endwhile; endif;?>
</div>
    
<?php get_footer(); ?>");

}elseif($page_option == 'page3'){

	//Third Page Option
    fwrite($page, "<?php get_header(); ?>
          <div class='container page pt-5 pb-5'>
              <?php if (have_posts()) : while(have_posts()) : the_post();?>
              <div class='row'>
                  <div class='col-md-2 col-sm-1'>
                  </div>
                  <div class='col-md-8 col-sm-10 col-12'>
                      <div class='card'>
                            <?php if(has_post_thumbnail()):?>
                                <img src='<?php the_post_thumbnail_url('largest');?>' class='card-img-top img-fluid'>
                            <?php endif;?>
                            <div class='card-body'>
                                <h1 class='card-title' href='<?php the_permalink(); ?>'><?php the_title(); ?></h1>
                                <p class='card-text'> <?php the_content(); ?> </p>
                            </div>
                        </div>
                  </div>
                  <div class='col-md-2 col-sm-1'>
                  </div>
             </div>  
             <?php endwhile; endif;?>
          </div>
          <?php get_footer(); ?>  ");      
}

    fclose($index);
    fclose($style);
    fclose($header);
    fclose($footer);
    fclose($page);
    fclose($single);
    fclose($archive);
    fclose($functions);
    fclose($customizer_php);
    fclose($customizer_js);
    fclose($scripts);
    
    return $basedir;
}
?>
