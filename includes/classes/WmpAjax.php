<?php
/**
 * Ajax Functions
 *
 * @package   WmpAjax
 * @developer Postlight <http://postlight.com>
 * @version   1.0
 */
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Exit if accessed directly
 */
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
                        // Fetch post using Mercury Parser API
                        $wmp_data = $wmpHelpers->wmp_fetch_post_data($fetch_posts_url);

                        if ((isset($wmp_data['status']) && $wmp_data['status'] == 'success') && (isset($wmp_data['data']->title))) {

                            // Fetch posts fields
                            $wmp_title = isset($wmp_data['data']->title) ? $wmp_data['data']->title : '';
                            $wmp_content = isset($wmp_data['data']->content) ? $wmp_data['data']->content : '';
                            $wmp_excerpt = isset($wmp_data['data']->excerpt) ? $wmp_data['data']->excerpt : '';
                            $wmp_date_published = isset($wmp_data['data']->date_published) ? $wmp_data['data']->date_published : '';
                            $wmp_featured_image = isset($wmp_data['data']->lead_image_url) ? $wmp_data['data']->lead_image_url : '';
                            $wmp_direction = isset($wmp_data['data']->direction) ? $wmp_data['data']->direction : '';
                            $wmp_domain = isset($wmp_data['data']->domain) ? $wmp_data['data']->domain : '';
                            $wmp_url = isset($wmp_data['data']->url) ? $wmp_data['data']->url : '';

                            //Check if post exists
                            global $wpdb;

                            $wmp_exists_query = $wpdb->prepare(
                                "SELECT ID FROM $wpdb->posts WHERE `post_title` = %s AND `post_type` = '$fetch_post_type'",
                                $wmp_title
                            );
                            $wmpPostId = $wpdb->get_results($wmp_exists_query);

                            if (isset($wmpPostId[0]->ID)) {

                                $wmpPostId = $wmpPostId[0]->ID;

                                //Update if it is
                                $wmpPostArgs = array(
                                    'ID' => $wmpPostId,
                                    'post_content' => $wmp_content,
                                    'post_excerpt' => $wmp_excerpt,
                                    'post_status' => $fetch_post_status,
                                );
                                wp_update_post($wmpPostArgs);

                            } else {
                                //Create it if it isn't
                                $wmpPostArgs = array(
                                    'post_title' => $wmp_title,
                                    'post_content' => $wmp_content,
                                    'post_status' => $fetch_post_status,
                                    'post_type' => $fetch_post_type,
                                    'post_excerpt' => $wmp_excerpt,
                                );

                                $wmpPostId = wp_insert_post($wmpPostArgs);
                            }

                            if ($wmpPostId) {

                                //Add and assign featured image
                                if ($wmp_featured_image) {
                                    $wmpHelpers->wmp_fetch_add_featured_image($wmpPostId, $wmp_featured_image);
                                }

                                //Create/Update Posts Meta
                                $wmpHelpers->wmp_create_update_posts_meta($wmpPostId, 'wmp_date_published', $wmp_date_published);
                                $wmpHelpers->wmp_create_update_posts_meta($wmpPostId, 'wmp_date_direction', $wmp_direction);
                                $wmpHelpers->wmp_create_update_posts_meta($wmpPostId, 'wmp_domain', $wmp_domain);
                                $wmpHelpers->wmp_create_update_posts_meta($wmpPostId, 'wmp_url', $wmp_url);

                                $wmp_data_temp = [];
                                $wmp_data_temp['p_id'] = $wmpPostId;
                                $wmp_data_temp['p_data'] = $wmp_data['data'];
                                $wmp_data_temp['p_test'] = $wmpPostId;

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
                        if (WMP_CUSTOM_ENDPOINT) {
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
        add_action('wp_ajax_wmp_fetch_posts', array(&$this, 'wmp_fetch_posts'));

        parent::__construct();
    }
}
