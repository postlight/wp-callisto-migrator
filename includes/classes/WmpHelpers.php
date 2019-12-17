<?php
/**
 * Helpers
 *
 * @package   WmpHelpers
 * @developer Postlight <http://postlight.com>
 * @version   1.0
 */
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Exit if accessed directly
 */
class WmpHelpers extends WmpBase
{

    public function wmp_fetch_post_data($fetch_posts_url)
    {
        $genStatus = [];

        if ($fetch_posts_url) {
            if (function_exists('curl_init')) {
                $wmp_dataArr = ['url' => $fetch_posts_url];

                $wmp_ch = curl_init();
                $wmp_data = http_build_query($wmp_dataArr);
                $wmp_get_url = WMP_MERCURY_PARSER_ENDPOINT . "?" . $wmp_data;
                curl_setopt($wmp_ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($wmp_ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($wmp_ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($wmp_ch, CURLOPT_URL, $wmp_get_url);
                curl_setopt($wmp_ch, CURLOPT_TIMEOUT, 80);

                $wmp_ch_response = curl_exec($wmp_ch);
                $wmp_data = json_decode($wmp_ch_response);
                curl_close($wmp_data);

                if (!empty($wmp_data)) {
                    $genStatus['status'] = 'success';
                    $genStatus['data'] = $wmp_data;
                } else {
                    $genStatus['status'] = 'error';
                    $genStatus['action'] = 'missing_data';
                }
            } else {
                $genStatus['status'] = 'error';
                $genStatus['action'] = 'missing_curl';
            }
        } else {
            $genStatus['status'] = 'error';
            $genStatus['action'] = 'missing_param';
        }

        return $genStatus;
    }

    public function wmp_create_update_posts_meta($post_id, $meta_key, $meta_value)
    {
        $genStatus = [];
        if ($post_id && $meta_key && $meta_value) {
            //Check existing meta data
            $wmp_ex_md = get_post_meta($post_id, $meta_key, true);
            $wmp_ex_type = '';
            if ($wmp_ex_md) {
                //Update post meta
                $wmp_action_status = update_post_meta($post_id, $meta_key, $meta_value);
                $wmp_ex_type = 'update';
            } else {
                //Create post meta
                $wmp_action_status = add_post_meta($post_id, $meta_key, $meta_value, true);
                $wmp_ex_type = 'create';
            }

            if ($wmp_action_status) {
                $genStatus['status'] = 'success';
                $genStatus['type'] = $wmp_ex_type;
            } else {
                $genStatus['status'] = 'error';
                $genStatus['action'] = 'exec_error';
                $genStatus['type'] = $wmp_ex_type;
            }

        } else {
            $genStatus['status'] = 'error';
            $genStatus['action'] = 'missing_param';
        }
    }

    public function wmp_fetch_add_featured_image($post_id, $thumbnail)
    {
        $genStatus = [];

        if ($post_id && $thumbnail) {

            if (get_post_status($post_id)) {

                $image_name = sanitize_title_with_dashes(get_the_title($post_id)) . '.jpg';
                $upload_dir = wp_upload_dir();
                $unique_file_name = wp_unique_filename($upload_dir['path'], $image_name);
                $image_data = $this->wmp_url_get_contents($thumbnail);
                $filename = basename($unique_file_name);

                if ($filename) {

                    /*Check folder permission and define file location*/
                    if (wp_mkdir_p($upload_dir['path'])) {
                        $file = $upload_dir['path'] . '/' . $filename;
                    } else {
                        $file = $upload_dir['basedir'] . '/' . $filename;
                    }

                    /*Create the image file on the server*/
                    file_put_contents($file, $image_data);

                    $file_array = array(
                        'name' => $filename,
                        'tmp_name' => $file,
                    );

                    $attach_id = media_handle_sideload($file_array, $post_id);

                    if ($attach_id) {

                        /*And finally assign featured image to post*/
                        $set_post_thumb = set_post_thumbnail($post_id, $attach_id);

                        if (!is_wp_error($set_post_thumb)) {
                            $genStatus['status'] = 'success';
                            $genStatus['action'] = 'image_upload_assign_post_thumbnail';
                        } else {
                            $genStatus['status'] = 'fail';
                            $genStatus['action'] = 'image_upload_assign_post_thumbnail';
                        }

                        $genStatus['obj'] = $set_post_thumb;
                        $genStatus['attachmentObj'] = $attach_id;
                        $genStatus['attachmentFileObj'] = $file_array;

                    } else {
                        $genStatus['status'] = 'fail';
                        $genStatus['action'] = 'image_upload_create_insert_attachement';
                        $genStatus['obj'] = $attach_id;
                    };

                } else {
                    $genStatus['status'] = 'fail';
                    $genStatus['action'] = 'image_upload_create_unique_filename';
                    $genStatus['obj'] = $filename;
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

    public function wmp_url_get_contents($Url)
    {
        if (!function_exists('curl_init')) {
            die('CURL is not installed!');
        }
        $ch_1 = curl_init();
        curl_setopt($ch_1, CURLOPT_URL, $Url);
        curl_setopt($ch_1, CURLOPT_RETURNTRANSFER, true);
        $output_1 = curl_exec($ch_1);
        curl_close($ch_1);

        return $output_1;
    }
}
