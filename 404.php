<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php get_header(); ?>

<section class="404" id="<?php $content->slug(); ?>">
	<div class="inner">
		<h2>
			<?php e__pe("Page Not Found");  ?>
			<i class="title_line"></i>    
		</h2>
		<br/>
		<p>
			<?php echo $t->options->get("404content"); ?>
		</p>
		<br/>
		<br/>
	</div>
</section>

<?php get_footer(); ?>