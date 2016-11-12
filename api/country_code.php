<?php
    require '../inc/conf.php';
    require '../inc/mysqli.php';
    require '../inc/functions.php';

    $f = new Functions();
    $f->checkSession();

    if (!$f->checkLogin())
    {
      header("Location: index.php");
    }

    echo $f->getField("country_code");
?>
