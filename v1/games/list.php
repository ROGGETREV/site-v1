<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header("content-type: application/json");

function getArrayFromGame($game) {
    global $con;
    $q = $con->prepare("SELECT * FROM users WHERE id = :id");
    $q->bindParam(':id', $game["creator"], PDO::PARAM_INT);
    $q->execute();
    $usr = $q->fetch();
    return [
        "creatorId" => (int)$usr["id"],
        "creatorName" => $usr["username"],
        "creatorType" => "User",
        "creatorHasVerifiedBadge" => (bool)$usr["verified"],
        "totalUpVotes" => 0,
        "totalDownVotes" => 0,
        "universeId" => (int)$game["id"],
        "name" => $game["name"],
        "placeId" => (int)$game["id"],
        "playerCount" => (int)$game["players"],
        "imageToken" => "/images/Games/Get.ashx?ID=".(int)$game["id"],
        "isSponsored" => false,
        "nativeAdData" => "",
        "isShowSponsoredLabel" => false,
        "price" => null,
        "analyticsIdentifier" => null,
        "gameDescription" => $game["description"],
        "genre" => $game["genre"],
        "minimumAge" => 0,
        "ageRecommendationDisplayName" => ""
    ];
}

$games = [];
$q = $con->prepare("SELECT * FROM games");
$q->execute();
foreach($q->fetchAll() as $game) array_push($games, getArrayFromGame($game));

echo json_encode([
    "games" => $games,
    "suggestedKeyword" => "",
    "correctedKeyword" => "",
    "filteredKeyword" => "",
    "hasMoreRows" => false,
    "nextPageExclusiveStartId" => 0,
    "featuredSearchUniverseId" => 0,
    "emphasis" => true,
    "cutOffIndex" => 0,
    "algorithm" => "",
    "algorithmQueryType" => "",
    "suggestionAlgorithm" => "",
    "relatedGames" => [],
    "esDebugInfo" => [
        "esQuery" => ""
    ]
]);