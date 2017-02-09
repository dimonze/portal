<?php

namespace Portal\MainPageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Movie
 *
 * @ORM\Table(name="movie")
 * @ORM\Entity(repositoryClass="Portal\MainPageBundle\Repository\MovieRepository")
 * @Vich\Uploadable
 */
class Movie
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="unique_name", type="string", length=150, unique=true)
     */
    private $uniqueName;

    /**
     * @var string
     *
     * @ORM\Column(name="name_en", type="string", length=200, nullable=true)
     */
    private $nameEn;

    /**
     * @var string
     *
     * @ORM\Column(name="name_ru", type="string", length=200, nullable=true)
     */
    private $nameRu;

    /**
     * @var int
     *
     * @ORM\Column(name="year", type="integer", nullable=true)
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=75, nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="tagline", type="string", length=255, nullable=true)
     */
    private $tagline;

    /**
     * @var string
     *
     * @ORM\Column(name="producer", type="string", length=150, nullable=true)
     */
    private $producer;

    /**
     * @var string
     *
     * @ORM\Column(name="scenario", type="string", length=255, nullable=true)
     */
    private $scenario;

    /**
     * @var string
     *
     * @ORM\Column(name="producer_second", type="string", length=255, nullable=true)
     */
    private $producerSecond;

    /**
     * @var string
     *
     * @ORM\Column(name="operator", type="string", length=100, nullable=true)
     */
    private $operator;

    /**
     * @var string
     *
     * @ORM\Column(name="composer", type="string", length=100, nullable=true)
     */
    private $composer;

    /**
     * @var string
     *
     * @ORM\Column(name="painter", type="string", length=100, nullable=true)
     */
    private $painter;

    /**
     * @var string
     *
     * @ORM\Column(name="montage", type="string", length=100, nullable=true)
     */
    private $montage;

    /**
     * @var string
     *
     * @ORM\Column(name="genre", type="string", length=200, nullable=true)
     */
    private $genre;

    /**
     * @var string
     *
     * @ORM\Column(name="premiere_world", type="string", length=50, nullable=true)
     */
    private $premiereWorld;

    /**
     * @var string
     *
     * @ORM\Column(name="rating_mpaa", type="string", length=50, nullable=true)
     */
    private $ratingMpaa;

    /**
     * @var int
     *
     * @ORM\Column(name="duration", type="integer", nullable=true)
     */
    private $duration;

    /**
     * @var float
     *
     * @ORM\Column(name="rating_kinopoisk", type="float", nullable=true)
     */
    private $ratingKinopoisk;

    /**
     * @var int
     *
     * @ORM\Column(name="rating_kinopoisk_vote_count", type="integer", nullable=true)
     */
    private $ratingKinopoiskVoteCount;

    /**
     * @var float
     *
     * @ORM\Column(name="rating_imdb", type="float", nullable=true)
     */
    private $ratingImdb;

    /**
     * @var int
     *
     * @ORM\Column(name="rating_imdb_vote_count", type="integer", nullable=true)
     */
    private $ratingImdbVoteCount;

    /**
     * @var text
     *
     * @ORM\Column(name="description_en", type="text", nullable=true)
     */
    private $descriptionEn;

    /**
     * @var text
     *
     * @ORM\Column(name="description_ru", type="text", nullable=true)
     */
    private $descriptionRu;

    /**
     * @var string
     *
     * @ORM\Column(name="poster", type="string", length=500, nullable=true)
     */
    private $poster;

    /**
     * @var string
     *
     * @ORM\Column(name="trailer", type="string", length=500, nullable=true)
     */
    private $trailer;


    /**
     *
     * @Vich\UploadableField(mapping="posters_image", fileNameProperty="posterImageName")
     *
     * @var File
     */
    private $posterImageFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $posterImageName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Movie
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Movie
     */
    public function setPosterImageFile(File $image = null)
    {
        $this->posterImageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getPosterImageFile()
    {
        return $this->posterImageFile;
    }

    /**
     * @param string $posterImageName
     *
     * @return Movie
     */
    public function setPosterImageName($posterImageName)
    {
        $this->posterImageName = $posterImageName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPosterImageName()
    {
        return $this->posterImageName;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set uniqueName
     *
     * @param string $uniqueName
     *
     * @return Movie
     */
    public function setUniqueName($uniqueName)
    {
        $this->uniqueName = $uniqueName;

        return $this;
    }

    /**
     * Get uniqueName
     *
     * @return string
     */
    public function getUniqueName()
    {
        return $this->uniqueName;
    }

    /**
     * Set nameEn
     *
     * @param string $nameEn
     *
     * @return Movie
     */
    public function setNameEn($nameEn)
    {
        $this->nameEn = $nameEn;

        return $this;
    }

    /**
     * Get nameEn
     *
     * @return string
     */
    public function getNameEn()
    {
        return $this->nameEn;
    }

    /**
     * Set nameRu
     *
     * @param string $nameRu
     *
     * @return Movie
     */
    public function setNameRu($nameRu)
    {
        $this->nameRu = $nameRu;

        return $this;
    }

    /**
     * Get nameRu
     *
     * @return string
     */
    public function getNameRu()
    {
        return $this->nameRu;
    }

    /**
     * Set year
     *
     * @param integer $year
     *
     * @return Movie
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Movie
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set tagline
     *
     * @param string $tagline
     *
     * @return Movie
     */
    public function setTagline($tagline)
    {
        $this->tagline = $tagline;

        return $this;
    }

    /**
     * Get tagline
     *
     * @return string
     */
    public function getTagline()
    {
        return $this->tagline;
    }

    /**
     * Set producer
     *
     * @param string $producer
     *
     * @return Movie
     */
    public function setProducer($producer)
    {
        $this->producer = $producer;

        return $this;
    }

    /**
     * Get producer
     *
     * @return string
     */
    public function getProducer()
    {
        return $this->producer;
    }

    /**
     * Set scenario
     *
     * @param string $scenario
     *
     * @return Movie
     */
    public function setScenario($scenario)
    {
        $this->scenario = $scenario;

        return $this;
    }

    /**
     * Get scenario
     *
     * @return string
     */
    public function getScenario()
    {
        return $this->scenario;
    }

    /**
     * Set producerSecond
     *
     * @param string $producerSecond
     *
     * @return Movie
     */
    public function setProducerSecond($producerSecond)
    {
        $this->producerSecond = $producerSecond;

        return $this;
    }

    /**
     * Get producerSecond
     *
     * @return string
     */
    public function getProducerSecond()
    {
        return $this->producerSecond;
    }

    /**
     * Set operator
     *
     * @param string $operator
     *
     * @return Movie
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;

        return $this;
    }

    /**
     * Get operator
     *
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * Set composer
     *
     * @param string $composer
     *
     * @return Movie
     */
    public function setComposer($composer)
    {
        $this->composer = $composer;

        return $this;
    }

    /**
     * Get composer
     *
     * @return string
     */
    public function getComposer()
    {
        return $this->composer;
    }

    /**
     * Set painter
     *
     * @param string $painter
     *
     * @return Movie
     */
    public function setPainter($painter)
    {
        $this->painter = $painter;

        return $this;
    }

    /**
     * Get painter
     *
     * @return string
     */
    public function getPainter()
    {
        return $this->painter;
    }

    /**
     * Set montage
     *
     * @param string $montage
     *
     * @return Movie
     */
    public function setMontage($montage)
    {
        $this->montage = $montage;

        return $this;
    }

    /**
     * Get montage
     *
     * @return string
     */
    public function getMontage()
    {
        return $this->montage;
    }

    /**
     * Set genre
     *
     * @param string $genre
     *
     * @return Movie
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return string
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set premiereWorld
     *
     * @param string $premiereWorld
     *
     * @return Movie
     */
    public function setPremiereWorld($premiereWorld)
    {
        $this->premiereWorld = $premiereWorld;

        return $this;
    }

    /**
     * Get premiereWorld
     *
     * @return string
     */
    public function getPremiereWorld()
    {
        return $this->premiereWorld;
    }

    /**
     * Set ratingMpaa
     *
     * @param string $ratingMpaa
     *
     * @return Movie
     */
    public function setRatingMpaa($ratingMpaa)
    {
        $this->ratingMpaa = $ratingMpaa;

        return $this;
    }

    /**
     * Get ratingMpaa
     *
     * @return string
     */
    public function getRatingMpaa()
    {
        return $this->ratingMpaa;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     *
     * @return Movie
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return integer
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set ratingKinopoisk
     *
     * @param string $ratingKinopoisk
     *
     * @return Movie
     */
    public function setRatingKinopoisk($ratingKinopoisk)
    {
        $this->ratingKinopoisk = $ratingKinopoisk;

        return $this;
    }

    /**
     * Get ratingKinopoisk
     *
     * @return string
     */
    public function getRatingKinopoisk()
    {
        return $this->ratingKinopoisk;
    }

    /**
     * Set ratingImdb
     *
     * @param string $ratingImdb
     *
     * @return Movie
     */
    public function setRatingImdb($ratingImdb)
    {
        $this->ratingImdb = $ratingImdb;

        return $this;
    }

    /**
     * Get ratingImdb
     *
     * @return string
     */
    public function getRatingImdb()
    {
        return $this->ratingImdb;
    }

    /**
     * Set descriptionEn
     *
     * @param string $descriptionEn
     *
     * @return Movie
     */
    public function setDescriptionEn($descriptionEn)
    {
        $this->descriptionEn = $descriptionEn;

        return $this;
    }

    /**
     * Get descriptionEn
     *
     * @return string
     */
    public function getDescriptionEn()
    {
        return $this->descriptionEn;
    }

    /**
     * Set descriptionRu
     *
     * @param string $descriptionRu
     *
     * @return Movie
     */
    public function setDescriptionRu($descriptionRu)
    {
        $this->descriptionRu = $descriptionRu;

        return $this;
    }

    /**
     * Get descriptionRu
     *
     * @return string
     */
    public function getDescriptionRu()
    {
        return $this->descriptionRu;
    }

    /**
     * Set poster
     *
     * @param string $poster
     *
     * @return Movie
     */
    public function setPoster($poster)
    {
        $this->poster = $poster;

        return $this;
    }

    /**
     * Get poster
     *
     * @return string
     */
    public function getPoster()
    {
        return $this->poster;
    }

    /**
     * Set trailer
     *
     * @param string $trailer
     *
     * @return Movie
     */
    public function setTrailer($trailer)
    {
        $this->trailer = $trailer;

        return $this;
    }

    /**
     * Get trailer
     *
     * @return string
     */
    public function getTrailer()
    {
        return $this->trailer;
    }

    /**
     * Set ratingKinopoiskVoteCount
     *
     * @param integer $ratingKinopoiskVoteCount
     *
     * @return Movie
     */
    public function setRatingKinopoiskVoteCount($ratingKinopoiskVoteCount)
    {
        $this->ratingKinopoiskVoteCount = $ratingKinopoiskVoteCount;

        return $this;
    }

    /**
     * Get ratingKinopoiskVoteCount
     *
     * @return integer
     */
    public function getRatingKinopoiskVoteCount()
    {
        return $this->ratingKinopoiskVoteCount;
    }

    /**
     * Set ratingImdbVoteCount
     *
     * @param integer $ratingImdbVoteCount
     *
     * @return Movie
     */
    public function setRatingImdbVoteCount($ratingImdbVoteCount)
    {
        $this->ratingImdbVoteCount = $ratingImdbVoteCount;

        return $this;
    }

    /**
     * Get ratingImdbVoteCount
     *
     * @return integer
     */
    public function getRatingImdbVoteCount()
    {
        return $this->ratingImdbVoteCount;
    }
}
