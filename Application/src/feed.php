<?php
require_once 'config.php';
$userinfo = buboard_authenticate($mysqli, $authenticationKey);

$categoriesQuery = mysqli_query($mysqli, "SELECT category_id, category_name, category_color FROM post_categories");
?>

<!doctype html>
<html style="overflow: hidden">
<head>
    <title>BuBoard Feed</title>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?=getenv("ANALYTICS_ID")?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '<?=getenv("ANALYTICS_ID")?>');
        gtag('set', {'user_id': '<?=$userinfo['profile_id']?>'});
    </script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="static/css/material.min.css"/>
    <link rel="stylesheet" href="static/css/feed.css"/>
    <meta name="theme-color" content="#2196f3">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--Used for favicon generation -->
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/manifest.json">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
</head>

<body>
<div id="contentWrapper">
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header" id="postsContentPanel">
        <header class="mdl-layout__header">
            <!--Top row of header-->
            <div class="mdl-layout__header-row">
                <span class="mdl-layout-title">My BuBoard</span>
                <div class="mdl-layout-spacer"></div>
                <nav class="mdl-navigation" id="desktopCategoriesSwitcher">
                    <!-- ID's are category_tab_curView_curViewIsCategory -->
                    <a class="mdl-navigation__link is-active-feed-view" id="category_tab_0_0" style="cursor: pointer" onclick="allPostsVue.changeView(0, 0, false)">Latest</a>
                    <a class="mdl-navigation__link" id="category_tab_1_0" style="cursor: pointer" onclick="allPostsVue.changeView(1, 0, false)">Subscriptions</a>
                    <?php
                    while ($category = mysqli_fetch_assoc($categoriesQuery)) {
                        echo "<a class=\"mdl-navigation__link\" id='category_tab_" . $category['category_id'] . "_1' style=\"cursor: pointer\" onclick='allPostsVue.changeView(" . $category['category_id'] . ", 1, false)'>" . $category['category_name'] . "</a>";
                    }
                    ?>
                </nav>
            </div>
        </header>
        <div class="mdl-layout__drawer">
            <span class="mdl-layout-title">BuBoard</span>
            <nav class="mdl-navigation mdl-color--blue-light_blue-800">
                <a class="mdl-navigation__link" href="/feed.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i> Home</a>
                <a class="mdl-navigation__link" href="/profile.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">account_box</i> My Profile</a>
                <a class="mdl-navigation__link" href="/profilesearch.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">search</i> Find Members</a>
                <a class="mdl-navigation__link" onclick="logout()"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">exit_to_app</i> Logout</a>
            </nav>
        </div>

        <!-- Creates the main content of the page -->
        <main class="mdl--layout__content">
            <div id="postsView" class="mdl-grid">
                <!--"No cards here" placeholder-->
                <div v-if="postsObj.length == 0 && isAtViewPaginationEnd" style="overflow: initial"
                     class="mdl-card mdl-shadow--8dp mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--6-col-phone">
                    <div class="postTitleCard mdl-card__title mdl-color--blue">
                        <img class="thumbtack" src="static/image/thumbtack.png">
                        <h2 class="mdl-card__title-text">
                            Whoa There!
                        </h2>
                    </div>
                    <div class="mdl-card__supporting-text">
                        This view doesn't have any posts. Tell your friends about BuBoard, or follow more people.
                    </div>
                </div>
                <!--Actual real, bona fide cards-->
                <transition-group :name="listTransitionType" id="main" style="width:100%" tag="span">
                    <div v-for="post in postsObj" v-bind:key="post" class="mdl-card mdl-shadow--8dp mdl-cell mdl-cell--4-col">
                        <div class="postTitleCard mdl-card__title mdl-color--blue">
                            <img class="thumbtack" src="static/image/thumbtack.png">
                            <h2 class="mdl-card__title-text">
                                {{post.post_title}}
                            </h2>
                        </div>
                        <div style="width: unset" class="mdl-card__supporting-text">
                            <div style="display: flex">
                                <ul class="post-authorship mdl-list">
                                    <li class="mdl-list__item mdl-list__item--two-line">
                            <span class="mdl-list__item-primary-content">
                                <i v-if="post.has_submitted_photo == 0" v-on:click="window.location='profile.php?id=' + post.profile_id" style="cursor: pointer"
                                   class="material-icons mdl-list__item-avatar">person</i>
                                <img v-else v-bind:src="'usercontent/user_avatars/' + post.profile_id + post.photo_filename_extension" v-on:click="window.location='profile.php?id=' + post.profile_id"
                                     style="cursor: pointer" class="mdl-list__item-avatar">
                                <span v-on:click="window.location='profile.php?id=' + post.profile_id" class="post-name-display"><i v-if="post.isVerifiedAccount > 0"
                                                                                                                                    class="material-icons verified_user">verified_user</i>{{post.real_name}}</span>
                                <span class="mdl-list__item-sub-title">{{formatSeconds(post.seconds_since)}}</span>
                            </span>
                                    </li>
                                </ul>
                                <div class="card-category-chip chip" v-bind:style="{backgroundColor: '#' + post.category_color, color: invertColor(post.category_color, true)}">
                                    {{post.category_name}}
                                </div>
                            </div>
                            <hr>
                            <div class="post-contents">
                                {{post.post_contents}}
                            </div>
                            <div v-if="Object.keys(post.attachment_id).length > 0" class="post-image-attachments">
                                <br>
                                Attachments:
                                <div>
                                    <a v-for="attachment in post.attachment_id" target="_blank" :href="'usercontent/post_attachments/' + attachment"><img
                                                class="mdl-cell mdl-cell--2-col mdl-cell--1-col-phone" v-bind:src="'usercontent/post_attachments/' + attachment"></a>
                                </div>
                            </div>
                        </div>
                        <!--own profile menu-->
                        <div v-if="post.isOwnPost > 0" class="mdl-card__menu postOptionsMenu">
                            <button :id=" post.post_id + 'cornermenu'"
                                    class="mdl-button mdl-js-button mdl-button--icon">
                                <i class="material-icons">more_vert</i>
                            </button>
                            <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
                                :for=" post.post_id + 'cornermenu'">
                                <li class="mdl-menu__item" v-on:click="deletePost(post.post_id)">Delete Post</li>
                            </ul>
                        </div>
                        <!--Follow button-->
                        <div v-else class="mdl-card__menu postOptionsMenu">
                            <i style="color: white; cursor: pointer" :id="post.post_id + '-following'" v-on:click="manageSubscription(post.profile_id, post.isSubscribed)"
                               v-bind:class="[post.isSubscribed > 0 ? 'subscribed-btn' : 'subscribe-btn', 'material-icons']">person_add</i>
                            <div class="mdl-tooltip" :data-mdl-for="post.post_id + '-following'">
                                <span v-if="post.isSubscribed > 0">Unsubscribe</span>
                                <span v-else>Subscribe</span>
                            </div>
                        </div>
                    </div>
                </transition-group>
                <!-- Loading card. Just a placeholder for mobile scroll -->
                <div v-if="!isAtViewPaginationEnd" style="overflow: initial" class="mdl-card mdl-cell--hide-desktop mdl-cell--hide-tablet mdl-shadow--8dp mdl-cell mdl-cell--4-col">
                    <div class="postTitleCard mdl-card__title mdl-color--blue">
                        <img class="thumbtack" src="static/image/thumbtack.png">
                        <h2 class="mdl-card__title-text">
                            loading...
                        </h2>
                    </div>
                    <div class="mdl-progress mdl-js-progress mdl-progress__indeterminate"></div>
                </div>
                <div v-show="leftArrowVisible" v-on:click="arrowButtonHandler('right')" class="left-swipe-arrow">
                    <img style="height: 150px; border-top-right-radius: 15px; border-bottom-right-radius: 15px;" src="static/image/arrow-left.png">
                </div>
                <div v-show="rightArrowVisible" v-on:click="arrowButtonHandler('left')" class="right-swipe-arrow">
                    <img style="height: 150px; border-top-left-radius: 15px; border-bottom-left-radius: 15px;" src="static/image/arrow-right.png">
                </div>
            </div>
        </main>
    </div>
    <!--Add post modal-->
    <div id="overlayModal">
        <form name="mainform" id="newPostForm" method="post" onsubmit="submitNewPost(event)" enctype="multipart/form-data">
            <div class="mdl-grid mainbodyModal mdl-shadow--24dp">
                <div style="display: inline-block; width: 100%" class="mdl-cell mdl-cell--12-col-desktop mdl-cell--4-col-phone">
                    <h2 style='display: inline-block; float: left' class="mdl-card__title-text mdl-color-text--blue-grey-600 title">Pin To Buboard</h2>
                    <i onclick="showNewPostModal()" style="float: right; cursor:pointer; display: inline-block; color: unset" class="material-icons">close</i>
                </div>
                <div class="mdl-cell mdl-cell--4-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label textModal">
                    <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="title">Title</label>
                    <input class="mdl-textfield__input" name="newPostTitle"/>
                </div>
                <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone mdl-textfield mdl-js-textfield wideModal">
                    <textarea class="mdl-textfield__input" type="text" rows="10" name="post"></textarea>
                    <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="post">Tell the world...</label>
                </div>
                <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--4-col-phone">
                    <label class="mdl-color-text--blue-grey-600">Add an attachment. (Optional, must be an image.)</label><br>
                    <input class="mdl-button" type="file" name="fileToUpload">
                </div>
                <div style="width: 100%" class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label">
                    <select class="mdl-selectfield__select" name="tag">
                        <option selected disabled value="">Select a tag</option>
                        <?php
                        mysqli_data_seek($categoriesQuery, 0);
                        while ($category = mysqli_fetch_assoc($categoriesQuery)) {
                            echo "<option value='" . $category['category_id'] . "'>" . $category['category_name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div style="width:100%"><p id="postingError" style="color: red"></p></div>
                <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone">
                    <button class="mdl-button mdl-button--raised mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-color-text--white submit" type="submit" name="submit"
                            value="uploadImage">
                        Submit Post
                    </button>
                </div>
            </div>
        </form>
    </div>
    <!--Floating Add post button-->
    <button id="addButton" onclick="showNewPostModal()"
            style="position: fixed; right: 24px; bottom: 24px; padding-top: 24px; margin-bottom: 0; z-index: 90; color: white"
            class="mdl-button mdl-shadow--8dp mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored mdl-color--light-blue-400">
        <i class="material-icons">add</i>
    </button>
</div>
<!--Snackbar-->
<div id="snackbar" class="mdl-js-snackbar mdl-snackbar">
    <div class="mdl-snackbar__text"></div>
    <button class="mdl-snackbar__action" type="button"></button>
</div>
</body>
<script src="static/js/material.min.js"></script>
<script src="static/js/vue.min.js"></script>
<script src="static/js/jquery.min.js"></script>
<script>
    function logout() {
        gtag('event', 'logout');
        document.cookie = "token=; expires=Thu, 01 Jan 1970 00:00:01 GMT;";
        document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:01 GMT;";
        window.location.replace('/');
    }

    function snack(message, length) {
        if(message === undefined){
            return;
        }
        var data = {
            message: message,
            timeout: length
        };
        document.querySelector('#snackbar').MaterialSnackbar.showSnackbar(data);
    }

    function showNewPostModal() {
        gtag('event', 'open_new_post_card');
        el = document.getElementById("overlayModal");
        el.style.visibility = (el.style.visibility === "visible") ? "hidden" : "visible";
        $('#postsContentPanel').toggleClass('blurred');
    }

    function submitNewPost(e) {
        e.preventDefault();
        var formData = new FormData($('#newPostForm')[0]);
        $.ajax({
            type: 'POST',
            url: 'api/submitPost.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                gtag('event', 'make_new_post');
                $('#postingError').html('');
                $('#newPostForm')[0].reset();
                //reset mdl state. Bug in MDL
                $('.mdl-textfield').each(function () {
                    $(this)[0].MaterialTextfield.change()
                });
                showNewPostModal();
                allPostsVue.scrollToTop(allPostsVue.refreshWholePage());
            },
            error: function (data) {
                $('#postingError').html(data.responseText);
            }
        });
    }

    var allPostsVue = new Vue({
        el: '#postsView',
        data: {
            postsObj: [],
            curViewIsCategory: 0, //see curView
            curView: 0, //0 for latest/firehose, 1 for followers view. Otherwise, if curViewIsCategory, it is category index
            latestPostCurView: -1, // for pagination, ID of the last post in received dataset.
            isAtViewPaginationEnd: false, //end of dataset, make no more requests until view change
            scrollLock: false, //mutex on scroll event handler
            listTransitionType: 'list',
            leftArrowVisible: false,
            rightArrowVisible: true,
            categories: <?php
            mysqli_data_seek($categoriesQuery, 0);
            $output = array();
            while ($category = mysqli_fetch_assoc($categoriesQuery)) {
                $output[$category['category_id']] = $category;
            }
            echo json_encode($output);
            ?>
        },
        mounted: function () {
            var self = this;
            this.getPosts();
            //scroll event handler - 100 px from bottom, pulls new posts
            $('#postsContentPanel').on('scroll', function () {
                //self is the vue object, this is the postsContentPanel jquery object
                if (!(self.scrollLock || self.isAtViewPaginationEnd)) {
                    if (this.scrollTop >= (this.scrollHeight - this.offsetHeight) - 100) {
                        self.listTransitionType = 'list';
                        Vue.nextTick(function () {
                            self.getPosts();
                        });
                    }
                }
            });
        },
        updated: function () {
            componentHandler.upgradeDom();
        },
        methods: {
            refreshWholePage: function () {
                var self = this;
                this.listTransitionType = 'list';
                Vue.nextTick(function () {
                    self.changeView(this.curView, this.curViewIsCategory, true)
                });
            },
            /*Clear all state and request new one with new filter flags*/
            /* Override = true will skip state change check and refresh anyway */
            changeView: function (viewID, isCategory, override) {
                if (this.curViewIsCategory !== isCategory || this.curView !== viewID || override) {
                    $('#category_tab_' + this.curView + '_' + this.curViewIsCategory).toggleClass('is-active-feed-view');
                    this.curView = viewID;
                    this.curViewIsCategory = isCategory;
                    this.latestPostCurView = Infinity;
                    this.isAtViewPaginationEnd = false;
                    this.postsObj = [];
                    $('#category_tab_' + viewID + '_' + isCategory).toggleClass('is-active-feed-view');
                    this.getPosts();
                }
            },
            arrowButtonHandler: function (direction) {
                var self = this;
                if (direction === "left") {
                    self.listTransitionType = 'swipeleft';
                    Vue.nextTick(function () {
                        snack(self.swipeView(false), 1000);
                        self.scrollToTop();
                    });
                } else if (direction === "right") {
                    self.listTransitionType = 'swiperight';
                    Vue.nextTick(function () {
                        snack(self.swipeView(true), 1000);
                        self.scrollToTop();
                    });
                }
            },
            swipeView: function (direction) { // moves view left or right, returns name.
                //direction is true for right, false for left
                if (!direction) { //moving right
                    if (this.curViewIsCategory === 1) {
                        //smallest curview value is assumed to be 1 based on mysql's first default auto_increment
                        if (this.curView >= Object.keys(this.categories).length) {
                            //Nothing there
                            return;
                        } else {
                            this.changeView(this.curView + 1, 1, false);
                            var rightArrow = true;
                            if(this.curView === Object.keys(this.categories).length){
                                rightArrow = false;
                            }
                            this.setArrowVisibility(true, rightArrow);
                            return "Tagged: " + this.categories[this.curView]['category_name'];
                        }
                    } else { //if not in categories
                        if (this.curView === 0) {
                            this.changeView(1, 0, false);
                            this.setArrowVisibility(true, true);
                            return "Subscriptions";
                        } else {
                            this.changeView(1, 1, false);
                            var rightArrow = true;
                            if(this.curView === Object.keys(this.categories).length){
                                rightArrow = false;
                            }
                            this.setArrowVisibility(true, rightArrow);
                            return "Tagged: " + this.categories[this.curView]['category_name'];
                        }
                    }
                } else { // moving left
                    if (this.curViewIsCategory === 1) {
                        if (this.curView <= 1) {
                            this.changeView(1, 0, false);
                            this.setArrowVisibility(true, true);
                            return "Subscriptions";
                        } else {
                            this.changeView(this.curView - 1, 1, false);
                            var rightArrow = true;
                            if(this.curView === Object.keys(this.categories).length){
                                rightArrow = false;
                            }
                            this.setArrowVisibility(true, rightArrow);
                            return "Tagged: " + this.categories[this.curView]['category_name'];
                        }
                    } else { //not in categories
                        if (this.curView === 0) {
                            //Nothing there
                            return;
                        } else {
                            this.changeView(0, 0, false);
                            this.setArrowVisibility(false, true);
                            return "Latest Posts";
                        }
                    }
                }
            },
            setArrowVisibility: function(leftArrow, rightArrow){
                this.leftArrowVisible = leftArrow;
                this.rightArrowVisible = rightArrow;
            },
            getPosts: function () {
                this.scrollLock = true;
                if (!this.isAtViewPaginationEnd) {
                    var self = this;
                    $.getJSON('api/getPosts.php', {
                            curViewIsCategory: this.curViewIsCategory,
                            curView: this.curView,
                            latestPostCurView: (this.latestPostCurView === Infinity ? -1 : this.latestPostCurView)
                        },
                        function (data) {
                            gtag('event', 'load_10_posts');
                            //if number returned is less than API default of 10, then all data is received. Don't re-update
                            if (data.length < 10) {
                                self.isAtViewPaginationEnd = true;
                            }
                            self.postsObj = self.postsObj.concat(data);
                            var smallestID = Infinity;
                            for (var i = 0; i < self.postsObj.length; i++) {
                                if (parseInt(self.postsObj[i]['post_id']) < smallestID) {
                                    smallestID = parseInt(self.postsObj[i]['post_id']);
                                }
                            }
                            //if this number doesn't update, good indication that we're at the end of the data
                            if (self.latestPostCurView === smallestID) {
                                self.isAtViewPaginationEnd = true;
                            }
                            self.latestPostCurView = smallestID;
                            //release scroll mutex
                            self.scrollLock = false;
                        }).fail(function () {
                        self.scrollLock = false;
                        snack("Server Unavailable", 1200);
                    });
                }
            },
            manageSubscription: function (subscribeToID, isSubscribed) {
                var self = this;
                var argsObj = {subscribeToID: subscribeToID};
                var successMessage = "Subscribed!";
                if (isSubscribed > 0) {
                    argsObj.action = "unsubscribe";
                    successMessage = "Unsubscribed!";
                }
                $.get('api/subscribe.php', argsObj, function () {
                    //ux - if in "following" view and you're unsubscribing, just remove posts from postsObj
                    if (self.curViewIsCategory === 0 && self.curView === 1 && argsObj['action'] === 'unsubscribe') {
                        self.postsObj = self.postsObj.filter(function (post) {
                            return (post['profile_id'] !== subscribeToID);
                        });
                    } else { // else loop through postsObj to flip the subscription status of all posts under that account.
                        for (var i = 0; i < self.postsObj.length; i++) {
                            if (self.postsObj[i]['profile_id'] === subscribeToID) {
                                if (parseInt(self.postsObj[i]['isSubscribed']) > 0) {
                                    self.postsObj[i]['isSubscribed'] = 0;
                                } else {
                                    self.postsObj[i]['isSubscribed'] = 1;
                                }
                            }
                        }
                    }
                    gtag('event', 'subscribe');
                    snack(successMessage);
                }).fail(function () {
                    snack("Could not edit subscription.", 1000);
                });
            },
            deletePost: function (post_id) {
                var self = this;
                $.get('api/deletePost.php', {post_id: post_id}, function () {
                    gtag('event', 'delete_post');
                    for (var i = 0; i < self.postsObj.length; i++) {
                        if (self.postsObj[i]['post_id'] === post_id) {
                            self.postsObj.splice(i, 1);
                            break;
                        }
                    }
                }).fail(function () {
                    snack('Could not delete post.', 1500);
                });
            },
            formatSeconds: function (inSeconds) {
                function numberEnding(number) {
                    return (number > 1) ? 's' : '';
                }

                var curTimestamp = Math.round((new Date()).getTime() / 1000);
                var temp = Math.floor(inSeconds);
                temp = curTimestamp - temp;

                var years = Math.floor(temp / 31536000);
                if (years) {
                    return years + ' year' + numberEnding(years) + ' ago';
                }
                var days = Math.floor((temp %= 31536000) / 86400);
                if (days) {
                    return days + ' day' + numberEnding(days) + ' ago';
                }
                var hours = Math.floor((temp %= 86400) / 3600);
                if (hours) {
                    return hours + ' hour' + numberEnding(hours) + ' ago';
                }
                var minutes = Math.floor((temp %= 3600) / 60);
                if (minutes) {
                    return minutes + ' minute' + numberEnding(minutes) + ' ago';
                }
                var seconds = temp % 60;
                if (seconds) {
                    return seconds + ' second' + numberEnding(seconds) + ' ago';
                }
                return 'Just Now';
            },
            scrollToTop: function (callback) {
                $("#postsContentPanel").animate({scrollTop: 0}, "slow", "swing", callback);
            },
            invertColor: function (hex, bw) {
                function padZero(str, len) {
                    len = len || 2;
                    var zeros = new Array(len).join('0');
                    return (zeros + str).slice(-len);
                };

                // stolen from https://github.com/onury/invert-color MIT Licensed. -MC
                if (hex.indexOf('#') === 0) {
                    hex = hex.slice(1);
                }
                // convert 3-digit hex to 6-digits.
                if (hex.length === 3) {
                    hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
                }
                if (hex.length !== 6) {
                    throw new Error('Invalid HEX color.');
                }
                var r = parseInt(hex.slice(0, 2), 16),
                    g = parseInt(hex.slice(2, 4), 16),
                    b = parseInt(hex.slice(4, 6), 16);
                if (bw) {
                    // http://stackoverflow.com/a/3943023/112731
                    return (r * 0.299 + g * 0.587 + b * 0.114) > 186
                        ? '#000000'
                        : '#FFFFFF';
                }
                // invert color components
                r = (255 - r).toString(16);
                g = (255 - g).toString(16);
                b = (255 - b).toString(16);
                // pad each with zeros and return
                return "#" + this.padZero(r) + this.padZero(g) + this.padZero(b);
            }
        }
    });


</script>
</html>
