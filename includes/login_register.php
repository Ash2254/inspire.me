<?php if(!isset($_SESSION["user_id"])): ?>
<!-- SECTION login modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="">
    <div class="modal-dialog modal-login" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-rose text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>

                        <h4 class="card-title"><strong>Log in</strong></h4>
                    </div>
                </div>
                <form class="form" method="POST" action="/actions/logins.php">
                    <div class="modal-body">
                        <p class="description text-center">Need an account? <a href="#" data-target="#registerModal"
                                data-toggle="modal">Register now!</a></p>
                        <div class="card-body">

                            <div class="form-group bmd-form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="material-icons">person</i></div>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Username..." name="username"
                                        autocomplete="username">
                                </div>
                            </div>

                            <div class="form-group bmd-form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="material-icons">lock_outline</i></div>
                                    </div>
                                    <input type="password" class="form-control" placeholder="Password..."
                                        name="password" autocomplete="current-password">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center my-3">
                        <button type="submit" class="btn btn-rose btn-round btn-wd" name="action" value="login">Log
                            in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- !SECTION login modal -->

<!-- SECTION register modal -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-signup" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <h2 class="modal-title card-title">Register</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="material-icons">clear</i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5 ml-auto">
                            <div class="info info-horizontal">
                                <div class="icon icon-rose">
                                    <i class="material-icons">people</i>
                                </div>
                                <div class="description">
                                    <h4 class="info-title">Get Inspired</h4>
                                    <p class="description">
                                        View work from other designers and developers to get inspired, or post your own
                                        to inspire others!
                                    </p>
                                </div>
                            </div>

                            <div class="info info-horizontal">
                                <div class="icon icon-primary">
                                    <i class="material-icons">star</i>
                                </div>
                                <div class="description">
                                    <h4 class="info-title">Star Designs You Love</h4>
                                    <p class="description">
                                        If you love a post, give it a star to show your appreciation!
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 mr-auto">

                            <form class="form" method="POST" action="actions/logins.php" id="register">
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i
                                                        class="material-icons">person_outline</i></div>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Username..."
                                                name="username" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="material-icons">mail_outline</i>
                                                </div>
                                            </div>
                                            <input type="email" class="form-control" placeholder="Email..." name="email"
                                                required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="material-icons">lock_outline</i>
                                                </div>
                                            </div>
                                            <input type="password" placeholder="Password..." class="form-control"
                                                name="password" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="material-icons">lock</i>
                                                </div>
                                            </div>
                                            <input type="password" placeholder="Retype Password..." class="form-control"
                                                name="password2" required>
                                        </div>
                                    </div>

                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" name="agree_terms">
                                            <span class="form-check-sign">
                                                <span class="check"></span>
                                            </span>
                                            I agree to the <a href="#something">terms and conditions</a>.
                                        </label>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-center mt-4">
                                    <button class="btn btn-primary btn-round btn-wd" name="action" value="register">Get
                                        Started</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- !SECTION register modal -->
<?php require_once("error_check.php"); ?>
<?php endif; ?>