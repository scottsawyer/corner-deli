<?php
/*
Template Name: Home Template
*/
get_header(); ?>

<div class="small-12 large-12 columns" role="main">
  <div class="flexslider">
    <ul class="slides">
      <?php
        $args=array(
          'post_type' => 'menu_item',
          'post_status' => 'publish',
          'menu_category' => 'sandwiches',
          'orderby'=>'rand',
          'posts_per_page' => 3,
        );
        $my_query = null;
        $my_query = new WP_Query($args);
        if( $my_query->have_posts() ) {
          while ($my_query->have_posts()) : $my_query->the_post(); ?>
          <li>
            <div class="slider_text">
              <h3>
                <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
              </h3>
              <?php the_content();?>
            </div>
            <div class="slider_image">
              <?php the_post_thumbnail(); ?>
            </div>
            <?php
          endwhile;
          }
          wp_reset_query();  // Restore global post data stomped by the_post().
        ?>
      </li>
    </ul>    
  </div>
</div>
</div>
<div class="row" id="home_featured">

      <?php
        $args=array(
          'post_type' => 'menu_item',
          'post_status' => 'publish',
          'menu_category' => 'sandwiches',
          'orderby'=>'rand',
          'posts_per_page' => 3,
        );
        $my_query = null;
        $my_query = new WP_Query($args);
        if( $my_query->have_posts() ) {
          while ($my_query->have_posts()) : $my_query->the_post(); ?>
          <div class="small-12 large-4 columns">
            <?php the_post_thumbnail( array( 300,240 ) ); ?>
            <h4><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
            
          </div>
            <?php
          endwhile;
          }
          wp_reset_query();  // Restore global post data stomped by the_post().
        ?>
    <?php // get_sidebar( 'home_left' ); ?>
</div>
<div class="row">
  <div class="small-12 large-6 columns">
  <?php while (have_posts()) : the_post(); ?>
    <article <?php post_class() ?> id="post-<?php the_ID(); ?>">
      <div class="entry-content">
        <?php the_content(); ?>
      </div>
    </article>
  <?php endwhile; // End the loop ?>
  </div>
  <div class="small-12 large-6 columns" id="brown_bagger">
  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/brown-bag.png" alt="The Brown Bagger" />
  <h3>The Brown Bagger</h3>
  <p>Ask for the Brown Bagger and we will pack your choice of sandwich, chips, pickle, and one side then deliver it to your office. All for $6.99.</p>
  
  </div>
  <div>
<?php
 the_widget( 'SSC_Posts_by_Category_Widget' );
?>
<? get_footer(); ?> 