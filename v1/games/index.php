<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header("content-type: application/json");

$info = [];

if(!isset($_REQUEST["universeIds"])) {
    exit;
}

$id = (int)$_REQUEST["universeIds"];

$q = $con->prepare("SELECT * FROM games WHERE id = :id");
$q->bindParam(':id', $id, PDO::PARAM_INT);
$q->execute();
$game = $q->fetch();
if(!$game) {
    exit;
}

$q = $con->prepare("SELECT * FROM users WHERE id = :id");
$q->bindParam(':id', $game["creator"], PDO::PARAM_INT);
$q->execute();
$usr = $q->fetch();
if(!$usr) {
    exit;
}

$info = [
    "data" => [
        [
            "id" => (int)$game["id"],
            "rootPlaceId" => (int)$game["id"],
            "name" => $game["name"],
            "description" => $game["description"],
            "sourceName" => $game["name"],
            "sourceDescription" => $game["description"],
            "creator" => [
                "id" => (int)$usr["id"],
                "name" => $usr["username"],
                "type" => "User",
                "isRNVAccount" => false,
                "hasVerifiedBadge" => (bool)$usr["verified"]
            ],
            "price" => null,
            "allowedGearGenres" => [ "All" ],
            "allowedGearCategories" => [],
            "isGenreEnforced" => true,
            "copyingAllowed" => false,
            "playing" => (int)$game["players"],
            "visits" => 0,
            "maxPlayers" => (int)$game["maxplayers"],
            "created" => date("Y-m-d\TH:i:s.u\Z", (int)$game["created"]),
            "updated" => date("Y-m-d\TH:i:s.u\Z", (int)$game["updated"]),
            "studioAccessToApisAllowed" => false,
            "createVipServersAllowed" => false,
            "universeAvatarType" => "MorphToR6",
            "genre" => "All",
            "isAllGenre" => true,
            "isFavoritedByUser" => false,
            "favoritedCount" => 0
        ]
    ]
];

echo json_encode($info);