<?php
// Author:  Victor L. Lee, January 1, 2015
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Cache-Control: public");

function newGameJSON () {
	$chessgame = '[{"Piece":"R1","Color":"W","Cell":"A1"}';
	$chessgame .=',{"Piece":"N1","Color":"W","Cell":"B1"}';
	$chessgame .=',{"Piece":"B1","Color":"W","Cell":"C1"}';
	$chessgame .=',{"Piece":"K","Color":"W","Cell":"E1"}';
	$chessgame .=',{"Piece":"Q","Color":"W","Cell":"D1"}';
	$chessgame .=',{"Piece":"B2","Color":"W","Cell":"F1"}';
	$chessgame .=',{"Piece":"N2","Color":"W","Cell":"G1"}';
	$chessgame .=',{"Piece":"R2","Color":"W","Cell":"H1"}';
	$chessgame .=',{"Piece":"P1","Color":"W","Cell":"A2"}';
	$chessgame .=',{"Piece":"P2","Color":"W","Cell":"B2"}';
	$chessgame .=',{"Piece":"P3","Color":"W","Cell":"C2"}';
	$chessgame .=',{"Piece":"P4","Color":"W","Cell":"D2"}';
	$chessgame .=',{"Piece":"P5","Color":"W","Cell":"E2"}';
	$chessgame .=',{"Piece":"P6","Color":"W","Cell":"F2"}';
	$chessgame .=',{"Piece":"P7","Color":"W","Cell":"G2"}';
	$chessgame .=',{"Piece":"P8","Color":"W","Cell":"H2"}';

	$chessgame .=',{"Piece":"R1","Color":"B","Cell":"A8"}';
	$chessgame .=',{"Piece":"N1","Color":"B","Cell":"B8"}';
	$chessgame .=',{"Piece":"B1","Color":"B","Cell":"C8"}';
	$chessgame .=',{"Piece":"K","Color":"B","Cell":"E8"}';
	$chessgame .=',{"Piece":"Q","Color":"B","Cell":"D8"}';
	$chessgame .=',{"Piece":"B2","Color":"B","Cell":"F8"}';
	$chessgame .=',{"Piece":"N2","Color":"B","Cell":"G8"}';
	$chessgame .=',{"Piece":"R2","Color":"B","Cell":"H8"}';
	$chessgame .=',{"Piece":"P1","Color":"B","Cell":"A7"}';
	$chessgame .=',{"Piece":"P2","Color":"B","Cell":"B7"}';
	$chessgame .=',{"Piece":"P3","Color":"B","Cell":"C7"}';
	$chessgame .=',{"Piece":"P4","Color":"B","Cell":"D7"}';
	$chessgame .=',{"Piece":"P5","Color":"B","Cell":"E7"}';
	$chessgame .=',{"Piece":"P6","Color":"B","Cell":"F7"}';
	$chessgame .=',{"Piece":"P7","Color":"B","Cell":"G7"}';
	$chessgame .=',{"Piece":"P8","Color":"B","Cell":"H7"}';

	$chessgame .=',{"Piece":"Q2","Color":"W","Cell":"pieces"}';
	$chessgame .=',{"Piece":"Q2","Color":"B","Cell":"pieces"}';
	$chessgame .= ']';
	return $chessgame;
};

function updateJoinTime($IP,$p) {  // update JOIN timestamp
	$userFile = fopen("users/".$IP.".txt", "w"); 
    fwrite ($userFile,$p);
	fclose($userFile);
}
function joinLast($IP) {  // get the last game played
  if(!file_exists("users/".$IP.".txt"))  {
	$userFile = fopen("users/".$IP.".txt", "r"); 
    $p=fgets ($userFile,200); // assuming line is 200 char max
	fclose($userFile);
  }else {
    $p="anyplayer";
  }
  return $p;
}
function getJoinTime($IP,$p){  // returns JOIN timestamp
  if(!file_exists("users/".$IP.".txt"))  {
    updateJoinTime($IP,$p);
  }  
  clearstatcache(); 
  $jtime = filemtime("users/".$IP.".txt");
  $jtime = ($jtime) ? $jtime:0;
return $jtime;
};

function checkForChatUpdate(&$sess, $p){  // true if update needed, also updates the sess
  clearstatcache(); 
  $chatsess = filemtime("chat/".$p."_chat.txt");
  $chatsess = ($chatsess) ? $chatsess:0;
  $r = ($sess!=$chatsess);
  $sess=$chatsess;
return $r;
};

function getChatFile($p) {
	$chatfile = fopen("chat/".$p."_chat.txt", "r"); 
	$r= fread($chatfile,filesize("chat/".$p."_chat.txt"));
	fclose($chatfile);
return $r;
};

function saveChatFile($p, $cs) {
    $fchat = fopen ("chat/".$p."_chat.txt","w"); 
	fwrite($fchat,$cs);
	fclose ($fchat);
};

function checkForChessUpdate(&$sess, $p){
  clearstatcache(); 
  $boardsess = filemtime("games/".$p.".json");
  $boardsess = ($boardsess) ? $boardsess:0;
  $r = ($sess!=$boardsess);
  $sess=$boardsess;
return $r;
};

function getGameListJSON () {
  $r="[";
  $first = true;
  foreach (array_diff(scandir("games"), array('..', '.')) as $g) {  // diff to remove root and parent .. and . 
    if (!$first) $r .= ","; else $first=false;
    $r .= '{"game":"'.substr($g,0,-5).'"}'; 
  }; 
  $r .= "]";
  return $r;
}

function getBoardFile($p) {
 if (file_exists("games/".$p.".json")) {
	$boardfile = fopen("games/".$p.".json", "r"); 
	$r= fread($boardfile,filesize("games/".$p.".json"));
	fclose($boardfile);
    } 
 else {
	$r = newGameJSON();
	};
return $r;
};
// ----------------------------------------------------------main--------------------------------------
if(!file_exists("chat")) {mkdir ("chat",0766);};  
if(!file_exists("games")) {mkdir ("games",0766);};
if(!file_exists("users")) {mkdir ("users",0777);};  //$IP = $_SERVER['REMOTE_ADDR'] in /user/$IP.txt

$p = ($_POST["players"] == "" ? "anyplayer" : $_POST["players"]); $p=strtolower($p);
$b = $_POST["msg"]; 
if (get_magic_quotes_gpc()) $b = stripslashes($b); 

$t=microtime(true);
// $time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];

// DATA BLOCK TO SEND BACK TO CLIENT
$state="_";  
$ts=date("Y.m.d_H:i:s.II",$t);

$sesschat =  (!isset($_POST["sesschat"]) || is_null($_POST["sesschat"])) ? 0 : $_POST["sesschat"]; 
$sessboard=  (!isset($_POST["sessboard"]) || is_null($_POST["sessboard"])) ? 0 : $_POST["sessboard"]; 

$IP  = $_SERVER["REMOTE_ADDR"];     // user's IP address
$msg = "_";   //msg - sent to client
$data= '"_"';   //data - sent to client - is JSON content
$JoinTime = getJoinTime($IP,$p);

switch ($_POST["command"]){
  case "awaiting":
	$state = "awaiting";
	$msg = "error.  this message should not be seen.";
	$looping = true;
	$ii=0;

	do { 
	if ($JoinTime !== getJoinTime($IP,$p)) {   // when user joins another game, must terminate the current wait loop 
		$looping=false;
		$state="joinupdate";  //"update" here means, refresh/update the AWAITING loop
		$msg="Player at ".$IP." has joined a new game! Leaving game ".$p.".";
	}
	elseif (checkForChatUpdate($sesschat,$p)) { 
		$looping=false;
		$state="chatupdate";
		$msg=getChatFile($p);
		}
	elseif (checkForChessUpdate($sessboard,$p)) { 
		$looping=false;
		$state="boardupdate";
		$msg="board status for game ".$p.", sessboard:".$sessboard." filemtime:".filemtime("games/".$p.".json"); 
		$data=getBoardFile($p);
		};
	if ($looping) { 
	    if ($ii<60) {$ii++; usleep(500000);}   //60*0.5s; refresh await at 30s
		else {$ii=0; $looping=false; $msg='+Δ'.date("s.II",microtime(true)-$t)."s wait done, requesting renew.";}
		}
	} while ($looping);
	break;
	
  case "chat":
    $msg=rawurldecode(stripslashes($_POST["msg"]));
    saveChatFile($p, $msg);
	$state = "chatACK";
	break;    
	
  case "gameList":
	$data = getGameListJSON();
	$state = "gamelistupdate";
	$msg = "Latest games list. Request from IP ".$IP;
    break; 

  case "join":
	$sessboard = -99; //clear sess
	updateJoinTime($IP,$p);  // set up a flag, this will kill AWAITING loop for prior game user was in 
	$state = "joinACK";
	$msg = "Joining game ".$p.". Request from IP ".$IP;
    break; 

  case "joinLast":
	$sessboard = -99;    //clear sess; will make the AWAIT LOOP know to update the board
	$p = joinLast($IP);  // get last game the player at IP was joined to
	$data = $p;          // sent back to client, let them know the last game played
	$state = "joinlastACK";
	$msg = "Get last game ".$p.". Request from IP ".$IP;
    break; 

  case "new":  // load a new game, save it.  the save will trigger a update for all people
	$boardFile = fopen("games/".$p.".json", "w"); 
	fwrite ($boardFile,newGameJSON());
	fclose($boardFile);
	$state = "newACK";
	$msg = "NEW game ".$p." request from IP ".$IP;
	break;
	
  case "save":
	$boardFile = fopen("games/".$p.".json", "w"); 
	fwrite ($boardFile,$b);
	fclose($boardFile);
	$msg = "SAVE command received.";
	$state = "saveACK";
    break;
   
  default:
    echo "Unrecognised command.";
}

$reply = '[{"state":"'.$state.'","msg":"'.$msg.'","timestamp":"'.$ts.'","sesschat":"'.$sesschat.'","sessboard":"'.$sessboard.'","data":'.$data.'}]';
echo ($reply);  // send the stuff to the client!!!  this must be a JSON string

?>