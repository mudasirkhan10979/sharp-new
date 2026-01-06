<?php                                                                                                                                    
class Helper {

    public static function redirect($url = null) {
        if (!empty($url)) {
            header("Location: {$url}");
            exit;
        }
    }

    public static function cleanString($name = null) {
        if (!empty($name)) {
            return strtolower(preg_replace('/[^a-zA-Z0-9.]/', '-', $name));
        }
    }

    public static function isPost(){
        if (!empty($_POST)) {
            return true;
        }
        return false;
    }

    /*
     * Files uploading related
     */
    // public static function uploadfiles($file,$dir='listing'){
    //     if($file['name'] != ''){ // check for the files allowed
    //         $targetpath = DIR_UPLOAD.$dir."/".$file['name'];
    //         copy($file['tmp_name'],$targetpath);
    //         return $file['name'];
    //     }else{
    //         return "";
    //     }
    // }

    public static function  uploadfiles($file,$dirs='enquiries'){
        $arr=array('png','jpg','jpeg');
       // $arr=explode(',',Core::config('image.allowed_formats'));
        //global $ROOT,$allowedfiles,$allowedfiles2,$allowedjpg;
        if($file['name'] != ''){   // again check the file name is not empty
            $ext = explode('.', $file['name']);
            $x=array_pop($ext);
            if (in_array($x, $arr)) {
                $filename = $dirs .'-' .$dirs.'-' .rand().time().rand(). '.' . $x;
                //var_dump( $filename);
                $targetpath = DIR_UPLOAD.$dirs."/".$filename;
                copy($file['tmp_name'],$targetpath);
                return $filename;
            } else{
                return "";
            }
        }else{
            return "";
        }
    }

     public static function teest(){
            echo 'here';
    }
    public static function deleteFile($dirs,$fileName){
        if($fileName != ''){   // again check the file name is not empty
           $targetpath = DIR_UPLOAD.$dirs."/".$fileName;
            if(file_exists($targetpath) && is_file($targetpath)){
                    unlink($targetpath); 
                    return true;
            }else{
                return false;
            }
        } else{
            return false;
        }
    }

    /*
     * General static function to make the url
     */

    public static function makeurl($vtitle){
        $farray=array(" ","%","#","&","*","@","!","(",")","/","/\\",'.');
        foreach($farray as $farr){
            $vtitle = str_replace($farr,"-",$vtitle);
        }
        $vtitle = strtolower($vtitle);
        return $vtitle;
    }
    /*
     * General Static function for the encodingHtml
     */

    public static function encodeHTML($string, $case = 2) {
        switch($case) {
            case 1:
                return htmlentities($string, ENT_NOQUOTES, 'UTF-8', false);
                break;
            case 2:
                $pattern = '<([a-zA-Z0-9\.\, "\'_\/\-\+~=;:\(\)?&#%![\]@]+)>';
                // put text only, devided with html tags into array
                $textMatches = preg_split('/' . $pattern . '/', $string);
                // array for sanitised output
                $textSanitised = array();
                foreach($textMatches as $key => $value) {
                    $textSanitised[$key] = htmlentities(html_entity_decode($value, ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8');
                }
                foreach($textMatches as $key => $value) {
                    $string = str_replace($value, $textSanitised[$key], $string);
                }
                return $string;
                break;
        }
    }


    public static function getImgSize($image, $case) {
        if(is_file($image)) {
            // 0 => width, 1 => height, 2 => type, 3 => attributes
            $size = getimagesize($image);
            return $size[$case];
        }
    }

    public static function shortenString($string, $len = 150) {
        if (strlen($string) > $len) {
            $string = trim(substr($string, 0, $len));
            $string = substr($string, 0, strrpos($string, " "))."&hellip;";
        } else {
            $string .= "&hellip;";
        }
        return $string;
    }

    /*
     * Dev profiling function
     */
       public static function Dev_output($arr){
            echo "<pre>"; print_r($arr); echo "<hr></pre>";
       }



}