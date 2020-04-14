<script>
    const BACKEND_URL = "backend.php";

    <?php
    function url()
    {
        return sprintf(
            "%s://%s%s%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME'],
            $_SERVER['SERVER_PORT'] ? ":" . $_SERVER['SERVER_PORT'] : "",
            $_SERVER['REQUEST_URI']
        );
    }
    ?>

    <?php foreach ($resource_types as $idx => $resource_type) : ?>
        initTab('<?= $resource_type->key ?>', <?= json_encode($keywords[$resource_type->key]) ?>);
    <?php endforeach; ?>

    $(".loginButton").click(function() {
        $("#login-modal").modal();
    });

    var baseLat = localStorage.getItem("baseLat");
    var baseLng = localStorage.getItem("baseLng");

    if (!baseLat || !baseLng) {
        $("#map-target-modal").modal();
    } else {

    }

    baseLat = baseLat ? baseLat : 47.4811277;
    baseLng = baseLng ? baseLng : 18.9898783;

    $("#mapTargetAddress").geocomplete({
        "map": "#maptarget-map-canvas",
        "location": [baseLat, baseLng],
        "markerOptions": {
            "draggable": true
        }
    }).bind("geocode:result", function(event, result) {
        var location = result.geometry.location;
        console.log(location.lat(), location.lng());
        $("#mapTargetAddress").attr("data-lat", location.lat());
        $("#mapTargetAddress").attr("data-lng", location.lng());
    }).bind("geocode:dragged", function(event, location) {
        console.log(location.lat(), location.lng());
        $("#mapTargetAddress").attr("data-lat", location.lat());
        $("#mapTargetAddress").attr("data-lng", location.lng());
    });

    $("#mapTargetSaveButton").click(function() {
        localStorage.setItem("baseLat", $("#mapTargetAddress").attr("data-lat"));
        localStorage.setItem("baseLng", $("#mapTargetAddress").attr("data-lng"));
        $("#map-target-modal").modal('hide');
    });

    $(".mapTargetButton").click(function() {
        $("#map-target-modal").modal();
    });

    var firebaseConfig = {
        apiKey: "AIzaSyCsLUi82gxN97jSOR6eTDYRySBWGID6rzA",
        authDomain: "envienta-1537699258996.firebaseapp.com",
        databaseURL: "https://envienta-1537699258996.firebaseio.com",
        projectId: "envienta-1537699258996",
        storageBucket: "envienta-1537699258996.appspot.com",
        messagingSenderId: "146909556325",
        appId: "1:146909556325:web:94ae39f94cbf5443bb608c",
        measurementId: "G-RKWBH5LKF6"
    };

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    firebase.analytics();

    firebase.auth().onAuthStateChanged(async function(user) {
        if (user) {
            console.log(user);
            $("#userContainer").show();
            $("#loginContainer").hide();
            if (user.photoURL)
                $("#profileImage").attr("src", user.photoURL);
            else
                $("#profileImage").attr("src", "https://www.gravatar.com/avatar/" + md5(user.email) + "?s=40");
        } else {
            console.log("No user is signed in.");
            $("#userContainer").hide();
            $("#loginContainer").show();
        }
    });

    $(".logoutButton").click(function() {
        firebase.auth().signOut().then(function() {
            console.log('Signed Out');
        }, function(error) {
            console.error('Sign Out Error', error);
        });
    });

    var ui = new firebaseui.auth.AuthUI(firebase.auth());
    ui.start('#firebaseui-auth-container', {
        signInSuccessUrl: "https://local.envienta.com",
        signInOptions: [{
                provider: firebase.auth.GoogleAuthProvider.PROVIDER_ID
            }, {
                provider: firebase.auth.FacebookAuthProvider.PROVIDER_ID
            },
            {
                provider: firebase.auth.EmailAuthProvider.PROVIDER_ID,
                signInMethod: firebase.auth.EmailAuthProvider.EMAIL_LINK_SIGN_IN_METHOD
            }
        ]
    });

    var profileGeocodeAdded = false;

    $(".profileButton").click(async function() {
        $("#profile-modal").modal();
        var user = firebase.auth().currentUser;
        var idToken = await user.getIdToken(true);
        try {
            var data = await $.get(BACKEND_URL + "/getUserData?token=" + idToken);
        } catch {
            var data = {};
        }
        data["name"] = data["name"] ? data["name"] : user.displayName;
        data["lat"] = data["lat"] ? data["lat"] : baseLat;
        data["lng"] = data["lng"] ? data["lng"] : baseLng;
        console.log(data);
        $("#profileName").val(data["name"]);
        $("#profileDescription").val(data["description"]);
        <?php foreach ($resource_types as $idx => $resource_type) : ?>
            initTagSearch('profile-<?= $resource_type->key ?>', <?= json_encode($keywords[$resource_type->key]) ?>, false, data["taglist"]);
        <?php endforeach; ?>

        if (!profileGeocodeAdded) {
            $("#profileAddress").geocomplete({
                "map": "#profile-map-canvas",
                "location": [data['lat'], data['lng']],
                "markerOptions": {
                    "draggable": true
                }
            }).bind("geocode:result", function(event, result) {
                var location = result.geometry.location;
                console.log(location.lat(), location.lng());
                $("#profileAddress").attr("data-lat", location.lat());
                $("#profileAddress").attr("data-lng", location.lng());
            }).bind("geocode:dragged", function(event, location) {
                console.log(location.lat(), location.lng());
                $("#profileAddress").attr("data-lat", location.lat());
                $("#profileAddress").attr("data-lng", location.lng());
            });
            $("#profileAddress").attr("data-lat", data['lat']);
            $("#profileAddress").attr("data-lng", data['lng']);
            profileGeocodeAdded = true;
        }
    });


    $("#profileForm").submit(async function(event) {
        event.preventDefault();
        try {
            var idToken = await firebase.auth().currentUser.getIdToken(true);
            var data = await $.post(BACKEND_URL + "/setUserData?token=" + idToken, {
                "name": $("#profileName").val(),
                "description": $("#profileDescription").val(),
                "lat": $("#profileAddress").attr('data-lat'),
                "lng": $("#profileAddress").attr('data-lng'),
                <?php foreach ($resource_types as $idx => $resource_type) : ?> "<?= $resource_type->key ?>-taglist": $("#profile-<?= $resource_type->key ?>-search-input").attr("data-taglist"),
                <?php endforeach; ?>
            });
            console.log(data);
            $("#profile-modal").modal('hide');
        } catch (error) {
            console.error('Submit profile', error);
        }
    });

    $(".add-row").click(function() {
        var linkValue = $("#profileLink").val();
        var linkText = $("#profileLink option:selected").html();

        var url = $("#profileURL").val();
        var markup = "<tr><td><input type='checkbox' name='record'></td><td>" + linkText + "</td><td>" + url + "</td></tr>";
        $("#tblLinks tbody").append(markup);

        $("#profileURL").val('');
    });

    // Find and remove selected table rows
    $(".delete-row").click(function() {
        $("#tblLinks tbody").find('input[name="record"]').each(function() {
            if ($(this).is(":checked")) {
                $(this).parents("tr").remove();
            }
        });
    });

    $(function() {
        $("#tabs").tabs();
    });

    $("[data-tr]").each(function(){
        $(this).html($(this).attr("data-tr"));
    });
</script>