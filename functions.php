<?php
// AI Image generator https://creator.nightcafe.studio/explore?claimTopup=true&n_class=topupReminder&n_medium=email&n_urlVariant=explore
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
header('Access-Control-Allow-Origin: *');

if(isset($_GET['seed'])){
	(int)$_SESSION['seed'] = $_GET['seed'];
}else{
	$_SESSION['seed'] = time();
}
mt_srand((int)$_SESSION['seed']);

function getTrait($trait){
    $path = "json/".$trait.".json";
	$str = file_get_contents($path);
	$result_array = [];
	$temp_json = json_decode($str, true);

    $rand_keys = array_rand($temp_json, 1);
    $json = $temp_json[$rand_keys];
    return $json[$trait];
}


function siblings($race){
	$siblings = mt_rand(1,6);
		$resultArray = [];
		if($siblings >=1 && $siblings <=5){
		$siblingAmount = mt_rand(1,12);
		for ($s = 1; $s <= $siblingAmount; $s++) {
			mt_srand($s); 
			$genderRoll = mt_rand(1,2);
			$raceRoll 	= mt_rand(1,100);
			if($genderRoll == 1){
					$gender = "brother";
					$fname = generate_first_name('male');
				}else{
					$gender = "sister";
					$fname = generate_first_name('female');
				}

				if($raceRoll > 0 AND $raceRoll < 70){
					$siblingRace =  $race;
				}else{
						$raceRoll = mt_rand(1,100);
						if($raceRoll > 0 AND $raceRoll < 50){
							$siblingRace = "android";
						}elseif($raceRoll > 50 AND $raceRoll < 60){
							$siblingRace = "shirren";
						}elseif($raceRoll > 60 AND $raceRoll < 75){
							$siblingRace = "kasatha";
						}elseif($raceRoll > 75 AND $raceRoll < 80){
							$siblingRace = "vesk";
						}elseif($raceRoll > 80 AND $raceRoll < 100){
							$siblingRace = "ysoki";
						}
				}
			$fate 	= mt_rand(1,12);
			if($fate == 1 || $fate == 2){
				$fateResult = "location unknown";
			}elseif($fate == 3 || $fate == 4){
				$fateResult = "lives at home with parents";
			}elseif($fate == 5 || $fate == 6){
				$fateResult = "history of misfortune";
				//echo ", ";
				//generate('misfortune');
			}elseif($fate == 7 || $fate == 8){
				$fateResult = "keeps in touch";
			}elseif($fate == 9 || $fate == 10){
				$fateResult = "hates you";
			}elseif($fate == 11 || $fate == 12){
				$fateResult = "is dead";
				//echo ", ";
				//generate('death');
			}
			$siblingArray = [];
			$siblingArray['name'] 	= $fname[1];
			$siblingArray['race'] 	= $siblingRace;
			$siblingArray['gender'] = $gender;
			$siblingArray['fate'] 	= $fateResult;
			array_push($resultArray,$siblingArray);
		}
		
	}elseif($siblings == 6){
		$resultArray = [];
	}

	if(isset($resultArray)){
		return $resultArray;
	}
}

//Name generator
function generate_first_name($gender){
	//$seed = $GLOBALS['seed'];
	$names = [];
	if($gender == 'male'){
		$names = array_map('str_getcsv', file('names/Human_Names_-_Western_Male.csv'));
	}else{
		$names = array_map('str_getcsv', file('names/Human_Names_-_Western_Female.csv'));
	}
	//Generate a random forename.
	//$first_name = SeedShuffle($GLOBALS['seed'],array_column($names, 1));
	$first_name = $names[mt_rand(0, sizeof($names) - 1)];
	//Combine them together and print out the result.
	return $first_name;
}
function generate_last_name(){
	$surnames = array_map('str_getcsv', file('names/Human_Names_-_Western_Surname.csv'));
	//Generate a random surname.
	$random_surname = $surnames[mt_rand(0, sizeof($surnames) - 1)];
	//Combine them together and print out the result.
	$GLOBALS['lname'] = $random_surname[1];
}

function tragedy(){
	$fate = mt_rand(1,12);
	if($fate == 1 || $fate == 2){
		$result = "You lost all your credits/possessions";
	}elseif($fate == 3 || $fate == 4){
		$result = "You made yourself indebted to someone or some group";
	}elseif($fate == 5 || $fate == 6){
		$result = "You ended up imprisoned for several months";
	}elseif($fate == 7 || $fate == 8){
		$result = "You had a serious accident that left you incapacitated for several months";
	}elseif($fate == 9 || $fate == 10){
		$result = "You spent several months battling an addiction";
	}elseif($fate == 11 || $fate == 12){
		$result = "You lost a pet";
	}
	$resultArray = [];
	$resultArray["eventtype"] = "Tragedy";
	$resultArray["event"] = $result;
	return $resultArray;
}
function windfall(){
	$fate = mt_rand(1,12);
	if($fate == 1 || $fate == 2){
		$result = "You nearly double your worth";
	}elseif($fate == 3 || $fate == 4){
		$result = "You managed to be at the right place and at the right time and someone owes you";
	}elseif($fate == 5 || $fate == 6){
		$result = "Through your deeds you manage to make a name for yourself locally";
	}elseif($fate == 7 || $fate == 8){
		$result = "You find a sibling you never knew you had";
	}elseif($fate == 9 || $fate == 10){
		$result = "You find yourself a pet";
	}elseif($fate == 11 || $fate == 12){
		$result = "The opportunity arises to travel to far distant lands for several months";
	}
	$resultArray = [];
	$resultArray["eventtype"] = "Windfall";
	$resultArray["event"] = $result;
	return $resultArray;
}

function enemy_heft(){
	$fate = mt_rand(1,12);
	if($fate == 1){
		$result = "This person has no real pull, only has themselves";
	}elseif($fate == 2){
		$result = "They are apart of a clan all willing to lay their lives for you";
	}elseif($fate == 3){
		$result = "They are apart of a small gang";
	}elseif($fate == 4){
		$result = "They are apart of a large family";
	}elseif($fate == 5){
		$result = "They are a local hero that can pull on the resources of a single town";
	}elseif($fate == 6){
		$result = "They are a famous hero or major noble that can pull resources over an entire province";
	}elseif($fate == 7){
		$result = "They are apart of a mercenary outfit or part of the guard";
	}elseif($fate == 8){
		$result = "They have powerful connections with the black market and the criminal world";
	}elseif($fate == 9){
		$result = "They know someone who is a power unto himself, like a mage or a powerful priest";
	}elseif($fate == 10){
		$result = "They are connected to angelic or extra planar forces";
	}elseif($fate == 11){
		$result = "They have connections to dark demonic forces or something of an evil nature";
	}elseif($fate == 12){
		$result = "They are a member of the ruling family with pull anywhere within the kingdom, some beyond";
	}
	$resultArray = [];
	$resultArray['heft'] = $result;
	return $resultArray;
	//echo ".  They hate you because ";
	//animosity();
}

function friend_heft($friend){
	$fate = mt_rand(1,12);
	if($fate == 1){
		$result = "This person has no real pull, only has themselves";
	}elseif($fate == 2){
		$result = "They are apart of a clan all willing to lay their lives for them";
	}elseif($fate == 3){
		$result = "They are apart of a small gang";
	}elseif($fate == 4){
		$result = "They are apart of a large family";
	}elseif($fate == 5){
		$result = "They are a local hero that can pull on the resources of a single town";
	}elseif($fate == 6){
		$result = "They are a famous hero or major noble that can pull resources over an entire province";
	}elseif($fate == 7){
		$result = "They are apart of a mercenary outfit or part of the guard";
	}elseif($fate == 8){
		$result = "They have powerful connections with the black market and the criminal world";
	}elseif($fate == 9){
		$result = "They know someone who is a power unto himself, like a mage or a powerful priest";
	}elseif($fate == 10){
		$result = "They are connected to angelic or extra planar forces";
	}elseif($fate == 11){
		$result = "They have connections to dark demonic forces or something of an evil nature";
	}elseif($fate == 12){
		$result = "They are a member of the ruling family with pull anywhere within the kingdom, some beyond";
	}
	$resultArray = [];
	$result['friend'] = $friend;
	$result['heft'] = $result;
	return $result;
	//echo ".  They are your friend because ";
	//animosity();
}


function animosity(){
	$fate = mt_rand(1,12);
	if($fate == 1){
		$result = "you caused the loss of face or status publicly";
	}elseif($fate == 2){
		$result = "you caused the loss of a friend or lover";
	}elseif($fate == 3){
		$result = "you truly or falsely brought criminal charges against the person";
	}elseif($fate == 4){
		$result = "you left the other out to dry or outright backstabbing";
	}elseif($fate == 5){
		$result = "you turned down their job or romantic advances";
	}elseif($fate == 6){
		$result = "you were commpeting for a job or romance and won";
	}elseif($fate == 7){
		$result = "you caused the failure of some plot, quest or undertaking";
	}elseif($fate == 8){
		$result = "because you defeated them in combat or game/gamble";
	}elseif($fate == 9){
		$result = "you are hated due to race and/or religious beliefs, the hatred stems from stereotype";
	}elseif($fate == 10){
		$result = "you murdered a friend/relative/lover";
	}elseif($fate == 11){
		$result = "you made them jealous";
	}elseif($fate == 12){
		$result = "you took economic advantage by scam, or physical advantage through force";
	}
	$resultArray = [];
	$resultArray["animosity"] = $result;
	return $resultArray;
}
function intensity(){
	$fate = mt_rand(1,12);
	if($fate == 1){
		$result = "Annoyed - It rubs you wrong to be around this person, but you can control it";
	}elseif($fate == 2){
		$result = "Bothered - You can't restrain quips and cut downs when you are around this person";
	}elseif($fate == 3){
		$result = "Angry	- Proximity to this individual leads to arguments, shouting, yelling";
	}elseif($fate == 4){
		$result = " <br>";
	}elseif($fate == 5){
		$result = " <br>";
	}elseif($fate == 6){
		$result = " <br>";
	}elseif($fate == 7){
		$result = " <br>";
	}elseif($fate == 8){
		$result = " <br>";
	}elseif($fate == 9){
		$result = " <br>";
	}elseif($fate == 10){
		$result = " <br>";
	}elseif($fate == 11){
		$result = " <br>";
	}elseif($fate == 12){
		$result = " <br>";
	}
	$resultArray = [];
	$resultArray['intensity'] = $result;
	return $resultArray;
}
function friend(){
	$fate = mt_rand(1,12);
	if($fate == 1){
		$result = "Like a Big Brother or Sister to You - Someone that is older and looks after you, fussing over you at times";
	}elseif($fate == 2){
		$result = "Like a Kid Brother or Sister to You	- Someone you look after as well as tease<br>";
	}elseif($fate == 3){
		$result = "Teacher or Mentor - A sage becomes a friend that instructs you in matters<br>";
	}elseif($fate == 4){
		$result = "Partner or Co-worker - Someone you work with often becomes a close friend<br>";
	}elseif($fate == 5){
		$result = "An Old Lover - You said - I just want to be friends - and meant it<br>";
	}elseif($fate == 6){
		$result = "Bygones become bygones and old rivalries become funny stories with an old enemy";
	}elseif($fate == 7){
		$result = "Like a Foster Parent to You - This friend regails you with advice as well as cares for you<br>";
	}elseif($fate == 8){
		$result = "Old Childhood Friend - You bump into someone you had not seen in years<br>";
	}elseif($fate == 9){
		$result = "Relative - A relative becomes a friend as well as a relation<br>";
	}elseif($fate == 10){
		$result = "Gang or Tribe - Somehow you earn the friendship of a gang or tribe of people<br>";
	}elseif($fate == 11){
		$result = "Creature with Animal Intelligence - You befriend a badger or horse, or even a random Displacer Beast you can no longer find<br>";
	}elseif($fate == 12){
		$result = "Intelligent Creature - Maybe you ran into a Sphinx or a Wemic and managed to take the proverbial thorn out of the proverbial paw<br>";
	}
	$resultArray = [];
	$resultArray['eventtype'] = "Made a friend";
	$resultArray['event'] = $result;
	return $resultArray;
	//return friend_heft($result);
}
function enemy(){
	$fate = mt_rand(1,12);
	if($fate == 1){
		$result = "A former friend now hates you";
	}elseif($fate == 2){
		$result = "A former lover now hates you";
	}elseif($fate == 3){
		$result = "A relative now hates you";
	}elseif($fate == 4){
		$result = "A childhood enemy, an old face you hoped you would never see again has returned";
	}elseif($fate == 5){
		$result = "A person you worked for";
	}elseif($fate == 6){
		$result = "A person that worked for you, hates you";
	}elseif($fate == 7){
		$result = "A former partner turns to arguments";
	}elseif($fate == 8){
		$result = "You managed to step on the really wrong foot and now a gang or tribe hates you";
	}elseif($fate == 9){
		$result = "Someone amongst the law reall dislikes you";
	}elseif($fate == 10){
		$result = "Somehow you've come to the attention of dark forces, and they know your name";
	}elseif($fate == 11){
		$result = "You kicked that animal one time too many, and now it hates you to the bone";
	}elseif($fate == 12){
		$result = "You have raised the anger of a dragon";
	}
	$resultArray = [];
	$resultArray["eventtype"] = "Made an Enemy";
	$resultArray["event"] = $result;
	return $resultArray;
	//enemy_heft();
}

function romance(){
	$fate = mt_rand(1,12);
	if($fate == 1){
		$result = "The year is marked with relationships. You date several people throughout the year, each for about 1d12 weeks";
	}elseif($fate == 2){
		$result = "The year is marked with relationships. You date several people throughout the year, each for about 1d12 weeks";
	}elseif($fate == 3){
		$result = "You find a certain someone whom you date for 1d12 months";
	}elseif($fate == 4){
		$result = "You find a certain someone whom you date for 1d12 months";
	}elseif($fate == 5){
		$result = "A serious relationship has lasted into this year. Roll 1d12 - On a 1-5 it ends, on a 6-11 it continues through the year, on a 12 you marry";
	}elseif($fate == 6){
		$result = "A serious relationship has lasted into this year. Roll 1d12 - On a 1-5 it ends, on a 6-11 it continues through the year, on a 12 you marry";
	}elseif($fate == 7){
		$result = "You find someone else, while dating someone seriously. Roll 1d12 - odd they find out and dump you, even they never find out";
	}elseif($fate == 8){
		$result = "You find someone else, while dating someone seriously. Roll 1d12 - odd they find out and dump you, even they never find out";
	}elseif($fate == 9){
		$result = "Someone whom you'd been dating cheats on you. Roll 1d12. Even, you find out, odd they dump you and you don't know why";
	}elseif($fate == 10){
		$result = "Someone whom you'd been dating cheats on you. Roll 1d12. Even, you find out, odd they dump you and you don't know why";
	}elseif($fate == 11){
		$result = "Someone whom you'd been dating for over a year dies";
	}elseif($fate == 12){
		$result = "Pregnancy. Roll 1d12; 1-3 You leave, 4-6 He/she Leaves You, 7-8 You Marry, 9-12 Crossbow Point Wedding";
	}
	$resultArray = [];
	$resultArray["eventtype"] = "Romance";
	$resultArray["event"] = $result;
	return $resultArray;
}


function enlightenment(){
	$fate = mt_rand(1,12);
	$resultArray = [];
	if($fate == 1 || $fate == 2 ||  $fate == 3){
		//Attribute Improvement
		$fate_attr = mt_rand(1,12);
			if($fate_attr == 1 || $fate_attr == 2){
				$result['event'] = "Heavy labor and little rest develop your muscles (gain +1 Strength)";
			}elseif($fate_attr == 3 || $fate_attr == 4){
				$result['event'] = "Running with a band of rogues or maybe at the circuit with the jugglers sharpen your reflexes (gain +1 Dexterity)";
			}elseif($fate_attr == 5 || $fate_attr == 6){
				$result['event'] = "Training under a veteran or ex-mercenary, or time spent in harsh terrains, toughens you (gain +1 Constitution)";
			}elseif($fate_attr == 7 || $fate_attr == 8){
				$result['event'] = "Time spent at an university or with a scholar teaches valuable skills and how to apply rational thinking (gain +1 Intelligence)";
			}elseif($fate_attr == 9 || $fate_attr == 10){
				$result['event'] = "A sage or priest schools you in the benefits of faith and strength of mind (gain +1 Wisdom)";
			}elseif($fate_attr == 11 || $fate_attr == 12){
				$result['event'] = "You meet a very charismatic leader or powerful entertainer who teaches you the strength of assertiveness and charm (gain +1 Charisma)";
			}
		$resultArray["eventtype"] = "Enlightenment - Attribute Improvement";
		$resultArray["event"] = $result;
		return $resultArray;
	}elseif($fate == 4 || $fate == 5 ||  $fate == 6){
		//Skill Learning
		$fate_attr = mt_rand(1,12);
			if($fate_attr == 1){
				$result = "You are able to learn a new Strength-based skill.";
			}elseif($fate_attr == 2){
				$result = "Through lots of practice or much use, one of your Strength-based skills improves.";
			}elseif($fate_attr == 3){
				$result = "You are able to learn a new Dexterity-based skill.";
			}elseif($fate_attr == 4){
				$result = "Through lots of practice or much use, one of your Dexterity-based skills improves.";
			}elseif($fate_attr == 5){
				$result = "You are able to learn a new Constitution-based skill.";
			}elseif($fate_attr == 6){
				$result = "Through lots of practice or much use, one of your Constitution-based skills improves.";
			}elseif($fate_attr == 7){
				$result = "You are able to learn a new Intelligence-based skill.";
			}elseif($fate_attr == 8){
				$result = "Through lots of practice or much use, one of your Intelligence-based skills improves.";
			}elseif($fate_attr == 9){
				$result = "You are able to learn a new Wisdom-based skill.";
			}elseif($fate_attr == 10){
				$result = "Through lots of practice or much use, one of your Wisdom-based skills improves.";
			}elseif($fate_attr == 11){
				$result = "You are able to learn a new Charisma-based skill.";
			}elseif($fate_attr == 12){
				$result = "Through lots of practice or much use, one of your Charisma-based skills improves.";
			}
			$resultArray["eventtype"] = "New Skill";
			$resultArray["event"] = $result;
			return $resultArray;
	}elseif($fate == 7 || $fate == 8 ||  $fate == 9){
		//Magical Ability
		$fate_attr = mt_rand(1,12);
			if($fate_attr == 1){
				$result = "You learn a new Abjuration spell.";
			}elseif($fate_attr == 2){
				$result = "You learn a new Conjuration spell.";
			}elseif($fate_attr == 3){
				$result = "You learn a new Divination spell.";
			}elseif($fate_attr == 4){
				$result = "You learn a new Enchantment spell.";
			}elseif($fate_attr == 5){
				$result = "You learn a new Evocation spell.";
			}elseif($fate_attr == 6){
				$result = "You learn a new Illusion spell.";
			}elseif($fate_attr == 7){
				$result = "You learn a new Necromancy spell.";
			}elseif($fate_attr == 8){
				$result = "You learn a new Transmutation spell.";
			}elseif($fate_attr == 9){
				$result = "1/day	You somehow gain the ability to use a Spell-Like Ability 1/day";
			}elseif($fate_attr == 10){
				$result = "1/day	You somehow gain the ability to use a Spell-Like Ability 1/day";
			}elseif($fate_attr == 11){
				$result = "1/day	You somehow gain the ability to use a Supernatural Ability 1/day";
			}elseif($fate_attr == 12){
				$result = "1/day	You somehow gain the ability to use a Supernatural Ability 1/day";
			}
			$resultArray["eventtype"] = "Magical Gift";
			$resultArray["event"] = $result;
			return $resultArray;
	}elseif($fate == 10 || $fate == 11 ||  $fate == 12){
		//New Feat
			$fate_attr = mt_rand(1,12);
			if($fate_attr == 1){
				$result = "You learn how to use a weapon.";
			}elseif($fate_attr == 2){
				$result = "You learn how to use a weapon.";
			}elseif($fate_attr == 3){
				$result = "You learn how to handle a type of armor or shield.";
			}elseif($fate_attr == 4){
				$result = "You learn how to handle a type of armor or shield.";
			}elseif($fate_attr == 5){
				$result = "You gain a feat (for which you meet the prerequisites) which only improves skill(s).";
			}elseif($fate_attr == 6){
				$result = "You gain a feat (for which you meet the prerequisites) which only improves skill(s).";
			}elseif($fate_attr == 7){
				$result = "You learn a new Feat that has no prerequisites.";
			}elseif($fate_attr == 8){
				$result = "You learn a new Feat that has no prerequisites.";
			}elseif($fate_attr == 9){
				$result = "You learn a new General Feat for which you meet the prerequisites.";
			}elseif($fate_attr == 10){
				$result = "You learn a new General Feat for which you meet the prerequisites.";
			}elseif($fate_attr == 11){
				$result = "You learn a new Feat for which you meet the prerequisites.";
			}elseif($fate_attr == 12){
				$result = "You learn a new Feat for which you meet the prerequisites.";
			}
			$resultArray["eventtype"] = "New Feat";
			$resultArray["event"] = $result;
			return $resultArray;
	}
}

function fate(){
			$fate = mt_rand(1,12);
			if($fate == 1 || $fate == 2){
				//Tragedy
				$result = tragedy();
			}elseif($fate == 3 || $fate == 4){
				//Windfall
				$result = windfall();
			}elseif($fate == 5 || $fate == 6){
				//Friend
				$result = friend();
			}elseif($fate == 7 || $fate == 8){
				//Enemy
				$result = enemy();
			}elseif($fate == 9 || $fate == 10){
				//Romance
				$result = romance();
			}elseif($fate == 11 || $fate == 12){
				//Enlightenment
				$result = enlightenment();
			}
			return $result;
}

//Handle Errors
function error_modal($title,$message){
	echo '<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
	<div class="modal-dialog"><div class="modal-content"><div class="modal-header alert-danger">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title">'.$title.'</h4></div><div class="modal-body">';
	echo $message;
	echo '</div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div></div></div></div>
	<script>$("#myModal").modal();</script>';
}

function array_to_obj($array, &$obj){
	foreach ($array as $key => $value){
		if (is_array($value)){
			$obj->$key = new stdClass();
			array_to_obj($value, $obj->$key);
		}else{
			$obj->$key = $value;
		}
	}
	return $obj;
}
	
function arrayToObject($array){
	$object= new stdClass();
	return array_to_obj($array,$object);
}
?>