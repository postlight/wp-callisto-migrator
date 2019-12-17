jQuery( document ).ready(
	function () {
		// Limit to # of rows in textarea or arbitrary # of rows.
		jQuery( '#wmp_urls_field' ).bind(
			'change keyup',
			function (event) {
				var $rows     = 5;
				var $value    = '';
				var $splitval = jQuery( this ).val().split( "\n" );

				// Reset notices.
				wmp_reset_notices();

				for (var $a = 0; $a < $rows && typeof $splitval[$a] != 'undefined'; $a++) {
					if ($a > 0) {
						$value += "\n";
					}
					$value += $splitval[$a];
				}

				// Append URLs.
				jQuery( this ).val( $value );

				// Check URLs count.
				if ($splitval.length > $rows) {
					// Return notice.
					wmp_return_notice( 'Only 5 lines per attempt are allowed, additional ones were ignored', 'notice-warning' );
				}
			}
		);
	}
);

jQuery( '#wmp_fetch_posts' ).on(
	'click',
	function (e) {
		e.preventDefault();

		// Reset.
		wmp_reset_notices();

		// Action variables.
		var $this             = jQuery( this );
		var $nonce            = jQuery( '#wmp_fetch_posts_nonce' ).val();
		var $ajax_url         = jQuery( '#wmp_fetch_posts_ajax_url' ).val();
		var $fetch_posts_urls = jQuery( '#wmp_urls_field' ).val();
		var $post_type        = jQuery( '#wmp_post_type' ).val();
		var $post_status      = jQuery( '#wmp_post_status' ).val();

		// Show spinner.
		wmp_show_spinner();
		$this.addClass( 'wmp_disabled' );

		// Verify URLs input.
		if ( ! $fetch_posts_urls) {
			// Return notice.
			wmp_return_notice( 'You need to add some URL(s) before fetching', 'notice-error' );

			// Enable btn.
			$this.removeClass( 'wmp_disabled' );
			return;
		}

		// Verify URLs type.
		wmp_verify_urls();

		// Recheck verified URLs.
		$fetch_posts_urls = jQuery( '#wmp_urls_field' ).val();
		if ( ! $fetch_posts_urls) {
			// Return notice.
			wmp_return_notice( 'You need to add some valid URL(s) before fetching', 'notice-error' );

			// Enable btn.
			$this.removeClass( 'wmp_disabled' );
			return;
		}

		// Verify nonce and ajax URL.
		if ( ! $nonce || ! $ajax_url) {
			// Return notice.
			wmp_return_notice( 'An error occurred, please refresh to try again or contact us at https://postlight.com/#contact-us', 'notice-error' );
			return;
		}

		// Fetch posts through AJAX.
		jQuery.ajax(
			{
				url: $ajax_url,
				type: "POST",
				dataType: "json",
				data: {
					nonce: $nonce,
					action: "wmp_fetch_posts",
					fetch_posts_urls: $fetch_posts_urls,
					post_type: $post_type,
					post_status: $post_status
				},
				success: function (response) {
					if (response.success) {
						// Return notice.
						wmp_return_notice( 'Post(s) successfully fetched and created/updated, additional details below:', 'notice-success' );

						// Reset Vals.
						jQuery( '#wmp_urls_field' ).val( '' );

						// Enable btn.
						$this.removeClass( 'wmp_disabled' );

						// Show fetched posts.
						var $counter = 0;
						jQuery.each(
							response.data.wmp_fetch_data,
							function (index, res) {
								var $wmp_pid      = res.p_id;
								var $wmp_ptitle   = res.p_data.title;
								var $wmp_pexcerpt = res.p_data.content;

								// Clone preview from origin.
								var $wmp_to_clone        = jQuery( '.wmp_generated_to_clone' ).clone();
								var $wmp_clone_container = jQuery( '.wmp_generated_cloned_posts' );

								$counter++;

								// Fields.
								var $wmp_edit_post_link = '/wp-admin/post.php?post=' + $wmp_pid + '&action=edit';
								var $wmp_post_link      = '<a class="wmp_post_fetched_view_link" href="' + $wmp_edit_post_link + '" target="_blank">(View Post)</a>';

								$wmp_to_clone.find( '.wmp_post_fetched_title' ).html( $counter + '- ' + $wmp_ptitle + ' ' + $wmp_post_link );
								$wmp_to_clone.find( '.wmp_post_fetched_excerpt' ).html( $wmp_pexcerpt );
								$wmp_to_clone.css( 'display', 'block' );
								$wmp_to_clone.removeClass( 'wmp_generated_to_clone' );
								$wmp_clone_container.append( $wmp_to_clone );
								$wmp_clone_container.slideDown( 'fast' );
							}
						);

						// Show cont.
						jQuery( '.wmp_generated_posts' ).slideDown( 'fast' );

						// Scroll to section.
						jQuery( 'html, body' ).animate(
							{
								scrollTop: jQuery( "#wmp_to_scroll" ).offset().top - 20
							},
							800
						);
					} else {
						if (response.data.status === 'warning') {
							if (response.data.error_type === 'empty_invalid_api_response') {
								wmp_return_notice( 'Your custom endpoint didn\'t return any data, are you sure it\'s setup correctly?', 'notice-warning' );
							} else {
								wmp_return_notice( 'Couldn\'t fetch data from entered URl(s)', 'notice-warning' );
							}
						} else {
							wmp_return_notice( 'An error occurred, please refresh to try again or contact us at https://postlight.com/#contact-us', 'notice-error' );
						}
					}
				},
				error: function () {
					wmp_return_notice( 'An error occurred, please refresh to try again or contact us at https://postlight.com/#contact-us', 'notice-error' );
				}
			}
		);
	}
);

// Toggle fetched posts accordian.
jQuery( document ).on(
	'click',
	'.wmp_post_toggle',
	function (e) {
		e.preventDefault();

		jQuery( this ).closest( '.postbox' ).find( '.wmp_post_fetched_excerpt' ).toggle();
		jQuery( this ).toggleClass( 'wmp_rotate' );
	}
);
