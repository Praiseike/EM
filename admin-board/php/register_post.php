<?php 

    if(isset($_POST['post-title'],$_POST['post-text'],$_FILES['post-image'],$_POST['post-description']))
    {

        $con = new mysqli("localhost","root","",'em-db');
        if($con->connect_errno){
            die("Unable to connect to database posts");
        }


        $title = filter_var($_POST['post-title'],FILTER_SANITIZE_STRING);
        $text = filter_var($_POST['post-text'],FILTER_SANITIZE_STRING);
        $description = filter_var($_POST['post-description'],FILTER_SANITIZE_STRING);
        
        $code = uniqid();
        
        $base = "../../posts/";
        $path = $base.$code;

        
        /* Check is a directory exist before loading into the directory */
        
        if(!file_exists($base))
        {
            mkdir($base);
        }else{
            mkdir($path);
        }

        // get file info
        $filepath = $_FILES['post-image']['tmp_name'];
        $fileSize = filesize($filepath);
        $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
        $filetype = finfo_file($fileinfo, $filepath);
        
        if ($fileSize === 0) {
            $_SESSION['error-msg'] = "The file is empty";
            header("Location: ../create_post");
        }
        
        if ($fileSize > 3145728) { // 3 MB (1 byte * 1024 * 1024 * 3 (for 3 MB))
            $_SESSION['error-msg'] = "The file is too large";
            header("Location: ../create_post");
        }
        
        $allowedTypes = [
        'image/png' => 'png',
        'image/jpeg' => 'jpg'
        ];
        
        if (!in_array($filetype, array_keys($allowedTypes))) {
            $_SESSION['error-msg'] = "This file type is not allowed";
            header("Location: ../create_post");
            
        }

        $extension = $allowedTypes[$filetype];

        $targetDirectory = $path;
        $thumbnail = "post-image.".$extension;
        $newFilepath = $targetDirectory . "/".$thumbnail;

        
        if (!copy($filepath, $newFilepath)) { // Copy the file, returns false if failed
            die("Can't move file.");
        }
        unlink($filepath); // Delete the temp file  






        $title = filter_var($title,FILTER_SANITIZE_STRING);
        $timestamp = Date('Y-m-d');
        $stmt = $con->prepare("INSERT INTO posts(TITLE,DESCRIPTION,CONTENT,CODE,TIMESTAMP,THUMBNAIL) VALUES(?, ?, ?, ?, ?, ?) ");
        $stmt->bind_param('ssssss',$title,$description,$text,$code,$timestamp,$thumbnail);
        $s = $stmt->execute();
        if(!$s){
            die("unable to insert into table posts");
        }else{
            // upload was successful
            header("Location: ../view_posts");
        }

    }

?>