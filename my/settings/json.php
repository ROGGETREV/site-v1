<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
$info = [
    "ChangeUsernameEnabled" => false,
    "IsAdmin" => false,
    "MyLazyAss" => "CantFinishThis"
];

if($loggedin) {
    $admin = false;
    if($user["permission"] === "Administrator") $admin = true;

    $info = [
        "ChangeUsernameEnabled" => false,
        "IsAdmin" => $admin,
        "UserId" => (int)$user["id"],
        "Name" => $user["username"],
        "IsEmailOnFile" => false,
        "IsEmailVerified" => false,
        "IsPhoneFeatureEnabled" => false,
        "RobuxRemainingForUsernameChange" => 1000,
        "PreviousUserNames" => "",
        "UseSuperSafePrivacyMode" => false,
        "IsAppChatSettingEnabled" => true,
        "IsGameChatSettingEnabled" => true,
        "IsParentalSpendControlsEnabled" => true,
        "IsSetPasswordNotificationEnabled" => false,
        "ChangePasswordRequiresTwoStepVerification" => false,
        "UserEmail" => null,
        "UserEmailMasked" => true,
        "UserEmailVerified" => false,
        "CanHideInventory" => true,
        "CanTrade" => true,
        "MissingParentEmail" => false,
        "IsUpdateEmailSectionShown" => true,
        "IsUnder13UpdateEmailMessageSectionShown" => false,
        "IsUserConnectedToFacebook" => false,
        "IsTwoStepToggleEnabled" => false,
        "AgeBracket" => 0,
        "UserAbove13" => true,
        "ClientIpAddress" => "127.0.0.1",
        "AccountAgeInDays" => null,
        "IsPremium" => false,
        "IsBcRenewalMembership" => true,
        "PremiumFeatureId" => null,
        "HasCurrencyOperationError" => false,
        "CurrencyOperationErrorMessage" => null,
        "Tab" => null,
        "ChangePassword" => true,
        "IsAccountPinEnabled" => true,
        "IsAccountRestrictionsFeatureEnabled" => true,
        "IsAccountRestrictionsSettingEnabled" => false,
        "IsAccountSettingsSocialNetworksV2Enabled" => true,
        "IsUiBootstrapModalV2Enabled" => true,
        "IsDateTimeI18nPickerEnabled" => true,
        "InApp" => false,
        "MyAccountSecurityModel" => [
            "IsEmailSet" => false,
            "IsEmailVerified" => true,
            "IsTwoStepEnabled" => false,
            "ShowSignOutFromAllSessions" => true,
            "TwoStepVerificationViewModel" => [
                "UserId" => null,
                "IsEnabled" => false,
                "CodeLength" => 0,
                "ValidCodeCharacters" => null
            ]
        ],
        "ApiProxyDomain" => "https://shitblx.cf",
        "AccountSettingsApiDomain" => "https://shitblx.cf",
        "AuthDomain" => "https://shitblx.cf",
        "IsDisconnectFacebookEnabled" => true,
        "IsDisconnectXboxEnabled" => true,
        "NotificationSettingsDomain" => "https://shitblx.cf",
        "AllowedNotificationSourceTypes" => [
            "Test",
            "FriendRequestReceived",
            "FriendRequestAccepted",
            "PartyInviteReceived",
            "PartyMemberJoined",
            "ChatNewMessage",
            "PrivateMessageReceived",
            "UserAddedToPrivateServerWhiteList",
            "ConversationUniverseChanged",
            "TeamCreateInvite",
            "GameUpdate",
            "DeveloperMetricsAvailable",
            "GroupJoinRequestAccepted",
            "Sendr",
            "ExperienceInvitation"
        ],
        "AllowedReceiverDestinationTypes" => [
            "DesktopPush",
            "NotificationStream"
        ],
        "BlacklistedNotificationSourceTypesForMobilePush" => [],
        "MinimumChromeVersionForPushNotifications" => 50,
        "PushNotificationsEnabledOnFirefox" => true,
        "LocaleApiDomain" => "https://shitblx.cf",
        "HasValidPasswordSet" => true,
        "IsFastTrackAccessible" => false,
        "HasFreeNameChange" => false,
        "IsAgeDownEnabled" => true,
        "IsDisplayNamesEnabled" => true,
        "IsBirthdateLocked" => false
    ];
}

echo json_encode($info);