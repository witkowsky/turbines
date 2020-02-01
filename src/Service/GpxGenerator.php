<?php
declare(strict_types=1);

namespace App\Service;

use DOMDocument;

class GpxGenerator extends BaseGenerator
{
    /**
     * @param array $turbines
     * @return DOMDocument
     */
    public function generateDom(array $turbines): DOMDocument
    {
        $dom = new DOMDocument('1.0','utf-8');
        $dom->formatOutput = false;
        $gpx = $dom->createElement('gpx');
        $dom->appendChild($gpx);

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