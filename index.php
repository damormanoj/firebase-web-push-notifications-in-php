<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://www.gstatic.com/firebasejs/5.2.0/firebase.js"></script>
    <!-- Firebase App is always required and must be first -->
    <script src="https://www.gstatic.com/firebasejs/5.2.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.2.0/firebase-messaging.js"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script>
        // Initialize Firebase
        var config = {
           
        };

        firebase.initializeApp(config);

        var messaging = firebase.messaging();

        messaging.usePublicVapidKey("usePublicVapidKey");

        messaging.requestPermission().then(function() {
            console.log("ok permission");
            return messaging.getToken();
        }).then(function(token) {
            console.log("get token");
            console.log(token);
            document.getElementById('token').innerHTML = token;
/// for save token
            // $.ajax({
            //     url: 'http://localhost:53188/firebase/savetoken?token=' + token,
            //     type: "GET",
            //     crossDomain: true,
            //     data: {},
            //     success: function(res) {
            //         alert("success: " + res);
            //     },
            //     error: function(error) {
            //         alert("error: " + error);
            //     }
            // });

        }).catch(function(err) {
            console.log('Permission denied', err);
        });

        messaging.onTokenRefresh(function() {
            messaging.getToken().then(function(refreshedToken) {
                console.log('Token refreshed.');
                console.log(refreshedToken);
                // should call ajax to savetoken 
                // http://localhost:53188/firebase/savetoken?token=
            }).catch(function(err) {
                console.log('Unable to retrieve refreshed token ', err);
            });
        });

        messaging.onMessage(function(payload) {
            console.log('onMessage: ', payload);
            var message = document.getElementById('message').innerHTML;
            message = message + '<div>' + JSON.stringify(payload) + '</div>';

            document.getElementById('message').innerHTML = message;
        });
    </script>
</head>

<body>
    My firebase app
    <div>Current token:</div>
    <div id='token'></div>
    <div>Message</div>
    <div id='message'></div>
</body>

</html>