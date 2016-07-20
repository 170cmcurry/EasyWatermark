<?php
namespace EasyWatermark;

use EasyWatermark\Watermark;

Class WatermarkFacade
{
    private static $driver = 'Intervention';
    private static $watermark;

    public function __construct($driver = 'Intervention')
    {
        self::$driver = $driver;
    }

    public static function setDriver($driver)
    {
        self::$driver = $driver;
    }

    public static function setBaseImage($baseimg)
    {
        self::$watermark = new Watermark('\\EasyWatermark\\Drivers\\' . self::$driver, $baseimg);
    }

    public static function text($text, $dx = 0, $dy = 0, $fontsize = 12)
    {
        self::$watermark->text($text, $dx, $dy, $fontsize);
    }

    public static function image($image, $x = 0, $y = 0, $width = 100)
    {
        return self::$watermark->image($image, $x, $y, $width);
    }

    public static function returnImage()
    {
        return self::$watermark->returnImage();
    }

}