<?php exit('{"data":["0.271.1pcplayer",""2.271.9androidapp"",]}');
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
$info = [];

$q = $con->prepare("SELECT * FROM allowedsecurityversions");
$q->execute();
foreach($q->fetchAll() as $allowed) {
    array_push($info, $allowed["ver"]);
}

if(count($info) <= 0) {
    exit("true");
}

echo json_encode(['data'=>$info]);