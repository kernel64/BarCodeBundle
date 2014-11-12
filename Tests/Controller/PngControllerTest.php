<?php
/**
 * @author Mohamed Aymen Ben Slimane <med.aymen3@gmail.com>
 * Date: 11/11/2014
 *
 */

namespace Mabs\BarCodeBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PngControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/generatePng/qrcode.png?data=mabs');

        $this->assertTrue($client->getResponse()->headers->get('Content-Type') == 'image/png');
    }
}
