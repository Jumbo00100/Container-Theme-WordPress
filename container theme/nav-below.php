<?php
the_posts_navigation(
	array(
		/* translators: %s: arrow */
		'prev_text' => sprintf( esc_html__( '%s older', 'containertheme' ), '<span class="meta-nav">&larr;</span>' ),
		/* translators: %s: arrow */
		'next_text' => sprintf( esc_html__( 'newer %s', 'containertheme' ), '<span class="meta-nav">&rarr;</span>' ),
	)
);
