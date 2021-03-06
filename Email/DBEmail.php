<?php
namespace Flipside\Email;
require_once('Autoload.php');

abstract class DBEmail extends \Flipside\Email\Email
{
    protected $dbData;

    public function __construct($datasetName, $datatableName, $dataRowName)
    {
        parent::__construct();
        $dataTable = \Flipside\DataSetFactory::getDataTableByNames($datasetName, $datatableName);
        $this->dbData = $dataTable->read(new \Flipside\Data\Filter('id eq '.$dataRowName));
        if($this->dbData === false)
        {
            throw new \Exception('Unknown dataRow identified by ID '.$dataRowName);
        }
        if(isset($this->dbData[0]))
        {
            $this->dbData = $this->dbData[0];
        }
    }

    public function getFromAddress()
    {
        if(isset($this->dbData['from']))
        {
            return $this->dbData['from'];;
        }
        return parent::getFromAddress();
    }

    public function getReplyTo()
    {
        if(isset($this->dbData['replyTo']))
        {
            return $this->dbData['replyTo'];;
        }
        return parent::getReplyTo();
    }

    public function getSubject()
    {
        if(isset($this->dbData['subject']))
        {
            return $this->dbData['subject'];
        }
        return parent::getSubject();
    }

    public abstract function getSubstituteVars();

    protected function getRawBodyText($html)
    {
        if(isset($this->dbData['body']))
        {
            return $this->dbData['body'];
        }
        if($html === true)
        {
            return $this->htmlBody;
        }
        return $this->textBody;
    }

    protected function getBodyFromDB($html=true)
    {
        $vars = $this->getSubstituteVars();
        $rawText = $this->getRawBodyText($html);
        if($html === true)
        {
            $text = strtr($rawText, $vars);
            return $text;
        }
        $index = strpos($rawText, "<script");
        if($index !== false)
        {
            $end = strpos($rawText, "</script>");
            if($index === 0)
            {
                $rawText = substr($rawText, $end+9);
            }
        }
        return strtr(strip_tags($rawText), $vars);
    }

    public function getHTMLBody()
    {
        return $this->getBodyFromDB();
    }

    public function getTextBody()
    {
        return $this->getBodyFromDB(false);
    }
}
/* vim: set tabstop=4 shiftwidth=4 expandtab: */
