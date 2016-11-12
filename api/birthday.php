<?php
  require ('../inc/conf.php');
  require ('../inc/mysqli.php');
  require ('../inc/functions.php');

  $f = new Functions();
  $f->checkSession();

  if (!$f->checkLogin())
  {
    header("Location: index.php");
  }

  if (!isset($_POST['month']) || !isset($_POST['day']) || !isset($_POST['year']) || $_POST['month'] == "" || $_POST['day'] == "" || $_POST['year'] == "")
  {
    header("Location: index.php");
  } else {
    $f->o->where("id", $f->getField('id'));
    $data = array(
      'birth_month'=>$f->o->escape($_POST['month']),
      'birth_day'=>$f->o->escape($_POST['day']),
      'birth_year'=>$f->o->escape($_POST['year'])
    );
    $f->o->update("users",$data);
  }
?>
