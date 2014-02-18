<?php $t =& peTheme(); ?>
<?php $options =& $t->options; ?>

<?php
$social = 
	array(
		  "facebook" => "F",
		  "twitter" => "L",
		  "linkedin" => "I",
		  "dribbble" => "D",
		  "behance" => "E"
		  );
?>

<section id="social_module">
	<ul>
		<?php foreach ($social as $key => $icon): ?>
		<?php $link = $options->get($key); ?>
		<?php if (!empty($link)): ?>
		<li><a href="<?php echo esc_url($link); ?>"><i class=icon><?php echo $icon; ?></i></a></li>
		<?php endif; ?>
		<?php endforeach; ?>
	</ul>
</section>

<footer>
	<div><img alt="logo" src="<?php echo $t->options->get("logoFooter") ?>"></div>
</footer>

</div>
	
	<?php $t->footer->wp_footer(); ?>
	<script type="text/javascript" src="http://fulsonic.co.uk/wp-content/themes/halfcreative/js/jquery.hcaptions.js">
	</script>
	
	<script type="text/javascript">
		// $(window).load(function(){
		//   $('.hcaption').hcaptions({
		// 	  effect: "fade",
		// 	  speed: "200"
		// 	});
		// });
	</script>
    
    </body>
</html>