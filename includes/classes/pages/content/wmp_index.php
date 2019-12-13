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
    $wmpHelper = new WmpHelpers();
    $wmp_fetch_posts_nonce = wp_create_nonce("wmp_fetch_posts");
    $wmp_fetch_posts_ajax_url = admin_url('admin-ajax.php?action=wmp_fetch_posts');
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

                                <div class="inside">
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
                                    <input
                                            id="wmp_fetch_posts"
                                            class="button-secondary" type="submit"
                                            value="<?php esc_attr_e('Fetch And Preview Posts'); ?>"/>

                                    <div class="wmp_spinner spinner is-active" style="
                                float:none;
                                width:auto;
                                height:auto;
                                padding:10px 0 10px 50px;
                                display: none;
                                background-position:20px 0;">
                                    </div>

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

                    </div>
                    <!-- post-body-content -->


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

                //General variables
                var $notice = jQuery('.wmp_notice');
                var $spinner = jQuery('.wmp_spinner');

                //Reset
                wmp_reset_notices();

                //Action variables
                var $this = jQuery(this);
                var $nonce = jQuery('#wmp_fetch_posts_nonce').val();
                var $ajax_url = jQuery('#wmp_fetch_posts_ajax_url').val();
                var $fetch_posts_urls = jQuery('#wmp_urls_field').val();

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
                    wmp_return_notice('An error occurred, please refresh to try again or contact us at https://postlight.com/contact', 'notice-error');
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
                        fetch_posts_urls: $fetch_posts_urls
                    },
                    success: function (response) {
                        if (response.status === "success") {
                            //Return notice
                            wmp_return_notice('Post(s) successfully fetched, please preview it below before importing:', 'notice-success');

                            //Reset Vals
                            jQuery('#wmp_urls_field').val('');

                            //Enable btn
                            $this.removeClass('wmp_disabled');
                        } else {
                            //Return notice
                            wmp_return_notice('An error occurred, please refresh to try again or contact us at https://postlight.com/contact', 'notice-error');
                        }
                    },
                    error: function () {
                        //Return notice
                        wmp_return_notice('An error occurred, please refresh to try again or contact us at https://postlight.com/contact', 'notice-error');
                    }
                });
            });

            //Helpers
            function wmp_reset_notices() {
                //General Variables
                var $notice = jQuery('.wmp_notice');
                var $notice_alt = jQuery('.wmp_notice_alt');
                var $spinner = jQuery('.wmp_spinner');

                //Reset
                $notice.find('p').html('');
                $notice.removeClass('notice-error');
                $notice.removeClass('notice-warning');
                $notice.removeClass('notice-success');


                $notice_alt.find('p').html('');
                $notice_alt.removeClass('notice-error');
                $notice_alt.removeClass('notice-warning');
                $notice_alt.removeClass('notice-success');

                $notice.slideUp('fast');

                $notice_alt.slideUp('fast');

                $spinner.slideUp('fast');
            }

            function wmp_return_notice($msg, $notice_type, $alt=false) {
                //General Variables
                var $spinner = jQuery('.wmp_spinner');
                var $notice = jQuery('.wmp_notice');

                if($alt){
                    $notice = jQuery('.wmp_notice_alt');
                }

                if ($msg && $notice_type) {
                    $notice.find('p').html($msg);
                    $notice.addClass($notice_type);
                    $notice.slideDown('fast');
                    if(!$alt){
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
                    if (wmp_validate_url($splitval[$a])) {
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
                    wmp_return_notice('Your input contains invalid URL(s), it\'s been ignored', 'notice-warning',true);
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
        $fetch_posts_urls = $_POST['fetch_posts_urls'];
        if ($fetch_posts_urls) {
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

                    $fetch_posts_ret_data[] = $wmp_data;
                }

                if (!empty($fetch_posts_ret_data)) {
                    $result['status'] = "success";
                    $result['wmp_fetch_urls'] = $fetch_posts_urls_arr;
                    $result['wmp_fetch_data'] = $fetch_posts_ret_data;
                } else {
                    $result['status'] = "warning";
                    $result['error_type'] = "empty_api_response";
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
