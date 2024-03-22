<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header('Content-Type: application/json');
$defaultProductinfo = [
    "TargetId" => 1818,
    "ProductType" => "User Product",
    "AssetId" => 1818,
    "ProductId" => 1818,
    "Name" => "Asset",
    "Description" => "",
    "AssetTypeId" => 9,
    "Creator" => [
        "Id" => 1,
        "Name" => "nolanwhy",
        "CreatorType" => "User",
        "CreatorTargetId" => 1
    ],
    "IconImageAssetId" => 69,
    "Created" => "1889-04-20",
    "Updated" => "1889-04-20",
    "PriceInRobux" => null,
    "PriceInTickets" => null,
    "Sales" => 0,
    "IsNew" => false,
    "IsForSale" => false,
    "IsPublicDomain" => false,
    "IsLimited" => false,
    "IsLimitedUnique" => false,
    "Remaining" => null,
    "MinimumMembershipLevel" => 0,
    "ContentRatingTypeId" => 0
];
if(!isset($_GET["assetId"])) {
    $productinfo = $defaultProductinfo;
}
$assetid = (int)$_GET["assetId"];
$q = $con->prepare("SELECT * FROM games WHERE id = :id");
$q->bindParam(':id',$assetid,PDO::PARAM_INT);
$q->execute();
$item = $q->fetch();
if(!$item) {
    $q = $con->prepare("SELECT * FROM gamepasses WHERE assetid = :id");
    $q->bindParam(':id',$assetid,PDO::PARAM_INT);
    $q->execute();
    $item = $q->fetch();
    if(!$item) {
        header('location: https://economy.roblox.com/v2/assets/'.$assetid.'/details');
        exit;
    }
    // $productinfo = $defaultProductinfo;
}
$q = $con->prepare("SELECT * FROM users WHERE id = :id");
$q->bindParam(':id',$item["creator"],PDO::PARAM_INT);
$q->execute();
$creator = $q->fetch();
if(!$creator) {
    $productinfo = $defaultProductinfo;
}
if(!isset($productinfo)) {
    $productinfo = [
        "TargetId" => $item["id"],
        "ProductType" => "User Product",
        "AssetId" => $item["id"],
        "ProductId" => $item["id"],
        "Name" => filterBadWords($item["name"]),
        "Description" => filterBadWords($item["description"]),
        "AssetTypeId" => 9,
        "Creator" => [
            "Id" => $creator["id"],
            "Name" => filterBadWords($creator["username"]),
            "CreatorType" => "User",
            "CreatorTargetId" => $creator["id"]
        ],
        "IconImageAssetId" => 69,
        "Created" => $item["created"],
        "Updated" => $item["updated"],
        "PriceInRobux" => null,
        "PriceInTickets" => null,
        "Sales" => 0,
        "IsNew" => false,
        "IsForSale" => false,
        "IsPublicDomain" => false,
        "IsLimited" => false,
        "IsLimitedUnique" => false,
        "Remaining" => null,
        "MinimumMembershipLevel" => 0,
        "ContentRatingTypeId" => 0
    ];
}
echo json_encode($productinfo, JSON_UNESCAPED_SLASHES);