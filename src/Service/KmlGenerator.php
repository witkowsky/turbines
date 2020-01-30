<?php


namespace App\Service;

use App\Dto\FilterResultsDto;
use App\Dto\TurbineDto;

class KmlGenerator
{
    /**
     * @param FilterResultsDto $dto
     * @return \DOMDocument
     */
    public function generate(FilterResultsDto $dto): \DOMDocument
    {
        $dom = new \DOMDocument('1.0','utf-8');
        $dom->formatOutput = false;

        $kml = $dom->createElement('kml');
        $kml->setAttribute('xmlns', 'http://earth.google.com/kml/2.0');
        $dom->appendChild($kml);
        $turbines = [];
        foreach ($dto->found as $foundDto) {
            $turbines = array_merge($turbines, $foundDto);
        }

        /** @var TurbineDto $turbine */
        foreach ($turbines as $turbine) {
            $placemark = $dom->createElement('Placemark');
            $name = $dom->createElement('name', $turbine->name);
            $point = $dom->createElement('Point');
            $coordinates = $dom->createElement('coordinates', sprintf("%s,%s", $turbine->lon, $turbine->lat));//long, lat

            $placemark->appendChild($name);
            $placemark->appendChild($point);
            $point->appendChild($coordinates);
            $kml->appendChild($placemark);
        }

        return $dom;
    }
}