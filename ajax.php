<?php

require 'function.php';

if(isset($_GET['group'])) {
  if($_GET['group'] == 0){
    $result = R::getAll('select IdDrug, Drug from drug');
    echo json_encode($result);
  } else {
    $result = R::getAll('select IdDrug, Drug from drug where drug.IdGroup = '.$_GET['group']);
    echo json_encode($result);
  }
}

?>
