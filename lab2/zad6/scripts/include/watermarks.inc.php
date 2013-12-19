<?php

function gd_watermark_obj($img, $watermark)
{
//    $watermark = ImageCreateFromPNG($watermarkFilename);
//    $img = ImageCreateFromJPEG($imgFilename);

    $img_X = ImageSX($img);
    $img_Y = ImageSY($img);

    ImageCopyResized(
        $img, $watermark,
        0, 0,
        0, 0,
        $img_X, $img_Y,
        $img_X, $img_Y
    );

    return $img;
}


function watermark_get_gd_obj($imgFilename, $watermarkFilename)
{
    $watermark = ImageCreateFromPNG($watermarkFilename);
    $img = ImageCreateFromJPEG($imgFilename);
    
    $img_X = ImageSX($img);
    $img_Y = ImageSY($img);
    
    ImageCopyResized(
        $img, $watermark,
        0, 0,
        0, 0,
        $img_X, $img_Y,
        $img_X, $img_Y
    );
    
    return $img;
}

function watermark_save_to_file($srcFilename, $destFilename, $watermarkFilename, $quality = 95)
{
    $tmp = watermark_get_gd_obj($srcFilename, $watermarkFilename);
    
    imagejpeg($tmp, $destFilename, $quality);
}


function watermark_get_data($srcFilename, $watermarkFilename, $quality = 95)
{
    $tmp = watermark_get_gd_obj($srcFilename, $watermarkFilename);
    
    ob_start();
    imagejpeg($tmp, NULL, $quality);        
    $img = ob_get_clean(); 
    
    return $img;
}





