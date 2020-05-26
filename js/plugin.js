// DOM Ready!
$(function () {

    // Run every second
    var heartbeatChecker = setInterval(startHeartbeatChecker, 1000);

    function startHeartbeatChecker()
    {

        var request = $.ajax({
            url: heartbeatPluginEndpoint,
            method: "GET",
        });

        request.done(function (msg) {
            if (msg.isLoggedIn !== true) {
                stopHeartbeatChecker();
            }
        });

        request.fail(function (jqXHR, textStatus) {
            stopHeartbeatChecker();
        });

    }

    function stopHeartbeatChecker()
    {
        clearInterval(heartbeatChecker);
        alert("DANGER! You were logged out / lost network connectivity\n\nBackup the page content manually to a file.");
    }

})
