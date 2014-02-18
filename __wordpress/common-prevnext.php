<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<div class="row-fluid post-pager">
	<div class="span12">
		
		<ul class="pager">
			<li class="previous<?php echo (($prev = $content->prevPostLink())  ? "" : " disabled") ?>">
				<a href="<?php echo ($prev ? $prev : "#"); ?>">&larr; <span><?php e__pe("Previous"); ?></span></a>
			</li>
			<li class="next<?php echo (($next = $content->nextPostLink())  ? "" : " disabled") ?>">
				<a href="<?php echo ($next ? $next : "#"); ?>"><span><?php e__pe("Next"); ?></span> &rarr;</a>
			</li>
		</ul> 
	</div>
</div>
