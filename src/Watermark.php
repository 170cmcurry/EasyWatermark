<?php
namespace EasyWatermark;

use EasyWatermark\Contracts\Driver;

Class Watermark
{

    public function __construct($driver, $baseimg)
    {
        return $this->loadDriver(new $driver($baseimg));
    }

    private function loadDriver(Driver $driver)
    {
        $this->driver = $driver;
    }

    function __call($name, $arguments)
    {
        return call_user_func_array([$this->driver, $name], $arguments);
    }

}