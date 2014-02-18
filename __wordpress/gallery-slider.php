<?php $t =& peTheme(); ?>
<?php list($pid,$conf,$loop) = $t->template->data(); ?>
<?php $w = $t->media->width(870); ?>
<?php $h = $t->media->height(300); ?>


<div class="peSlider peVolo" data-autopause="enabled" data-plugin="<?php echo apply_filters("pe_theme_slider_plugin","peVolo"); ?>" data-controls-arrows="edges-full" data-controls-bullets="disabled" data-icon-font="enabled">
	<?php while ($slide =& $loop->next()): ?>
	
	<?php $link = empty($slide->link) ? false: $slide->link; ?>
	<?php $img = $t->image->resizedImg($slide->img,$w,$h); ?>

	<div data-delay="7" <?php echo $slide->idx == 0 ? ' class="visible"' : 'class=""'; ?> data-background="<?php echo $slide->img; ?>">
		<?php if (isset($slide->caption)) $t->slider->caption($slide->caption); ?>
		<?php if ($link): ?>
		<a href="<?php echo $link ?>" data-flare-gallery="fsGallery<?php echo $pid ?>">
			<?php echo $img; ?>
		</a>
		<?php else: ?>
			<?php echo $img; ?>
		<?php endif; ?>
	</div>
	<?php endwhile; ?>
</div>

