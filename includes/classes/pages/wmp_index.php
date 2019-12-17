<?php
/**
 * Main page
 *
 * @package   Wmp
 * @developer Postlight <http://postlight.com>
 * @version   1.0
 */
function Wmp_index()
{
    $wmp_fetch_posts_nonce = wp_create_nonce('wmp_fetch_posts');
    $wmp_fetch_posts_ajax_url = admin_url('admin-ajax.php?action=wmp_fetch_posts');
    $wmp_post_types = get_post_types(
        array(
            'public' => true,
            '_builtin' => false,
        ),
        'names',
        'and'
    );
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
                                    <span>
                                        <?php
                                        esc_attr_e(
                                            'Create WordPress posts 
                                                from any other website',
                                            'wpMercuryParser'
                                        );
                                        ?>
                                    </span>
                                </h2>

                                <div class="inside">
                                    <p>
                                        <?php
                                        esc_attr_e(
                                            'Add external link(s)
                                         to start creating posts: 
                                        (max 5 URLs per attempt)',
                                            'wpMercuryParser'
                                        );
                                        ?>
                                    </p>

                                    <input type="hidden" id="wmp_fetch_posts_nonce"
                                           value="<?php echo $wmp_fetch_posts_nonce; ?>">
                                    <input type="hidden" id="wmp_fetch_posts_ajax_url"
                                           value="<?php echo $wmp_fetch_posts_ajax_url; ?>">

                                    <textarea id="wmp_urls_field" name="wmp_urls_field" cols="80" rows="10"
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
                        <div id="wmp_to_scroll" class="poststuff wmp_generated_posts" style="display: none">

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

                                <h2><span>
                                <?php
                                esc_attr_e(
                                    'Posts Fields:',
                                    'wpMercuryParser'
                                );
                                ?>
                                        </span></h2>

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
                                                <?php
                                                esc_attr_e(
                                                    'Title',
                                                    'wpMercuryParser'
                                                );
                                                ?>
                                            </label>
                                        </td>
                                        <td>
                                            <?php esc_attr_e('Default', 'wpMercuryParser'); ?>
                                        </td>
                                    </tr>
                                    <tr class="alternate">
                                        <td class="row-title">
                                            <label for="tablecell">
                                                <?php
                                                esc_attr_e(
                                                    'Content',
                                                    'wpMercuryParser'
                                                );
                                                ?>
                                            </label>
                                        </td>
                                        <td><?php esc_attr_e('Default', 'wpMercuryParser'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="row-title"><label for="tablecell">
                                                <?php
                                                esc_attr_e(
                                                    'Excerpt',
                                                    'wpMercuryParser'
                                                );
                                                ?>
                                            </label></td>
                                        <td><?php esc_attr_e('Default', 'wpMercuryParser'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="row-title"><label for="tablecell">
                                                <?php
                                                esc_attr_e(
                                                    'Featured Image',
                                                    'wpMercuryParser'
                                                );
                                                ?>
                                            </label></td>
                                        <td><?php esc_attr_e('Default', 'wpMercuryParser'); ?></td>
                                    </tr>
                                    <tr class="alternate">
                                        <td class="row-title"><label for="tablecell">
                                                <?php
                                                esc_attr_e(
                                                    'URL',
                                                    'wpMercuryParser'
                                                );
                                                ?>
                                            </label></td>
                                        <td><?php esc_attr_e('Custom Field', 'wpMercuryParser'); ?></td>
                                    <tr>
                                    <tr class="alternate">
                                        <td class="row-title"><label for="tablecell">
                                                <?php
                                                esc_attr_e(
                                                    'Source',
                                                    'wpMercuryParser'
                                                );
                                                ?>
                                            </label></td>
                                        <td><?php esc_attr_e('Custom Field', 'wpMercuryParser'); ?></td>
                                    </tr>
                                    <tr class="alternate">
                                        <td class="row-title"><label for="tablecell">
                                                <?php
                                                esc_attr_e(
                                                    'Direction',
                                                    'wpMercuryParser'
                                                );
                                                ?>
                                            </label></td>
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
    </div>
    <?php
}
