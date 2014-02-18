<?php $t =& peTheme(); ?>
<?php $meta = $t->content->meta(); ?>
<?php $bg = empty($meta->bg->background) ? false : $meta->bg->background;  ?>
<?php if ($bg): ?>
<header style="background-image: url('<?php echo esc_url($meta->bg->background); ?>')">
<?php else: ?>
<header>
<?php endif; ?>
	
	<div class="float-over-bg">
	<a id="home"></a>
	
	<h1 class="fade-in one">
		<?php if (!empty($meta->bg->logo)): ?>
		<img alt="" src="<?php echo $meta->bg->logo; ?>" />
		<?php endif; ?>
	</h1>

	<div class="fade-in one">
		<div class="roles">
			<?php if (!empty($meta->bg->headlines)): ?>
			<?php foreach ($meta->bg->headlines as $headline): ?>
			<div><?php echo $headline; ?></div>
			<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
	</div>
</header>

<?php if (!empty($meta->bg->label)): ?>
<div id="tab" class="fade-in one">
	<a href="<?php echo esc_attr($meta->bg->url) ?>"><?php echo $meta->bg->label ?></a>
</div>
<?php endif; ?>