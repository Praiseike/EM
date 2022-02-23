<?php

    $a = array(array('name'=>'praise'),array('name'=>'david'),array('name'=>'joseph'));
    
    for($i = 0; $i < 3; $i ++)
    {
        echo $a[$i]['name'];
    }
    <?php for($i = 0; $i < 4; $i++): ?>
          
        <div class="card shadow">
            <a href="course_info.php?p=<?= $pcrypt->encrypt($courses[$i]['CODE'],$_SESSION['key']) ?>"><img src="videos/<?= $course[$i]['CODE'].'/'.$courses[$i]['THUMBNAIL']?>" class="card-img" alt="..."></a>
            <div class="card-body">
                <h5 class="card-title"><?= $courses[$i]['TITLE'] ?></h5>
                <p class="card-text">
                    <?= substr($courses[$i]['DESCRIPTION'],0,42)?>
                    <span>...</span>
                </p>
                <div class="price btn">$<?= $courses[$i]['PRICE'] ?></div>
                <a href="course_info.php?p=<?= $pcrypt->encrypt($courses[$i]['CODE'],$_SESSION['key']) ?>" class="btn btn-primary">info</a>
            </div>
        </div>
        
    <?php endfor ?>
?>