<!doctype html>
<html class="no-js" lang="en">
<?php
//https://wiki.travellerrpg.com/Universal_Personality_Profile
	session_start();
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: text/html; charset=utf-8');

	include "../header.php";
	include "functions.php";

	//Check for existing JSON
	if(isset($_GET['seed'])){
		//Same SEED in use
		$seed = $_GET['seed'];
		$file = "fates/".$seed.".json";
		//IF File Exists...
		if (file_exists($file)) {
			//Valid UTF-8
			$validUtf8Str = mb_convert_encoding(file_get_contents($file), 'UTF-8', 'UTF-8');
			$obj = json_decode($validUtf8Str);
			switch (json_last_error()) {
				case JSON_ERROR_NONE:
					//echo '<div class="alert alert-danger" role="alert">No errors</div>';
				break;
				case JSON_ERROR_DEPTH:
					echo '<div class="alert alert-danger" role="alert">Maximum stack depth exceeded</div>';
					die();
				break;
				case JSON_ERROR_STATE_MISMATCH:
					echo '<div class="alert alert-danger" role="alert">Underflow or the modes mismatch</div>';
					die();
				break;
				case JSON_ERROR_CTRL_CHAR:
					echo '<div class="alert alert-danger" role="alert">Unexpected control character found</div>';
					die();
				break;
				case JSON_ERROR_SYNTAX:
					echo '<div class="alert alert-danger" role="alert">Syntax error, malformed JSON</div>';
					die();
				break;
				case JSON_ERROR_UTF8:
					echo '<div class="alert alert-danger" role="alert">Malformed UTF-8 characters, possibly incorrectly encoded</div>';
					die();
				break;
				default:
					echo '<div class="alert alert-danger" role="alert">Unknown error</div>';
					die();
				break;
			}
			$seed = $obj -> seed;
			$background = $obj -> background;
			$environment = $obj -> environment;
			$birth = $obj -> birth;
			$caretakers_status = $obj -> caretakers_status;
			$caretakers = $obj -> caretakers;
			$hair = $obj -> hair;
			$clothing = $obj -> clothing;
			$mark = $obj -> mark;
			$siblings = $obj -> siblings;

		}else{
			//echo '<div class="alert alert-danger" role="alert">Fate File Missing</div>';
			//die();
			$year = 0;
			$background = getTrait('background');
			$environment = getTrait('environment');
			$birth = getTrait('birth');
			$caretakers_status = getTrait('caretakers_status');
			$caretakers = getTrait('caretakers');
			$hair = getTrait('hair');
			$clothing = getTrait('clothing');
			$mark = getTrait('mark');
		}
	}else{
		//No SEED passed, Refresh
		$year = 0;
		$seed = time();
		$background = getTrait('background');
		$environment = getTrait('environment');
		$birth = getTrait('birth');
		$caretakers_status = getTrait('caretakers_status');
		$caretakers = getTrait('caretakers');
		$hair = getTrait('hair');
		$clothing = getTrait('clothing');
		$mark = getTrait('mark');
	}
?>
<body id="page-top"><div id="particles-js">
<div class="container">
<h1>Lifepath Generator&nbsp;<small class="pull-right">for Starfinder RPG</small></h1>
 <header class="masthead mb-auto">
	<nav class="navbar navbar-dark col-md-12 justify-content-end">
			<form class="form-inline">
			<div class="form-group">
			<label for="RaceSelect1">Seed&nbsp;
			<input class="form-control form-control-sm" name="seed" value="<?php 
			if(isset($_GET['seed'])){
				echo trim($_GET['seed'],"%09");
			}else{
				$seed = time();
				echo $seed;
			}?>"/>
			</label>
			</div>
			<button type="submit" class="btn btn-sm btn-primary">USE SEED</button>
			<button type="submit" class="btn btn-sm btn-primary"><a href="/starfinder/lifepath/index.php">Refresh</a></button>
			</form>
	</nav>
</header>

<table class='table table-sm table-borderless'><tbody>
<tr><th class='bg-primary col-2'>Background</th>
<td class='text-bg-dark col-4'>
	<ul>
	<li><?php echo $birth; ?></li>
	<li><?php echo $environment;?></li>
	</ul>
</td>
<th class='bg-primary col-2'>Custodian</th>
<td class='text-bg-secondary col-4'>
	<ul>
	<li><?php echo $caretakers;?></li>
	<li><?php echo $caretakers_status;?></li>
	</ul>
</td>
</tr>
<tr>
<th class='bg-primary col-2'>Social Standing</th><td class='text-bg-secondary col-4'>
	<ul><li><?php echo $background;?></li></ul>
</td>
<th class='bg-primary col-2'>Remarks</th><td class='text-bg-dark col-4'>
	<ul>
	<li><?php echo $hair;?></li>
	<li><?php echo $clothing;?></li>
	<li><?php echo $mark;?></li>
	</ul>
</td></tr>
</tbody></table>

<table class='table table-sm table-borderless'><tbody>
<tr><th class='bg-primary col-2'>Siblings</th>
<td class='text-bg-dark text-white col-10' style='padding:20px;'>
	<?php
	//Check if $siblings is defined, otherwise generate siblings
	echo "<table class='table table-sm table-borderless table-striped'>
	<thead><tr><th>Name</th><th>Race</th><th>Gender</th><th>Fate</th></tr></thead><tbody>";

	if(isset($siblings)){
		//Siblings loaded
		foreach($siblings as $sibling){
			echo "<tr>";
			echo "<td>".$sibling->name."</td>".
			"<td>".$sibling->race."</td>".
			"<td>".$sibling->gender."</td>".
			"<td>".$sibling->fate."</td>";
			echo "</tr>";
		}
	}else{
		//Generate fresh sibling list
		if(siblings('human')){
			$siblings = [];
			$siblings = siblings('human');

			if($siblings){
			foreach($siblings as $key => $v){
				echo "<tr>";
				echo "<td>".ucfirst($v['name'])."</td>".
				"<td>".ucfirst($v['race'])."</td>".
				"<td>".ucfirst($v['gender'])."</td>".
				"<td>".ucfirst($v['fate'])."</td>";
				echo "</tr>";
			}}
		}else{
			//Only Child
			echo "<tr><td colspan='4'><center>ONLY CHILD</center></td></tr>";
		}
	}
	echo "</tbody></table>";
	?>
</td>
</tr>
</tbody></table>
<!-- Starting Age, then determine Starting Age of character, for each year provide lifepath / career options -->
<!-- If career is terminated, option to return to lifepath -->

<!-- LIFEPATH -->

<table class='table table-sm table-borderless'><tbody>
<tr><th class='bg-primary col-1'>Lifepath</th>
<td class='text-bg-light text-dark'>
<?php

// Get start and current age
	//starting (maturity) age for Humans
	$start_age 		= 14;
	$current_age 	= mt_rand(2,12)+14;
	$fate_years		= $current_age - $start_age;
	$year			= 1;

	echo "<p>Current Age: ".$current_age."</p>";
	//Loop through history
	if(isset($obj)){
		foreach($obj->fate as $fate){
			echo "<div class='card'><div class='card-header'>Year ".$fate->year." ".$fate->eventtype."</div>";
			echo "<div class='card-body'><p class='card-text'>".$fate->event."</p></div></div><br/>";
	}}
	
	$fate = fate();
	echo "<div class='card'><div class='card-header'>Year ".$year." ".$fate["eventtype"]."</div>";
	echo "<div class='card-body'><p class='card-text'>".$fate["event"]."</p>";

	//AJAX Form to append Fate results to Fate Session Array
	echo "<form id='FateForm' class='form'>";
	echo "<input type='hidden' name='seed' required value='".$seed."'/>";
	echo "<input type='hidden' name='background' required value='".$background."'/>";
	echo "<input type='hidden' name='birth' required value='".$birth."'/>";
	echo "<input type='hidden' name='hair' required value='".$hair."'/>";
	echo "<input type='hidden' name='clothing' required value='".$clothing."'/>";	
	echo "<input type='hidden' name='caretakers' required value='".$caretakers."'/>";
	echo "<input type='hidden' name='caretakers_status' required value='".$caretakers_status."'/>";
	echo "<input type='hidden' name='mark' required value='".$mark."'/>";
	echo "<input type='hidden' name='environment' required value='".$environment."'/>";
	echo "<input type='hidden' name='eventtype' required value='".$fate['eventtype']."'/>";
	echo "<input type='hidden' name='event' required value='".$fate['event']."'/>";
  	echo "<input type='hidden' name='year' required value='".$year."'/>";

	//Loop through each sibling
	if(isset($sibling)){
		(object)$siblings = arrayToObject($siblings);
		$i = 0;
		foreach($siblings as $sibling){
			echo "<input type='hidden' name='siblings[".$i."][name]' value='".$sibling->name."'/>";
			echo "<input type='hidden' name='siblings[".$i."][race]' value='".$sibling->race."'/>";
			echo "<input type='hidden' name='siblings[".$i."][gender]' value='".$sibling->gender."'/>";
			echo "<input type='hidden' name='siblings[".$i."][fate]' value='".$sibling->fate."'/>";
			$i++;
		}
	}
  	echo "<input type='submit' class='btn btn-primary float-right' value='Continue to Next Year'/>";
	echo "</form>";
	echo "</div></div>";
?>

</td>
</tr>
</tbody></table>

</div>
<script>
// Variable to hold request
var request;
// Bind to the submit event of our form
$("#FateForm").submit(function(event){
    // Prevent default posting of form - put here to work in case of errors
    	event.preventDefault();
    if (request) {
        request.abort();
    }
    // setup some local variables
    var $form = $(this);
    var $inputs = $form.find("input, select, button, textarea");
    var serializedData = $form.serialize();
	var data = new FormData();
	data.append("siblings",serializedData);
    $inputs.prop("disabled", true);

	$.post('/starfinder/lifepath/fate-form-processor.php',serializedData, function(response) {
		console.log(data);
    	console.log("Response: "+response);
	})
    .done(function (response, textStatus, jqXHR){
		location.reload();
    })
    .fail(function (jqXHR, textStatus, errorThrown){

    })
	.always(function () {
        $inputs.prop("disabled", false);
    });
});
</script>
<?php include "../footer.php"; ?>
</div>
</body>
</html>
