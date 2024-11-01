<?php

//include "TC4B_functions.php";

function TC4B_generate_layout4($name,$dir,$page_option){
   	$basedir = TC4B_generate_layout_std($name,$dir,$page_option);
    TC4B_copydir(theme_dir.'/images/Layout4',$basedir.'/themes/'.$dir);
	
    $style = fopen ($basedir. '/themes/'.$dir.'/style.css','a');
    $front_page = fopen($basedir. '/themes/'.$dir.'/front-page.php','w');
    
    //The following are rewritten
    $customizer_php = fopen($basedir. '/themes/'.$dir.'/customizer.php', 'w');
    $customizer_js = fopen($basedir. '/themes/'.$dir.'/js/customizer.js', 'w');
    
    fwrite($style, "
/*.internal{
	border: 1px solid rgba(0,0,0,.125);
    border-radius: .25rem;
}*/

.card{
	padding: 0;
}

#menu-r, #menu-l, #posts {
	padding: 0;
}
");
    
  	fwrite($front_page, "<?php get_header(); ?>
<div class='flex-container pt-5 pb-md-5 pb-2 pl-1 pr-1'>
	<h1 id='blog-title'><?php echo get_bloginfo('name');?></h1>
    <h4 id='blog-description'><?php echo get_bloginfo('description');?></h4>
    
    <?php \$wpb_all_query = new WP_Query(array('post_type'=>'post', 'post_status'=>'publish', 'posts_per_page'=>8)); ?>

    <?php if ( \$wpb_all_query->have_posts() ) : ?>
    
    <div class= 'container'>
    	<div class='row'>
        	<div class='col-md-2 mt-3' id='menu-r'>
            	<div class='internal'>
                  <h3>Latest Posts </h3>
                  <?php \$n = 1; ?>
                  <ul>

                  <?php while ( \$wpb_all_query->have_posts() ) : \$wpb_all_query->the_post(); ?>
                      <?php if(  \$n < 6 ){?>
                          <li>
                          <a href='#post<?php echo \$n; ?>' ><?php the_title(); ?></a>
                          </li>
                      <?php } ?>
                      <?php \$n += 1; ?>
                  <?php endwhile; ?>
                  </ul>
                </div>
            </div>
            
            <div class='col-md-7' id='posts' >
            <!-- the loop -->
            <?php \$n = 1; ?>
            <?php while ( \$wpb_all_query->have_posts() ) : \$wpb_all_query->the_post(); ?>
                <div class='pb-3 pt-3 pl-1 pr-1 pl-md-3 pr-md-3'>
                  <div class='card h-100 nav-link' id='post<?php echo \$n ;?>' >
                      <?php if(has_post_thumbnail()):?>
                          <img src='<?php the_post_thumbnail_url('largest');?>' class='card-img-top img-fluid'>
                      <?php endif;?>
                      <div class='card-body'>
                          <h5 class='card-title' href='<?php the_permalink(); ?>'><?php the_title(); ?></h5>
                          <p class='card-text'> <?php the_excerpt(); ?> </p>
                          <a href='<?php the_permalink(); ?>' class='btn align-self-start'>Read more</a>
                      </div>
                  </div>
                </div>
                <?php \$n += 1; ?>
            <?php endwhile; ?>
            </div>
            
            <div class='col-md-3 mt-3' id='menu-l' >
            	<div class='internal'>
                	<div id='left-paragraph'>
                    	<?php echo get_theme_mod('custom_text_aside', '<h3>Contacts</h3> <ul> <li>Email: example@gmail.com <li>Phone: +39 02 000 000 </ul> <h3>Social</h3> <ul> <li><a href=\'\'> Facebook </a> <li><a href=\'\'> Instagram </a> <li><a href=\'\'> YouTube </a> <li><a href=\'\'> Twitter </a> </ul>'); ?> 
                    </div>
                </div>
            </div>
        </div>
    </div>
 
    <?php wp_reset_postdata(); ?>
 
    <?php else : ?>
        <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
    <?php endif; ?>
   
</div>

<?php get_footer(); ?>");

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
          
      \$wp_customize->add_setting( 'custom_text_aside' , array(
          'default'     => '<h3>Contacts</h3> <ul> <li>Email: example@gmail.com <li>Phone: +39 02 000 000 </ul> <h3>Social</h3> <ul> <li><a href=\'\'> Facebook </a> <li><a href=\'\'> Instagram </a> <li><a href=\'\'> YouTube </a> <li><a href=\'\'> Twitter </a> </ul>',
          'transport'   => 'postMessage'
      ) );
      
      \$wp_customize->add_control( 'custom_text_aside', array(
          'label' => 'Right Aside Text',
          'section' => 'TC4B_custom_text_section',
          'settings' => 'custom_text_aside',
          'type' => 'textarea'
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
    
    wp.customize( 'custom_text_aside', function( value ) {
      value.bind( function( newval ) {
        $( '#left-paragraph' ).html( newval );
      } );
    } );
        
} );");

    fclose($front_page);    
    fclose($style);
    fclose($customizer_php); 
    fclose($customizer_js);
}
?>
