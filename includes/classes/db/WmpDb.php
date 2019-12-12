<?php
/**
 * Db
 *
 * @package WmpDb
 * @developer  Postlight <http://postlight.com>
 * @version 1.0
 *
 */
if (!defined('ABSPATH')) {
    exit;
}

/** Exit if accessed directly */
class WmpDb extends WmpBase
{
    /** Create DB tables*/
    public function wmp_db_create_tables()
    {
        global $wpdb;

        /** Logging table */
        $wmp_logging_table_name = wmp_mercury_parser_logs_table;
        if ($wpdb->get_var("show tables like '$wmp_logging_table_name'") !== $wmp_logging_table_name) {

            require_once ABSPATH . 'wp-admin/includes/upgrade.php';

            $charset_collate = $wpdb->get_charset_collate();
            $sql = "CREATE TABLE " . $wmp_logging_table_name . "
(id mediumint(255) NOT NULL AUTO_INCREMENT,
action text DEFAULT NULL,
post_type varchar(255) DEFAULT NULL,
post_id int(255) DEFAULT 0,
status tinyint(9) DEFAULT 0,
created_by text DEFAULT NULL,
created_at text DEFAULT NULL,
UNIQUE KEY id (id)) ENGINE=InnoDB $charset_collate;";

            dbDelta($sql);

        }
    }

    public function __construct()
    {
        add_action('init', array(&$this, 'wmp_db_create_tables'));

        parent::__construct();
    }
}
