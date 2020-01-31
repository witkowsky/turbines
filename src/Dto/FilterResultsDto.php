<?php

namespace App\Dto;

class FilterResultsDto
{
    /**
     * @var FoundDto[]
     */
    public $found;

    /**
     * @var string[]
     */
    public $notFound;

    /**
     * @return FoundDto[]
     */
    public function getValid(): array
    {
        return array_filter($this->found, function (FoundDto $foundDto) {
            return $foundDto->valid;
        });
    }

    /**
     * @return FoundDto[]
     */
    public function getInValid(): array
    {
        return array_filter($this->found, function (FoundDto $foundDto) {
            return !$foundDto->valid;
        });
    }
}