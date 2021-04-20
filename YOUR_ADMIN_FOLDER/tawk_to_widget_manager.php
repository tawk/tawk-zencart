<?php
/**
* @package tawk.to
* @copyright Copyright 2021 tawk.to
* @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
* @version 1.1.1
*/

require('includes/application_top.php');
header('Content-Type: application/json');

$request_method = $_SERVER['REQUEST_METHOD'];
if ($request_method !== 'POST') {
    echo json_encode(array('success' => false));
    die();
}

$actionType = $_GET['actionType'];
if (!isset($actionType)) {
    echo json_encode(array('success' => false));
    die();
}

if ($actionType === 'set') {
    $page_id = $_POST['page_id'];
    $widget_id = $_POST['widget_id'];

    if (!isset($page_id) || !isset($widget_id)) {
        echo json_encode(array('success' => false));
        die();
    }

    setWidget($page_id, $widget_id);
} else if ($actionType === 'remove') {
    removeWidget();
} else if ($actionType === 'set_visibility') {
    $options = $_POST['options'];
    if (!isset($options)) {
        echo json_encode(array('success' => false));
        die();
    }

    setVisibility($options);
} else {
    echo json_encode(array('success' => false));
    die();
}

echo json_encode(array('success' => true));
die();

/**
 * Main Functions
 */
function setWidget($page_id, $widget_id) {
    global $db;
    $page_id = trim($page_id);
    $widget_id = trim($widget_id);

    $db->Execute("insert into " . TABLE_CONFIGURATION . "
        (configuration_key, configuration_value)
        values('" . TAWK_TO_PAGE_ID_FIELD . "', '" . $db->prepare_input($page_id) . "')
        on duplicate key update configuration_value='" . $db->prepare_input($page_id) . "'");

    $db->Execute("insert into " . TABLE_CONFIGURATION . "
        (configuration_key, configuration_value)
        values('" . TAWK_TO_WIDGET_ID_FIELD . "', '" . $db->prepare_input($widget_id) . "')
        on duplicate key update configuration_value='" . $db->prepare_input($widget_id) . "'");
}

function removeWidget() {
    global $db;
    $db->Execute("insert into " . TABLE_CONFIGURATION . "
        (configuration_key, configuration_value)
        values('" . TAWK_TO_PAGE_ID_FIELD . "', '')
        on duplicate key update configuration_value=''");

    $db->Execute("insert into " . TABLE_CONFIGURATION . "
        (configuration_key, configuration_value)
        values('" . TAWK_TO_WIDGET_ID_FIELD . "', '')
        on duplicate key update configuration_value=''");
}

function setVisibility($options) {
    global $db;
    // default values
    $jsonOpts = array(
        'always_display' => false,
        'show_onfrontpage' => false,
        'show_oncategory' => false,
        'show_onproduct' => false,
        'show_oncustom' => array(),
        'hide_oncustom' => array()
    );

    if (!empty($options)) {
        $options = explode('&amp;', $options); // request data has been sanitized, used escaped version of & sign.
        foreach ($options as $post) {
            list($column, $value) = explode('=', $post);
            switch ($column) {
                case 'show_oncustom':
                case 'hide_oncustom':
                    // replace newlines and returns with comma, and convert to array for saving
                    $value = urldecode($value);
                    $value = str_ireplace(array("\r\n", "\r", "\n"), ',', $value);
                    if (!empty($value)) {
                        $value = explode(",", $value);
                        $jsonOpts[$column] = json_encode($value);
                    }
                    break;
                case 'show_onfrontpage':
                case 'show_oncategory':
                case 'show_onproduct':
                case 'always_display':
                    $jsonOpts[$column] = ($value == 1);
                    break;
            }
        }
    }

    $db_input = $db->prepare_input(json_encode($jsonOpts));

    $db->Execute("insert into " . TABLE_CONFIGURATION . "
        (configuration_key, configuration_value)
        values('" . TAWK_TO_VISIBILITY_OPTS_FIELD . "', '" . $db_input . "')
        on duplicate key update configuration_value='" . $db_input . "'");
}
