<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $project =& $t->project; ?>

<?php $meta =& $content->meta(); ?>

<section class="portfolio" id="<?php $content->slug(); ?>">
	
	<div class="inner">
		
		<h2><?php $content->title(); ?>
	    <i class="title_line"></i>  
		</h2>
		
		<?php if (!empty($meta->portfolio->subtitle)): ?>
		<p class="lead"><?php echo $meta->portfolio->subtitle; ?></p>
		<?php endif; ?>

		<?php if (!post_password_required()): ?>
		<?php $t->project->portfolio($content->meta()->portfolio,true) ?>
		<?php else: ?>
		<?php get_template_part("password"); ?>
		<?php endif; ?>
	</div>
</section>