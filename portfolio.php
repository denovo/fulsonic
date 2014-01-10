<?php $t =& peTheme(); ?>
<?php list($portfolio) = $t->template->data(); ?>

<?php $content =& $t->content; ?>

<!-- if you need more space on mobile layout, increase the minheight parameter -->
<ul id="og-grid" class="og-grid" data-minheight="450">
	<?php while ($content->looping()): ?>
	<?php $meta =& $content->meta(); ?>
	<li>
		<a 
			href="<?php $content->link(); ?>"
			<?php if (!empty($meta->project->url) && !empty($meta->project->label)): ?>
			data-link-url="<?php echo esc_url($meta->project->url); ?>"
			data-link-label="<?php echo esc_attr($meta->project->label); ?>"
			<?php endif; ?>
			data-largesrc="<?php echo $t->image->resizedImgUrl($content->get_origImage(),500,370);  ?>"
			data-title="<?php echo esc_attr(get_the_title()); ?>"
			data-description="<?php echo esc_html(get_the_content()); ?>">
			<?php $content->img(250,185); ?>
			<span class="gridtitle"><?php echo get_the_title(); ?></span>
		</a>
	</li>
	<?php endwhile; ?>
</ul>
