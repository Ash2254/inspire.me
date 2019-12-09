<?php 

if (isset($_SESSION["user_id"])):
  $user_query = " SELECT users.username, avatars.url AS avatar
                  FROM users 
                  LEFT JOIN avatars
                  ON users.avatar_id = avatars.id
                  WHERE users.id = " . $_SESSION["user_id"];
              
  if ($user_request = mysqli_query($conn, $user_query)):
    while ($user_row = mysqli_fetch_array($user_request)):
      $username = $user_row["username"];
      $avatar   = $user_row["avatar"];

    endwhile;
  endif;
endif;

?>

<div class="sidebar" data-color="azure" data-background-color="black" data-image="../../assets/img/sidebar-1.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
      <div class="logo">
        <a href="" class="simple-text logo-mini">
          
        </a>
        <a href="/" class="simple-text logo-normal">
          Inspire.me
        </a>
      </div>
      <div class="sidebar-wrapper">
        <div class="user">
          <?php if(isset($_SESSION["user_id"])): ?>
          <div class="photo">
            <img class="img" src="<?=($avatar) ? $avatar : "/assets/img/placeholder.jpg"?>" alt="<?=$username?>'s Avatar"/>
          </div>
          <div class="user-info">
            <a data-toggle="collapse" href="#collapseExample" class="username">
              <span>
                <?=$_SESSION["username"];?>
                <b class="caret"></b>
              </span>
            </a>
            <div class="collapse" id="collapseExample">
              <ul class="nav">
                <li class="nav-item">
                  <a class="nav-link" href="/profile/view.php">
                    <span class="sidebar-mini"> MP </span>
                    <span class="sidebar-normal"> My Profile </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/profile/edit.php">
                    <span class="sidebar-mini"> EP </span>
                    <span class="sidebar-normal"> Edit Profile </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">
                    <span class="sidebar-mini"> S </span>
                    <span class="sidebar-normal"> Settings </span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <?php else: ?>
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link" href="/login.php">
                <i class="material-icons">fingerprint</i>
                <p> Log In </p>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/register.php">
                <i class="material-icons">person_add</i>
                <p> Register </p>
              </a>
            </li>
          </ul>
          <?php endif; ?>
        </div>

        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="/index.php">
              <i class="material-icons">dashboard</i>
              <p> Home </p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/users.php">
              <i class="material-icons">people</i>
              <p> Users </p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/posts.php">
              <i class="material-icons">view_list</i>
              <p> Posts </p>
            </a>
          </li>
          <hr>
          <li class="nav-item">
            <a href="add_post.php" class="nav-link">
              <i class="material-icons">add_post</i>
              <p>Add Post</p>
            </a>
          </li>
        <ul>
          


      </div>
    </div>