<?php

namespace App\Service;

use App\Dto\FilterResultsDto;
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
                        $found[$turbines[$j]] = [$data];
                        //wyrzuc z listy szukanych
                        unset($turbines[$j]);
                    } elseif (strpos($turbineNameFromCsv, $turbines[$j]) !== false) {
                        //znalazlo podobny wrzuc na liste
                        $found[$turbines[$j]][] = $data;
                    }
                }
            }
            fclose($handle);
        }

        $result = new FilterResultsDto();
        $result->notFound = array_diff($turbines, array_keys($found));
        $result->found = array_map(function (array $innerTurbines) {
            return array_map(function (array $turbine) {
                return new TurbineDto(trim($turbine[1]), trim($turbine[0]), trim($turbine[2]));
            }, $innerTurbines);
        }, $found);

        return $result;
    }
}