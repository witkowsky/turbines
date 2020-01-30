<?php

namespace App\Controller;

use App\Form\FilterFormType;
use App\Service\GpxGenerator;
use App\Service\KmlGenerator;
use App\Service\TurbinesFinder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @var TurbinesFinder
     */
    private $turbinesFinder;

    /**
     * @var GpxGenerator
     */
    private $gpxGenerator;

    /**
     * @var KmlGenerator
     */
    private $kmlGenerator;

    /**
     * IndexController constructor.
     * @param TurbinesFinder $turbinesFinder
     * @param GpxGenerator $gpxGenerator
     * @param KmlGenerator $kmlGenerator
     */
    public function __construct(TurbinesFinder $turbinesFinder, GpxGenerator $gpxGenerator, KmlGenerator $kmlGenerator)
    {
        $this->turbinesFinder = $turbinesFinder;
        $this->gpxGenerator = $gpxGenerator;
        $this->kmlGenerator = $kmlGenerator;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(Request $request)
    {
        $resultsDto = null;
        $form = $this->createForm(FilterFormType::class);
        $uniqueTurbinesPassed = [];
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $turbines = $data['turbines'];
            $turbines = explode(PHP_EOL, $turbines);
            $turbines = array_map('trim', $turbines);
            $uniqueTurbinesPassed = array_unique($turbines);
            $resultsDto = $this->turbinesFinder->findTurbines(array_values($uniqueTurbinesPassed));

            $action = $data['action'];
            if ($action !== 'check') {
                $response = new Response($this->getGenerator($action)->generate($resultsDto)->saveXML());
                $disposition = HeaderUtils::makeDisposition(
                    HeaderUtils::DISPOSITION_ATTACHMENT,
                    "turbiny.$action"
                );

                $response->headers->set('Content-Disposition', $disposition);
                return $response;
            }
        }

        return $this->render('index/index.html.twig', [
            'form' => $form->createView(),
            'resultsDto' => $resultsDto,
            'uniqueTurbinesPassed'=> count($uniqueTurbinesPassed)
        ]);
    }

    private function getGenerator(string $fileType)
    {
        switch ($fileType) {
            case 'gpx':
                return $this->gpxGenerator;
            case 'kml':
                return $this->kmlGenerator;
        }
    }
}
