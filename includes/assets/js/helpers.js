//Helpers functions
function wmp_reset_notices()
{
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

function wmp_return_notice($msg, $notice_type, $alt = false)
{
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

function wmp_show_spinner()
{
    var $spinner = jQuery('.wmp_spinner');
    $spinner.slideDown('fast');
}

function wmp_validate_url(url)
{
    return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
}

function wmp_verify_urls()
{
    var $value = '';
    var $splitval = jQuery('#wmp_urls_field').val().split("\n");
    var has_invalid_urls = false;

    for (var $a = 0; typeof $splitval[$a] != 'undefined'; $a++) {
        //Check valid + duplicate URLs
        if (wmp_validate_url($splitval[$a]) && !$value.includes($splitval[$a])) {
            if ($a > 0) {
                $value += "\n";
            }
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