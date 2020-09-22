<?php
    if ( isset($_POST['number']) && $_POST['number']!="" &&
        isset($_POST['number2']) && $_POST['number2']!="" )  {
        $sumas = $_POST['number'] + $_POST['number2'];
        echo $sumas;
    }
?>