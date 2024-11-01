<?php

//include "TC4B_functions.php";

function TC4B_generate_layout5($name,$dir,$page_option){
    $basedir = TC4B_generate_layout_std($name,$dir,$page_option);	
    TC4B_copydir(theme_dir.'/images/Layout5',$basedir.'/themes/'.$dir);

    $front_page = fopen($basedir. '/themes/'.$dir.'/front-page.php','w');
				
  	fwrite($front_page, "<?php get_header(); ?>
<div class='flex-container pt-5 pb-5 pl-1 pr-1 pl-md-5 pr-md-5'>
	<h1 id='blog-title'><?php echo get_bloginfo('name');?></h1>
    <h4 id='blog-description'><?php echo get_bloginfo('description');?></h4>
    
    <?php \$wpb_all_query = new WP_Query(array('post_type'=>'post', 'post_status'=>'publish', 'posts_per_page'=>8)); ?>

    <?php if ( \$wpb_all_query->have_posts() ) : ?>
    
    <div class= 'container'>
    	<div class='row'>
        
        <!-- the loop -->
        <?php \$n=1;?>
        <?php while ( \$wpb_all_query->have_posts() ) : \$wpb_all_query->the_post(); ?>
          <?php if(\$n%2 == 1){?> 
        	<div class='pb-3 pt-3 pl-1 pr-1 pl-md-3 pr-md-3 col-12 col-md-4'>
              <div class='card h-100'>
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
          <?php } else { ?>
            <div class='pb-3 pt-3 pl-1 pr-1 pl-md-3 pr-md-3 col-12 col-md-8'>
              <div class='card h-100'>
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
            <?php } ?>
          <?php \$n += 1; ?>  
        <?php endwhile; ?>
        </div>
    </div>
 
    <?php wp_reset_postdata(); ?>
 
    <?php else : ?>
        <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
    <?php endif; ?>  
   
</div>
    
<?php get_footer(); ?>");

    fclose($front_page);
    
}
?>
