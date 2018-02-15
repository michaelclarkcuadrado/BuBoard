<?php
require_once 'config.php';
$userinfo = buboard_authenticate($mysqli, $authenticationKey);

?>

<!doctype html>
<html>
<head>
    <title>Profile Search</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="static/css/material.min.css"/>
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
            <span class="mdl-layout-title">Find Members</span>
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
    <main id="profile_search_main" class="mdl--layout__content">
        <div class="largeTitle mdl-typography--text-center">
            <h3 style="margin: 4px">Discover new connections on BuBoard</h3>
        </div>
        <br>
        <div style="margin-left: auto; margin-right: auto; background-color: white; border-radius: 10px; width: fit-content" class="mdl-shadow--2dp">
            <div class="mdl-textfield mdl-js-textfield" style="margin: 0 15px 0 15px">
                <input class="mdl-textfield__input" v-model="searchQuery"  type="text" id="sample1">
                <label class="mdl-textfield__label" for="sample1">Search</label>
            </div>
        </div>
        <div id="searchResultsContainer">
            <div id="searchResultsList" v-if="searchQuery != '' || Object.keys(searchResults).length != 0">
                <h5 class="mdl-typography--text-center">Results for {{searchQuery}}: {{Number(Object.keys(searchResults).length).toLocaleString()}} results</h5>
                <ul style="display:flex; flex-wrap: wrap; justify-content: space-evenly; max-width: 1400px; margin-left: auto; margin-right: auto;" class="mdl-list">
                    <li v-for="(profile, profile_index) in searchResults" style="flex-grow: 1;"  class="mdl-list__item mdl-list__item--two-line">
                            <span class="mdl-list__item-primary-content">
                                <i v-if="profile.has_submitted_photo == 0" v-on:click="window.location='profile.php?id=' + profile.profile_id" style="cursor: pointer"
                                   class="material-icons mdl-list__item-avatar">person</i>
                                <img v-else v-bind:src="'usercontent/user_avatars/' + profile.profile_id + profile.photo_filename_extension" v-on:click="window.location='profile.php?id=' + profile.profile_id"
                                     style="cursor: pointer" class="mdl-list__item-avatar">
                                <span v-on:click="window.location='profile.php?id=' + profile.profile_id" style="cursor: pointer" class="post-name-display"><i v-if="profile.isVerifiedAccount > 0"
                                                                                                                                                               class="material-icons verified_user">verified_user</i>{{profile.real_name}}</span>
                                <span v-on:click="window.location='profile.php?id=' + profile.profile_id" class="mdl-list__item-sub-title" style="cursor: pointer">
                                    <b>{{Number(profile.followers).toLocaleString()}} followers</b><br>
                                    {{profile.profile_desc}}
                                </span>
                            </span>
                        <span v-if="profile.isSubscribed == 0" class="mdl-list__item-secondary-content">
                            <a class="mdl-list__item-secondary-action" v-on:click="subscribe(profile.profile_id, profile_index, false)"><button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent">Subscribe</button></a>
                        </span>
                        <span v-else class="mdl-list__item-secondary-content">
                            <a class="mdl-list__item-secondary-action"><button disabled class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent">Subscribed</button></a>
                        </span>
                    </li>
                </ul>
            </div>
            <div id="initialRecommendationsContainer" v-else>
                <h5 class="mdl-typography--text-center">Popular on BuBoard</h5>
                <ul style="display:flex; flex-wrap: wrap; justify-content: space-evenly; max-width: 1400px; margin-left: auto; margin-right: auto;" class="mdl-list">
                    <li v-for="(profile, profile_index) in initialRecommendations" style="flex-grow: 1;"  class="mdl-list__item mdl-list__item--two-line">
                            <span class="mdl-list__item-primary-content">
                                <i v-if="profile.has_submitted_photo == 0" v-on:click="window.location='profile.php?id=' + profile.profile_id" style="cursor: pointer"
                                   class="material-icons mdl-list__item-avatar">person</i>
                                <img v-else v-bind:src="'usercontent/user_avatars/' + profile.profile_id + profile.photo_filename_extension" v-on:click="window.location='profile.php?id=' + profile.profile_id"
                                     style="cursor: pointer" class="mdl-list__item-avatar">
                                <span v-on:click="window.location='profile.php?id=' + profile.profile_id" style="cursor: pointer" class="post-name-display"><i v-if="profile.isVerifiedAccount > 0"
                                                                                                                                          class="material-icons verified_user">verified_user</i>{{profile.real_name}}</span>
                                <span v-on:click="window.location='profile.php?id=' + profile.profile_id" class="mdl-list__item-sub-title" style="cursor: pointer">
                                    <b>{{Number(profile.followers).toLocaleString()}} followers</b><br>
                                    {{profile.profile_desc}}
                                </span>
                            </span>
                        <span class="mdl-list__item-secondary-content">
                            <a class="mdl-list__item-secondary-action" v-on:click="subscribe(profile.profile_id, profile_index, false)"><button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent">Subscribe</button></a>
                            </span>
                    </li>
                </ul>
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
        document.cookie = "token=; expires=Thu, 01 Jan 1970 00:00:01 GMT;";
        document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:01 GMT;";
        window.location.replace('/');
    }

    var searchVue = new Vue({
        el: "#profile_search_main",
        data: {
            initialRecommendations: {},
            searchResults: {},
            searchQuery: "",
            debouncer_lock: false
        },
        mounted: function(){
            self = this;
            $.getJSON('/api/followRecommendations.php', function(data){
                self.initialRecommendations = data;
            }).fail(function(){
                snack("Could not contact server.", 4500);
            });
        },
        watch: {
            searchQuery: function(newData, oldData) {
                if(newData == ""){
                    this.searchResults = [];
                } else {
                    this.search(newData);
                }
            }
        },
        methods: {
            search: function(query){
                var self = this;
                $.getJSON('api/profileSearchProvider.php', {q: query}, function(data) {
                    self.searchResults = data;
                });
            },
            subscribe: function(profile_id, profile_index, isSearchResult){
                var self = this;
                $.get('api/subscribe.php', {subscribeToID: profile_id}, function() {
                    Vue.delete(self.initialRecommendations, profile_index);
                   snack("Subscribed!", 1500);
                });
            }
        }
    });
</script>
</body>
</html>
