<?php

namespace App\Service;

use App\Dto\FilterResultsDto;
use App\Dto\FoundDto;
use App\Dto\TurbineDto;

class TurbinesFinder
{
    /**
     * @param array $turbines
     * @return FilterResultsDto
     */
    public function findTurbines(array $turbines): FilterResultsDto
    {
        $found = [];
        $countTurbines = count($turbines);
        if (($handle = fopen(__DIR__ . '/1580324940-vestas-converted.csv', "r")) !== FALSE) {
            while (count($turbines) > 0 && ($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                for ($j = 0; $j < $countTurbines; $j++) {
                    if (!array_key_exists($j, $turbines)) {
                        continue;
                    }
                    $turbineNameFromCsv = trim($data[2]);
                    //ten sam na 100%
                    if ($turbineNameFromCsv == $turbines[$j] || $turbineNameFromCsv == 'V' . $turbines[$j]) {
                        $foundDto = new FoundDto();
                        $foundDto->turbines = [new TurbineDto(trim($data[1]), trim($data[0]), trim($data[2]))];
                        $foundDto->valid = true;
                        $found[$turbines[$j]] = $foundDto;
                        //wyrzuc z listy szukanych
                        unset($turbines[$j]);
                    } elseif (strpos($turbineNameFromCsv, $turbines[$j]) !== false) {
                        //znalazlo podobny wrzuc na liste
                        if (isset($found[$turbines[$j]])) {
                            /** @var FoundDto $foundDto */
                            $foundDto = $found[$turbines[$j]];
                        } else {
                            $foundDto = new FoundDto();
                            $found[$turbines[$j]] = $foundDto;
                        }
                        $foundDto->turbines[] = new TurbineDto(trim($data[1]), trim($data[0]), trim($data[2]));
                    }
                }
            }
            fclose($handle);
        }

        $result = new FilterResultsDto();
        $result->found = $found;
        $result->notFound = array_diff($turbines, array_keys($found));

        return $result;
    }
}