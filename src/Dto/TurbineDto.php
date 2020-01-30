<?php


namespace App\Dto;

class TurbineDto
{
    /**
     * @var string
     */
    public $lat;

    /**
     * @var string
     */
    public $lon;

    /**
     * @var string
     */
    public $name;

    /**
     * TurbineDto constructor.
     * @param string $lat
     * @param string $lon
     * @param string $name
     */
    public function __construct(string $lat, string $lon, string $name)
    {
        $this->lat = $lat;
        $this->lon = $lon;
        $this->name = $name;
    }
}