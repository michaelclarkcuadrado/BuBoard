<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="static/css/material.min.css">
    <script defer src="static/js/material.min.js"></script>

</head>
<body>
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
            <!-- Title -->
            <!-- Add spacer, to align navigation to the right -->
            <!-- Navigation. We hide it in small screens. -->
            <nav class="mdl-navigation mdl-layout--large-screen-only">
            </nav>
        </div>
    </header>
    <style>
        .card-me {
            padding-left: 25px;
            padding-right: 25px;
            padding-bottom: 25px;
        }
        .card-me > .mdl-card__title {
            color: #fff;
            height: 176px;
            background: url('static/image/buboard_logo.jpg') center / cover;
        }
    </style>
    <main class="mdl-layout__content">
        <div class="page-content">
            <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--4-col"></div>
                <div class="mdl-cell mdl-cell--4-col"></div>
                <div class="mdl-cell mdl-cell--4-col"></div>
            </div>
            <div class="mdl-grid">
                <div class="mdl-layout-spacer"></div>
                <div class="wrapper">

                    <div class="demo-card-wide mdl-card mdl-shadow--8dp card-me">
                        <h4 align="center">Login</h4>

                        <div align="center">
                            <form action="#">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="text" id="email">
                                    <label class="mdl-textfield__label" for="email">Email or Phone</label>
                                </div>

                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="password" id="password">
                                    <label class="mdl-textfield__label" for="password">Password</label>
                                </div>

                                <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
                                    Login
                                </button>
                            </form>
                        </div>

                    </div>

                </div>
                <div class="mdl-layout-spacer"></div>
            </div>
            <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--4-col"></div>
                <div class="mdl-cell mdl-cell--4-col"></div>
                <div class="mdl-cell mdl-cell--4-col"></div>
            </div>
        </div>
    </main>
</div>
</body>
</html>