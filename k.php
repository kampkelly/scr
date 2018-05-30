<?php

    $myfile = fopen("k.txt", "w") or die("Unable to open file!");
    fwrite($myfile, 'ddjk');
    fclose($myfile);
    //echo 'done';

?> 
