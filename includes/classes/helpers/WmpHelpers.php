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
}
