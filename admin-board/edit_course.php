<?php 
    session_start();
    if(!isset($_SESSION['admin-loggedin']))
    {
        header("Location: login");
    }
    
    include 'php/db.php';


    if(isset($_GET['id'])){

        $id = $_GET['id'];       
        $id = filter_var($id,FILTER_SANITIZE_STRING);
        $stmt = $con->prepare("SELECT * FROM courses WHERE CODE = ?");
        $stmt->bind_param('s',$id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
        }
        $stmt->close();
    }

    $con->close();
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Edit course</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src='../assets/fontawesome-free-6.0.0-beta3-web/js/all.min.js'></script>
        
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script> -->
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark" style="background-color: rgb(0,6,20) !important;">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index">Video</a>
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
        <div id="layoutSidenav" >

            <div id="layoutSidenav_nav" >
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion" style="background-color: rgb(0,6,20) !important;">
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
                                    <a class="nav-link" href="#!">View courses</a>
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

                                    <a class="nav-link collapsed" href="password" >
                                        Forgot Password
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
                        <h1 class="mt-4">Edit Course</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                            <li class="breadcrumb-item active">Edit course</li>
                        </ol>
                
                        <div class="container mb-3">
                        <form action='./php/register_course.php' enctype="multipart/form-data" method="post" class="row align-items-left mx-5 w-75">
                            <div class="mb-3">
                                <label class="form-label" for="video-title">Enter title</label>
                                <input type="text" value ="<?= $row['TITLE'] ?>" class="form-control" id="video-title" required name="course-title">
                                <div id="title-help" class="form-text">Make sure to give a title</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="video-description">Enter description</label>
                                <textarea type="text" class="form-control" id="video-description" required name="course-description"><?= $row['DESCRIPTION'] ?></textarea>
                                <div id="title-help" class="form-text">Video description</div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label" for="video-price">Enter price</label>
                                <input value ="<?= $row['PRICE'] ?>" type="number" class="form-control" id="video-price" required name="course-price">
                                <div id="title-help" class="form-text">Price is in dollars</div>
                            </div>

                            <img src="../videos/<?= $row['CODE'].'/'.$row['THUMBNAIL'] ?>"  style="margin-left: 10px;margin-bottom: 20px;height: 150px;width:200px;" class='img-thumbnail'>
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Change image</label>
                                <input class="form-control" type="file" required id="course-thumbnail" name="course-thumbnail">
                                <div id="title-help" class="form-text">file size < 3mb (png / jpg)</div>
                            </div>
                            <?php if(isset($_SESSION['error-msg'])) :?>
                                <div class="mb-3">
                                    <div class="alert alert-danger" role='alert'>
                                        <?= $_SESSION['error-mgs'] ?>
                                        <!-- <?php// session_destroy(); ?> -->
                                    </div>
                                </div>
                            <?php endif ?>
                            
                            <div class="mb-3">
                                <!-- <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Done</button> -->
                                <button type="submit" class="btn btn-primary" >Done</button>
                            </div>

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
        <script src="../assets/jquery.min.js"></script>
        <script src='./js/worker.js'></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
