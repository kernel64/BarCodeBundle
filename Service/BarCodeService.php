<?php
/**
 * @author Mohamed Aymen Ben Slimane <med.aymen3@gmail.com>
 * Date: 02/10/2014
 * Time: 23:05
 */

namespace Mabs\BarCodeBundle\Service;

use Mabs\BarCodeBundle\Exception\BarCodeException;

class BarCodeService
{

    protected $str;
    protected $type;
    protected $params;
    protected $barCode = null;

    public function __construct($configData)
    {
        $this->params = $configData;
    }

    public function getPngBarCode($str, $type, $params = array())
    {
        if (!$str) {
            $str = $this->str;
        }
        if (!$type) {
            $type = $this->type;
        }

        $this->barCode = $this->buildBarCode($str, $type);
        $defaultConfig = $this->getTypeConfig($type);

        $width = (isset($params['width']))?$params['width']:$defaultConfig['width'];
        $height = (isset($params['height']))?$params['height']:$defaultConfig['height'];
        $color = (isset($params['color']))?$params['color']:$defaultConfig['color'];

        $data = $this->barCode->getBarcodePngData($width, $height, array(hexdec($color[0]),hexdec($color[1]),hexdec($color[2])));

        return $data;
    }

    protected function buildBarCode($str, $type = null)
    {
        if (!$type) {
            throw new BarCodeException('Cannot generate a null BarCode.');
        }

        switch (strtoupper($type)) {
            case 'C39':
            case 'C39+':
            case 'C39E':
            case 'C39E+':
            case 'C93':
            case 'S25':
            case 'S25+':
            case 'I25':
            case 'I25+':
            case 'C128':
            case 'C128A':
            case 'C128B':
            case 'C128C':
            case 'EAN2':
            case 'EAN5':
            case 'EAN8':
            case 'EAN13':
            case 'UPCA':
            case 'UPCE':
            case 'MSI':
            case 'MSI+':
            case 'POSTNET':
            case 'PLANET':
            case 'RMS4CC':
            case 'KIX':
            case 'IMB':
            case 'CODABAR':
            case 'CODE11':
            case 'PHARMA':
            case 'PHARMA2T':
                return new \TCPDFBarcode($str, $type);
            case 'DATAMATRIX':
            case 'PDF417':
            case 'QRCODE':
            case 'RAW':
            case 'TEST':
                return new \TCPDF2DBarcode($str, $type);
            default:
                throw new BarCodeException("Cannot found '{$type}' Type");
        }
    }

    protected function getTypeConfig($type)
    {
        if (!isset($this->params['types'])) {

            return $this->getDefaultParameter();
        }

        if (isset($this->params['types'][$type])) {

            return $this->params['types'][$type];
        }
    }

    protected function getDefaultParameter()
    {
        if (!isset($this->params['default'])) {
            throw new BarCodeException("Missing default config");
        }

        return $this->params['default'];
    }
}
