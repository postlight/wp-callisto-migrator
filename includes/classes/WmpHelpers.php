<?php
/**
 * Helpers
 *
 * @package   WmpHelpers
 * @developer Postlight <http://postlight.com>
 * @version   1.0
 */

/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WmpHelpers Class.
 */
class WmpHelpers extends WmpBase {
	/**
	 * Fetch post data from Merucy Parser API
	 *
	 * @param string $fetch_posts_url URL to be fetched.
	 * @return array
	 **/
	public function wmp_fetch_post_data( $fetch_posts_url ) {
		$gen_status = array();

		if ( $fetch_posts_url ) {
			if ( function_exists( 'curl_init' ) ) {
				$wmp_data_arr = array( 'url' => $fetch_posts_url );

				//phpcs:disable
				$wmp_ch      = curl_init();
				$wmp_data    = http_build_query( $wmp_data_arr );
				$wmp_get_url = WMP_MERCURY_PARSER_ENDPOINT . '?' . $wmp_data;
				curl_setopt( $wmp_ch, CURLOPT_SSL_VERIFYPEER, false );
				curl_setopt( $wmp_ch, CURLOPT_FOLLOWLOCATION, true );
				curl_setopt( $wmp_ch, CURLOPT_RETURNTRANSFER, true );
				curl_setopt( $wmp_ch, CURLOPT_URL, $wmp_get_url );
				curl_setopt( $wmp_ch, CURLOPT_TIMEOUT, 80 );

				$wmp_ch_response = curl_exec( $wmp_ch );
				$wmp_data        = json_decode( $wmp_ch_response );
				curl_close( $wmp_data );

				//phpcs:enable
				if ( ! empty( $wmp_data ) ) {
					$gen_status['status'] = 'success';
					$gen_status['data']   = $wmp_data;
				} else {
					$gen_status['status'] = 'error';
					$gen_status['action'] = 'missing_data';
				}
			} else {
				$gen_status['status'] = 'error';
				$gen_status['action'] = 'missing_curl';
			}
		} else {
			$gen_status['status'] = 'error';
			$gen_status['action'] = 'missing_param';
		}

		return $gen_status;
	}

	/**
	 * Create or update (if existing) posts meta
	 *
	 * @param int    $post_id Post ID.
	 * @param string $meta_key Meta Key.
	 * @param string $meta_value Meta Value.
	 *
	 * @return array
	 **/
	public function wmp_create_update_posts_meta( $post_id, $meta_key, $meta_value ) {
		$gen_status = array();
		if ( $post_id && $meta_key && $meta_value ) {
			// Check existing meta data.
			$wmp_ex_md   = get_post_meta( $post_id, $meta_key, true );
			$wmp_ex_type = '';
			if ( $wmp_ex_md ) {
				// Update post meta.
				$wmp_action_status = update_post_meta( $post_id, $meta_key, $meta_value );
				$wmp_ex_type       = 'update';
			} else {
				// Create post meta.
				$wmp_action_status = add_post_meta( $post_id, $meta_key, $meta_value, true );
				$wmp_ex_type       = 'create';
			}

			if ( $wmp_action_status ) {
				$gen_status['status'] = 'success';
				$gen_status['type']   = $wmp_ex_type;
			} else {
				$gen_status['status'] = 'error';
				$gen_status['action'] = 'exec_error';
				$gen_status['type']   = $wmp_ex_type;
			}
		} else {
			$gen_status['status'] = 'error';
			$gen_status['action'] = 'missing_param';
		}

		return $gen_status;
	}

	/**
	 * Fetch/Create media post from image source
	 *
	 * @param int    $post_id Post ID.
	 * @param string $thumbnail Image URL from source.
	 *
	 * @return array
	 **/
	public function wmp_fetch_add_featured_image( $post_id, $thumbnail ) {
		$gen_status = array();

		if ( $post_id && $thumbnail ) {

			if ( get_post_status( $post_id ) ) {

				$image_name       = $this->wmp_return_img_name_from_url( $thumbnail );
				$upload_dir       = wp_upload_dir();
				$unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name );
				$image_data       = $this->wmp_url_get_contents( $thumbnail );
				$filename         = basename( $unique_file_name );

				if ( $filename ) {

					/*Check folder permission and define file location*/
					if ( wp_mkdir_p( $upload_dir['path'] ) ) {
						$file = $upload_dir['path'] . '/' . $filename;
					} else {
						$file = $upload_dir['basedir'] . '/' . $filename;
					}

					/*Create the image file on the server*/
					file_put_contents( $file, $image_data ); //phpcs:ignore

					$file_array = array(
						'name'     => $filename,
						'tmp_name' => $file,
					);

					$attach_id = media_handle_sideload( $file_array, $post_id );

					if ( $attach_id ) {

						/*And finally assign featured image to post*/
						$set_post_thumb = set_post_thumbnail( $post_id, $attach_id );

						if ( ! is_wp_error( $set_post_thumb ) ) {
							$gen_status['status'] = 'success';
							$gen_status['action'] = 'image_upload_assign_post_thumbnail';
						} else {
							$gen_status['status'] = 'fail';
							$gen_status['action'] = 'image_upload_assign_post_thumbnail';
						}

						$gen_status['obj']               = $set_post_thumb;
						$gen_status['attachmentObj']     = $attach_id;
						$gen_status['attachmentFileObj'] = $file_array;

					} else {
						$gen_status['status'] = 'fail';
						$gen_status['action'] = 'image_upload_create_insert_attachement';
						$gen_status['obj']    = $attach_id;
					};

				} else {
					$gen_status['status'] = 'fail';
					$gen_status['action'] = 'image_upload_create_unique_filename';
					$gen_status['obj']    = $filename;
				}
			} else {
				$gen_status['status'] = 'fail';
				$gen_status['action'] = 'invalid_post';
			}
		} else {
			$gen_status['status'] = 'fail';
			$gen_status['action'] = 'field_check';
		}

		return $gen_status;
	}

	/**
	 * Get image from source URL
	 *
	 * @param string $url image source URL.
	 *
	 * @return string
	 **/
	public function wmp_url_get_contents( $url ) {
		if ( ! function_exists( 'curl_init' ) ) {
			die( 'CURL is not installed!' );
		}
        //phpcs:disable
		$ch_1 = curl_init();
		curl_setopt( $ch_1, CURLOPT_URL, $url );
		curl_setopt( $ch_1, CURLOPT_RETURNTRANSFER, true );
		$output_1 = curl_exec( $ch_1 );
		curl_close( $ch_1 );

        //phpcs:enable
		return $output_1;
	}

	/**
	 * Get image name and extension from source URL
	 *
	 * @param string $url image source URL.
	 *
	 * @return string
	 **/
	public function wmp_return_img_name_from_url( $url ) {
		if ( $url ) {
			if ( strpos( $url, '?' ) !== false ) {
				$t   = explode( '?', $url );
				$url = $t[0];
			}
			return basename( $url );
		}
	}
}
