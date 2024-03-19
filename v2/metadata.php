<?php
echo json_encode([
    "isChatEnabledByPrivacySetting" => 1,
    "languageForPrivacySettingUnavailable" => "Chat is currently unavailable",
    "maxConversationTitleLength" => 150,
    "numberOfMembersForPartyChrome" => 6,
    "partyChromeDisplayTimeStampInterval" => 300000,
    "signalRDisconnectionResponseInMilliseconds" => 3000,
    "typingInChatFromSenderThrottleMs" => 5000,
    "typingInChatForReceiverExpirationMs" => 8000,
    "relativeValueToRecordUiPerformance" => 0.0,
    "isChatDataFromLocalStorageEnabled" => false,
    "chatDataFromLocalStorageExpirationSeconds" => 30,
    "isUsingCacheToLoadFriendsInfoEnabled" => false,
    "cachedDataFromLocalStorageExpirationMS" => 30000,
    "senderTypesForUnknownMessageTypeError" => [
        "User"
    ],
    "isInvalidMessageTypeFallbackEnabled" => true,
    "isRespectingMessageTypeEnabled" => true,
    "validMessageTypesWhiteList" => [
        "PlainText",
        "Link"
    ],
    "shouldRespectConversationHasUnreadMessageToMarkAsRead" => true,
    "isAliasChatForClientSideEnabled" => true,
    "isPlayTogetherForGameCardsEnabled" => true,
    "isRoactChatEnabled" => true
]);