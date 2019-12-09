<?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/header.php"); ?>

<?php

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

if ($user_request = mysqli_query($conn, $user_query)):
  while ($user_row = mysqli_fetch_array($user_request)):

    $tags = [];
    $tag_ids = [];
    
    if ($tag_request = mysqli_query($conn, $tag_query)) {
      while ($tag_row = mysqli_fetch_array($tag_request)) {
        $tags[] = $tag_row["name"];
        $tag_ids[] = $tag_row["id"];
      }
    }

        $username = $user_row["username"];
        $email    = $user_row["email"];
        $bio      = $user_row["bio"];
        $avatar   = $user_row["avatar"];
        $banner   = $user_row["banner"];

?>

<body class="">
    <div class="wrapper">
        <?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/sidebar.php"); ?>
        <div class="main-panel">
            <?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/navbar.php"); ?>

            <div class="content">


                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="card card-profile">

                                <div class="card-header card-header-primary text-center">
                                    <div class="card-avatar mb-3">
                                        <a href="#pablo">
                                            <img class="img"
                                                src="<?=($avatar) ? $avatar : "/assets/img/placeholder.jpg"?>"
                                                alt="<?=$username?>'s Avatar" />
                                        </a>
                                    </div>

                                    <h1 class="card-title"><?=$username?></h1>
                                    <p class="category">
                                        <?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/tags.php"); ?>
                                    </p>

                                </div>
                                <div class="card-body container">
                                    <h4><?=$bio?></h4>

                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <!-- BEGIN CARD -->
                            <div class="card card-product">
                                <div class="card-header card-header-image" data-header-animation="true">
                                    <a href="#pablo">
                                        <img class="img" src="/assets/img/login.jpg">
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="card-actions text-center">
                                        <button type="button" class="btn btn-danger btn-link fix-broken-card">
                                            <i class="material-icons">build</i> Fix Header!
                                        </button>
                                        <button type="button" class="btn btn-default btn-link" rel="tooltip"
                                            data-placement="bottom" title="" data-original-title="View"
                                            aria-describedby="tooltip374115">
                                            <i class="material-icons">art_track</i>
                                        </button>
                                        <button type="button" class="btn btn-success btn-link" rel="tooltip"
                                            data-placement="bottom" title="" data-original-title="Edit">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-link" rel="tooltip"
                                            data-placement="bottom" title="" data-original-title="Remove">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </div>
                                    <h4 class="card-title">
                                        <a href="#pablo">Epic Design Post</a>
                                    </h4>
                                    <div class="card-description">
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Maiores molestiae natus magni reprehenderit perferendis tempore necessitatibus iusto placeat quos dolorem? Quis ad fugit quaerat tempora ipsam rerum iure, ratione labore!
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">access_time</i> posted 2 days ago
                                    </div>
                                </div>
                            </div>
                            <!-- END CARD -->
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