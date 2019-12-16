<?php
/**
 * Helpers
 *
 * @package WmpHelpers
 * @developer  Postlight <http://postlight.com>
 * @version 1.0
 *
 */
if (!defined('ABSPATH')) {
    exit;
}

/** Exit if accessed directly */
class WmpHelpers extends WmpBase
{
    public function wmp_get_current_date_time()
    {
        date_default_timezone_set(wmp_default_timezone);

        return date('Y-m-d H:i:s');
    }

    public function wmp_get_current_raw_date()
    {
        date_default_timezone_set(wmp_default_timezone);

        return date('Y-m-d');
    }

    public function wmp_get_current_user_id()
    {
        if (get_current_user_id()) {
            return get_current_user_id();
        }
    }

    public function wmp_fetch_add_featured_image( $post_id, $thumbnail ) {
        $genStatus = [];

        if ( $post_id && $thumbnail ) {

            if ( get_post_status( $post_id ) ) {

                $main_type        = get_post_type( $post_id );
                $image_name       = 'wmp_' . $main_type . '_' . $post_id.'_' .rand(1, 9999). '.jpg';
                $upload_dir       = wp_upload_dir(); // Set upload folder
                $unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name ); // Generate unique name
                $image_data       = $this->wmp_url_get_contents( $thumbnail ); // Get image data
                $filename         = basename( $unique_file_name ); // Create image file name

                if ( $filename ) {

                    /*Check folder permission and define file location*/
                    if ( wp_mkdir_p( $upload_dir['path'] ) ) {
                        $file = $upload_dir['path'] . '/' . $filename;
                    } else {
                        $file = $upload_dir['basedir'] . '/' . $filename;
                    }

                    /*Create the image file on the server*/
                    file_put_contents( $file, $image_data );

                    $file_array = array(
                        'name'     => $filename,
                        'tmp_name' => $file,
                    );

                    $attach_id = media_handle_sideload( $file_array, $post_id );

                    if ( $attach_id ) {

                        /*And finally assign featured image to post*/
                        $set_post_thumb = set_post_thumbnail( $post_id, $attach_id );

                        if ( ! is_wp_error( $set_post_thumb ) ) {
                            $genStatus['status'] = 'success';
                            $genStatus['action'] = 'image_upload_assign_post_thumbnail';
                        } else {
                            $genStatus['status'] = 'fail';
                            $genStatus['action'] = 'image_upload_assign_post_thumbnail';
                        }

                        $genStatus['obj']               = $set_post_thumb;
                        $genStatus['attachmentObj']     = $attach_id;
                        $genStatus['attachmentFileObj'] = $file_array;

                    } else {
                        $genStatus['status'] = 'fail';
                        $genStatus['action'] = 'image_upload_create_insert_attachement';
                        $genStatus['obj']    = $attach_id;
                    };

                } else {
                    $genStatus['status'] = 'fail';
                    $genStatus['action'] = 'image_upload_create_unique_filename';
                    $genStatus['obj']    = $filename;
                }

            } else {
                $genStatus['status'] = 'fail';
                $genStatus['action'] = 'invalid_post';
            }

        } else {
            $genStatus['status'] = 'fail';
            $genStatus['action'] = 'field_check';
        }

        return $genStatus;
    }

   public function wmp_url_get_contents( $Url ) {
        if ( ! function_exists( 'curl_init' ) ) {
            die( 'CURL is not installed!' );
        }
        $ch_1 = curl_init();
        curl_setopt( $ch_1, CURLOPT_URL, $Url );
        curl_setopt( $ch_1, CURLOPT_RETURNTRANSFER, true );
        $output_1 = curl_exec( $ch_1 );
        curl_close( $ch_1 );

        return $output_1;
    }
}
