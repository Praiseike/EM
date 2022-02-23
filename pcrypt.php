<?php 


    function error_handler($errno,$errstr){
        throw new Exception($errstr);
    }

    set_error_handler("error_handler",E_ALL);

    class PCrypt
    {
        /*
            This is a simple Cryptography class
            the encryption mechanism is not complicated though 
            and might be easy to crack
         
         */

        function windex($array,$i){
            // for some weird reason
            // php doesn't wrap the index, e.g array[-1] should point to 
            // the last element but instead raises an error.
            // This function is a work-around

            if($i < 0){
                return $array[count($array) + $i];
            }
            return $array[$i];
            
        }

        function gen_random_key(){
            // generate a 5 digit random key
            $a = "abcdefghijklmnopqrstuvwxyz";
            $result = "";
            for($i = 0; $i < 5; $i++){
                $result .= $a[rand(0,25)];
            }
            return $result;
        }

        function __construct(){
            $this->keys = array();
            $this->values = array();
            $c = 0;
            for($i = 0x61; $i < 0x7b; $i++)
            {
                array_push($this->keys,chr($i));
                array_push($this->values,$c);
                $c++;
            }
            array_push($this->keys,'-');
            array_push($this->values,$c);

            $this->table = array_combine($this->keys,$this->values);
            $this->reverse_table = array_flip($this->table);
        }

        function encrypt($text,$key){
            try{

                $text = strtolower($text);
                $key = strtolower($this->gen_key($text,$key));
    
                $key = str_replace(" ","-",$key);
                $text = str_replace(" ","-",$text);
    
                $result = "";
                for($i= 0; $i < strlen($text); $i++)
                {
                    if(!isset($this->table[$text[$i]])){
                        $result .= $text[$i]; 
                        continue;
                    }else{
                        $c = $this->table[$text[$i]];
                    }
                    
                    if(!isset($this->table[$key[$i]])){
                        $result .= $key[$i]; 
                        continue;
                    }else{
                        $k = $this->table[$key[$i]];
                    }

                    $p = ($c - $k) % 27;
                    $result .= $this->windex($this->reverse_table,$p);
    
                }
                return $result;
            }catch(Exception $e){
                echo "Message: ".$e->getMessage();
            }
        }

        function decrypt($text,$key){
            try{

                $text = strtolower($text);
                $key = strtolower($this->gen_key($text,$key));
                
                $result = "";
                for($i= 0; $i < strlen($text); $i++)
                {

                    if(!isset($this->table[$text[$i]])){
                        $result .= $text[$i]; 
                        continue;
                    }else{
                        $p = $this->table[$text[$i]];
                    }
                    
                    if(!isset($this->table[$key[$i]])){
                        $result .= $key[$i]; 
                        continue;
                    }else{
                        $k = $this->table[$key[$i]];
                    }

                    $c = ($p + $k) % 27;
                    $result .= $this->windex($this->reverse_table,$c);
                }
                $result = str_replace("-"," ",$result);
                return $result;

            }catch(Exception $e){
                echo "Message[".$e->getLine()."]: ".$e->getMessage()."\n";

            }
        }

        function gen_key($text,$key){
 
            $key = str_replace(" ","-",$key);    

            if(strlen($key) > strlen($text)){
                return substr($key,0,strlen($text));
            }
            if(strlen($text) > strlen($key)){
                $i = floor(strlen($text)  / strlen($key)) + 1;
                $k = str_repeat($key,$i);
                $k = substr($k,0,strlen($text));
                return $k;
            }
            if(strlen($text) == strlen($key)){
                return $key;
            }
        }

    }

    $pcrypt = new PCrypt();

?>