<?php
declare(strict_types=1);

namespace App\Service;

use App\Dto\FilterResultsDto;
use App\Dto\TurbineDto;

/**
 * Class BaseGenerator
 * @package App\Service
 */
abstract class BaseGenerator implements GeneratorInterface
{
    /**
     * @param array $turbines
     * @return \DOMDocument
     */
    abstract protected function generateDom(array $turbines): \DOMDocument;

    /**
     * @param FilterResultsDto $dto
     * @param bool $downloadAll
     * @return \DOMDocument
     */
    public function generate(FilterResultsDto $dto, bool $downloadAll): \DOMDocument
    {
        $turbines = $this->prepareRows($dto, $downloadAll);
        return $this->generateDom($turbines);
    }

    /**
     * @param FilterResultsDto $dto
     * @param bool $downloadAll
     * @return TurbineDto[]
     */
    protected function prepareRows(FilterResultsDto $dto, bool $downloadAll): array
    {
        $turbines = [];
        $foundToMerge = $downloadAll ? $dto->found : $dto->getValid();
        foreach ($foundToMerge as $foundDto) {
            $turbines = array_merge($turbines, $foundDto->turbines);
        }
        return $turbines;
    }
}