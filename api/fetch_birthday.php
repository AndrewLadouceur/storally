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

  $f->o->where("id", $f->getField('id'));
  $k = $f->o->get("users");
  $out = array();
  $out['month'] = $k[0]['birth_month'];
  $out['day'] = $k[0]['birth_day'];
  $out['year'] = $k[0]['birth_year'];
  echo json_encode($out);
?>
