<?php
error_reporting(0);
header('Content-Type: text/plain');
if($_REQUEST["apiKey"] === "EHbKaHdKKrWlRfxneJkbEUWo9vZVLE64") {
    echo "function waitForChild(instance, name)
    while not instance:findFirstChild(name) do
        instance.ChildAdded:wait()
    end
end\n";
    if($_REQUEST["authentication"] === "nolanwhyfrfr") {
        echo "print('Authentication check success')
waitForChild(game.Players, '".addslashes($_REQUEST["authentication"])."')
plr = game.Players:findFirstChild('".addslashes($_REQUEST["authentication"])."')
plr.Name = 'nolanwhy'
plr.userId = 69";
    } else {
        echo "print('Authentication check failed')
waitForChild(game.Players, '".addslashes($_REQUEST["authentication"])."')
plr = game.Players:findFirstChild('".addslashes($_REQUEST["authentication"])."')
pcall(function() kickPlayer(plr, \"Authentication check failed\") end)
pcall(function()
    plr.Name = 'Auth check fail'
    plr:remove()
end)";
    }
} else {
    echo "print('API Key is incorrect! Could not check authentication.')";
}