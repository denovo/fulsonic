<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta =& $content->meta(); ?>


<section class="about" id="<?php $content->slug(); ?>">
	<div class="inner">
		<h2><?php $content->title(); ?>
	    <i class="title_line"></i>    
		</h2>

		<?php if (!empty($meta->staff->subtitle)): ?>
		<p class="lead"><?php echo $meta->staff->subtitle; ?></p>
		<?php endif; ?>

		<?php if (!empty($meta->staff->members)): ?>
		<?php if ($content->customLoop(
								"staff",-1,null,
								array(
									  "post__in" => $meta->staff->members,
									  "orderby" => "post__in"
									  ),false)): 
		?>
		<ul id="portraits">
			<?php while ($content->looping() ) : ?>
			<?php $meta =& $content->meta(); ?>
			<a href="<?php the_permalink(); ?>">
				<li>
					<?php $content->img(220,180); ?>
					<span class="name"><?php $content->title(); ?></span><br/>
					<?php if (!empty($meta->info->position)): ?>
					<span class="poste"><?php echo $meta->info->position; ?></span><br/>
					<?php endif; ?>
					<span class="whathedo">
						<?php if (!empty($meta->info->twitter)): ?>
						<a href="<?php echo esc_url($meta->info->twitter); ?>"><i class="icon">L</i></a>
						<?php endif; ?>
						<?php if (!empty($meta->info->linkedin)): ?>
						<a href="<?php echo esc_url($meta->info->linkedin); ?>"><i class="icon">I</i></a>
						<?php endif; ?>
						<?php if (!empty($meta->info->facebook)): ?>
						<a href="<?php echo esc_url($meta->info->facebook); ?>"><i class="icon">F</i></a>
						<?php endif; ?>
					</span>
		      	</li>
	      	</a>
			<?php endwhile; ?>
			<?php $content->resetLoop(); ?>
		</ul>
		<?php endif; ?>
		<?php endif; ?>
	</div>
</section>