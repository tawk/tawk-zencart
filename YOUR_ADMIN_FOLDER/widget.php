<?php
/**
* @package tawk.to
* @copyright Copyright 2021 tawk.to
* @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
* @version 1.0.1
*/

require('includes/application_top.php');

if (isset($_GET['set'])) {
    header('Content-Type: application/json');

    if (!isset($_POST['page_id']) || !isset($_POST['widget_id'])) {
        echo json_encode(array('success' => FALSE));
        die();
    }

    global $db;
    $page_id = trim($_POST['page_id']);
    $widget_id = trim($_POST['widget_id']);

    $db->Execute("insert into " . TABLE_CONFIGURATION . "
        (configuration_key, configuration_value)
        values('" . TAWK_TO_PAGE_ID_FIELD . "', '" . $db->prepare_input($page_id) . "')
        on duplicate key update configuration_value='" . $db->prepare_input($page_id) . "'");

    $db->Execute("insert into " . TABLE_CONFIGURATION . "
        (configuration_key, configuration_value)
        values('" . TAWK_TO_WIDGET_ID_FIELD . "', '" . $db->prepare_input($widget_id) . "')
        on duplicate key update configuration_value='" . $db->prepare_input($widget_id) . "'");

    echo json_encode(array('success' => TRUE));
    die();
}

if (isset($_GET['remove'])) {
    header('Content-Type: application/json');
    $db->Execute("insert into " . TABLE_CONFIGURATION . "
        (configuration_key, configuration_value)
        values('" . TAWK_TO_PAGE_ID_FIELD . "', '')
        on duplicate key update configuration_value=''");

    $db->Execute("insert into " . TABLE_CONFIGURATION . "
        (configuration_key, configuration_value)
        values('" . TAWK_TO_WIDGET_ID_FIELD . "', '')
        on duplicate key update configuration_value=''");

    echo json_encode(array('success' => TRUE));
    die();
}
