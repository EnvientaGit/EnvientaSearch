<?php
$resource_types = json_decode(file_get_contents("config/resource_types.json"));
$keywords = json_decode(file_get_contents("config/keywords.json"), TRUE);
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="search engine for accessing local resources (products and services)">
    <meta name="keywords" content="Find local services, products, food and more">
    <meta name="author" content="ENVIENTA">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://local.envienta.com">
    <meta property="og:title" content="ENVIENTA Social Matchmaker">
    <meta property="og:description" content="Find local services, products, food and more">
    <meta property="og:image" content="https://local.envienta.com/img/zoe-deal-EULcMrkoPuo-unsplash.jpg">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link type="text/css" rel="stylesheet" href="https://cdn.firebase.com/libs/firebaseui/3.5.2/firebaseui.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="favicon.ico" type="x-icon">
    <link href="//cdn-images.mailchimp.com/embedcode/horizontal-slim-10_7.css" rel="stylesheet" type="text/css">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-63687947-5"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-63687947-5');
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light bg-transparent fixed-top">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a id="howitworks-menu" class="nav-link" href="#"><span data-localize="howitworks">How it works?</span> |</a>
                </li>
                <li class="nav-item">
                    <a id="whoweare-menu" class="nav-link" href="#"><span data-localize="whoweare">Who we are?</span></a>
                </li>
                <li id="loginContainer" class="nav-item">
                    <a id="loginButton" class="nav-link loginButton" href="#">| <span data-localize="signup">Sign Up / Sign In</span></a>
                </li>
                <li id="userContainer" class="nav-item" style="display: none;">
                    <a id="userButton" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img id="profileImage" width="40" height="40" class="d-inline-block align-top profile-image" />
                    </a>
                    <div class="dropdown-menu profileDropDown" aria-labelledby="userButton">
                        <a class="dropdown-item profileButton" href="#"><span data-localize="profile">Profile</span></a>
                        <a class="dropdown-item logoutButton" href="#"><span data-localize="logoff">Log Off</span></a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <main role="main" class="container">
        <div class="row justify-content-md-center">
            <div class="col-lg-8">
                <img style="display: block; margin:auto; margin-bottom: 1rem;" src="img/envienta.png" />
                <!--
                <ul class="nav nav-pills mb-3" id="resource-pills-tab" role="tablist">
                    <?php foreach ($resource_types as $idx => $resource_type) : ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $idx == 0 ? 'active' : '' ?>" id="pills-<?= $resource_type->key ?>-tab" data-toggle="pill" href="#pills-<?= $resource_type->key ?>" role="tab" aria-controls="pills-<?= $resource_type->key ?>" aria-selected="<?= $idx == 0 ? 'true' : 'false' ?>"><?= $resource_type->title ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                -->

                <div class="tab-content" id="resource-pills-tabContent">
                    <?php foreach ($resource_types as $idx => $resource_type) : ?>
                        <div class="tab-pane fade show <?= $idx == 0 ? 'active' : '' ?>" id="pills-<?= $resource_type->key ?>" role="tabpanel" aria-labelledby="pills-<?= $resource_type->key ?>-tab">
                            <div class="input-group search-input">
                                <div class="input-group-prepend" id="<?= $resource_type->key ?>-button-addon4">
                                    <button id="<?= $resource_type->key ?>-add-tag" class="btn btn-secondary mapTargetButton" type="button"><i class="fas fa-map-marker-alt"></i></button>
                                </div>
                                <input id="<?= $resource_type->key ?>-search-input" type="text" class="form-control search-edit" data-localize="searchinput" placeholder="Search for local products / services (start typing a keyword)" aria-label="Start typing a keyword, then click + to add it to the list" aria-describedby="<?= $resource_type->key ?>-button-addon4" autocomplete="off">
                            </div>
                            <div style="height: 1rem;"></div>
                            <span id="<?= $resource_type->key ?>-taglist-active"></span><br />
                            <span id="<?= $resource_type->key ?>-taglist"></span>
                            <div style="height: 1rem;"></div>
                            <div id="<?= $resource_type->key ?>-results"></div>
                            <div id="<?= $resource_type->key ?>-paginator">
                                <button type="button" class="btn btn-primary prevButton" style="display: none;">Previous</button>
                                <button type="button" class="btn btn-primary nextButton float-right" style="display: none;">Next</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <p style="margin-top: 8rem;">
            <div class="row" style="width: 98%; margin:auto;">
                <div class="col-2"></div>
                <div class="col-8">
                    <div id="mc_embed_signup">
                        <form action="https://envienta.us12.list-manage.com/subscribe/post?u=1cfb2999615d57f7f085b1680&amp;id=da900f432b" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                            <div id="mc_embed_signup_scroll">
                                <label for="mce-EMAIL" data-localize="launch-email">We're Getting Ready to Launch. Join our mailing list to stay in the loop.</label>
                                <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
                                <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_1cfb2999615d57f7f085b1680_da900f432b" tabindex="-1" value=""></div>
                                <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </p>



    </main>

    <div class="footer">
        <p>ENVIENTA @2020 <span data-localize="allrights">All Rights reserved.</span> | <span data-localize="background">Background:</span>
            <a style="background-color:black;color:white;text-decoration:none;padding:4px 6px;font-family:-apple-system, BlinkMacSystemFont, San Francisco, Helvetica Neue, Helvetica, Ubuntu, Roboto, Noto, Segoe UI, Arial, sans-serif;font-size:12px;font-weight:bold;line-height:1.2;display:inline-block;border-radius:3px" href="https://unsplash.com/@federicorespini?utm_medium=referral&amp;utm_campaign=photographer-credit&amp;utm_content=creditBadge" target="_blank" rel="noopener noreferrer" title="Download free do whatever you want high-resolution photos from Federico Respini"><span style="display:inline-block;padding:2px 3px"><svg xmlns="http://www.w3.org/2000/svg" style="height:12px;width:auto;position:relative;vertical-align:middle;top:-2px;fill:white" viewBox="0 0 32 32">
                        <title>unsplash-logo</title>
                        <path d="M10 9V0h12v9H10zm12 5h10v18H0V14h10v9h12v-9z"></path>
                    </svg></span><span style="display:inline-block;padding:2px 3px">Federico Respini</span></a>
            <span style="display: inline-block; color:white; width: 50%; text-align: right;">
                <a href="https://envienta.com/terms.html" target="_blank"><span data-localize="termsofservice">Terms of Service</span> </a><a href="https://envienta.com/privacy.html" target="_blank">| <span data-localize="privacypolicy">Private Policy</span></a>
            </span>
        </p>
    </div>

    <?php include("components/login-modal.php"); ?>

    <?php include("components/map-target-modal.php"); ?>

    <?php include("components/whoweare-modal.php"); ?>

    <?php include("components/howitworks-modal.php"); ?>

    <?php include("components/profile-modal.php"); ?>

    <script type="text/x-handlebars-template" id="result-card-template">
        {{#each results}}
            <div class="card mb-3 result-card" data-url="{{url}}">
                <div class="row no-gutters">
                    <div class="col-3">
                        <img class="card-img" alt="" src="{{photoUrl}}">
                    </div>
                    <div class="col-9">
                        <div class="card-body">
                            <h5 class="card-title result-title">{{title}}</h5>
                            <p class="card-text result-description">{{description}}</p>
                            <p class="card-text">
                                {{#each keywords}}
                                    <span class="badge badge-primary tag-badge">{{this}}</span>
                                {{/each}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        {{/each}}
    </script>

    <script type="text/x-handlebars-template" id="inactive-tag-template">
        {{#each tags}}
            <span class="badge badge-light tag-badge" data-tag="{{tag}}" style="{{style}}">
                <span>{{tag}}</span>
            </span>
        {{/each}}
    </script>

    <script type="text/x-handlebars-template" id="active-tag-template">
        {{#each tags}}
            <span class="badge badge-primary tag-badge" data-tag="{{tag}}">
                <span>{{tag}}</span>
            </span>
        {{/each}}
    </script>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-localize/0.1.0/jquery.localize.min.js" integrity="sha256-zTr9AlJ1gxy4jC5amkrL/4Re/HsZKSq28jWfcFhzhaw=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.6/handlebars.min.js" integrity="sha256-usTqAE1ywvdMtksWzdeWzD75MsfJN0h0U7y2NtZL3N0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/geocomplete/1.7.0/jquery.geocomplete.js" integrity="sha256-4hWBXlNNh9SqNDfISZkwRkKlWcxb1pxQNYsAPXCpGKs=" crossorigin="anonymous"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAllK8G0cYz4d596TCHCEiGWbDbF6HUJ-I&sensor=false&libraries=places"></script>
    <script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-analytics.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-auth.js"></script>
    <script src="https://cdn.firebase.com/libs/firebaseui/3.5.2/firebaseui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.13.0/js/md5.min.js" integrity="sha256-qlDpLxKXa1lzPjJ5vbWLDWbxuHT8d/ReH4E6dBDRRoA=" crossorigin="anonymous"></script>

    <script src="js/main.js"></script>
    <?php include("components/init.php"); ?>

    <script>
        $("[data-localize]").localize("envienta_search", {
            pathPrefix: "langs"
        });
        $('.search-edit').popover({
            trigger: 'focus',
            placement: "top",
            html: true,
            content: "Press ENTER to select the selected matching keyword. Use the right / left arrows to move between keywords."
        }).on('hidden.bs.popover', function() {
            $('.search-edit').popover('disable');
        }).on('shown.bs.popover', function() {
            setTimeout(function() {
                $('.search-edit').popover('hide');
            }, 5000);
        });
        $("#whoweare-menu").click(function() {
            $("#whoweare-modal").modal();
        });
        $("#howitworks-menu").click(function() {
            $("#howitworks-modal").modal();
        });
        $("#subscribe-button").click(function() {
            $("#mailchimp-modal").modal();
        });
        //$("#service-results").loadTemplate($("#result-card-template"), [1]);
    </script>
</body>

</html>