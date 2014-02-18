<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $isSingle = is_single(); ?>

<?php while ($content->looping() ) : ?>
<?php $meta =& $content->meta(); ?>
<?php $link = get_permalink(); ?>
<?php $type = $content->type(); ?>
<?php $hasFeatImage = $content->hasFeatImage(); ?>

<div class="post post-single">
	<div class="inner-spacer-right-lrg">
		<div class="post-title">
			<?php if ($isSingle): ?>
			<h3><?php $content->title() ?></h3>
			<?php else: ?>
			<h3><a href="<?php echo $link ?>"><?php $content->title() ?></a></h3>
			<?php endif; ?>
			<div class="post-meta">
				By <?php the_author_posts_link(); ?> on <?php $content->date(); ?>
				<?php if ($type === "post"): ?>
				in <?php $content->category(); ?>
				<?php endif; ?>
			</div>
		</div>
		<div class="post-media">

			<?php switch($content->format()): case "gallery": // Gallery post ?>
			<?php $t->media->size($meta->gallery,592,333); ?>
			<?php $t->gallery->output($meta->gallery->id); ?>
			<?php $t->media->size(); ?>
			<?php break; case "video": // Video post ?>
			<?php $t->media->size(592,333); ?>
			<?php $t->video->output(); ?>
			<?php $t->media->size(); ?>
			<?php break; default: // Standard post ?>
			<?php if ($hasFeatImage): ?>
			<?php $imgLink = $isSingle ? $content->get_origImage() : $link; ?>
			<?php if (false): ?>
			<a href="<?php echo $imgLink; ?>"><?php $content->img(592,0); ?></a>
			<?php else: ?>
			<?php $content->img(592,$content->type() === "project" ? 0 : 333); ?>
			<?php endif; ?>
			<?php endif; ?>
			<?php endswitch; ?>

		</div>
		
		<div class="post-body">
			<?php $content->content(); ?>
		</div>
		
		<div class="tags">
			<?php if ($type === "post"): ?>
			<?php $content->tags(" "); ?>
			<?php else: ?>
			<?php echo get_the_term_list(null,$t->project->taxonomy,""," ",""); ?>
			<?php endif; ?>
		</div>
		<?php if ($isSingle): ?>
		<?php get_template_part("common","prevnext"); ?>
		<?php endif; ?>
	</div>
</div>
<?php if ($isSingle): ?>
<?php // comments_template(); ?>
<?php endif; ?>
<?php endwhile; ?>
<?php if (!$isSingle): ?>
<?php $t->content->pager(); ?>
<?php endif; ?>
