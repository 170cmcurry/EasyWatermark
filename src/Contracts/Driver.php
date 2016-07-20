<?php
namespace EasyWatermark\Contracts;

interface Driver
{
    public function __construct($baseimg);

    public function setFontStyle($stylename, $stylefilename);

    public function text($text, $dx, $dy, $fontsize);

    public function image($image, $x, $y, $width);

    public function returnImage();
}


