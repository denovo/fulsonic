<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<section class="content" id="<?php $content->slug(); ?>">
	<div class="inner">
		<h2>
			<?php $content->title(); ?>
			<i class="title_line"></i>    
		</h2>
		<p class="lead"></p>
		<?php $content->content(); ?>
	</div>
</section>