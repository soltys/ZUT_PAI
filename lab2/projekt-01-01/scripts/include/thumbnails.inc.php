<?php

/*
 * Jeœli obraz jest poziomy to jest skalowany do szerokoœci AWidth
 * Jeœli obraz jest pionowy to jest skalowany do wysokoœci AHeight
 * Kwadratowy: skalujemy do wysokoœci AHeight
 *
 * Parametr $AImg jest obiektem GD
 * Wynik - miniaturka - jest zwracany jako obiekt GD 
 */
function gd_thumbnail_obj($AImg, $AWidth, $AHeight)
{
    if (!$AImg) {
        die('gd_thumbnail_obj() - $AImg error');
    }

    $AImg_X = ImageSX($AImg);
    $AImg_Y = ImageSY($AImg);
    
    $tmp_Y  = ($AWidth / $AImg_X) * $AImg_Y;
    $tmp_X  = ($AHeight / $AImg_Y) * $AImg_X;
    
    if ($tmp_Y <= $AHeight){
    
        $thumbnail_X = $AWidth;
        $thumbnail_Y = $tmp_Y;
    
    } else {
    
        $thumbnail_X = $tmp_X;
        $thumbnail_Y = $AHeight;
        
    }

    $thumbnail = ImageCreateTrueColor(
        $thumbnail_X,
        $thumbnail_Y
    );
    
    imageAlphaBlending($thumbnail, false);
    imageSaveAlpha($thumbnail, true);

    ImageCopyResized(
        $thumbnail, $AImg,           //przeznaczenie, zrodlo
        0, 0,                        //gdzie ma trafic w przeznaczeniu
        0, 0,                        //skad ma pochodzic ze zrodla
        $thumbnail_X, $thumbnail_Y,  //wymiary, jakie ma zaj¹æ w przeznaczeniu
        $AImg_X, $AImg_Y             //wymiary pobierane ze Ÿród³a
    );

    //poprawka: usuwamy image destroy
//    ImageDestroy($AImg);
    return $thumbnail;

}


/*
 * Funkcja identyczna jak function gd_thumbnail_obj()
 * Ró¿ni siê parametrami.
 *
 * Pierwszy parametr - $AFileName - to nazwa pliku do przeskalowania
 * Wynik - miniaturka - jest zwracany jako obiekt GD 
 */
function gd_thumbnail_file($AFileName, $AWidth, $AHeight)
{
    $img = ImageCreateFromJPEG($AFileName);
    return gd_thumbnail_obj($img, $AWidth, $AHeight);
}
