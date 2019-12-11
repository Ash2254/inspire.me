<?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/header.php"); ?>

<?php
// SECTION users query
$user_id = (isset($_GET["user_id"])) ? $_GET["user_id"] : $_SESSION["user_id"];

$user_query = " SELECT users.*, avatars.url AS avatar, banners.url AS banner
                FROM users 
                LEFT JOIN avatars
                ON users.avatar_id = avatars.id
                LEFT JOIN banners
                ON users.banner_id = banners.id
                WHERE users.id = " . $user_id;

$tag_query  = " SELECT user_tags.*, tags.* FROM user_tags
                LEFT JOIN tags
                ON user_tags.tag_id = tags.id
                WHERE user_tags.user_id = $user_id";

// if ($user_request = mysqli_query($conn, $user_query)):
//   while ($user_row = mysqli_fetch_array($user_request)):

//     $tags = [];
//     $tag_ids = [];
    
//     if ($tag_request = mysqli_query($conn, $tag_query)) {
//       while ($tag_row = mysqli_fetch_array($tag_request)) {
//         $tags[] = $tag_row["name"];
//         $tag_ids[] = $tag_row["id"];
//       }
//     }

//         $username = $user_row["username"];
//         $email    = $user_row["email"];
//         $bio      = $user_row["bio"];
//         $avatar   = $user_row["avatar"];
//         $banner   = $user_row["banner"];
// !SECTION users query
?>

<body class="">
    <div class="wrapper">
        <?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/sidebar.php"); ?>
        <div class="main-panel">
            <?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/navbar.php"); ?>

            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <?php
                        $users_query = "SELECT users.*, 
                                        avatars.url AS avatar, 
                                        banners.url AS banner
                                        FROM users 
                                        LEFT JOIN avatars
                                        ON users.avatar_id = avatars.id
                                        LEFT JOIN banners
                                        ON users.banner_id = banners.id";
        
                        $search = (isset($_GET["search"])) ? $_GET["search"] : false;
                
                        if ($search) {
                
                            $search_words = explode(" ", $search);
                
                            for ($i = 0; $i < count($search_words); $i++) {
                
                                $users_query .= ($i > 0) ? " OR " : " WHERE ";
                                $users_query .= "users.username LIKE '%".$search_words[$i]."%'";
                            }
                        }
                
                        if ($users_result = mysqli_query($conn, $users_query)) {
                
                            while($user_row = mysqli_fetch_array($users_result)) {

                                $banner = $user_row["banner"];
                                $avatar = $user_row["avatar"];
                                $username = $user_row["username"];
                                $bio    = $user_row["bio"];
                        ?>
                        <div class="col-md-4">
                            <div class="card card-profile">
                                <?=($banner) ? "<img class=\"card-img-top\" src=\"$banner\" style='height: 300px; object-fit: cover; '>" : false ?>
                                <div class="card-avatar">
                                    <a href="#pablo">
                                        <img class="img" src="<?=($avatar) ? $avatar : "/assets/img/placeholder.jpg"?>"
                                            alt="<?=$username?>'s Avatar" />
                                    </a>
                                </div>

                                <div class="card-body">
                                    <h4 class="card-title"><?=$username;?></h4>
                                    <h6 class="card-category">
                                        <!-- TAGS -->
                                    </h6>
                                    <p class="card-description">
                                        <?=$bio?>
                                    </p>
                                    <a href="#pablo" class="btn btn-rose btn-round">View Profile</a>
                                </div>
                            </div>
                        </div>
                        <?php 
                            }
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


<?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/footer.php"); ?>
<?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/error_check.php"); ?>