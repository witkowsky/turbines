<?php

namespace App\Dto;

class FilterResultsDto
{
    /**
     * @var TurbineDto[]
     */
    public $found;

    /**
     * @var string[]
     */
    public $notFound;
}