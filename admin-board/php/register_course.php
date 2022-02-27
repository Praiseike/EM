<?php
    session_start();
    
    $dbname = "em-db";
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';

    $con = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
    if($con->connect_error)
    {
        die('unable to connect to database '.$dbname);
    }
    
    if(isset($_POST['course-title'],$_POST['course-description'],$_POST['course-price'],$_FILES['course-thumbnail']))
    {
        // retrieve form data
        $title = filter_var($_POST['course-title'],FILTER_SANITIZE_STRING);
        $description = filter_var($_POST['course-description'],FILTER_SANITIZE_STRING);
        $price = filter_var($_POST['course-price'],FILTER_VALIDATE_INT);
        $code = uniqid('course_');
        $base = "../../videos/";
        $path = $base.$code;
        
        /* Check is a directory exist before loading into the directory */
        
        if(!file_exists($base))
        {
            mkdir($base);
        }else{
            mkdir($path);
        }

        // get file info
        $filepath = $_FILES['course-thumbnail']['tmp_name'];
        $fileSize = filesize($filepath);
        $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
        $filetype = finfo_file($fileinfo, $filepath);
        
        if ($fileSize === 0) {
            $_SESSION['error-msg'] = "The file is empty";
            header("Location: ../create_course");
        }
        
        if ($fileSize > 3145728) { // 3 MB (1 byte * 1024 * 1024 * 3 (for 3 MB))
            $_SESSION['error-msg'] = "The file is too large";
            header("Location: ../create_course");
        }
        
        $allowedTypes = [
           'image/png' => 'png',
           'image/jpeg' => 'jpg'
        ];
        
        if (!in_array($filetype, array_keys($allowedTypes))) {
            $_SESSION['error-msg'] = "This file type is not allowed";
            header("Location: ../create_course");
        }

        $extension = $allowedTypes[$filetype];

        $targetDirectory = $path;
        $thumbnail = "course-thumbnail.".$extension;
        $newFilepath = $targetDirectory . "/".$thumbnail;

        
        if (!copy($filepath, $newFilepath)) { // Copy the file, returns false if failed
            die("Can't move file.");
        }
        unlink($filepath); // Delete the temp file  
    
        // prepare and execute sql insert statements
        $stmt = $con->prepare("INSERT INTO courses(TITLE,DESCRIPTION,PRICE,CODE,THUMBNAIL,DATE) VALUES( ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssss',$title,$description,$price,$code,$thumbnail,date('Y-m-d'));
        $stmt->execute();

        $stmt->close();


        header('Location: ../view_courses');
  
    }

    $con->close();
?>