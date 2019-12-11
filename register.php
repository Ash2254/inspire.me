<?php require_once("includes/header.php") ?>
<!-- SECTION register -->
<body class="off-canvas-sidebar">
  <!-- SECTION navbar -->
  <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top text-white">
    <div class="container">
      <div class="navbar-wrapper">
        <a class="navbar-brand" href="/">Inspire.me</a>
      </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
        <span class="sr-only">Toggle navigation</span>
        <span class="navbar-toggler-icon icon-bar"></span>
        <span class="navbar-toggler-icon icon-bar"></span>
        <span class="navbar-toggler-icon icon-bar"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="/" class="nav-link">
              <i class="material-icons">dashboard</i> Home
            </a>
          </li>
          <li class="nav-item  active ">
            <a href="register.php" class="nav-link">
              <i class="material-icons">person_add</i> Register
            </a>
          </li>
          <li class="nav-item ">
            <a href="/login.php" class="nav-link">
              <i class="material-icons">fingerprint</i> Login
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- !SECTION navbar -->

  <div class="wrapper wrapper-full-page">
    <div class="page-header register-page header-filter" filter-color="black" style="background-image: url('/assets/img/login.jpg')">
      <div class="container">
        <div class="row">
          <div class="col-md-10 ml-auto mr-auto">
            <div class="card card-signup">
              <h2 class="card-title text-center">Register</h2>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-5 ml-auto">
                    <div class="info info-horizontal">
                      <div class="icon icon-primary">
                        <i class="material-icons">people</i>
                      </div>
                      <div class="description">
                        <h4 class="info-title">See People's Designs</h4>
                        <p class="description">
                          View work from designers to get inspired, or post your own to inspire others!
                        </p>
                      </div>
                    </div>
                    <div class="info info-horizontal">
                      <div class="icon icon-info">
                        <i class="material-icons">star</i>
                      </div>
                      <div class="description">
                        <h4 class="info-title">Star Designs You Love</h4>
                        <p class="description">
                          If you love a person's design, give it a star to show your appreciation!
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-5 mr-auto">
                    <!-- SECTION register form -->
                    <form class="form" method="POST" action="actions/logins.php" id="register">
                      <div class="form-group has-default">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="material-icons">person_outline</i>
                            </span>
                          </div>
                          <input type="text" class="form-control" placeholder="Username..." required id="username" name="username">
                        </div>
                      </div>
                      <div class="form-group has-default">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="material-icons">mail_outline</i>
                            </span>
                          </div>
                          <input type="email" class="form-control" placeholder="Email..." required id="email" name="email">
                        </div>
                      </div>
                      <div class="form-group has-default">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="material-icons">lock_outline</i>
                            </span>
                          </div>
                          <input type="password" placeholder="Password..." class="form-control" required id="password" name="password">
                        </div>
                      </div>
                      <div class="form-group has-default">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="material-icons">lock</i>
                            </span>
                          </div>
                          <input type="password" placeholder="Retype Password..." class="form-control" required id="password2" name="password2">
                        </div>
                      </div>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="checkbox" name="agree_terms">
                          <span class="form-check-sign">
                            <span class="check"></span>
                          </span>
                          I agree to the
                          <a href="#something">terms and conditions</a>.
                        </label>
                      </div>
                      <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-round mt-4" name="action" value="register">Get Started</button>
                      </div>
                    </form>
                    <!-- !SECTION register form -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php require_once("includes/footer.php") ?>

  <?php require_once("includes/error_check.php"); ?>
<!-- !SECTION register  -->