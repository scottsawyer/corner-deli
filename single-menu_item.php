<?php get_header(); ?>

<!-- Row for main content area -->
<!-- single menu_item -->
	<div class="small-12 large-8 columns" role="main">
	
	<?php /* Start loop */ ?>
	<?php while (have_posts()) : the_post(); ?>
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<header>
				<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php if( has_post_thumbnail() ) { the_post_thumbnail(); } ?> <!--'full', array( 'alt' => trim( strip_tags( $wp_postmeta->_wp_attachment_image_alt ) ) ) ); ?> -->
				<dl class="ssc_menu_item_info">
					 <?php 
            echo '<dt>Price:</dt> <dd> ';
            echo get_post_meta( get_the_ID(), '_ssc_price', true );//the_field( $value );
            echo '</dd>';

          	echo '<dt>Calories:</dt> <dd> ';
            echo get_post_meta( get_the_ID(), '_ssc_calories', true );
            echo '</dd>';

          	echo '<dt>Ingredients:</dt> <dd> ';
            echo get_post_meta( get_the_ID(), '_ssc_ingredients', true );
            echo '</dd>';
            ?>
        </dl>
			</header>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
			<footer>
				<?php wp_link_pages(array('before' => '<nav id="page-nav"><p>' . __('Pages:', 'reverie'), 'after' => '</p></nav>' )); ?>
				<p><?php the_tags(); ?></p>
			</footer>
			<?php comments_template(); ?>
		</article>
	<?php endwhile; // End the loop ?>

	</div>
	<article class="small-12 large-4 columns">
  	<?php dynamic_sidebar("Menu Item Sidebar"); ?>
  </article>
		
<?php get_footer(); ?>