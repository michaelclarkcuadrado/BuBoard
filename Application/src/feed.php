<?php
require_once 'config.php';
$userinfo = buboard_authenticate($mysqli, $authenticationKey);

$categoriesQuery = mysqli_query($mysqli, "SELECT category_id, category_name FROM post_categories");
?>

<!doctype html>
<html>
<head>
    <title>BuBoard Feed</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="static/css/material.min.css"/>
    <link rel="stylesheet" href="static/css/feed.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header" id="postsContentPanel">
    <header class="mdl-layout__header">
        <!--Top row of header-->
        <div class="mdl-layout__header-row">
            <span class="mdl-layout-title">Local Feed</span>
            <div class="mdl-layout-spacer"></div>
            <a class="mdl-navigation__link" id="help_btn" href="help.php">
                <i class="material-icons">help</i>
            </a>
        </div>

        <div class="mdl-layout__header-row" id="desktopCategoriesSwitcher">
            <div class="mdl-layout-spacer"></div>
            <nav class="mdl-navigation">
                <a class="mdl-navigation__link is-active" href="test">Latest</a>
                <a class="mdl-navigation__link" href="test">Following</a>
                <?php
                while ($category = mysqli_fetch_assoc($categoriesQuery)) {
                    echo "<a class=\"mdl-navigation__link\" href=\"test\">" . $category['category_name'] . "</a>";
                }
                ?>
            </nav>
        </div>
    </header>
    <div class="mdl-layout__drawer">
        <span class="mdl-layout-title">BuBoard</span>
        <nav class="mdl-navigation mdl-color--blue-light_blue-800">
            <a class="mdl-navigation__link" href="/feed.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i> Home</a>
            <a class="mdl-navigation__link" href="profile.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">flag</i> My Profile</a>
            <a class="mdl-navigation__link" onclick="logout()"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">exit_to_app</i> Logout</a>
        </nav>
    </div>

    <!-- Creates the main content of the page -->
    <main class="mdl--layout__content">
        <div id="postsView" class="mdl-grid">
            <div v-for="post in postsObj" class="mdl-card mdl-shadow--8dp mdl-cell mdl-cell--4-col">
                <div class="postTitleCard mdl-card__title mdl-color--blue">
                    <img class="thumbtack" src="static/image/thumbtack.png">
                    <h2 class="mdl-card__title-text">
                        {{post.post_title}}
                    </h2>
                </div>
                <div class="mdl-card__supporting-text">
                    <div class="card-category-chip chip" v-bind:style="{float: 'right', backgroundColor: '#' + post.category_color, color: invertColor(post.category_color, true)}">
                        {{post.category_name}}
                    </div>
                    <ul class="post-authorship mdl-list">
                        <li class="mdl-list__item mdl-list__item--two-line">
                            <span class="mdl-list__item-primary-content">
                                <div style="cursor: pointer" v-on:click="window.location='profile.php?id=' + post.profile_id">
                                    <i v-if="post.has_submitted_photo == 0" class="material-icons mdl-list__item-avatar">person</i>
                                    <img v-else v-bind:src="'usercontent/user_avatars/' + post.profile_id + '.jpg'" class="mdl-list__item-avatar">
                                    <span>{{post.real_name}}</span>
                                </div>
                                <i :id="post.post_id + '-following'" v-bind:class="[post.isSubscribed ? 'subscribed-btn' : 'subscribe-btn', 'material-icons']">rss_feed</i>
                                <div class="mdl-tooltip" :data-mdl-for="post.post_id + '-following'">
                                    <span v-if="post.isSubscribed">Unsubscribe</span>
                                    <span v-else>Subscribe</span>
                                </div>
                                <span class="mdl-list__item-sub-title">{{post.post_date}}</span>
                            </span>
                        </li>
                        <hr>
                    </ul>
                    <div class="post-contents">
                        {{post.post_contents}}
                    </div>
                    <div v-if="Object.keys(post.attachments).length > 0" class="post-image-attachments">
                        <br>
                        Attachments:
                        <div>
                            <a v-for="attachment in post.attachments" target="_blank" :href="'usercontent/post_attachments/' + attachment.attachment_id + '.jpg'"><img
                                        class="mdl-cell mdl-cell--2-col mdl-cell--1-col-phone" v-bind:src="'usercontent/post_attachments/' + attachment.attachment_id + '.jpg'"></a>
                        </div>
                    </div>
                </div>
                <div class="mdl-card__menu postOptionsMenu">
                    <button :id=" post.post_id + 'cornermenu'"
                            class="mdl-button mdl-js-button mdl-button--icon">
                        <i class="material-icons">more_vert</i>
                    </button>
                    <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
                        :for=" post.post_id + 'cornermenu'">
                        <li class="mdl-menu__item">Follow User</li>
                        <li class="mdl-menu__item">Delete Post</li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
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

    var allPostsVue = new Vue({
        el: '#postsView',
        data: {
            postsObj: [],
            curViewIsCategory: 0,
            curView: 0, //0 for latest/firehose, 1 for followers view. Otherwise, if is category, it is category index
            latestPostCurView: -1, // for pagination, ID of the last post in received dataset.
            isAtViewPaginationEnd: 0
        },
        mounted: function () {
            this.getPosts();
        },
        updated: function () {
            componentHandler.upgradeDom();
        },
        methods: {
            changeView: function (viewID, isCategory) {
                if (this.curViewIsCategory !== isCategory || this.curView !== viewID) {
                    this.latestPostCurView = 0;
                    this.isAtViewPaginationEnd = 0;
                    this.curViewIsCategory = isCategory;
                    this.curView = viewID;
                    this.postsObj = [];
                    this.getPosts();
                }
            },
            getPosts: function () {
                if (!this.isAtViewPaginationEnd) {
                    self = this;
                    $.getJSON('api/getPosts.php', {
                            curViewIsCategory: this.curViewIsCategory,
                            curView: this.curView,
                            latestPostCurView: this.latestPostCurView
                        },
                        function (data) {
                            self.postsObj = self.postsObj.concat(data);
                            var maxID = 0;
                            for (var i = 0; i < self.postsObj.length; i++) {
                                if (parseInt(self.postsObj[i]['post_id']) > maxID) {
                                    maxID = parseInt(self.postsObj[i]['post_id']);
                                }
                            }
                            self.latestPostCurView = maxID;
                            //TODO test if pagination is done
                        });
                }
            },
            invertColor: function (hex, bw) {
                // stolen from https://github.com/onury/invert-color MIT Licensed.
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
