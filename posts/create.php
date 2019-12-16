<?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/header.php") ?>

<body class="">
    <div class="wrapper">
        <?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/sidebar.php"); ?>
        <div class="main-panel">
            <?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/navbar.php"); ?>
            <div class="content">
                <div class="container-fluid">
                    <div class="header text-center">
                        <h3 class="title">Create a New Post</h3>
                    </div>
                    <form action="/actions/create_post.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-header card-header-primary">
                                        <h4 class="card-title">Post Details</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="post_title" class="bmd-label-floating">Post
                                                        Title</label>
                                                    <input type="text" name="post_title" id="post_title"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="post_tags" class="bmd-label-floating">Tags (Press
                                                        <kbd>Enter</kbd> or <kbd>,</kbd> to Seperate tags)</label>
                                                    <input type="text" name="post_tags" id="post_tags"
                                                        class="tagsinput form-control" data-color="info">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="post_description"
                                                        class="bmd-label-floating">Description</label>
                                                    <textarea name="post_description" id="post_description" cols="30"
                                                        rows="15" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-header card-header-rose">
                                        <h4 class="card-title">Post Image</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-md-12 text-center mt-3">
                                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail">
                                                    <img src="/assets/img/image_placeholder.jpg">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail">
                                                </div>
                                                <div>
                                                    <span class="btn btn-round btn-primary btn-file">
                                                        <span class="fileinput-new">Select Image</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" name="post_image">
                                                    </span>
                                                    <br>
                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists"
                                                        data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-rose">Create Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/footer.php"); ?>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/error_check.php"); ?>