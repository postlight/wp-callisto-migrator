<?php
/**
 * Main page
 *
 * @package Wmp
 * @developer Postlight <http://postlight.com>
 * @version 1.0
 *
 */

function wmp_index()
{
    $wmp_fetch_posts_nonce = wp_create_nonce("wmp_fetch_posts");
    $wmp_fetch_posts_ajax_url = admin_url('admin-ajax.php?action=wmp_fetch_posts');
    $wmp_post_types = get_post_types([
        'public' => true,
        '_builtin' => false,
    ], 'names', 'and');

    ?>
    <div class="wmp_page wmp_index">
        <div class="wrap">

            <div id="icon-options-general" class="icon32"></div>
            <h1><?php esc_attr_e('WP Mercury Parser', 'wpMercuryParser'); ?></h1>

            <div id="poststuff">

                <div id="post-body" class="metabox-holder columns-2">

                    <!-- main content -->
                    <div id="post-body-content">

                        <div class="meta-box-sortables ui-sortable">

                            <div class="postbox">

                                <h2>
                                    <span><?php esc_attr_e('Create WordPress posts from any other website', 'wpMercuryParser'); ?></span>
                                </h2>

                                <div class="inside" id="wmp_to_scroll">
                                    <p><?php esc_attr_e(
                                            'Add external link(s) to start creating posts: (max 5 URLs per attempt)',
                                            'wpMercuryParser'
                                        ); ?></p>

                                    <input type="hidden" id="wmp_fetch_posts_nonce"
                                           value="<?php echo $wmp_fetch_posts_nonce; ?>">
                                    <input type="hidden" id="wmp_fetch_posts_ajax_url"
                                           value="<?php echo $wmp_fetch_posts_ajax_url; ?>">

                                    <textarea id="wmp_urls_field" name="" cols="80" rows="10"
                                              class="wmp_urls"></textarea>

                                    <br>

                                    <?php
                                    if (!empty($wmp_post_types)) {
                                        ?>
                                        <p>
                                            <b>Posts Type:</b>
                                        </p>
                                        <select id="wmp_post_type">
                                            <option selected="selected" value="post">Post (default)</option>
                                            <?php
                                            foreach ($wmp_post_types as $wmp_post_type) {
                                                ?>
                                                <option value="<?php echo $wmp_post_type; ?>">
                                                    <?php echo $wmp_post_type; ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <br>
                                        <br>
                                        <?php
                                    }
                                    ?>

                                    <p>
                                        <b>Posts Status:</b>
                                    </p>

                                    <select id="wmp_post_status">
                                        <option selected="selected" value="publish">Publish</option>
                                        <option value="draft">Draft</option>
                                    </select>

                                    <br>
                                    <br>

                                    <input
                                            id="wmp_fetch_posts"
                                            class="button-secondary" type="submit"
                                            value="<?php esc_attr_e('Fetch And Create Posts'); ?>"/>

                                    <div class="wmp_spinner spinner is-active" style="
                                float:none;
                                width:auto;
                                height:auto;
                                padding:10px 0 10px 50px;
                                display: none;
                                background-position:20px 0;">
                                    </div>


                                    <br>
                                    <br>

                                    <div
                                            style="display: none"
                                            class="wmp_notice_alt notice inline">
                                        <p>
                                        </p>
                                    </div>

                                    <div
                                            style="display: none"
                                            class="wmp_notice notice inline">
                                        <p>
                                        </p>
                                    </div>
                                </div>
                                <!-- .inside -->

                            </div>
                            <!-- .postbox -->

                        </div>
                        <!-- .meta-box-sortables .ui-sortable -->

                        <!-- generated-posts-content -->
                        <div class="poststuff wmp_generated_posts" style="display: none">

                            <h1><?php esc_attr_e('Fetched And Created/Updated Posts', 'wpMercuryParser'); ?></h1>

                            <div class="post-body metabox-holder wmp_generated_to_clone" style="display: none">
                                <!-- main content -->
                                <div class="post-body-content">
                                    <div class="meta-box-sortables">
                                        <div class="postbox">
                                            <button type="button"
                                                    class="handlediv wmp_rotate wmp_post_toggle wmp_post_btn"
                                                    aria-expanded="true">
                                                <span class="screen-reader-text">Toggle panel</span>
                                                <span class="toggle-indicator" aria-hidden="true"></span>
                                            </button>
                                            <!-- Toggle -->

                                            <h2 class="wmp_post_fetched_title">
                                                <span></span>
                                            </h2>

                                            <div class="inside wmp_post_fetched_excerpt" style="display: none">
                                                <p></p>
                                            </div>
                                            <!-- .inside -->
                                        </div>
                                        <!-- .postbox -->
                                    </div>
                                    <!-- .meta-box-sortables .ui-sortable -->
                                </div>
                                <!-- post-body-content -->
                            </div>

                            <div class="wmp_generated_cloned_posts" style="display: none">

                            </div>

                            <br class="clear">
                        </div>
                        <!-- #poststuff -->

                    </div>

                    <!-- sidebar -->
                    <div id="postbox-container-1" class="postbox-container">

                        <div class="meta-box-sortables">

                            <div class="postbox">

                                <h2><span><?php esc_attr_e(
                                            'Posts Fields:', 'wpMercuryParser'
                                        ); ?></span></h2>

                                <table class="widefat">
                                    <thead>
                                    <tr>
                                        <th class="row-title"><?php esc_attr_e('Field', 'wpMercuryParser'); ?></th>
                                        <th><?php esc_attr_e('Field Type', 'wpMercuryParser'); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="row-title">
                                            <label for="tablecell">
                                                <?php esc_attr_e(
                                                    'Title', 'wpMercuryParser'
                                                ); ?>
                                            </label>
                                        </td>
                                        <td>
                                            <?php esc_attr_e('Default', 'wpMercuryParser'); ?>
                                        </td>
                                    </tr>
                                    <tr class="alternate">
                                        <td class="row-title">
                                            <label for="tablecell">
                                                <?php esc_attr_e(
                                                    'Content', 'wpMercuryParser'
                                                ); ?>
                                            </label>
                                        </td>
                                        <td><?php esc_attr_e('Default', 'wpMercuryParser'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="row-title"><label for="tablecell"><?php esc_attr_e(
                                                    'Featured Image', 'wpMercuryParser'
                                                ); ?></label></td>
                                        <td><?php esc_attr_e('Default', 'wpMercuryParser'); ?></td>
                                    </tr>
                                    <tr class="alternate">
                                        <td class="row-title"><label for="tablecell"><?php esc_attr_e(
                                                    'URL', 'wpMercuryParser'
                                                ); ?></label></td>
                                        <td><?php esc_attr_e('Custom Field', 'wpMercuryParser'); ?></td>
                                    <tr>
                                    <tr class="alternate">
                                        <td class="row-title"><label for="tablecell"><?php esc_attr_e(
                                                    'Source', 'wpMercuryParser'
                                                ); ?></label></td>
                                        <td><?php esc_attr_e('Custom Field', 'wpMercuryParser'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="row-title"><label for="tablecell"><?php esc_attr_e(
                                                    'Excerpt', 'wpMercuryParser'
                                                ); ?></label></td>
                                        <td><?php esc_attr_e('Custom Field', 'wpMercuryParser'); ?></td>
                                    </tr>
                                    <tr class="alternate">
                                        <td class="row-title"><label for="tablecell"><?php esc_attr_e(
                                                    'Direction', 'wpMercuryParser'
                                                ); ?></label></td>
                                        <td><?php esc_attr_e('Custom Field', 'wpMercuryParser'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="row-title"><label for="tablecell"><?php esc_attr_e(
                                                    'Word Count', 'wpMercuryParser'
                                                ); ?></label></td>
                                        <td><?php esc_attr_e('Custom Field', 'wpMercuryParser'); ?></td>
                                    </tr>
                                    <tbody>
                                    <tfoot>
                                    <tr>
                                        <th class="row-title"><?php esc_attr_e('Field', 'wpMercuryParser'); ?></th>
                                        <th><?php esc_attr_e('Field Type', 'wpMercuryParser'); ?></th>
                                    </tr>
                                    </tfoot>
                                </table>

                            </div>
                            <!-- .postbox -->

                        </div>
                        <!-- .meta-box-sortables -->

                    </div>
                    <!-- #postbox-container-1 .postbox-container -->

                </div>
                <!-- #post-body .metabox-holder .columns-2 -->

                <br class="clear">
            </div>
            <!-- #poststuff -->

        </div> <!-- .wrap -->
        <script type="text/javascript">
            jQuery(document).ready(function () {
                //Limit to # of rows in textarea or arbitrary # of rows
                jQuery('#wmp_urls_field').bind('change keyup', function (event) {
                    var $rows = 5;
                    var $value = '';
                    var $splitval = jQuery(this).val().split("\n");

                    //Reset notices
                    wmp_reset_notices();

                    for (var $a = 0; $a < $rows && typeof $splitval[$a] != 'undefined'; $a++) {
                        if ($a > 0) $value += "\n";
                        $value += $splitval[$a];
                    }

                    //Append URLs
                    jQuery(this).val($value);

                    //Check URLs count
                    if ($splitval.length > $rows) {
                        //Return notice
                        wmp_return_notice('Only 5 lines per attempt are allowed, additional ones were ignored', 'notice-warning');
                    }
                });
            });

            jQuery('#wmp_fetch_posts').on('click', function (e) {
                e.preventDefault();

                //Reset
                wmp_reset_notices();

                //Action variables
                var $this = jQuery(this);
                var $nonce = jQuery('#wmp_fetch_posts_nonce').val();
                var $ajax_url = jQuery('#wmp_fetch_posts_ajax_url').val();
                var $fetch_posts_urls = jQuery('#wmp_urls_field').val();
                var $post_type = jQuery('#wmp_post_type').val();
                var $post_status = jQuery('#wmp_post_status').val();

                //Show spinner
                wmp_show_spinner();
                $this.addClass('wmp_disabled');

                //Verify URLs input
                if (!$fetch_posts_urls) {
                    //Return notice
                    wmp_return_notice('You need to add some URL(s) before fetching', 'notice-error');

                    //Enable btn
                    $this.removeClass('wmp_disabled');
                    return;
                }

                //Verify URLs type
                wmp_verify_urls();

                //Recheck verified URLs
                $fetch_posts_urls = jQuery('#wmp_urls_field').val();
                if (!$fetch_posts_urls) {
                    //Return notice
                    wmp_return_notice('You need to add some valid URL(s) before fetching', 'notice-error');

                    //Enable btn
                    $this.removeClass('wmp_disabled');
                    return;
                }

                //Verify nonce and ajax URL
                if (!$nonce || !$ajax_url) {
                    //Return notice
                    wmp_return_notice('An error occurred, please refresh to try again or contact us at https://postlight.com/#contact-us', 'notice-error');
                    return;
                }

                //Fetch posts through AJAX
                jQuery.ajax({
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
                        if (response.status === "success") {
                            //Return notice
                            wmp_return_notice('Post(s) successfully fetched and created/updated, additional details below:', 'notice-success');

                            //Reset Vals
                            jQuery('#wmp_urls_field').val('');

                            //Enable btn
                            $this.removeClass('wmp_disabled');

                            //Show fetched posts
                            var $counter = 0;
                            jQuery.each(response.wmp_fetch_data, function (index, res) {
                                var $wmp_pid = res.p_id;
                                var $wmp_ptitle = res.p_data.title;
                                var $wmp_pexcerpt = res.p_data.content;

                                //Clone preview from origin
                                var $wmp_to_clone = jQuery('.wmp_generated_to_clone').clone();
                                var $wmp_clone_container = jQuery('.wmp_generated_cloned_posts');

                                $counter++;

                                //Fields
                                var $wmp_post_link = '<a class="wmp_post_fetched_view_link" href="/wp-admin/post.php?post=' + $wmp_pid + '&action=edit" target="_blank">(View Post)</a>';

                                $wmp_to_clone.find('.wmp_post_fetched_title').html($counter + '- ' + $wmp_ptitle + ' ' + $wmp_post_link);
                                $wmp_to_clone.find('.wmp_post_fetched_excerpt').html($wmp_pexcerpt);
                                $wmp_to_clone.css('display', 'block');
                                $wmp_to_clone.removeClass('wmp_generated_to_clone');
                                $wmp_clone_container.append($wmp_to_clone);
                                $wmp_clone_container.slideDown('fast');
                            });

                            //Show cont
                            jQuery('.wmp_generated_posts').slideDown('fast');

                            //Scroll to section
                            jQuery('html, body').animate({
                                scrollTop: jQuery("#wmp_to_scroll").offset().top - 20
                            }, 800);
                        } else if (response.status === 'warning') {
                            if (response.error_type === 'empty_invalid_api_response') {
                                //Return notice
                                wmp_return_notice('Your custom endpoint didn\'t return any data, are you sure it\'s setup correctly?', 'notice-warning');
                            } else {
                                //Return notice
                                wmp_return_notice('Couldn\'t fetch data from entered URl(s)', 'notice-warning');
                            }
                        } else {
                            wmp_return_notice('An error occurred, please refresh to try again or contact us at https://postlight.com/#contact-us', 'notice-error');
                        }
                    },
                    error: function () {
                        //Return notice
                        wmp_return_notice('An error occurred, please refresh to try again or contact us at https://postlight.com/#contact-us', 'notice-error');
                    }
                });
            });

            //Toggle fetched posts accordian
            jQuery(document).on('click', '.wmp_post_toggle', function (e) {
                e.preventDefault();

                jQuery(this).closest('.postbox').find('.wmp_post_fetched_excerpt').toggle();
                jQuery(this).toggleClass('wmp_rotate');
            });

            //Helpers
            function wmp_reset_notices() {
                //General Variables
                var $notice = jQuery('.wmp_notice');
                var $notice_alt = jQuery('.wmp_notice_alt');
                var $spinner = jQuery('.wmp_spinner');
                var $cloneCont = jQuery('.wmp_generated_posts');
                var $clonePostst = jQuery('.wmp_generated_cloned_posts');

                //Reset Notices
                $notice.find('p').html('');
                $notice.removeClass('notice-error');
                $notice.removeClass('notice-warning');
                $notice.removeClass('notice-success');

                $notice_alt.find('p').html('');
                $notice_alt.removeClass('notice-error');
                $notice_alt.removeClass('notice-warning');
                $notice_alt.removeClass('notice-success');

                //Reset clone stuff
                $clonePostst.html('');

                $notice.slideUp('fast');
                $notice_alt.slideUp('fast');
                $cloneCont.slideUp('fast');
                $spinner.slideUp('fast');

            }

            function wmp_return_notice($msg, $notice_type, $alt = false) {
                //General Variables
                var $spinner = jQuery('.wmp_spinner');
                var $notice = jQuery('.wmp_notice');

                if ($alt) {
                    $notice = jQuery('.wmp_notice_alt');
                }

                if ($msg && $notice_type) {
                    $notice.find('p').html($msg);
                    $notice.addClass($notice_type);
                    $notice.slideDown('fast');
                    if (!$alt) {
                        $spinner.slideUp('fast');
                    }
                }
            }

            function wmp_show_spinner() {
                var $spinner = jQuery('.wmp_spinner');
                $spinner.slideDown('fast');
            }

            function wmp_validate_url(url) {
                return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
            }

            function wmp_verify_urls() {
                var $value = '';
                var $splitval = jQuery('#wmp_urls_field').val().split("\n");
                var has_invalid_urls = false;

                for (var $a = 0; typeof $splitval[$a] != 'undefined'; $a++) {
                    //Check valid + duplicate URLs
                    if (wmp_validate_url($splitval[$a]) && !$value.includes($splitval[$a])) {
                        if ($a > 0) $value += "\n";
                        $value += $splitval[$a];
                    } else {
                        has_invalid_urls = true;
                    }
                }

                //Append URLs
                jQuery("#wmp_urls_field").val($value);

                //Check invalid URLs
                if (has_invalid_urls) {
                    //Return notice
                    wmp_return_notice('Your input contains invalid or duplicate URL(s), it\'s been ignored', 'notice-warning', true);
                }

            }
        </script>
    </div>
    <?php
}

//Ajax fetch posts
add_action('wp_ajax_wmp_fetch_posts', 'wmp_fetch_posts');
function wmp_fetch_posts()
{
    if (!wp_verify_nonce($_REQUEST['nonce'], "wmp_fetch_posts")) {
        exit("Invalid request");
    }
    if ($_POST['action'] == "wmp_fetch_posts") {
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
                        $wmp_direction = isset($wmp_data->direction) ? $wmp_data->direction : '';
                        $wmp_domain = isset($wmp_data->domain) ? $wmp_data->domain : '';
                        $wmp_url = isset($wmp_data->url) ? $wmp_data->url : '';
                        $wmp_word_count = isset($wmp_data->word_count) ? $wmp_data->word_count : '';

                        $wmp_title_sanitized = sanitize_title($wmp_title);

                        //Check if post exists
                        global $wpdb;

                        $wmp_exists_query = $wpdb->prepare(
                            "SELECT ID FROM $wpdb->posts WHERE `post_title` = %s AND `post_type` = '$fetch_post_type'",
                            $wmp_title
                        );
                        $wmpPostId = $wpdb->query($wmp_exists_query);

                        if ($wmpPostId) {

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
                            update_post_meta($wmpPostId, 'wmp_word_count', $wmp_word_count);

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
                            add_post_meta($wmpPostId, 'wmp_word_count', $wmp_word_count, true);
                        }

                        if ($wmpPostId) {
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
