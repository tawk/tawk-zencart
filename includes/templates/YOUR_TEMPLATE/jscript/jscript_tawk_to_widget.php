<?php
$tawk_widget_current_values = array(
    'page_id' => zen_get_configuration_key_value(TAWK_TO_PAGE_ID_FIELD),
    'widget_id' => zen_get_configuration_key_value(TAWK_TO_WIDGET_ID_FIELD)
);
$page_id = $tawk_widget_current_values['page_id'];
$widget_id = $tawk_widget_current_values['widget_id'];

//zen cart returns span with error message if configuration key can't be found
if (strpos($page_id, '<') === 0 || $page_id === '' || $widget_id === '') {
    echo '<!-- Tawk.to widget not set up -->';
} else { ?>
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
