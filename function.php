<?php
require 'rb.php';
$config = include 'config.php';


R::setup('mysql:host=localhost;dbname='.$config['db']['name'], $config['db']['user'], $config['db']['pass']);


function getRegionSelect($data){
  $result = '<div class="form-group col-4"><label for="region">Область</label><select id="region" class="form-control" name="region"><option selected value="0">Выберите область...</option>';
  foreach ($data as $d) {
    $result .= '<option value="'.$d['IdRegion'].'">'.$d['Region'].'</option>';
  }
  $result .= '</select></div>';
  return $result;
}

function getDrugSelect($data){
  $result = '<div class="form-group col-4"><label for="drug">Препарат</label><select multiple id="drug" class="form-control" name="drug[]">';
  foreach ($data as $d) {
    if(!empty($_GET['drug']) && in_array($d['IdDrug'],$_GET['drug'])){
        $result .= '<option value="'.$d['IdDrug'].'"selected="true">'.$d['Drug'].'</option>';
    } else {
        $result .= '<option value="'.$d['IdDrug'].'">'.$d['Drug'].'</option>';
    }
  }
  $result .= '</select></div>';
  return $result;
}

function getDistrSelect($data){
  $result = '<div class="form-group col-4"><label for="distr">Дистрибьютор</label><select multiple id="distr" class="form-control" name="distr[]">';
  foreach ($data as $d) {
      if(!empty($_GET['distr']) && in_array($d['IdDistr'],$_GET['distr'])){
          $result .= '<option value="'.$d['IdDistr'].'"selected="true">'.$d['Distr'].'</option>';
      } else {
          $result .= '<option value="'.$d['IdDistr'].'">'.$d['Distr'].'</option>';
      }
  }
  $result .= '</select></div>';
  return $result;
}

function getGroupSelect($data){
  $result = '<div class="form-group col-4"><label for="group">Група</label><select id="group" class="form-control" name="group"><option selected value="0">Оберіть групу...</option>';
  foreach ($data as $d) {
    $result .= '<option value="'.$d['IdGroup'].'">'.$d['Groups'].'</option>';
  }
  $result .= '</select></div>';
  return $result;
}

function getDateJson($data){
  $result = [];
  foreach ($data as $d) {
    array_push($result, $d['Month'].' '.$d['Year']);
  }
  return json_encode($result);
}
//Data Visualization
error_reporting(0);
function getData(){
  if(!empty($_GET['range-h'])) {
    if($_GET['vizualType'] == 1){
      $query = 'select IdRegion, count(Quantity) AS result from sales where (IdDate between '.$_GET['range-l'].' and '.$_GET['range-h'].')';

      if(!empty($_GET['drug'])) $query .= ' and IdDrug IN (';
      foreach ($_GET['drug'] as $drug)
        $query .= $drug.',';
      if(!empty($_GET['drug'])) $query = substr_replace($query,')',-1);

      if(!empty($_GET['distr'])) $query .= ' and IdDistr IN (';
      foreach ($_GET['distr'] as $distr)
        $query .= $distr.',';
      if(!empty($_GET['distr'])) $query = substr_replace($query,')',-1);

      $query .= ' group by IdRegion';

      $data = R::getAll($query);
      return getDataJson($data);
    } else {
      $query = 'select IdRegion, sum(Quantity) AS result from sales where (IdDate between '.$_GET['range-l'].' and '.$_GET['range-h'].')';

      if(!empty($_GET['drug'])) $query .= ' and IdDrug IN (';
      foreach ($_GET['drug'] as $drug)
        $query .= $drug.',';
      if(!empty($_GET['drug'])) $query = substr_replace($query,')',-1);

      if(!empty($_GET['distr'])) $query .= ' and IdDistr IN (';
      foreach ($_GET['distr'] as $distr)
        $query .= $distr.',';
      if(!empty($_GET['distr'])) $query = substr_replace($query,')',-1);

      $query .= ' group by IdRegion';
      $data = R::getAll($query);
      return getDataJson($data);
    }
  }
}
function getChartHide(){
    $tmp = '[';
    if(!empty($_GET['distr']))
        foreach ($_GET['distr'] as $distr)
            $tmp .= '"'.$distr.'",';
    echo substr_replace($tmp,']',-1);
}
function getDataJson($data){
  $result = [];
  $tmp = 1;
  for($i = 0; $i<count($data); $i++){
    if($data[$i]['IdRegion']== $i+$tmp){
      array_push($result, $data[$i]['result']);
    } else {
      array_push($result, '0');
      array_push($result, $data[$i]['result']);
      $tmp++;
    }
  }

  return json_encode($result);
}

function genTbl(){
  if($_GET['vizualType'] == 1) {
    $tbl='<table class="table card-body" style="padding: 3em;"><tr><th scope="col">#</th><th scope="col">Область</th><th scope="col">Кількість(шт.)</th></tr></table>';
  } else {
    $tbl='<table class="table card-body" style="padding: 3em;"><tr><th scope="col">#</th><th scope="col">Область</th><th scope="col">Сума(грн)</th></tr></table>';
  }
  return $tbl;
}

// Auth
$user = include 'user.php';

function isAuth($user){
 if (isset($_COOKIE['token'])) {
   $token = md5($user['name'].$user['pass']);
   if($token == $_COOKIE['token'])
     return true;
 }
 return false;
}

function logOut(){
 if (isset($_COOKIE['token'])){
   unset($_COOKIE['token']);
 }
 return true;
}

function logIn($name, $pass, $user){
 if($name == $user['name'] && $pass == $user['pass'])
   setcookie('token', md5($user['name'].$user['pass']), time()+3600, '/');
 return true;
}

function getGroupChartData(){
  $result = '[';
  if(!empty($_GET['range-h'])) {
    if($_GET['vizualType'] == 1){
        for ($i=1; $i<5 ; $i++) {
          $query = 'select IdRegion, count(Quantity) AS result from sales where (IdDate between '.$_GET['range-l'].' and '.$_GET['range-h'].')';

          if(!empty($_GET['drug'])) $query .= ' and IdDrug IN (';
          foreach ($_GET['drug'] as $drug)
            $query .= $drug.',';
          if(!empty($_GET['drug'])) $query = substr_replace($query,')',-1);

          $query .= ' and IdDistr = '.$i;

          $query .= ' group by IdRegion';

          $data[$i] = R::getAll($query);

          $result .= getDataJson($data[$i]).',';
        }

    } else {
      for ($i=1; $i<5 ; $i++) {
        $query = 'select IdRegion, sum(Quantity) AS result from sales where (IdDate between '.$_GET['range-l'].' and '.$_GET['range-h'].')';

        if(!empty($_GET['drug'])) $query .= ' and IdDrug IN (';
        foreach ($_GET['drug'] as $drug)
          $query .= $drug.',';
        if(!empty($_GET['drug'])) $query = substr_replace($query,')',-1);

        $query .= ' and IdDistr = '.$i;

        $query .= ' group by IdRegion';

        $data[$i] = R::getAll($query);

        $result .= getDataJson($data[$i]).',';
      }
    }
    echo substr_replace($result,']',-1);
  }
}

function getRangeData(){
    $result = '';
    if(!empty($_GET['range-h'])) {
        $result = '['.$_GET['range-l'].','.$_GET['range-h'].']';
    } else {
        $result = '[1,24]';
    }
    return $result;
}