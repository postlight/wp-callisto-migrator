<?php
/**
 * Ajax Functions
 *
 * @package   WmpAjax
 * @developer Postlight <http://postlight.com>
 * @version   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Exit if accessed directly
 */
class WmpAjax extends WmpBase {
	// Ajax fetch posts.
	public function wmp_fetch_posts() { // phpcs:ignore

		// Get values.
		$wmp_action = isset( $_POST['action'] ) ? wp_strip_all_tags( wp_unslash( $_POST['action'] ) ) : '';
		$wmp_nonce  = isset( $_POST['nonce'] ) ? wp_strip_all_tags( wp_unslash( $_POST['nonce'] ) ) : '';

		$fetch_posts_urls  = isset( $_POST['fetch_posts_urls'] ) ? wp_strip_all_tags( wp_unslash( $_POST['fetch_posts_urls'] ) ) : '';
		$fetch_post_type   = isset( $_POST['post_type'] ) ? wp_strip_all_tags( wp_unslash( $_POST['post_type'] ) ) : '';
		$fetch_post_status = isset( $_POST['post_status'] ) ? wp_strip_all_tags( wp_unslash( $_POST['post_status'] ) ) : '';

		if ( ! wp_verify_nonce( $wmp_nonce, 'wmp_fetch_posts' ) ) {
			exit( 'Invalid request' );
		}
		if ( $wmp_action ) {
			// Init helper.
			$wmp_helpers = new WmpHelpers();

			if ( $fetch_posts_urls ) {
				// Default values for vars.
				if ( ! $fetch_post_type ) {
					$fetch_post_type = 'post';
				}

				if ( ! $fetch_post_status ) {
					$fetch_post_status = 'publish';
				}

				// Fetch URLs.
				$fetch_posts_urls_arr = explode( "\n", $fetch_posts_urls );

				$fetch_posts_ret_data = array();

				if ( ! empty( $fetch_posts_urls_arr ) ) {
					foreach ( $fetch_posts_urls_arr as $fetch_posts_url ) {
						// Fetch post using Mercury Parser API.
						$wmp_data = $wmp_helpers->wmp_fetch_post_data( $fetch_posts_url );

						if ( ( isset( $wmp_data['status'] ) && 'success' === $wmp_data['status'] ) && ( isset( $wmp_data['data']->title ) ) ) {

							// Fetch posts fields.
							$wmp_title          = isset( $wmp_data['data']->title ) ? $wmp_data['data']->title : '';
							$wmp_content        = isset( $wmp_data['data']->content ) ? $wmp_data['data']->content : '';
							$wmp_excerpt        = isset( $wmp_data['data']->excerpt ) ? $wmp_data['data']->excerpt : '';
							$wmp_date_published = isset( $wmp_data['data']->date_published ) ? $wmp_data['data']->date_published : '';
							$wmp_featured_image = isset( $wmp_data['data']->lead_image_url ) ? $wmp_data['data']->lead_image_url : '';
							$wmp_direction      = isset( $wmp_data['data']->direction ) ? $wmp_data['data']->direction : '';
							$wmp_domain         = isset( $wmp_data['data']->domain ) ? $wmp_data['data']->domain : '';
							$wmp_url            = isset( $wmp_data['data']->url ) ? $wmp_data['data']->url : '';

							$wmp_update_post = array();

							// Check if post exists.
							$wmp_post_id = post_exists( $wmp_title, '', '', $fetch_post_type );

							if ( $wmp_post_id ) {

								// Update if it is.
								$wmp_post_args = array(
									'ID'           => $wmp_post_id,
									'post_content' => $wmp_content,
									'post_excerpt' => $wmp_excerpt,
									'post_status'  => $fetch_post_status,
								);
								wp_update_post( $wmp_post_args );

								$wmp_update_post['p_id']   = $wmp_post_id;
								$wmp_update_post['update'] = true;

							} else {
								// Create it if it isn't.
								$wmp_post_args = array(
									'post_title'   => $wmp_title,
									'post_content' => $wmp_content,
									'post_status'  => $fetch_post_status,
									'post_type'    => $fetch_post_type,
									'post_excerpt' => $wmp_excerpt,
								);

								$wmp_post_id = wp_insert_post( $wmp_post_args );

								$wmp_update_post['update'] = false;
							}

							if ( $wmp_post_id ) {

								// Add and assign featured image.
								if ( $wmp_featured_image ) {
									$wmp_helpers->wmp_fetch_add_featured_image( $wmp_post_id, $wmp_featured_image );
								}

								// Create/Update Posts Meta.
								$wmp_helpers->wmp_create_update_posts_meta( $wmp_post_id, 'wmp_date_published', $wmp_date_published );
								$wmp_helpers->wmp_create_update_posts_meta( $wmp_post_id, 'wmp_date_direction', $wmp_direction );
								$wmp_helpers->wmp_create_update_posts_meta( $wmp_post_id, 'wmp_domain', $wmp_domain );
								$wmp_helpers->wmp_create_update_posts_meta( $wmp_post_id, 'wmp_url', $wmp_url );

								$wmp_data_temp                  = array();
								$wmp_data_temp['p_id']          = $wmp_post_id;
								$wmp_data_temp['p_data']        = $wmp_data['data'];
								$wmp_data_temp['p_update_post'] = $wmp_update_post;

								$fetch_posts_ret_data[] = $wmp_data_temp;
							}
						}
					}

					if ( ! empty( $fetch_posts_ret_data ) ) {
						$result['status']         = 'success';
						$result['wmp_fetch_urls'] = $fetch_posts_urls_arr;
						$result['wmp_fetch_data'] = $fetch_posts_ret_data;
					} else {
						$result['status'] = 'warning';
						if ( WMP_CUSTOM_ENDPOINT ) {
							$result['error_type'] = 'empty_invalid_api_response';
						} else {
							$result['error_type'] = 'empty_api_response';
						}
					}
				} else {
					$result['status']     = 'error';
					$result['error_type'] = 'missing_urls_obj';
				}
			} else {
				$result['status']     = 'error';
				$result['error_type'] = 'missing_urls';
			}

			if ( ! empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && 'xmlhttprequest' === strtolower( wp_strip_all_tags( wp_unslash( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) ) ) {
				// Return JSON response.
				if ( isset( $result['status'] ) && 'success' === $result['status'] ) {
					wp_send_json_success( $result );
				} else {
					wp_send_json_error( $result );
				}
			} else {
				$wmp_server_ref = isset( $_SERVER['HTTP_REFERER'] ) ? wp_strip_all_tags( wp_unslash( $_SERVER['HTTP_REFERER'] ) ) : '';

				header( 'Location: ' . $wmp_server_ref );
			}
			wp_die();
		} else {
			exit( 'Invalid request' );
		}
	}

	public function __construct() { // phpcs:ignore
		add_action( 'wp_ajax_wmp_fetch_posts', array( &$this, 'wmp_fetch_posts' ) );

		parent::__construct();
	}
}
