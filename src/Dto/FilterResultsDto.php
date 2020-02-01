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

    /**
     * @return int
     */
    public function countValid(): int
    {
        return $this->sumTurbines($this->getValid());
    }

    /**
     * @return int
     */
    public function countInValid(): int
    {
        return $this->sumTurbines($this->getInValid());
    }

    /**
     * @param $foundDtos
     * @return float|int
     */
    private function sumTurbines($foundDtos)
    {
        return array_sum(array_map(function (FoundDto $foundDto) { return count($foundDto->turbines); }, $foundDtos));
    }
}