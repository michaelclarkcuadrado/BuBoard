<!doctype html>
<html>
<head>
    <title>BuBoard Feed</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="static/css/material.min.css"/>
    <link rel="stylesheet" href="static/css/feed.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="mdl-color--light-blue-A100">
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
            <span class="mdl-layout-title">Local Feed</span>
            <div class="mdl-layout-spacer"></div>
            <a class="mdl-navigation__link" id="help_btn" href="help.php">
                <i class="material-icons">help</i>
            </a>
        </div>
    </header>
    <div class="mdl-layout__drawer">
        <span class="mdl-layout-title">BuBoard</span>
        <nav class="mdl-navigation mdl-color--blue-light_blue-800">
            <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i> Home</a>
            <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">forum</i> Personal Feed</a>
            <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">flag</i> My Profile</a>
        </nav>
    </div>

    <!-- Creates the main content of the page -->
    <main class="mdl--layout__content ">
        <div id="postsView" class="mdl-grid">
            <div v-for="(post, post_index) in postsObj" class="mdl-card mdl-shadow--6dp mdl-cell mdl-cell--4-col">
                <div class="mdl-card__title mdl-color--blue">
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
                              <i v-if="post.has_submitted_photo == 0" class="material-icons mdl-list__item-avatar">person</i>
                                <img v-else v-bind:src="'usercontent/user_avatars/' + post.profile_id + '.jpg'" class="mdl-list__item-avatar">
                                <span>{{post.real_name}}</span>
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
                            <a v-for="attachment in post.attachments" target="_blank" :href="'usercontent/post_attachments/' + attachment.attachment_id + '.jpg'"><img class="mdl-cell mdl-cell--2-col mdl-cell--1-col-phone" v-bind:src="'usercontent/post_attachments/' + attachment.attachment_id + '.jpg'"></a>
                        </div>
                    </div>
                </div>
                <div class="mdl-card__menu">
                    <button id="demo-menu-lower-right"
                            class="mdl-button mdl-js-button mdl-button--icon">
                        <i class="material-icons">more_vert</i>
                    </button>
                    <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
                        for="demo-menu-lower-right">
                        <li class="mdl-menu__item">Follow User</li>
                        <li class="mdl-menu__item">RSVP</li>
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
    var allPostsVue = new Vue({
        el: '#postsView',
        data: {
            postsObj: {}
        },
        mounted: function () {
            self = this;
            $.getJSON('api/getPosts.php', function (data) {
                self.postsObj = data;
            });
        },
        methods: {
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















