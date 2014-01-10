<form action="<?php echo esc_url(home_url("/")); ?>" id="searchform" method="get" role="search">
	<input name="s" id="s" type="text" class="search" placeholder="<?php e__pe("Search.."); ?>" value="<?php echo get_search_query() ? get_search_query() : ""; ?>">
	<input type="submit" value="<?php e__pe("Go"); ?>" />
</form>