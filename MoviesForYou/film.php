<?php

class Film {
    //proprietà
    private $title;            //titolo
    private $title_original;    //titolo originale
    private $img;               //immagine Copertina
    private $rating;           //voto film
    private $description;      //descrizione
    private $id;               //id
    private $lan;              //lingua
    private $adult;            //boolean true solo per adulti
    private $genre;             //genere
    private $year;              //anno
    private $link;              //link
    private $link_streaming;    //link streaming
    private $direction;         //regia - regista
    private $cast;              //cast
    private $duration;            //durata
    private $story;                 //trama
    private $review;                //recensione
    private $nationality;           //nazionalità

    /**
     * Film constructor.
     * @param $title
     * @param $title_original
     * @param $img
     * @param $rating
     * @param $description
     * @param $id
     * @param $lan
     * @param $adult
     * @param $genre
     * @param $year
     * @param $link
     * @param $link_streaming
     * @param $direction
     * @param $cast
     * @param $duration
     * @param $story
     * @param $review
     * @param $nationality
     */
    public function __construct($title, $title_original, $img, $rating, $description, $id, $lan, $adult, $genre, $year,
                                $link, $link_streaming, $direction, $cast, $duration, $story, $review, $nationality)
    {
        $this->title = $title;
        $this->title_original = $title_original;
        $this->img = $img;
        $this->rating = $rating;
        $this->description = $description;
        $this->id = $id;
        $this->lan = $lan;
        $this->adult = $adult;
        $this->genre = $genre;
        $this->year = $year;
        $this->link = $link;
        $this->link_streaming = $link_streaming;
        $this->direction = $direction;
        $this->cast = $cast;
        $this->duration = $duration;
        $this->story = $story;
        $this->review = $review;
        $this->nationality = $nationality;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTitleOriginal()
    {
        return $this->title_original;
    }

    /**
     * @param mixed $title_original
     */
    public function setTitleOriginal($title_original)
    {
        $this->title_original = $title_original;
    }

    /**
     * @return mixed
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @param mixed $img
     */
    public function setImg($img)
    {
        $this->img = $img;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getLan()
    {
        return $this->lan;
    }

    /**
     * @param mixed $lan
     */
    public function setLan($lan)
    {
        $this->lan = $lan;
    }

    /**
     * @return mixed
     */
    public function getAdult()
    {
        return $this->adult;
    }

    /**
     * @param mixed $adult
     */
    public function setAdult($adult)
    {
        $this->adult = $adult;
    }

    /**
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param mixed $genre
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @return mixed
     */
    public function getLinkStreaming()
    {
        return $this->link_streaming;
    }

    /**
     * @param mixed $link_streaming
     */
    public function setLinkStreaming($link_streaming)
    {
        $this->link_streaming = $link_streaming;
    }

    /**
     * @return mixed
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * @param mixed $direction
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;
    }

    /**
     * @return mixed
     */
    public function getCast()
    {
        return $this->cast;
    }

    /**
     * @param mixed $cast
     */
    public function setCast($cast)
    {
        $this->cast = $cast;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param mixed $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return mixed
     */
    public function getStory()
    {
        return $this->story;
    }

    /**
     * @param mixed $story
     */
    public function setStory($story)
    {
        $this->story = $story;
    }

    /**
     * @return mixed
     */
    public function getReview()
    {
        return $this->review;
    }

    /**
     * @param mixed $review
     */
    public function setReview($review)
    {
        $this->review = $review;
    }

    /**
     * @return mixed
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * @param mixed $nationality
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;
    }
}
?>