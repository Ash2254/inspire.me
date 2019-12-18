<?php 
// SECTION user query
if (isset($_SESSION["user_id"])):
  $user_query = " SELECT users.username, avatars.url AS avatar
                  FROM users 
                  LEFT JOIN avatars
                  ON users.avatar_id = avatars.id
                  WHERE users.id = " . $_SESSION["user_id"];
              
  if ($user_request = mysqli_query($conn, $user_query)):
    while ($sidebar_user_row = mysqli_fetch_array($user_request)):
      $username = $sidebar_user_row["username"];
      $avatar   = $sidebar_user_row["avatar"];

    endwhile;
  endif;
endif;
// !SECTION user query
?>
<!-- SECTION sidebar -->
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
            <!-- SECTION user -->
            <?php if(isset($_SESSION["user_id"])): ?>
            <div class="photo">
                <img class="img" src="<?=($avatar) ? $avatar : "/assets/img/placeholder.jpg"?>"
                    alt="<?=$username?>'s Avatar" />
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
                                <span class="sidebar-mini"><i class="material-icons">person</i></span>
                                <span class="sidebar-normal"> My Profile </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/profile/edit.php">
                                <span class="sidebar-mini"><i class="material-icons">edit</i></span>
                                <span class="sidebar-normal"> Edit Profile </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="sidebar-mini"><i class="material-icons">settings_applications</i></span>
                                <span class="sidebar-normal"> Settings </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:$('#logout').submit();">
                                <span class="sidebar-mini"><i class="material-icons">exit_to_app</i></span>
                                <span class="sidebar-normal">Log out</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <?php else: ?>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="#" data-target="#loginModal" data-toggle="modal">
                        <i class="material-icons">fingerprint</i>
                        <p> Log In </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-target="#registerModal" data-toggle="modal">
                        <i class="material-icons">person_add</i>
                        <p> Register </p>
                    </a>
                </li>
            </ul>
            <?php endif; ?>
            <!-- !SECTION user -->
        </div>

        <!-- SECTION nav -->
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
                <a class="nav-link" href="/posts/view.php">
                    <i class="material-icons">view_list</i>
                    <p> Posts </p>
                </a>
            </li>
            <hr>
            <li class="nav-item">
                <a href="/posts/create.php" class="nav-link">
                    <i class="material-icons">add_post</i>
                    <p>Add Post</p>
                </a>
            </li>
        </ul>
        <!-- !SECTION nav -->



    </div>
</div>
<!-- !SECTION sidebar -->