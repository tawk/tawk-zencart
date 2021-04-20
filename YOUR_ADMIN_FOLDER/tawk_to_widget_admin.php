<?php
/**
* @package tawk.to
* @copyright Copyright 2021 tawk.to
* @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
* @version 1.1.1
*/

require('includes/application_top.php');

$tawk_widget_current_values = array(
    'page_id' => zen_get_configuration_key_value(TAWK_TO_PAGE_ID_FIELD),
    'widget_id' => zen_get_configuration_key_value(TAWK_TO_WIDGET_ID_FIELD),
    'visibility_opts' => zen_get_configuration_key_value(TAWK_TO_VISIBILITY_OPTS_FIELD)
);

$display_opts = null;
if (isset($tawk_widget_current_values['visibility_opts'])
    && !empty($tawk_widget_current_values)) {
    $display_opts = json_decode($tawk_widget_current_values['visibility_opts']);
}

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

<style>
    #module_form .checkbox {
        display: inline-block;
        min-height: 20px;
    }

    @media only screen and (min-width: 1200px) {
        #module_form .checkbox {
            display: block;
        }
    }

    #module_form textarea.form-control {
        width: 100%;
    }
</style>
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
<div id="tawkto" class="container col-lg-12">
    <div id="widget-selection">
        <h1>Select Widget</h1>
        <hr>
        <iframe id="tawkIframe" src="" style="width:100%; height: 275px; border: none"></iframe>
    </div>
    <form id="module_form" class="form-horizontal" method="post">
        <div id="visibility">
            <h1>Visibility Settings</h1>
            <hr>
            <div class="col-lg-9">
                <div class="form-group col-lg-12">
                    <label for="always_display" class="col-xs-9 col-sm-6 control-label">Always show Tawk.To widget on every page</label>
                    <div class="col-xs-3 col-sm-6 control-label">
                        <input type="checkbox" class="checkbox" name="always_display" id="always_display" value="1"
                            <?php
                                $always_display = true; // default value
                                if (!is_null($display_opts) && isset($display_opts->always_display)) {
                                    $always_display = $display_opts->always_display;
                                }

                                if ($always_display) :
                            ?>
                            checked
                            <?php endif ?>
                        />
                    </div>
                </div>
                <div class="form-group col-lg-12">
                    <label for="hide_oncustom" class="col-sm-6 control-label">Except on pages:</label>
                    <div class="col-sm-6 control-label">
                        <?php
                            if (!is_null($display_opts) &&
                                isset($display_opts->hide_oncustom) &&
                                !empty($display_opts->hide_oncustom)) :
                        ?>
                            <?php $whitelist = json_decode($display_opts->hide_oncustom) ?>
                            <textarea class="form-control hide_specific" name="hide_oncustom"
                                id="hide_oncustom" cols="30" rows="10"><?php foreach ($whitelist as $page) { echo $page."\r\n"; } ?></textarea>
                        <?php else : ?>
                            <textarea class="form-control hide_specific" name="hide_oncustom" id="hide_oncustom" cols="30" rows="10"></textarea>
                        <?php endif; ?>
                        <br>
                        <p style="text-align: justify;">
                        Add URLs to pages in which you would like to hide the widget. ( if "always show" is checked )<br>
                        Put each URL in a new line.
                        </p>
                    </div>
                </div>
                <div class="form-group col-lg-12">
                    <label for="show_onfrontpage" class="col-xs-9 col-sm-6 control-label">Show on frontpage</label>
                    <div class="col-xs-3 col-sm-6 control-label ">
                        <input type="checkbox" class="checkbox show_specific" name="show_onfrontpage"
                            id="show_onfrontpage" value="1"
                            <?php
                                $show_onfrontpage = false; // default value
                                if (!is_null($display_opts) && isset($display_opts->show_onfrontpage)) {
                                    $show_onfrontpage = $display_opts->show_onfrontpage;
                                }

                                if ($show_onfrontpage) :
                            ?>
                            checked
                            <?php endif ?>
                        />
                    </div>
                </div>
                <div class="form-group col-lg-12">
                    <label for="show_oncategory" class="col-xs-9 col-sm-6 control-label">Show on category pages</label>
                    <div class="col-xs-3 col-sm-6 control-label ">
                        <input type="checkbox" class="checkbox show_specific" name="show_oncategory" id="show_oncategory" value="1"
                            <?php
                                $show_oncategory = false; // default value
                                if (!is_null($display_opts) && isset($display_opts->show_oncategory)) {
                                    $show_oncategory = $display_opts->show_oncategory;
                                }

                                if ($show_oncategory) :
                            ?>
                            checked
                            <?php endif ?>
                        />
                    </div>
                </div>
                <div class="form-group col-lg-12">
                    <label for="show_onproduct" class="col-xs-9 col-sm-6 control-label">Show on product pages</label>
                    <div class="col-xs-3 col-sm-6 control-label ">
                        <input type="checkbox" class="checkbox show_specific" name="show_onproduct" id="show_onproduct" value="1"
                            <?php
                                $show_onproduct = false; // default value
                                if (!is_null($display_opts) && isset($display_opts->show_onproduct)) {
                                    $show_onproduct = $display_opts->show_onproduct;
                                }

                                if ($show_onproduct) :
                            ?>
                            checked
                            <?php endif ?>
                        />
                    </div>
                </div>
                <div class="form-group col-lg-12">
                    <label for="show_oncustom" class="col-sm-6 control-label">Show on pages:</label>
                    <div class="col-sm-6 control-label">
                        <?php
                            if (!is_null($display_opts) &&
                                isset($display_opts->show_oncustom) &&
                                !empty($display_opts->show_oncustom)) :
                        ?>
                            <?php $whitelist = json_decode($display_opts->show_oncustom) ?>
                            <textarea class="form-control show_specific" name="show_oncustom"
                                id="show_oncustom" cols="30" rows="10"><?php foreach ($whitelist as $page) { echo $page."\r\n"; } ?></textarea>
                        <?php else : ?>
                            <textarea class="form-control show_specific" name="show_oncustom" id="show_oncustom" cols="30" rows="10"></textarea>
                        <?php endif; ?>
                        <br>
                        <p style="text-align: justify;">
                        Add URLs to pages in which you would like to show the widget.<br>
                        Put each URL in a new line.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div id="buttons" class="col-lg-12">
            <div class="col-lg-9">
                <div class="col-lg-6 col-xs-12" style="text-align: right; margin-bottom: 10px;">
                    <button type="submit" value="1" id="module_form_submit_btn" name="submitBlockCategories" class="btn btn-default"><i class="process-icon-save"></i> Save</button>
                </div>
                <div class="col-lg-6 col-xs-12" style="min-height: 60px;">
                    <div id="optionsSuccessMessage" style="background-color: #dff0d8; color: #3c763d; border-color: #d6e9c6; font-weight:bold; display: none; margin-bottom: 0;" class="alert alert-success col-lg-12">Successfully set widget options to your site</div>
                </div>
            </div>
        </div>
    </form>
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

jQuery(document).ready(function() {
    if(jQuery("#always_display").prop("checked")){
        jQuery('.show_specific').prop('disabled', true);
    } else {
        jQuery('.hide_specific').prop('disabled', true);
    }

    jQuery("#always_display").change(function() {
        if(this.checked){
            jQuery('.hide_specific').prop('disabled', false);
            jQuery('.show_specific').prop('disabled', true);
        } else {
            jQuery('.hide_specific').prop('disabled', true);
            jQuery('.show_specific').prop('disabled', false);
        }
    });

    // process the form
    jQuery('#module_form').submit(function(event) {
        $path = "tawk_to_widget_manager.php?actionType=set_visibility";
        jQuery.post($path, {
            options : jQuery(this).serialize()
        }, function(r) {
            if(r.success) {
                $('#optionsSuccessMessage').toggle().delay(3000).fadeOut();
            }
        });

        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();
    });
});
</script>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
