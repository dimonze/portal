<?php

namespace Portal\MainPageBundle\Controller;

use DOMDocument;
use DOMXPath;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Portal\MainPageBundle\Entity\Movie;
use Symfony\Component\HttpFoundation\Request;

class DefaultController
{
    public function updateAction()
    {
        libxml_use_internal_errors(true);

        $dom = new DomDocument;

        $dom->loadHTMLFile("http://www.imdb.com/list/ls076622175/");

        $xpath = new DomXPath($dom);

        $resultYear = $xpath->query("//div[contains(@class, 'list_item')]//div[contains(@class, 'info')]/b/span[contains(@text, '')]");
		$resultName = $xpath->query("//div[contains(@class, 'list_item')]//div[contains(@class, 'info')]/b/a[contains(@text, '')]");
        $resultPoster = $xpath->query("//div[contains(@class, 'list_item')]//div[contains(@class, 'image')]/img/@src");
        $uniqueArray = [];
		
		var_dump($resultName);
}}
