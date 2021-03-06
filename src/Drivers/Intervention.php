<?php
namespace EasyWatermark\Drivers;

use EasyWatermark\Contracts\Driver;
use Intervention\Image\ImageManagerStatic as Image;


class Intervention implements Driver
{
    protected $baseimg;
    private $fontstyle = null;

    public function __construct($baseimg)
    {
        $this->baseimg = Image::make($baseimg);
    }

    public function setFontStyle($stylename, $stylefilename)
    {
        if (file_exists($stylefilename)) {
            $this->fontstyle = "font/default.ttf";
        }
    }

    public function text($text, $dx, $dy, $fontsize)
    {
        $fontstyle = 3;
        if ($this->fontstyle) {
            $fontstyle = $this->fontstyle;
        }

        $this->baseimg->text($text, $dx, $dy, function ($font) use ($fontstyle, $fontsize) {
            $font->file($fontstyle);
            $font->size($fontsize);
            $font->align('left');
            $font->valign('top');
        });
    }

    public function image($image, $x, $y, $width)
    {
        if ($width) {
            $image = Image::make($image)->widen($width);
        }
        $this->baseimg->insert($image, "bottom-right", $x, $y);
    }

    public function returnImage()
    {
        return $this->baseimg->response();
    }
}