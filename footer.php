	</div><!-- Row End -->
</section><!-- Container End -->



<footer class="contain-to-grid footer-bottom" role="contentinfo">
	<div class="row full-width">
	  <?php dynamic_sidebar("Footer"); ?>
  </div>
  <div class="row full-width">
	<div class="small-12 large-4 columns">
		<p>&copy; <?php echo date('Y'); ?>. <?php _e('Powered by','text_domain'); ?> <a href="http://www.scottsawyerconsulting.com" rel="nofollow" title="Scott Sawyer Consulting">Scott Sawyer Consulting</a>.</p>
	</div>
	
	<div class="small-12 large-8 columns">
		<?php wp_nav_menu(array('theme_location' => 'utility', 'container' => false, 'menu_class' => 'inline-list right')); ?>
	</div>
</div>
</footer>

<?php wp_footer(); ?>

<script>
	(function($) {
		$(document).foundation();
	})(jQuery);
</script>
	
</body>
</html>