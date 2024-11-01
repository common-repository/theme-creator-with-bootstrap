<?php

//include "TC4B_functions.php";

function TC4B_generate_layout6($name,$dir,$page_option){
   	$basedir = TC4B_generate_layout_std($name,$dir,$page_option);
    TC4B_copydir(theme_dir.'/images/Layout6',$basedir.'/themes/'.$dir);
	
    $style = fopen ($basedir. '/themes/'.$dir.'/style.css','a');
    $front_page = fopen($basedir. '/themes/'.$dir.'/front-page.php','w');
    
    fwrite($style, "
@media (min-width: 32em) {
    .card-columns {
        -webkit-column-count: 2;
        -moz-column-count: 2;
        column-count: 2;
    }
}

@media (min-width: 48em) {
    .card-columns {
        -webkit-column-count: 3;
        -moz-column-count: 3;
        column-count: 3;
    }
}
");
    
  	fwrite($front_page, "<?php get_header(); ?>
<div class='flex-container pt-5 pb-5 pl-1 pr-1 pl-md-5 pr-md-5'>
	<h1 id='blog-title'><?php echo get_bloginfo('name');?></h1>
    <h4 id='blog-description'><?php echo get_bloginfo('description');?></h4>
    
    <?php \$wpb_all_query = new WP_Query(array('post_type'=>'post', 'post_status'=>'publish', 'posts_per_page'=>12)); ?>

    <?php if ( \$wpb_all_query->have_posts() ) : ?>
    
   <div class='card-columns'>
        
        <!-- the loop -->
        <?php while ( \$wpb_all_query->have_posts() ) : \$wpb_all_query->the_post(); ?>
              <div class='card'>
                  <?php if(has_post_thumbnail()):?>
                      <img src='<?php the_post_thumbnail_url('largest');?>' class='card-img-top img-fluid'>
                  <?php endif;?>
                  <div class='card-body'>
                      <h5 class='card-title' href='<?php the_permalink(); ?>'><?php the_title(); ?></h5>
                      <p class='card-text'> <?php the_excerpt(); ?> </p>
                      <a href='<?php the_permalink(); ?>' class='btn align-self-start'>Read more</a>
                  </div>
              </div>
        <?php endwhile; ?>
        
    </div>
 
    <?php wp_reset_postdata(); ?>
 
    <?php else : ?>
        <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
    <?php endif; ?>
   
</div>

<?php get_footer(); ?>");

	fclose($style);
    fclose($front_page);    
}
?>
