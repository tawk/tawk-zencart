<?php
/**
* @package tawk.to
* @copyright Copyright 2021 tawk.to
* @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
* @version 1.1.0
*/

require('includes/application_top.php');

$tawk_widget_current_values = array(
    'page_id' => zen_get_configuration_key_value(TAWK_TO_PAGE_ID_FIELD),
    'widget_id' => zen_get_configuration_key_value(TAWK_TO_WIDGET_ID_FIELD)
);

//zen cart returns span with error message if configuration key can't be found
if (strpos($tawk_widget_current_values['page_id'], '<') === 0) {
    $tawk_widget_current_values['page_id'] = '';
    $tawk_widget_current_values['widget_id'] = '';
}
?>

<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script type="text/javascript" src="<?php echo TAWK_TO_WIDGET_BASE_URL ?>/public/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript">
function init()
{
    cssjsmenu('navbar');
    if (document.getElementById) {
        var kill = document.getElementById('hoverJS');
        kill.disabled = true;
    }
}
</script>

</head>
<body onload="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<div style="width:100%; height: 100%; margin: 10px auto">
<iframe id="tawkIframe" src="" style="width:100%; height: 100%; border: none"></iframe>
</div>
<script type="text/javascript">
var currentHost = window.location.protocol + "//" + window.location.host;
var url = "<?php echo TAWK_TO_WIDGET_BASE_URL ?>/generic/widgets?currentWidgetId=<?php echo $tawk_widget_current_values['widget_id'] ?>&currentPageId=<?php echo $tawk_widget_current_values['page_id']?>&pltf=zencart&parentDomain=" + currentHost;

jQuery('#tawkIframe').attr('src', url);

var iframe = jQuery('#tawk_widget_customization')[0];

window.addEventListener('message', function(e) {
    if (e.origin === '<?php echo TAWK_TO_WIDGET_BASE_URL ?>') {

        if(e.data.action === 'setWidget') {
            setWidget(e);
        }

        if(e.data.action === 'removeWidget') {
            removeWidget(e);
        }

        if(e.data.action === 'reloadHeight') {
            reloadIframeHeight(e.data.height);
        }
    }
});

function setWidget(e) {
    jQuery.post('tawk_to_widget_manager.php?actionType=set', {
        page_id : e.data.pageId,
        widget_id : e.data.widgetId
    }, function(r) {
        if (r.success) {
            e.source.postMessage({action: 'setDone'}, '<?php echo TAWK_TO_WIDGET_BASE_URL ?>');
        } else {
            e.source.postMessage({action: 'setFail'}, '<?php echo TAWK_TO_WIDGET_BASE_URL ?>');
        }

    });
}

function removeWidget(e) {
    jQuery.post('tawk_to_widget_manager.php?actionType=remove', {}, function(r) {
        if (r.success) {
            e.source.postMessage({action: 'removeDone'}, '<?php echo TAWK_TO_WIDGET_BASE_URL ?>');
        } else {
            e.source.postMessage({action: 'removeFail'}, '<?php echo TAWK_TO_WIDGET_BASE_URL ?>');
        }
    });
}

function reloadIframeHeight(height) {
    if (!height) {
        return;
    }

    var iframe = jQuery('#tawkIframe');
    if (height === iframe.height()) {
        return;
    }

    iframe.height(height);
}
</script>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
