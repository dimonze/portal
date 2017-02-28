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

//$fake_user_agent = "Mozilla/5.0 (X11; Linux i686) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.47 Safari/536.11";
//ini_set('user_agent', $fake_user_agent);


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
            file_put_contents('/var/www/html/portal/web/images/posters/1.jpg', file_get_contents($poster));
            $file = new UploadedFile('/var/www/html/portal/web/images/posters/1.jpg', ($movieNameEn . " " . $movieYear . $i) . '.jpg', null, null, null, true);
            $movie->setPosterImageFile($file);
            $movie->setPosterImageName("testImage" . $i);
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
            $country = $xpath->query("//div[contains(@class, 'reducer movie-summary')]//dd[2]")[0]->nodeValue;
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
            $movie->setCountry($country);
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

    public function postersAction()
    {

        $movies = $this->getDoctrine()
            ->getRepository('PortalMainPageBundle:Movie')
            ->findAll();



        foreach ($movies as $key => $movie) {

            $curl = curl_init();
            $apiKey = "fca711ea6a069c86ca9eb6b43d80db3f";
            $language = "en-US";

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.themoviedb.org/3/search/movie?api_key=" . $apiKey . "&language=" . $language . "&query=" . urlencode($movie->getNameEn()) . "&page=1&include_adult=false",
//                CURLOPT_URL => "https://api.themoviedb.org/3/search/movie?api_key=" . $apiKey . "&language=" . $language . "&query=" . "Logan" . "&page=1&include_adult=false",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_POSTFIELDS => "{}",
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);


            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                echo $response;
            }
//            return new Response(' ');
        }

//            $em = $this->getDoctrine()->getManager();
//
//            // tells Doctrine you want to (eventually) save the Product (no queries yet)
//            $em->persist($movie);
//
//            // actually executes the queries (i.e. the INSERT query)
//            $em->flush();


//        return new Response(' ');
    }

    public function worldAction()
    {
        libxml_use_internal_errors(true);

        $dom = new DomDocument;

        $dom->loadHTMLFile("http://www.imsdb.com/all%20scripts/");

        $xpath = new DomXPath($dom);


        $resultUri = $xpath->query("//td//p/a[contains(@title, '')]");
        $resultYear = $xpath->query("//td/p/text()");

        $uniqueArray = [];

        foreach ($resultYear as $i => $node) {

            $movieNameEn = $resultUri[$i]->textContent;

            preg_match('/\d{4}/', $node->nodeValue, $year);
            $movieYear = array_key_exists(0, $year) ? $year[0] : 0;

//            var_dump($year);
//            return new Response(' ');


            if (in_array($movieNameEn . " " . $movieYear, $uniqueArray)) {

                $movieYear = $movieYear . $i;


                $movieNameEn = $movieNameEn . $i;
            }


            $movie = new Movie();
            $movie->setUniqueName($movieNameEn . " " . $movieYear);
            $uniqueArray[] = $movie->getUniqueName();
            $movie->setYear($movieYear);
            $movie->setNameEn($movieNameEn);




            $em = $this->getDoctrine()->getManager();

            // tells Doctrine you want to (eventually) save the Product (no queries yet)
            $em->persist($movie);

            // actually executes the queries (i.e. the INSERT query)
            $em->flush();
        }
        return new Response(' ');


    }

    public function idKinopoiskAction()
    {
        libxml_use_internal_errors(true);

        $dom = new DomDocument;

        $dom->loadHTMLFile("https://www.kinopoisk.ru/top/navigator/m_act%5Bnum_vote%5D/10/m_act%5Brating%5D/1:/m_act%5Bis_film%5D/on/order/rating/perpage/200/#results");

        $xpath = new DomXPath($dom);

        $resultUri = $xpath->query("//div[contains(@id, 'itemList')]/div/@id");
//        $resultUriRu = $xpath->query("//div[@class='info']//div[@class='name']//a[contains(@text, '')]");
//        var_dump($resultUri[0]);
//        return new Response(' ');

//        $uniqueArray = [];

        foreach ($resultUri as $i => $node) {


            preg_match('/\d+/', $node->nodeValue, $id);
            $idKinopoisk = array_key_exists(0, $id) ? $id[0] : 0;
//            var_dump($year);
//        return new Response(' ');


            $movie = new Movie();
            $movie->setUniqueName($idKinopoisk);
            $movie->setIdKinopoiskTEMP($idKinopoisk);


            $em = $this->getDoctrine()->getManager();

            // tells Doctrine you want to (eventually) save the Product (no queries yet)
            $em->persist($movie);

            // actually executes the queries (i.e. the INSERT query)
            $em->flush();
        }
        return new Response(' ');
    }

    public function getInfoAction()
    {


        $url="https://www.kinopoisk.ru/film/1003587/";
        $agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_COOKIESESSION, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_REFERER, 'https://www.kinopoisk.ru/');

        $headers = [
            'X-Apple-Tz: 0',
            'X-Apple-Store-Front: 143444,12',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Encoding: gzip, deflate',
            'Accept-Language: en-US,en;q=0.5',
            'Cache-Control: no-cache',
            'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
            'Host: www.example.com',
            'Referer: http://www.example.com/index.php', //Your referrer address
            'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0',
            'X-MicrosoftAjax: Delta=true'
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_URL, $url);
        $result=curl_exec($ch);
        echo ($result);
        return new Response(' ');


























        $fake_user_agent = "Mozilla/5.0 (X11; Linux i686) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.47 Safari/536.11";
        ini_set('user_agent', $fake_user_agent);
//
//        libxml_use_internal_errors(true);
//
//        $movies = $this->getDoctrine()
//            ->getRepository('PortalMainPageBundle:Movie')
//            ->findAll();
//
//        $uniqueArray = [];
//
//        foreach ($movies as $i => $movie) {

            $dom = new DomDocument;
        $dom->loadHTMLFile("https://www.kinopoisk.ru/film/1003587/");
        $xpath = new DomXPath($dom);




            $resultNameRu = $xpath->query("//h1/@itemprop")[0]->textContent;
            $resultNameEn = $xpath->query("//div[contains(@id,'headerFilm')]/span")->textContent;

            $resultYear = $xpath->query("//*[@id=\"infoTable\"]/table/tbody/tr[1]/td[2]/div/a")[0]->nodeValue;
            $resultCountry = $xpath->query("//*[@id=\"infoTable\"]/table/tbody/tr[2]/td[2]/div/a[1]")[0]->nodeValue;
            $resultPoster = $xpath->query("//div[contains(@id, 'photoBlock')]//div[contains(@id,'wrap')]//img/@src")[0]->nodeValue;
            $resultDescription = $xpath->query("//div[contains(@class, 'brand_words film-synopsys')]")[0]->nodeValue;




            if (strlen($resultNameEn) < 2 || is_null($resultNameEn)) {
                $resultNameEn = $resultNameRu;
            }

            if (in_array($resultNameEn . " " . $resultYear, $uniqueArray)) {

                $resultYear = $resultYear . $i;


                $resultNameEn = $resultNameEn . $i;
            }

            $movie = new Movie();
            $movie->setUniqueName($resultNameEn . " " . $resultYear);
            $uniqueArray[] = $movie->getUniqueName();
            $movie->setNameEn($resultNameEn);
            $movie->setPoster($resultPoster);
            $movie->setYear($resultYear);
            $movie->setDescriptionRu($resultDescription);
            $movie->setCountry($resultCountry);





            $em = $this->getDoctrine()->getManager();

            // tells Doctrine you want to (eventually) save the Product (no queries yet)
            $em->persist($movie);

            // actually executes the queries (i.e. the INSERT query)
            $em->flush();
//        }
        return new Response(' ');
    }
}
