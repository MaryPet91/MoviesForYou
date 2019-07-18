<?php

class Trailer{


    private $title;
    private $videoId;

    public function __construct($title,$videoId){
        $this->title = $title;
        $this->videoId = $videoId;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getVideoId()
    {
        return $this->videoId;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setVideoId($videoId)
    {
        $this->videoId = $videoId;
    }
}



?>