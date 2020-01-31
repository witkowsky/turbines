<?php


namespace App\Service;

use App\Dto\FilterResultsDto;
use App\Dto\TurbineDto;

class GpxGenerator
{
    /**
     * @param FilterResultsDto $dto
     * @return \DOMDocument
     */
    public function generate(FilterResultsDto $dto): \DOMDocument
    {
        $dom = new \DOMDocument('1.0','utf-8');
        $dom->formatOutput = false;

        $gpx = $dom->createElement('gpx');
        $dom->appendChild($gpx);
        $turbines = [];
        foreach ($dto->found as $foundDto) {
            $turbines = array_merge($turbines, $foundDto->turbines);
        }

        foreach ($turbines as $turbine) {
            $wpt = $dom->createElement('wpt');
            $gpx->appendChild($wpt);

            $wpt->setAttribute('lat', $turbine->lat);
            $wpt->setAttribute('lon', $turbine->lon);

            $wpt->appendChild( $dom->createElement('name', $turbine->name));
        }

        return $dom;
    }
}