<?php
    session_start();
    if(!isset($_SESSION['admin-loggedin']))
    {
        header('Location: login');
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Create post</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src='../assets/fontawesome-free-6.0.0-beta3-web/js/all.min.js'></script>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script> -->
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index">Dashboard</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="logout">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="index">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCourses" aria-expanded="false" aria-controls="collapseCourses">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Courses
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseCourses" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="create_course">New course</a>
                                </nav>
                            </div>
                            <div class="collapse" id="collapseCourses" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="view_courses">view courses</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseBlogPost" aria-expanded="false" aria-controls="collapseBlogPost">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                    Blog posts
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseBlogPost" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="create_post">New post</a>
                                </nav>
                            </div>
                            <div class="collapse" id="collapseBlogPost" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="view_posts">Posts</a>
                                </nav>
                            </div>
                            

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAccounts" aria-expanded="false" aria-controls="collapseAccounts">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                    Accounts
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            
                            <div class="collapse" id="collapseAccounts" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="register" >
                                        Add User
                                    </a>
                                  
                                    <a class="nav-link collapsed" href="password">
                                        Forgot password
                                    </a>
                                </nav>
                            </div>
                            <div class="sb-sidenav-menu-heading">Data</div>
                            <a class="nav-link" href="charts">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Charts
                            </a>
                            <a class="nav-link" href="tables">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tables
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?= $_SESSION['name'] ?>
                        
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Create Post</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                            <li class="breadcrumb-item active">Create Post</li>
                        </ol>

                    <div class="container">
                        <form action='php/register_post' method='post' enctype="multipart/form-data">
                            <div class="form-group mb-3">
                                <label for='title'>Enter title</label>
                                <input required type='text' maxlength class='form-control' name='post-title' id='title'>
                                <div id="text-help" class='form-text'>Max Length 100</div>
                            
                            </div>

                            <div class="form-group mb-3">
                                <label for='title'>Enter Desription</label>
                                <input required type='text' class='form-control' maxlength='150' name='post-description' id='description'>
                                <div id="text-help" class='form-text'>Max Length 150</div>
                            </div>

                            <div class="form-group mb-3">
                                <label for='image'>Select image</label>
                                <input required type='file' class='form-control' name='post-image' id='image'>
                            </div>

                            <?php if(isset($_SESSION['error-msg'])) :?>
                                <div class="mb-3">
                                    <div class="alert alert-danger" role='alert'>
                                        <?= $_SESSION['error-msg'] ?>
                                        <?php $_SESSION['error-msg'] = null ?>
                                    </div>
                                </div>
                            <?php endif ?>
                            <div class="form-group mb-3">
                                <label for='text'>Enter text</label>
                                <textarea required class='form-control' rows="12" name='post-text' id='text'></textarea>
                            </div>

                            <button type='submit' class='btn btn-primary'>post</button>
                        </form>

                    </div>
                    </div>


                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Empowered Blockchain Hub <?= Date('Y') ?></div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script> -->
        <script src="../assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
