<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta =& $content->meta(); ?>

<section class="blog" id="<?php $content->slug(); ?>">
	<div class="inner">
		<h2><?php $content->title(); ?><i class="title_line"></i></h2>
		<div class="row">
			<div class="col1">				
				<?php $content->blog($meta->blog,false); ?>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
</section>