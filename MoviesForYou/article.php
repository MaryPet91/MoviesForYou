<?php
class Article{
    
        private $title,$img,$link,$art;
        
        public function __construct($title,$img,$link,$art,$review){
    
            $this->title = $title;
            $this->img = $img;
            $this->link=$link;
            $this->art= $art;
            $this->review= $review;
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
        public function getArt()
        {
            return $this->art;
        }
    
        /**
         * @param mixed $art
         */
        public function setArt($art)
        {
            $this->art = $art;
        }

        public function getReview()
        {
            return $this->review;
        }
    
        /**
         * @param mixed $art
         */
        public function setReview($review)
        {
            $this->review = $review;
        }
    }
?>