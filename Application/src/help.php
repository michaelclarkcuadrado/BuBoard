<!doctype html>
<html>
<head>
    <title>Help page</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="static/css/material.min.css"/>
    <link rel="stylesheet" href="static/css/help.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="mdl-color--blue-50">
  <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="mdl-layout__header">
          <div class="mdl-layout__header-row">
              <span class="mdl-layout-title">Help Page</span>
              <div class="mdl-layout-spacer"></div>
              <a class="mdl-navigation__link" id="help_btn" href="help.php">
                  <i class="material-icons">help</i>
                  <div class="mdl-tooltip" data-mdl-for="help_btn">
                      Need Help?
                  </div>
              </a>
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
<main>
</main>
</div>
<script>
</script>
</body>
</html>
