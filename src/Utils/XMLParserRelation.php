<?php


namespace Muhep\ExchangeRates\Utils;


use Muhep\ExchangeRates\Models\DynamicModel;
use SimpleXMLElement;

class XMLParserRelation
{
    private $model;
    private $parser;
    private $xml;
    private $loopIndex;

    public function setModel(DynamicModel $model): void
    {
        $this->model = $model;
    }


    public function setParser(XmlParser $parser): void
    {
        $this->parser = $parser;
    }


    public function setXml(SimpleXMLElement $xml): void
    {
        $this->xml = $xml;
    }

    /**
     * @return mixed
     */
    public function getModel(): DynamicModel
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getParser(): XmlParser
    {
        return $this->parser;
    }

    /**
     * @return mixed
     */
    public function getXml(): SimpleXMLElement
    {
        return $this->xml;
    }

    /**
     * @param integer $loopIndex
     */
    public function setLoopIndex($loopIndex): void
    {
        $this->loopIndex = $loopIndex;
    }

    /**
     * @return int
     */
    public function getLoopIndex(): int
    {
        return $this->loopIndex;
    }
}
