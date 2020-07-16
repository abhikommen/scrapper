<?php
include("simple_html_dom.php");
$completeHtml = file_get_html("https://livescore.sportzwiki.com/");
$article = $completeHtml->find('div[id=content]');
$divTeams = $article[0]->find("div.column-teams");
$divMeta = $article[0]->find("div.column-meta");

// foreach ($divMeta as $meta) {

  // code...
  $jsonArray = array();
  for($i=0;$i<count($divMeta);$i++){

  $jsonObject = array();
  $jsonObject["status"] = $divMeta[$i]->find('span.status',0)->plaintext;
  $jsonObject["day"] = $divMeta[$i]->find('span.day', 0)->plaintext;
  $jsonObject["title"] = $divMeta[$i]->find('span.title', 0)->plaintext;
  $jsonObject["subtitle"] = $divMeta[$i]->find('span.subtitle', 0)->plaintext;

  $jsonObject["match_title"] = $divMeta[$i]->find('div.title', 0)->plaintext;
  $jsonObject["match_subtitle"] = $divMeta[$i]->find('div.subtitle', 0)->plaintext;
  $jsonObject["match_venue"] = $divMeta[$i]->find('div.venue', 0)->plaintext;
  $jsonObject["match_time"] = $divMeta[$i]->find('span.time', 0)->plaintext;

  $teamA = $divTeams[$i]->find('div.teama', 0);
  $jsonObject["match_status_note"] =  $divTeams[$i]->find('div.status_note', 0)->plaintext;

  if (($teamA->find('div.teamLogo',0)->find('a, img',0))) {
    // code...
    $jsonObject["first_team_logo"] =  $teamA->find('div.teamLogo',0)->find('a, img',0)->src;
  } else {
    $jsonObject["first_team_logo"] =  'NA';
  }
  
  if (($teamA->find('div.teamScore',0))) {
    // code...
    $jsonObject["first_team_score"] =  $teamA->find('div.teamScore',0)->plaintext;
  } else {
    $jsonObject["first_team_score"] =  'NA';
  }
  
  $jsonObject["first_team_name"] = $teamA->find('div.teamName', 0)->plaintext;

  $jsonObject["first_team_abbr"] = $teamA->find('div.teamAbbr', 0)->plaintext;

  if(($teamA->find('span.inningScore', 0))) {
    $jsonObject["first_team_inningscore"] = $teamA->find('span.inningScore', 0)->plaintext;
}else{
  $jsonObject["first_team_inningscore"] = 'NA';
}

if(($teamA->find('span.inningScore', 1))) {
  $jsonObject["first_team_inningscore2"] = $teamA->find('span.inningScore', 1)->plaintext;
}else {
  $jsonObject["first_team_inningscore2"] = 'NA';

}

  $teamB = $divTeams[$i]->find('div.teamb', 0);

  if (($teamB->find('div.teamLogo',0)->find('a, img',0))) {
    // code...
    $jsonObject["second_team_logo"] =  $teamB->find('div.teamLogo',0)->find('a, img',0)->src;
  } else {
    $jsonObject["second_team_logo"] =  "NA";
  }
    $jsonObject["second_team_name"] = $teamB->find('div.teamName', 0)->plaintext;
  $jsonObject["second_team_abbr"] = $teamB->find('div.teamAbbr', 0)->plaintext;
  
   if (($teamB->find('div.teamScore',0))) {
    // code...
    $jsonObject["second_team_score"] =  $teamB->find('div.teamScore',0)->plaintext;
  } else {
    $jsonObject["second_team_score"] =  'NA';
  }

  if(($teamB->find('span.inningScore', 0))) {
    $jsonObject["second_team_inningscore"] = $teamB->find('span.inningScore', 0)->plaintext;
}else{
  $jsonObject["second_team_inningscore"] = 'NA';
}

if(($teamB->find('span.inningScore', 1))) {
  $jsonObject["second_team_inningscore2"] = $teamB->find('span.inningScore', 1)->plaintext;
}else {
  $jsonObject["second_team_inningscore2"] = 'NA';

}


  //$jsonObject["first_team_inningscore2"] = $teamA->find('span.inningScore', 1)->plaintext;
  $jsonArray[$i] = $jsonObject;
}
$out = array_values($jsonArray);

$x = json_encode($out);
echo $x;

?>
