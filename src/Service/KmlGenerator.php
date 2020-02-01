<?php


namespace App\Service;

use App\Dto\FilterResultsDto;
use App\Dto\TurbineDto;
use DOMDocument;

class KmlGenerator extends BaseGenerator
{
    /**
     * @param array $turbines
     * @return DOMDocument
     */
    protected function generateDom(array $turbines): DOMDocument
    {
        $dom = new DOMDocument('1.0','utf-8');
        $dom->formatOutput = false;

        $kml = $dom->createElement('kml');
        $kml->setAttribute('xmlns', 'http://earth.google.com/kml/2.0');
        $dom->appendChild($kml);

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