<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta =& $content->meta(); ?>
<?php $contact =& $meta->contact; ?>

<section class="contact" id="<?php $content->slug(); ?>">
	<div class="inner">
		<h2><?php $content->title(); ?>
	    <i class="title_line"></i>    
		</h2>

		<?php if (!empty($contact->subtitle)): ?>
		<p class="lead"><?php echo $contact->subtitle; ?></p>
		<?php endif; ?>

		<div class="row">
			<div class="col1">
				<form name="htmlform" method="post" class="peThemeContactForm">
					<div class="control-group">
						<label>Name<span class="required">*</span></label>
						<input type="text" name="author" class="required" placeholder="<?php e__pe("Your lovely Name"); ?>" required />
					</div>
					<div class="control-group">
						<label>Email<span class="required">*</span></label>
						<input type="email" name="email" class="required" placeholder="E-Mail" data-validation="email" required />
					</div>
					<div class="control-group">
						<label>Message<span class="required">*</span></label>
						<textarea name="message" cols="1" rows="5" class="required" placeholder="<?php e__pe("Tell us everything"); ?>" required ></textarea>
					</div>
					<button name="send" type="submit" dir="ltr" lang="en" class="submit"><?php e__pe("Send"); ?></button>
				</form>
				
				<!--alert success-->
				<div id="contactFormSent" class="formSent alert alert-success fade in">
					<?php echo $contact->msgOK; ?>
				</div>
			
				<!--alert error-->
				<div id="contactFormError" class="formError alert alert-error fade in">
					<?php echo $contact->msgKO; ?>
				</div>
			</div>
					
			<div class="col2">
				
				<?php if (!empty($contact->info)): ?>
				<?php echo $contact->info; ?>
				<?php endif; ?>
									
			</div>
		</div>		
	</div>
</section>