<?php
/*
@Author: ananayarora
@Date:   2016-08-15T04:21:00+05:30
@Last modified by:   ananayarora
@Last modified time: 2016-08-15T04:49:08+05:30
*/

  require ('../inc/conf.php');
  require ('../inc/mysqli.php');
  require ('../inc/functions.php');

  $f = new Functions();
  $f->checkSession();

  if (!$f->checkLogin()) {
      header("Location: index.php");
  }

  if (!isset($_POST['address']) || $_POST['address'] == "") {
      header("Location: index.php");
  }

  $result = $f->verifyAddress($_POST['address']);

  if (!$result) {
    echo "error";
  } else {
    echo "success";
    // Save the address
    $f->o->where("id",$f->getField("id"));
    $data = Array(
      'address'=>$_POST['address']
    );
    $f->o->update("users",$data);
  }

?>
