<?php


namespace App\Service;

use App\Dto\FilterResultsDto;

/**
 * Class GeneratorInterface
 * @package App\Service
 */
interface GeneratorInterface
{
    /**
     * @param FilterResultsDto $dto
     * @param bool $downloadAll
     * @return \DOMDocument
     */
    public function generate(FilterResultsDto $dto, bool $downloadAll): \DOMDocument;
}