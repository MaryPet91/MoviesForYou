<?php
class Cinema{
    
        private $nome,$regione,$comune,$provincia,$latitudine,$longitudine;
        
        public function __construct($nome,$regione,$provincia,$latitudine,$longitudine){
    
            $this->nome = $nome;
            $this->regione = $regione;
            $this->provincia=$provincia;
            $this->latitudine= $latitudine;
            $this->longitudine = $longitudine;
        }
    
        /**
         * @return mixed
         */
        public function getNome()
        {
            return $this->nome;
        }
    
        /**
         * @param mixed $nome
         */
        public function setNome($nome)
        {
            $this->nome = $nome;
        }
    
        /**
         * @return mixed
         */
        public function getRegione()
        {
            return $this->regione;
        }
    
        /**
         * @param mixed $regione
         */
        public function setRegione($regione)
        {
            $this->regione = $regione;
        }
    
        /**
         * @return mixed
         */
        public function getProvincia()
        {
            return $this->provincia;
        }
    
        /**
         * @param mixed $provincia
         */
        public function setProvincia($provincia)
        {
            $this->provincia = $provincia;
        }
    
        /**
         * @return mixed
         */
        public function getLatitudine()
        {
            return $this->latitudine;
        }
    
        /**
         * @param mixed $latitudine
         */
        public function setLatitudine($latitudine)
        {
            $this->latitudine = $latitudine;
        }
    
        /**
         * @return mixed
         */
        public function getLongitudine()
        {
            return $this->longitudine;
        }
    
        /**
         * @param mixed $longitudine
         */
        public function setLongitudine($longitudine)
        {
            $this->longitudine = $longitudine;
        } 
    }
?>