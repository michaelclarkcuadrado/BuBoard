<?php
require_once 'config.php';
$userinfo = buboard_authenticate($mysqli, $authenticationKey);

$categoriesQuery = mysqli_query($mysqli, "SELECT category_id, category_name, category_color FROM post_categories");
?>

<!doctype html>
<html>
<head>
    <title>BuBoard Feed</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="static/css/material.min.css"/>
    <link rel="stylesheet" href="static/css/feed.css"/>
    <meta name="theme-color" content="#2196f3">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header" id="postsContentPanel">
    <header class="mdl-layout__header">
        <!--Top row of header-->
        <div class="mdl-layout__header-row">
            <span class="mdl-layout-title">My BuBoard</span>
            <div class="mdl-layout-spacer"></div>
            <nav class="mdl-navigation" id="desktopCategoriesSwitcher">
                <a class="mdl-navigation__link is-active-feed-view" style="cursor: pointer" onclick="allPostsVue.changeView(0, 0)">Latest</a>
                <a class="mdl-navigation__link" style="cursor: pointer" onclick="allPostsVue.changeView(1, 0)">Subscriptions</a>
                <?php
                while ($category = mysqli_fetch_assoc($categoriesQuery)) {
                    echo "<a class=\"mdl-navigation__link\" style=\"cursor: pointer\" onclick='allPostsVue.changeView(" . $category['category_id'] . " , 1)'>" . $category['category_name'] . "</a>";
                }
                ?>
            </nav>
        </div>
    </header>
    <div class="mdl-layout__drawer">
        <span class="mdl-layout-title"><?= $userinfo['real_name'] ?></span>
        <nav class="mdl-navigation mdl-color--blue-light_blue-800">
            <a class="mdl-navigation__link" href="/feed.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i> Home</a>
            <a class="mdl-navigation__link" href="profile.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">flag</i> My Profile</a>
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
            <transition-group name="list" id="main" style="width:100%" mode="out-in" tag="span">
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
                                <img v-else v-bind:src="'usercontent/user_avatars/' + post.profile_id + '.jpg'" v-on:click="window.location='profile.php?id=' + post.profile_id"
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
                                <a v-for="attachment in post.attachment_id" target="_blank" :href="'usercontent/post_attachments/' + attachment + '.jpg'"><img
                                            class="mdl-cell mdl-cell--2-col mdl-cell--1-col-phone" v-bind:src="'usercontent/post_attachments/' + attachment + '.jpg'"></a>
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
        </div>
    </main>
</div>
<!--Add post modal-->
<div id="overlayModal">
    <form name="mainform" method="post" onsubmit="return validateForm()" action="api/submitPost.php" enctype="multipart/form-data">
        <div class="mdl-grid mainbodyModal mdl-shadow--24dp">
            <div class="mdl-grid center-items">
                <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--4-col-phone">
                    <h2 class="mdl-card__title-text mdl-color-text--blue-grey-600 title">Pin To Buboard</h2>
                </div>

                <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--4-col-phone">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label textModal">
                        <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="title">Enter the title of your post</label>
                        <input class="mdl-textfield__input" name="newPostTitle" />
                    </div>
                </div>


                <div class="mdl-cell mdl-cell--12-col">
                    <div class="mdl-textfield mdl-js-textfield wideModal">
                        <textarea class="mdl-textfield__input " type="text" rows= "10" name="post"></textarea>
                        <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="post">Your post goes here</label>
                    </div>
                </div>

                <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--4-col-phone">
                    <label class="mdl-color-text--blue-grey-600">Upload a Post Picture</label>

                </div>
                <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--4-col-phone">
                    <input class="mdl-button" type="file" name="fileToUpload">
                </div>


                <div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label">
                    <select class="mdl-selectfield__select" name="tag">
                        <option value=""></option>
                        <option value="Events">Events</option>
                        <option value="Announcements">Announcements</option>
                    </select>
                    <label class="mdl-selectfield__label" for="professsion2">Select the tag for your post</label>
                </div>

                <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--4-col-phone">
                    <button class="mdl-button mdl-button--raised mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-color-text--white submit" type="submit" name="submit" value="uploadImage">
                        Submit Post
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
<!--Floating Add post button-->
<button id="addButton" onclick="showNewPostModal()"
        style="position: fixed; right: 24px; bottom: 24px; padding-top: 24px; margin-bottom: 0; z-index: 90; color: white"
        class="mdl-button mdl-shadow--8dp mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored mdl-color--blue">
    <i class="material-icons">add</i>
</button>
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
        document.cookie = "token=; expires=Thu, 01 Jan 1970 00:00:01 GMT;";
        document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:01 GMT;";
        window.location.replace('/');
    }

    function snack(message, length) {
        var data = {
            message: message,
            timeout: length
        };
        document.querySelector('#snackbar').MaterialSnackbar.showSnackbar(data);
    }

    function showNewPostModal(){
        //TODO
        el = document.getElementById("overlayModal");
        el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
        $('#postsContentPanel').toggleClass('blurred');
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
            categories: <?php
            mysqli_data_seek($categoriesQuery, 0);
            $output = array();
            while ($category = mysqli_fetch_assoc($categoriesQuery)) {
                array_push($output, $category);
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
                        self.getPosts();
                    }
                }
            });
        },
        updated: function () {
//            console.log("DOM mdl upgraded");
            componentHandler.upgradeDom();
        },
        methods: {
            /*Clear all state and request new one with new filter flags*/
            changeView: function (viewID, isCategory) {
                if (this.curViewIsCategory !== isCategory || this.curView !== viewID) {
                    this.curView = viewID;
                    this.curViewIsCategory = isCategory;
                    this.latestPostCurView = Infinity;
                    this.isAtViewPaginationEnd = false;
                    this.postsObj = [];
                    this.getPosts();
                }
            },
            getPosts: function () {
                this.scrollLock = true;
                if (!this.isAtViewPaginationEnd) {
                    self = this;
                    $.getJSON('api/getPosts.php', {
                            curViewIsCategory: this.curViewIsCategory,
                            curView: this.curView,
                            latestPostCurView: (this.latestPostCurView === Infinity ? -1 : this.latestPostCurView)
                        },
                        function (data) {
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
                    if (self.curViewIsCategory == 0 && self.curView == 1 && argsObj['action'] == 'unsubscribe') {
                        self.postsObj = self.postsObj.filter(function (post) {
                            return (post['profile_id'] !== subscribeToID);
                        });
                    } else { // else loop through postsObj to flip the subscription status of all posts under that account.
                        for (var i = 0; i < self.postsObj.length; i++) {
                            if (self.postsObj[i]['profile_id'] == subscribeToID) {
                                if (parseInt(self.postsObj[i]['isSubscribed']) > 0) {
                                    self.postsObj[i]['isSubscribed'] = 0;
                                } else {
                                    self.postsObj[i]['isSubscribed'] = 1;
                                }
                            }
                        }
                    }
                    snack(successMessage);
                }).fail(function () {
                    snack("Could not edit subscription.", 1000);
                });
            },
            deletePost: function (post_id) {
                var self = this;
                $.get('api/deletePost.php', {post_id: post_id}, function () {
                    for (var i = 0; i < self.postsObj.length; i++) {
                        if (self.postsObj[i]['post_id'] == post_id) {
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
            scrollToTop: function () {
                $("#postsContentPanel").animate({scrollTop: 0}, "fast", "swing", function () {

                });
            },
            invertColor: function (hex, bw) {
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
            },
            padZero: function (str, len) {
                len = len || 2;
                var zeros = new Array(len).join('0');
                return (zeros + str).slice(-len);
            }
        }
    });


</script>
</html>
