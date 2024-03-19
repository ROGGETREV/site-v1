<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header("content-type: application/json");
$info = [
    "keyword" => null,
    "previousPageCursor" => null,
    "nextPageCursor" => "2_1_d515f723411532860176328ad9b4f4ba",
    "data" => []
];

$q = $con->prepare("SELECT * FROM catalog");
$q->execute();
foreach($q->fetchAll() as $item) {
    $qq = $con->prepare("SELECT * FROM users WHERE id = :id");
    $qq->bindParam(':id', $item["creator"], PDO::PARAM_INT);
    $qq->execute();
    $usr = $qq->fetch();
    if($usr) {
        $info["data"][] = [
            "id" => (int)$item["id"],
            "itemType" => $item["type"],
            "bundleType" => null,
            "name" => $item["name"],
            "description" => $item["description"],
            "productId" => (int)$item["id"],
            "itemStatus" => [],
            "itemRestrictions" => [],
            "creatorHasVerifiedBadge" => (bool)$usr["verified"],
            "creatorType" => "User",
            "creatorTargetId" => (int)$usr["id"],
            "creatorName" => $usr["username"],
            "price" => (int)$item["nuggets"],
            "purchaseCount" => 0,
            "favoriteCount" => 0,
            "offSaleDeadline" => null,
            "saleLocationType" => "NotApplicable"
        ];
    }
}

echo json_encode($info);