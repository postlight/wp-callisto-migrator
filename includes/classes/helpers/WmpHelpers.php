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

    public function wmp_insert_log($args)
    {
        $genStatus = [];

        if (is_array($args)) {
            global $wpdb;

            $createLog = $wpdb->insert(
                wmp_logs_table,
                array(
                    'action' => $args['action'],
                    'post_type' => $args['post_type'],
                    'post_id' => $args['post_id'],
                    'status' => $args['status'],
                    'created_by' => $this->wmp_get_current_user_id(),
                    'created_at' => $this->wmp_get_current_date_time(),
                )
            );

            if ($createLog) {
                $genStatus['status'] = 'success';
                $genStatus['action'] = 'insert';
            } else {
                $genStatus['status'] = 'fail';
                $genStatus['action'] = 'insert';
            }

            $genStatus['obj'] = $createLog;
            $genStatus['insert_log_id'] = $wpdb->insert_id;

        } else {
            $genStatus['status'] = 'fail';
            $genStatus['action'] = 'field_check';
            $genStatus['obj'] = $args;
        }

        return $genStatus;
    }
}
