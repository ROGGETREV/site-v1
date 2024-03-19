<?php
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
echo json_encode([
    'jobId' => 'Test',
    'status' => 11,
    'joinScriptUrl' => "",
    'authenticationUrl' => "",
    'authenticationTicket' => '',
    'message' => "Goofy ahh uncle productions"
]);