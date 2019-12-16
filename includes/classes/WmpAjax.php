<?php
/**
 * Ajax Functions
 *
 * @package WmpAjax
 * @developer  Postlight <http://postlight.com>
 * @version 1.0
 *
 */
if (!defined('ABSPATH')) {
    exit;
}

/** Exit if accessed directly */
class WmpAjax extends WmpBase
{

    //Ajax fetch posts
    public function wmp_fetch_posts()
    {
        if (!wp_verify_nonce($_REQUEST['nonce'], "wmp_fetch_posts")) {
            exit("Invalid request");
        }
        if ($_POST['action'] == "wmp_fetch_posts") {
            //Init helper
            $wmpHelpers = new WmpHelpers();

            //Get values
            $fetch_posts_urls = strip_tags($_POST['fetch_posts_urls']);
            $fetch_post_type = strip_tags($_POST['post_type']);
            $fetch_post_status = strip_tags($_POST['post_status']);

            if ($fetch_posts_urls) {
                //Default values for vars
                if (!$fetch_post_type) {
                    $fetch_post_type = 'post';
                }

                if (!$fetch_post_status) {
                    $fetch_post_status = 'publish';
                }

                //Fetch URLs
                $fetch_posts_urls_arr = explode("\n", $fetch_posts_urls);

                $fetch_posts_ret_data = [];

                if (!empty($fetch_posts_urls_arr)) {
                    foreach ($fetch_posts_urls_arr as $fetch_posts_url) {
                        // Fetch post using Mercury
                        $wmp_dataArr = ['url' => $fetch_posts_url];

                        $wmp_ch = curl_init();

                        $wmp_data = http_build_query($wmp_dataArr);
                        $wmp_get_url = wmp_mercury_parser_endpoint . "?" . $wmp_data;
                        curl_setopt($wmp_ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                        curl_setopt($wmp_ch, CURLOPT_FOLLOWLOCATION, TRUE);
                        curl_setopt($wmp_ch, CURLOPT_RETURNTRANSFER, TRUE);
                        curl_setopt($wmp_ch, CURLOPT_URL, $wmp_get_url);
                        curl_setopt($wmp_ch, CURLOPT_TIMEOUT, 80);

                        $wmp_ch_response = curl_exec($wmp_ch);
                        $wmp_data = json_decode($wmp_ch_response);
                        curl_close($wmp_data);

                        if (isset($wmp_data->title)) {

                            // Insert post
                            $wmp_title = isset($wmp_data->title) ? $wmp_data->title : '';
                            $wmp_content = isset($wmp_data->content) ? $wmp_data->content : '';
                            $wmp_excerpt = isset($wmp_data->excerpt) ? $wmp_data->excerpt : '';
                            $wmp_date_published = isset($wmp_data->date_published) ? $wmp_data->date_published : '';
                            $wmp_featured_image = isset($wmp_data->lead_image_url) ? $wmp_data->lead_image_url : '';
                            $wmp_direction = isset($wmp_data->direction) ? $wmp_data->direction : '';
                            $wmp_domain = isset($wmp_data->domain) ? $wmp_data->domain : '';
                            $wmp_url = isset($wmp_data->url) ? $wmp_data->url : '';

                            //Check if post exists
                            global $wpdb;

                            $wmp_exists_query = $wpdb->prepare(
                                "SELECT ID FROM $wpdb->posts WHERE `post_title` = %s AND `post_type` = '$fetch_post_type'",
                                $wmp_title
                            );
                            $wmpPostId = $wpdb->query($wmp_exists_query);

                            if (!empty($wmpPostId['ID'])) {

                                $wmpPostId = $wmpPostId['ID'];

                                //Update if it is
                                $wmpPostArgs = array(
                                    'ID' => $wmpPostId,
                                    'post_content' => $wmp_content,
                                    'post_excerpt' => $wmp_excerpt,
                                    'post_status' => $fetch_post_status,
                                );
                                wp_update_post($wmpPostArgs);

                                //Update post meta
                                update_post_meta($wmpPostId, 'wmp_date_published', $wmp_date_published);
                                update_post_meta($wmpPostId, 'wmp_date_direction', $wmp_direction);
                                update_post_meta($wmpPostId, 'wmp_domain', $wmp_domain);
                                update_post_meta($wmpPostId, 'wmp_url', $wmp_url);

                            } else {
                                //Create if it isn't
                                $wmpPostArgs = array(
                                    'post_title' => $wmp_title,
                                    'post_content' => $wmp_content,
                                    'post_status' => $fetch_post_status,
                                    'post_type' => $fetch_post_type,
                                    'post_excerpt' => $wmp_excerpt,
                                );

                                $wmpPostId = wp_insert_post($wmpPostArgs);

                                //Create post meta
                                add_post_meta($wmpPostId, 'wmp_date_published', $wmp_date_published, true);
                                add_post_meta($wmpPostId, 'wmp_date_direction', $wmp_direction, true);
                                add_post_meta($wmpPostId, 'wmp_domain', $wmp_domain, true);
                                add_post_meta($wmpPostId, 'wmp_url', $wmp_url, true);
                            }

                            if ($wmpPostId) {

                                //Add and assign featured image
                                if ($wmp_featured_image) {
                                    $add_featured_image = $wmpHelpers->wmp_fetch_add_featured_image($wmpPostId, $wmp_featured_image);
                                }

                                $wmp_data_temp = [];
                                $wmp_data_temp['p_id'] = $wmpPostId;
                                $wmp_data_temp['p_data'] = $wmp_data;

                                $fetch_posts_ret_data[] = $wmp_data_temp;
                            }
                        }
                    }

                    if (!empty($fetch_posts_ret_data)) {
                        $result['status'] = "success";
                        $result['wmp_fetch_urls'] = $fetch_posts_urls_arr;
                        $result['wmp_fetch_data'] = $fetch_posts_ret_data;
                    } else {
                        $result['status'] = "warning";
                        if (wmp_custom_endpoint) {
                            $result['error_type'] = "empty_invalid_api_response";
                        } else {
                            $result['error_type'] = "empty_api_response";
                        }
                    }
                } else {
                    $result['status'] = "error";
                    $result['error_type'] = "missing_urls_obj";
                }
            } else {
                $result['status'] = "error";
                $result['error_type'] = "missing_urls";
            }

            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                $result = json_encode($result);
                echo $result;
            } else {
                header("Location: " . $_SERVER["HTTP_REFERER"]);
            }
            wp_die();
        } else {
            exit("Invalid request");
        }
    }

    public function __construct()
    {
        add_action('wp_ajax_wmp_fetch_posts', array( &$this, 'wmp_fetch_posts' ));

        parent::__construct();
    }
}
