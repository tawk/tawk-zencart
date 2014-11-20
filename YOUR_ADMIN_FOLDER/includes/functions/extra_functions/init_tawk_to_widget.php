<?php
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}


//----
// If the installation supports admin-page registration (i.e. v1.5.0 and later), then
// register the New Tools tool into the admin menu structure.
//
// NOTES:
// 1) Once this file has run once and you see the Tools->New Tool link in the admin
// menu structure, it is safe to delete this file (unless you have other functions that
// are initialized in the file).
// 2) If you have multiple items to add to the admin-level menus, then you should register each
// of the pages here, just make sure that the "page key" is unique or a debug-log will be
// generated!
//
if (function_exists('zen_register_admin_page')) {
  if (!zen_page_key_exists('tawkToWidget')) {
    zen_register_admin_page('tawkToWidget', 'BOX_TOOLS_TAWK_TO_WIDGET', 'FILENAME_TAWK_TO_WIDGET','' , 'tools', 'Y', 999);
  }
  // $page_key, $language_key, $main_page, $page_params, $menu_key, $display_on_menu, $sort_order
} else {
  die('no register function');
}