<?php 
    class EnglishWord {
        private $dictionaries;

        public function __construct($dict_dir){
            $file = fopen($dict_dir,"r");
            while(! feof($file))
            {
                $parts = explode(", ", fgets($file));
                if( sizeof($parts) != 2){
                    continue;
                }
                $this->dictionaries[preg_replace("/\([0-9]+\)$/", "", $parts[0])] = trim( str_replace(' ', '', $parts[1]));
            }
            fclose($file);
        }

        public function get_word($word){
            $word = strtoupper($word);
            if(array_key_exists($word, $this->dictionaries)){
                return "/" . $this->dictionaries[$word] . "/";
            }
            return "/?/";
        }

        private function add_extra_space($para){
            $para = preg_replace("/(\p{L})([^\p{L}])/", "$1 $2", $para);
            $para = preg_replace("/([^\p{L}])(\p{L})/", "$1 $2", $para);
            return $para;
        }

        private function is_word($word){
            return preg_match("/\p{L}+/", $word);
        }

        public function get_paragraph($para){
            $para = $this->add_extra_space($para);
            $out = array();
            foreach(preg_split("/\s+/", $para) as $word){
                if($this->is_word($word)){
                    array_push($out, "(" . $word . ", " . $this->get_word($word) . ")");
                }else{
                    array_push($out, $word);
                }
            }
            return join(" ", $out);
        }


    }

    $english = new EnglishWord("english16k.csv");
    
    if(isset($_POST['text'])){
        $text = $_POST['text'];
        echo $english->get_paragraph($text);
    }
?>