<?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/header.php") ?>

<body class="">
  <div class="wrapper">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/sidebar.php"); ?>
    <div class="main-panel">
      <?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/navbar.php"); ?>
      <div class="content">
        <div class="container-fluid">
          <div class="header text-center">
            <h3 class="title">Timeline</h3>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card card-timeline card-plain">
                <div class="card-body">
                  <ul class="timeline">
                    <li class="timeline-inverted">
                      <div class="timeline-badge danger">
                        <i class="material-icons">card_travel</i>
                      </div>
                      <div class="timeline-panel">
                        <div class="timeline-heading">
                          <span class="badge badge-pill badge-danger">Some Title</span>
                        </div>
                        <div class="timeline-body">
                          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit dolorum facilis voluptate consequatur soluta quasi hic molestiae perspiciatis adipisci? Doloremque rem vel culpa consectetur, impedit atque. Odio beatae rem id.</p>
                        </div>
                        <h6>
                          <i class="ti-time"></i> 11 hours ago via Twitter
                        </h6>
                      </div>
                    </li>
                    <li>
                      <div class="timeline-badge success">
                        <i class="material-icons">extension</i>
                      </div>
                      <div class="timeline-panel">
                        <div class="timeline-heading">
                          <span class="badge badge-pill badge-success">Another One</span>
                        </div>
                        <div class="timeline-body">
                          <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quos pariatur necessitatibus velit quae ipsam consequuntur laudantium quia perferendis, voluptatibus porro atque nesciunt? Expedita, similique! Quo praesentium incidunt quam quod placeat.</p>
                        </div>
                      </div>
                    </li>
                    <li class="timeline-inverted">
                      <div class="timeline-badge info">
                        <i class="material-icons">fingerprint</i>
                      </div>
                      <div class="timeline-panel">
                        <div class="timeline-heading">
                          <span class="badge badge-pill badge-info">Another Title</span>
                        </div>
                        <div class="timeline-body">
                          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur voluptatum quidem aperiam sequi ducimus dolorum pariatur nostrum odit exercitationem ipsum! Dolore fugiat maxime eius amet modi vero. Eos, saepe provident?</p>
                          <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sint consectetur dolore beatae, voluptatum animi necessitatibus adipisci recusandae, id fugiat iste itaque, provident quae harum! Quo recusandae suscipit blanditiis vero est?</p>
                          <hr>
                        </div>
                        <div class="timeline-footer">
                          <div class="dropdown">
                            <button type="button" class="btn btn-round btn-info dropdown-toggle" data-toggle="dropdown">
                              <i class="material-icons">build</i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="#">Action</a>
                              <a class="dropdown-item" href="#">Another action</a>
                              <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="timeline-badge warning">
                        <i class="material-icons">flight_land</i>
                      </div>
                      <div class="timeline-panel">
                        <div class="timeline-heading">
                          <span class="badge badge-pill badge-warning">Another One</span>
                        </div>
                        <div class="timeline-body">
                          <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit ipsam expedita asperiores assumenda ex est aperiam natus veritatis ducimus dolore repudiandae consequuntur, facere itaque consectetur delectus animi rerum molestias. Reiciendis.</p>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>



<?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/footer.php") ?>