<?php
require_once 'config.php';
$userinfo = buboard_authenticate($mysqli, $authenticationKey);

if (isset($_GET['id'])) {
    $profile_id = mysqli_real_escape_string($mysqli, $_GET['id']);
} else {
    $profile_id = $userinfo['profile_id'];
}
?>

<!doctype html>
<html>
<head>
    <title>Personal Profile</title>

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
    <link rel="stylesheet" href="static/css/profile.css"/>
<!--    <link rel="stylesheet" href="static/css/introjs.css"/>-->
    <meta name="theme-color" content="#2196f3">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--Used for favicon generation -->
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/manifest.json">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
</head>
<body class="mdl-color--blue-50">
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
            <span class="mdl-layout-title">Personal Profile</span>
            <div class="mdl-layout-spacer"></div>
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
    <main id="profile_page_main" class="mdl--layout__content">
        <div class="card-profile mdl-shadow--2dp">
            <img v-if="has_submitted_photo > 0" id="profile_image" :src="'/usercontent/user_avatars/' + profile_id + photo_filename_extension">
            <img v-else id="profile_image" src="/static/image/portrait.png">
            <div class="content" id="content">
                <h5><i v-if="isVerifiedAccount"
                       class="material-icons verified_user">verified_user</i>
                    {{ real_name }}
                </h5>
                <a style="background-color: rgba(255,255,255,0.2); color: #0000EE; padding: 4px; border-radius: 5px; word-wrap: break-word" :href="'mailto:' + email_address">Email Address: {{email_address}}</a>
                <p>{{ profile_desc }}</p>
                <p v-if="isSubscribed > 0"><b>This user is subscribed to you.</b></p>
            </div>
            <div class="hazard_panel" v-if="curProfileIsAdmin">
                <div style="background-color: cadetblue; margin: 5px; padding: 5px;">
                    Administrator Controls<br>
                    <label>
                        System Admin
                        <input v-model="isAdmin" v-on:change="updatePermissions()" type="checkbox">
                    </label>
                    <label>
                        Verified User
                        <input v-model="isVerifiedAccount" v-on:change="updatePermissions()" type="checkbox">
                    </label>
                </div>
            </div>
        </div>
        <div id="infoPane" class="mdl-grid mdl-grid--no-spacing">
            <div v-if="isOwnProfile" style="height:100%" class="mdl-cell mdl-cell--4-col">
                <h5 style="margin: 0; padding: 8px">Your Subscriptions </h5>
                <ul style="margin-top: 0; padding-top: 0" class="mdl-list">
                    <li v-for="subscribee in subscribees" class="mdl-list__item mdl-list__item--two-line">
                            <span class="mdl-list__item-primary-content">
                                <i v-if="subscribee.has_submitted_photo == 0" v-on:click="window.location='profile.php?id=' + subscribee.profile_id" style="cursor: pointer"
                                   class="material-icons mdl-list__item-avatar">person</i>
                                <img v-else v-bind:src="'usercontent/user_avatars/' + subscribee.profile_id + subscribee.photo_filename_extension" v-on:click="window.location='profile.php?id=' + subscribee.profile_id"
                                     style="cursor: pointer" class="mdl-list__item-avatar">
                                <span v-on:click="window.location='profile.php?id=' + subscribee.profile_id" class="post-name-display"><i v-if="subscribee.isVerifiedAccount > 0"
                                                                                                                                          class="material-icons verified_user">verified_user</i>{{subscribee.real_name}}</span>
                                <span class="mdl-list__item-sub-title">Subscribed</span>
                            </span>
                        <span class="mdl-list__item-secondary-content">
                                <a class="mdl-list__item-secondary-action" v-on:click="unsubscribe(subscribee.profile_id)"><i class="material-icons">person_add</i></a>
                            </span>
                    </li>
                    <li v-if="Object.keys(subscribees).length == 0" class="mdl-list__item">
                        <span class="mdl-list__item-primary-content">
                            <i class="material-icons mdl-list__item_avatar">person</i>
                            <span class="post-name-display">
                                No Subscriptions. <br>
                                <a href="profilesearch.php">Discover who's on BuBoard</a>
                            </span>
                        </span>
                    </li>
                </ul>
            </div>
            <div id="postsContentPanel" style="margin: 0" :class="['mdl-cell', 'mdl-cell--4-col', 'mdl-shadow--8dp', (isOwnProfile) ? 'mdl-cell--8-col-desktop mdl-cell--4-col-tablet' : 'mdl-cell--12-col-desktop mdl-cell--8-col-tablet']">
                <div v-for="post in postsObj" v-bind:key="post" :class="['mdl-card', 'mdl-shadow--8dp', 'mdl-cell', 'mdl-cell--4-col', (isOwnProfile && Object.keys('subscribees').length > 0 ? 'mdl-cell--6-col-desktop mdl-cell--8-col-tablet' : '')]">
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
                    <div v-if="post.isOwnPost > 0 || curProfileIsAdmin" class="mdl-card__menu postOptionsMenu">
                        <button :id=" post.post_id + 'cornermenu'"
                                class="mdl-button mdl-js-button mdl-button--icon">
                            <i class="material-icons">more_vert</i>
                        </button>
                        <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
                            :for=" post.post_id + 'cornermenu'">
                            <li class="mdl-menu__item" v-on:click="deletePost(post.post_id)">Delete Post</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>

</div>
<!--Snackbar-->
<div id="snackbar" class="mdl-js-snackbar mdl-snackbar">
    <div class="mdl-snackbar__text"></div>
    <button class="mdl-snackbar__action" type="button"></button>
</div>
<script src="static/js/material.min.js"></script>
<script src="static/js/jquery.min.js"></script>
<script src="static/js/vue.min.js"></script>
<script>
    function snack(message, length) {
        var data = {
            message: message,
            timeout: length
        };
        document.querySelector('#snackbar').MaterialSnackbar.showSnackbar(data);
    }
    function logout() {
        gtag('event', 'logout');
        document.cookie = "token=; expires=Thu, 01 Jan 1970 00:00:01 GMT;";
        document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:01 GMT;";
        window.location.replace('/');
    }

    var profilePageVue = new Vue({
        el: '#profile_page_main',
        data: {
            postsObj: [],
            latestPostCurView: Infinity,
            isAtViewPaginationEnd: false,
            scrollLock: false,
            subscribees: {},
            profile_id: 0,
            real_name: "",
            isVerifiedAccount: false,
            curProfileIsAdmin: <?=($userinfo['isAdmin'] > 0 ? 'true' : 'false') //whether or not this current user is an admin?>,
            isAdmin: false,
            has_submitted_photo: "",
            photo_filename_extension: "",
            profile_desc: "",
            email_address: "",
            isOwnProfile: false,
            isSubscribed: false
        },
        mounted: function () {
            var self = this;
            //todo merge subscription list into single API call
            $.getJSON('api/getProfilePageData.php', {id: <?=$profile_id?>}, function(data) {
                self.profile_id = data.profile_id;
                self.real_name = data.real_name;
                self.isAdmin = data.isAdmin;
                self.isVerifiedAccount = data.isVerifiedAccount;
                self.has_submitted_photo = data.has_submitted_photo;
                self.photo_filename_extension = data.photo_filename_extension;
                self.profile_desc = data.profile_desc;
                self.email_address = data.email_address;
                self.isSubscribed = data.isSubscribed;
                self.isOwnProfile = data.isOwnProfile;
                if (self.isOwnProfile) {
                    $.getJSON("api/getSubscriptionList.php", function (data) {
                        self.subscribees = data;
                    }).fail(function () {
                        snack("Could not connect to server.", 5000);
                    });
                }
                self.getPosts();
            }).fail(function(data){
                //set timeout to allow snack to be available.
                setTimeout(function(){
                    snack(data.responseText, 9001);
                }, 150);
            });
            $('#infoPane').on('scroll', function () {
                //self is the vue object, this is the postsContentPanel jquery object
                if (!(self.scrollLock || self.isAtViewPaginationEnd)) {
                    if (this.scrollTop >= (this.scrollHeight - this.offsetHeight) - 100) {
                        self.getPosts();
                    }
                }
            });
        },
        updated: function () {
            componentHandler.upgradeDom();
        },
        methods: {
            getPosts: function () {
                this.scrollLock = true;
                if (!this.isAtViewPaginationEnd) {
                    var self = this;
                    $.getJSON('api/getPosts.php', {
                        latestPostCurView: (this.latestPostCurView === Infinity ? -1 : this.latestPostCurView),
                        postsFromProfileID: this.profile_id
                    }, function (data) {
                        gtag('event', 'load_10_posts_from_profile');
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
                        if (self.latestPostCurView === smallestID) {
                            self.isAtViewPaginationEnd = true;
                        }
                        self.latestPostCurView = smallestID;
                        self.scrollLock = false;
                    }).fail(function () {
                        self.scrollLock = false;
                        snack("Server Unavailable", 1200);
                    });
                }
            },
            updatePermissions: function() {
                var argsObj = {
                    profile_id: this.profile_id,
                    verifiedAccount: this.isVerifiedAccount,
                    isAdmin: this.isAdmin
                };
                $.get('api/changeProfilePermissions.php', argsObj, function(data){
                    gtag('event', 'admin_update_permissions');
                    snack('Admin: Permissions Assigned');
                }).fail(function(){
                    snack("Couldn't contact server", 1500);
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
            unsubscribe: function (profile_id) {
                var self = this;
                var argsObj = {
                    subscribeToID: profile_id,
                    action: 'unsubscribe'
                };
                $.get('api/subscribe.php', argsObj, function () {
                    Vue.delete(self.subscribees, profile_id);
                    snack('Unsubscribed.', 2500);
                }).fail(function () {
                    snack("Couldn't unsubscribe from user.", 2500);
                });
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
</body>
</html>
