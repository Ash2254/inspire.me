<?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/header.php"); ?>

<?php

$user_id = (isset($_GET["user_id"])) ? $_GET["user_id"] : $_SESSION["user_id"];

$user_query = " SELECT users.*, avatars.url AS avatar 
                FROM users 
                LEFT JOIN avatars
                ON users.avatar_id = avatars.id
                WHERE users.id = " . $user_id;

if ($user_request = mysqli_query($conn, $user_query)):
  while ($user_row = mysqli_fetch_array($user_request)):

    $username = $user_row["username"];
    $email    = $user_row["email"];
    $bio      = $user_row["bio"];
    $avatar   = $user_row["avatar"];
    // TODO: Banner

?>

<body class="">
  <div class="wrapper">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/sidebar.php"); ?>
    <div class="main-panel">
      <?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/navbar.php"); ?>

      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-icon card-header-rose">
                  <div class="card-icon">
                    <i class="material-icons">perm_identity</i>
                  </div>
                  <h4 class="card-title">Edit Profile</h4>
                </div>
                <div class="card-body">
                  <form action="/actions/edit_profile.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="user_id" value="<?=$user_row["id"];?>">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating" for="username">Username</label>
                          <input type="text" class="form-control" id="username" name="username" value="<?=$username?>">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating" for="email">Email address</label>
                          <input type="email" class="form-control" id="email" name="email" value="<?=$email?>">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating" for="bio">About Me</label>
                          <textarea class="form-control" rows="5" id="bio" name="bio" ><?=$bio?></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6 text-center my-auto">
                      <h4 class="title">Avatar</h4>
                      <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <div class="fileinput-new thumbnail img-circle">
                          <img src="/assets/img/placeholder.jpg" alt="...">
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail img-circle" style="width: 100px; height: 100px;"></div>
                        <div>
                          <span class="btn btn-round btn-primary btn-file">
                            <span class="fileinput-new">Add Photo</span>
                            <span class="fileinput-exists">Change</span>
                            <input type="file" name="avatar" />
                          </span>
                          <br />
                          <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 text-center my-auto">
                      <h4 class="title">Banner Image</h4>
                      <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <div class="fileinput-new thumbnail">
                          <img src="/assets/img/image_placeholder.jpg" alt="...">
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                        <div>
                          <span class="btn btn-primary btn-round btn-file">
                            <span class="fileinput-new">Select image</span>
                            <span class="fileinput-exists">Change</span>
                            <input type="file" name="banner" />
                          </span>
                          <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                        </div>
                      </div>
                    </div>
                  </div>
                    <button type="submit" class="btn btn-rose pull-right" name="action" value="update">Update Profile</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card card-profile">
                <img class="card-img-top" src="/assets/img/image_placeholder.jpg">
                <div class="card-avatar">
                  <a href="#pablo">
                    <img class="img" src="/assets/img/placeholder.jpg" />
                  </a>
                </div>

                <div class="card-body">
                  <!-- <h6 class="card-category text-gray">CEO / Co-Founder</h6> -->
                  <h4 class="card-title"><?=$_SESSION["username"];?></h4>
                  <p class="card-description">
                    <!-- TODO: Add description -->
                  </p>
                  <a href="#pablo" class="btn btn-rose btn-round">Follow</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

<?php 
  endwhile; 
endif; 
?>

<?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/footer.php"); ?>
<?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/error_check.php"); ?>