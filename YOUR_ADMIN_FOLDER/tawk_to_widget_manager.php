<?php
/**
* @package tawk.to
* @copyright Copyright 2021 tawk.to
* @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
* @version 1.0.1
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
