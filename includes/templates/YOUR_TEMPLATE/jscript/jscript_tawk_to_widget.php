<?php
$tawk_widget_current_values = array(
    'page_id' => zen_get_configuration_key_value(TAWK_TO_PAGE_ID_FIELD),
    'widget_id' => zen_get_configuration_key_value(TAWK_TO_WIDGET_ID_FIELD),
    'visibility_opts' => zen_get_configuration_key_value(TAWK_TO_VISIBILITY_OPTS_FIELD)
);
$page_id = $tawk_widget_current_values['page_id'];
$widget_id = $tawk_widget_current_values['widget_id'];
$options = null;
if (isset($tawk_widget_current_values['visibility_opts'])
    && !empty($tawk_widget_current_values)) {
    $options = json_decode($tawk_widget_current_values['visibility_opts']);
}

$show = true;
if (!is_null($options)) {
    if (isset($options) && $options->always_display) {
        $show = true;
    } else {
        $show = false;

        if (!$show) {
            if ($this_is_home_page &&
                // homepage
                isset($options->show_onfrontpage) &&
                $options->show_onfrontpage) {
                $show = true;
            } else if ($current_page_base === FILENAME_DEFAULT &&
                // category pages
                $current_category_id > 0 &&
                isset($options->show_oncategory) &&
                $options->show_oncategory) {
                $show = true;
            } else if ($current_page_base === FILENAME_PRODUCT_INFO &&
                // product pages
                isset($options->show_onproduct) &&
                $options->show_onproduct) {
                $show = true;
            }
        }
    }
}

//zen cart returns span with error message if configuration key can't be found
if (strpos($page_id, '<') === 0 || $page_id === '' || $widget_id === '') {
    echo '<!-- Tawk.to widget not set up -->';
} else if ($show) { ?>
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),
        s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/<?php echo $page_id ?>/<?php echo $widget_id ?>';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->
<?php } ?>
