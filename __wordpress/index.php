<?php $t =& peTheme(); ?>
<?php get_header(); ?>

<section class="blog">
	<div class="inner">
		<div class="row">
			
			<div class="col1">				
				<?php $t->content->loop(); ?>
			</div>
			
			<?php get_sidebar(); ?>
			
		</div>
	</div>
</section>

<?php get_footer(); ?>
