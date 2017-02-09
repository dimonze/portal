<?php

namespace Portal\MainPageBundle\Controller;

use DOMDocument;
use DOMXPath;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Portal\MainPageBundle\Entity\Movie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');

        $movie = $this->getDoctrine()
            ->getRepository('PortalMainPageBundle:Movie')
            ->findAll();

        $result = $paginator->paginate(
            $movie,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 18)
        );
        return $this->render('PortalMainPageBundle:Default:index.html.twig', array('movies' => $result));
    }

    public function fileUploader()
    {
        $file = new UploadedFile('/var/www/html/portal/web/images/posters/1.jpg', 'image.jpg', null, null, null, true);

        $movie = new Movie();
        $movie->setUniqueName("Test_Dima");
        $movie->setNameEn("Test_dima");
        $movie->setPosterImageFile($file);
        $movie->setPosterImageName("testImage");
        //$movie->setPoster();
        //$movie->setYear($movieYear);

        $em = $this->getDoctrine()->getManager();

        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($movie);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();
    }

    public function updateAction()
    {
        libxml_use_internal_errors(true);

        $dom = new DomDocument;

        $dom->loadHTMLFile("https://planetakino.ua/odessa2/movies/archive/");

        $xpath = new DomXPath($dom);

        $resultUri = $xpath->query("//a[contains(@class,'movie-block__text_title')]/@href");
        $resultPoster = $xpath->query("//a[contains(@class,'movie-block__poster')]/img/@src");
        $uniqueArray = [];

        foreach ($resultUri as $i => $node) {

            $poster = "https://planetakino.ua" . $resultPoster[$i]->textContent;
            $dom = new DomDocument;
            $dom->loadHTMLFile("https://planetakino.ua" . $node->textContent);
            $xpath = new DomXPath($dom);
            $movieNameEn = $xpath->query("//h2[contains(@class,'original-title')]")[0]->nodeValue;
            $movieYear = $xpath->query("//dt[contains(@name,'year')]/following-sibling::dd[1]")[0]->nodeValue;
            if (in_array($movieNameEn . " " . $movieYear, $uniqueArray)) {
                continue;
            }
            $movie = new Movie();
            $movie->setUniqueName($movieNameEn . " " . $movieYear);
            $uniqueArray[] = $movie->getUniqueName();
            $movie->setNameEn($movieNameEn);
            echo($poster);
            //return new Response(' ');
            file_put_contents('/var/www/html/portal/web/images/posters/1.jpg', file_get_contents($poster));
            $file = new UploadedFile('/var/www/html/portal/web/images/posters/1.jpg', 'image'.$i.'.jpg', null, null, null, true);
            $movie->setPosterImageFile($file);
            $movie->setPosterImageName("testImage". $i);
            $movie->setPoster($poster);
            $movie->setYear($movieYear);

            $em = $this->getDoctrine()->getManager();

            // tells Doctrine you want to (eventually) save the Product (no queries yet)
            $em->persist($movie);

            // actually executes the queries (i.e. the INSERT query)
            $em->flush();
        }
        return new Response(' ');
    }

    public function testAction()
    {
        libxml_use_internal_errors(true);

        $dom = new DomDocument;

        $dom->loadHTMLFile("https://planetakino.ua/odessa2/movies/archive/");

        $xpath = new DomXPath($dom);

        $resultUri = $xpath->query("//a[contains(@class,'movie-block__text_title')]/@href");
        $resultPoster = $xpath->query("//a[contains(@class,'movie-block__poster')]/img/@src");
        $uniqueArray = [];

        foreach ($resultUri as $i => $node) {

            $poster = "https://planetakino.ua" . $resultPoster[$i]->textContent;
            $dom = new DomDocument;
            $dom->loadHTMLFile("https://planetakino.ua" . $node->textContent);
            $xpath = new DomXPath($dom);
            $movieNameEn = $xpath->query("//h2[contains(@class,'original-title')]")[0]->nodeValue;
            $movieYear = $xpath->query("//dt[contains(@name,'year')]/following-sibling::dd[1]")[0]->nodeValue;
            $description = $xpath->query("//div [contains(@itemprop, 'description')]//p[contains(@text, '')]")[0]->nodeValue;
            $cuntry = $xpath->query("//div[contains(@class, 'reducer movie-summary')]//dd[2]")[0]->nodeValue;
            $genre = $xpath->query("//div[contains(@class, 'reducer movie-summary')]//dd[4]")[0]->nodeValue;
            $director = $xpath->query("//div[contains(@class, 'reducer movie-summary')]//dd[6]")[0]->nodeValue;


            if (in_array($movieNameEn . " " . $movieYear, $uniqueArray)) {
                continue;
            }
            $movie = new Movie();
            $movie->setUniqueName($movieNameEn . " " . $movieYear);
            $uniqueArray[] = $movie->getUniqueName();
            $movie->setNameEn($movieNameEn);
            $movie->setPoster($poster);
            $movie->setYear($movieYear);
            $movie->setDescriptionRu($description);
            $movie->setCuntry($cuntry);
            $movie->setProducer($director);
            $movie->setGenre($genre);


            $em = $this->getDoctrine()->getManager();

            // tells Doctrine you want to (eventually) save the Product (no queries yet)
            $em->persist($movie);

            // actually executes the queries (i.e. the INSERT query)
            $em->flush();
        }
        return new Response(' ');
    }

    public function kinoAction()
    {
        libxml_use_internal_errors(true);

        $dom = new DomDocument;

        $dom->loadHTMLFile("https://www.kinopoisk.ru/top/navigator/m_act%5Bnum_vote%5D/10/m_act%5Brating%5D/1:/m_act%5Bis_film%5D/on/order/rating/perpage/200/#results");

        $xpath = new DomXPath($dom);

        $resultUri = $xpath->query("//div[@class='info']//div[@class='name']//span");
        $resultUriRu = $xpath->query("//div[@class='info']//div[@class='name']//a[contains(@text, '')]");

        $uniqueArray = [];

        foreach ($resultUri as $i => $node) {
//            var_dump($resultUriRu[0]);
//            return new Response(' ');

            preg_match('/\((\d{4})\)/', $node->nodeValue, $year);
            $movieYear = array_key_exists(1, $year) ? $year[1] : 0;

            preg_match('/.*(\S\d)/', $node->nodeValue, $duration);
            $movieDuration = array_key_exists(1, $duration) ? (int)$duration[1] : 0;

            preg_match('/^(.*)(?=\(\d{1,4}\))/', $node->nodeValue, $name);
            $movieNameEn = array_key_exists(1, $name) ? $name[1] : null;
            $movieNameRu = $resultUriRu[$i]->textContent;

            if (strlen($movieNameEn) < 2 || is_null($movieNameEn)) {
                $movieNameEn = $movieNameRu;
            }

            if (in_array($movieNameEn . " " . $movieYear, $uniqueArray)) {

                $movieYear = $movieYear . $i;


                $movieNameEn = $movieNameEn . $i;
            }


            $movie = new Movie();
            $movie->setUniqueName($movieNameEn . " " . $movieYear);
            $uniqueArray[] = $movie->getUniqueName();
            $movie->setYear($movieYear);
            $movie->setDuration($movieDuration);
            $movie->setNameEn($movieNameEn);
            $movie->setNameRu($movieNameRu);


            $em = $this->getDoctrine()->getManager();

            // tells Doctrine you want to (eventually) save the Product (no queries yet)
            $em->persist($movie);

            // actually executes the queries (i.e. the INSERT query)
            $em->flush();
        }
        return new Response(' ');
    }

}
