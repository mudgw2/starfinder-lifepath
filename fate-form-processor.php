<?php
    ini_set('display_errors', 1); 
    error_reporting(E_ALL);
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: text/html; charset=utf-8');
    //Handle Fate form data and add to Fate Session scope

    //TEST DATA if there is no POST data
    if(!$_POST){
      $_POST['seed'] = "1726965802";
      $_POST['birth'] = "Large City";
      $_POST['hair'] = "Corporate short and straight back";
      $_POST['clothing'] = "Shirts";
      $_POST['caretakers'] = "Parents";
      $_POST['caretakers_status'] = "Alive";
      $_POST['background'] = "farmer";
      $_POST['environment'] = "farm";
      $_POST['mark'] = "facial scar across nose";
      $_POST['year'] = 1;
      $_POST['event'] = "yyyyyyy";
      $_POST['eventtype'] = "Windfall";
      $_POST['siblings'] ='[{\"name\":\"Bridgette\",\"race\":\"human\",\"gender\":\"sister\",\"fate\":\"hates you\"},{\"name\":\"Luke\",\"race\":\"android\",\"gender\":\"brother\",\"fate\":\"lives at home with parents\"},{\"name\":\"Alden\",\"race\":\"human\",\"gender\":\"brother\",\"fate\":\"lives at home with parents\"},{\"name\":\"Ted\",\"race\":\"kasatha\",\"gender\":\"brother\",\"fate\":\"hates you\"},{\"name\":\"Nora\",\"race\":\"human\",\"gender\":\"sister\",\"fate\":\"hates you\"},{\"name\":\"Sammie\",\"race\":\"human\",\"gender\":\"brother\",\"fate\":\"hates you\"},{\"name\":\"Michele\",\"race\":\"ysoki\",\"gender\":\"sister\",\"fate\":\"keeps in touch\"},{\"name\":\"Juanita\",\"race\":\"human\",\"gender\":\"sister\",\"fate\":\"hates you\"}]';
    }
  $file = "fates/".$_POST['seed'].".json";

  //Load previous history
  //Check if exists
  if (file_exists($file)){
    //Exists
    $json = json_decode(file_get_contents($file), true);
  }else{
  //Does NOT Exist
  //POST Array
  
    $json = array(
      'seed' => $_POST['seed'],
      'birth' => $_POST['birth'],
      'environment' => $_POST['environment'],
      'background' => $_POST['background'],
      'caretakers' => $_POST['caretakers'],
      'caretakers_status' => $_POST['caretakers_status'],
      'hair' => $_POST['hair'],
      'clothing' => $_POST['clothing'],
      'mark' => $_POST['mark'],
      'siblings' => $_POST['siblings'],
      'fate' => []
    );
  }

  //Loop through each sibling and rebuild array

var_dump($_POST['siblings']);

foreach($_POST['siblings'] as $sibling){
echo $sibling;

}


  //Add Fate
  $a =  array('year' => $_POST['year'],'event' => $_POST['event'],'eventtype' => $_POST['eventtype']);
  array_push($json["fate"],$a);

  //File Exists - Overwrite
  file_put_contents($file,json_encode($json,JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
  return true;
?>