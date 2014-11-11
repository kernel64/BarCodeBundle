<?php

namespace Mabs\BarCodeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PngController extends Controller
{
    public function generateAction($type)
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $data = $request->request->get('data',$request->get('data', null));

        $content = $this->get('mabs_bar_code.service')->getPngBarCode($data, $type);

        $response = new Response($content);
        $response->headers->set('Content-Type', 'image/png');

        return $response;
    }
}
