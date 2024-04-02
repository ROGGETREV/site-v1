<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header('Content-Type: application/json');

if(!$loggedin && !$guestEnabled || !isset($_REQUEST["game"])) exit;

if(!$loggedin && $guestEnabled) {
    $guestId = -1 * random_int(1, 9999);
    $user = [
        "id" => $guestId,
        "username" => "Guest ".$guestId,
        "gameAuthentication" => "guest"
    ];
}

// Place join status results
// Waiting = 0,
// Loading = 1,
// Joining = 2,
// Disabled = 3,
// Error = 4,
// GameEnded = 5,
// GameFull = 6
// UserLeft = 10
// Restricted = 11
?>
-- ROGGET PlaceLauncher and Joining handler
-- Apparently we're forced to using a coroutine, oh well, if it works it works

currentRandInt = 0
function randint()
    currentRandInt = (currentRandInt + 74864)
    return currentRandInt
end

function splitString(inputstr, sep)
	if sep == nil then
			sep = "%s"
	end
	local t={}
	for str in string.gmatch(inputstr, "([^"..sep.."]+)") do
			table.insert(t, str)
	end
	return t
end

-- I should remove that
function getPLStatusString(status)
    if status == 0 then
        return "Waiting for server..."
    elseif status == 1 then
        return "Server found, loading..."
    elseif status == 2 then
        return "Joining server"
    else
        return "Unknown status"
    end
end

coroutine.wrap(function()
    -- Setting things up
    authentication = "<?php echo addslashes($user["gameAuthentication"]); ?>"
    username = "<?php echo addslashes($user["username"]); ?>"
    userid = <?php echo (int)$user["id"]; ?>

    -- CoreScripts and disabling menus
    game:GetService("NetworkClient")
    dofile("http://shitblx.cf/Game/2011/Cores/StarterScript.lua?authentication="..authentication)

    game:SetMessage("Hello, "..username.."! ROGGET is currently requesting authentication.")

    canJoin = false

    while not canJoin do
        placeLauncherResponse = splitString(game:httpGetAsync("http://shitblx.cf/Game/2011/PlaceLauncher.ashx?authentication="..authentication.."&game=<?php echo (int)$_REQUEST["game"]; ?>&"..randint()), ";")
        if placeLauncherResponse[1] == "false" then
            game:SetMessage("Failed to request ROGGET for the game!")
            wait(math.huge)
        end
        status = tonumber(placeLauncherResponse[2])
        if status == 0 then
            game:SetMessage("Searching for a server...")
            wait(5)
        elseif status == 1 then
            game:SetMessage("Server found, loading...")
            wait(5)
        elseif status == 2 then
            game:SetMessage("Currently loading into the server, "..username.."!")
            canJoin = true
        else
            game:SetMessage("ROGGET will retry requesting authentication in 5 seconds.")
            wait(5)
        end
    end

    dofile(placeLauncherResponse[3].."?authentication="..authentication.."&game=<?php echo (int)$_REQUEST["game"]; ?>&"..randint())
end)()