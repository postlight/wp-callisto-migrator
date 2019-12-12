<?php
/**
 * Logs page
 *
 * @package Wmp
 * @developer  Postlight <http://postlight.com>
 * @version 1.0
 *
 */

function wmp_logs()
{

    global $wpdb;

    $rows_per_page = 20;

    if (isset($_GET['pj'])) {
        $pageno = $_GET['pj'];
    } else {
        $pageno = 1;
    }

    $s1 = "select id from " . wmp_mercury_parser_logs_table . " order by id desc ";
    $s = "select * from " . wmp_mercury_parser_logs_table . " order by id desc ";

    $limit = 'LIMIT ' . ($pageno - 1) * $rows_per_page . ',' . $rows_per_page;

    $r = $wpdb->get_results($s1);

    $nr = count($r);
    $lastpage = ceil($nr / $rows_per_page);

    $r = $wpdb->get_results($s . $limit);

    ?>
    <div class="wrap wmp_page wmp_plugin_options wmp_folders_fetcher wmp_table container">
        <h1>Logs</h1>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
						<?php
if ($nr > 0):
    ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Action</th>
                                        <th>Post Type</th>
                                        <th>Post</th>
                                        <th>Status</th>
                                        <th>User</th>
                                        <th>Created At</th>
                                    </tr>
                                    </thead>
                                    <tbody>
									<?php
foreach ($r as $row):
    ?>
                                        <tr>
                                            <td>
												<?php
echo $row->id;
    ?>
                                            </td>
                                            <td>
												<?php
echo $row->action;
    ?>
											</td>
											<td>
												<?php
echo $row->post_type;
    ?>
											</td>
											<td>
												<?php
echo $row->post_id;
    ?>
                                            </td>
                                            <td>
												<?php
if ($row->status) {
        echo "SUCCESS";
    } else {
        echo "ERROR";
    }
    ?>
                                            </td>
                                            <td>
												<?php
$user = get_user_by('id', $row->created_by);
    echo $user->user_login;
    ?>
                                            </td>
                                            <td>
												<?php
echo $row->created_at;
    ?>
                                            </td>
                                        </tr>
									<?php
endforeach;
    ?>
                                    </tbody>
                                </table>
                            </div>
                            <ul class="pagination">
								<?php
for ($i = 1; $i <= $lastpage; $i++) {
        ?>
                                    <li<?php if ($i == $pageno): echo " class='active'";endif;?>>
                                        <a href="<?php echo get_bloginfo('siteurl'); ?>/wp-admin/admin.php?page=wmp_logs&pj=<?php echo $i; ?>">
											<?php echo $i; ?>
                                        </a>
                                    </li>
									<?php
}
    ?>
                            </ul>
						<?php
else:
    ?>
                            <h4>No logs, yet</h4>
						<?php
endif;
    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php
}
