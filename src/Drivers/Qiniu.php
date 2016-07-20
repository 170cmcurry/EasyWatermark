<?php
namespace EasyWatermark\Drivers;

use EasyWatermark\Contracts\Driver;
use Qiniu\Http\Client as QiniuClient;

class Qiniu implements Driver
{
    protected $baseimg;
    protected $imgurl;
    protected $insert;

    public function __construct($baseimg)
    {
        $this->baseimg = $baseimg;
        $this->imgurl  = $this->baseimg;
        $this->insert  = null;
    }


    public function text($text, $dx, $dy, $fontsize)
    {
        $translation = 20.5;
        $text        = '/text/' . \Qiniu\base64_urlSafeEncode($text) .
            '/fontsize/' . round($fontsize * $translation) .
            '/dx/' . $dx .
            '/dy/' . $dy .
            '/gravity/NorthWest';
        $this->insert .= $text;
    }

    public function image($image, $x, $y, $width)
    {
        $make = '/image/' . \Qiniu\base64_urlSafeEncode($image . '?imageView2/2/w/' . $width) .
            '/dx/' . $x .
            '/dy/' . $y;
        $this->insert .= $make;

    }

    public function returnImage()
    {
        if ($this->insert) {
            $this->imgurl = $this->baseimg . '?watermark/3' . $this->insert;
        }
        $image = QiniuClient::get($this->imgurl);
        $image = $image->body;
        if (function_exists('app') && is_a($app = app(), 'Illuminate\Foundation\Application')) {
            $response = \Response::make($image);
            $response->header('Content-Type', 'image/jpg');

            return $response;
        }
        header('Content-Type:image/jpg');
        $response = $image;

        return $response;
    }
}