<?php


namespace App\Dto;

class FoundDto
{
    /**
     * @var TurbineDto[]
     */
    public $turbines = [];

    /**
     * @var bool
     */
    public $valid = false;
}