<?php
    //read file
    function readUpFile($file){
        $section = file_get_contents($file);
        return $section;
    }

    //check if file only contains 400 numbers
    function checkContent($string){
        $array = str_split($string);            //split string in content and return an array of element
        if (count($array) == 400){
            foreach ($array as $element){
                if (!is_numeric($element))      //if element is not a number --> return 0
                    return 0;
            }
            return 1;
        }
        else return 0;
    }

    // echo (checkContent("1234"));

    //get 20x20 array 
    function turnto2D($input){
        if (checkContent($input) == 1){
            $k = 0;
            $result = array_fill(0, 20,  
                      array_fill(0, 20,""));
            for ($i = 0; $i < 20; $i++){ 
                for ($j = 0; $j < 20; $j++) 
                { 
                    if(!empty($input[$k])) 
                    $result[$i][$j] = $input[$k]; 
                    $k++; 
                } 
            }  
            return $result;
        }
    }


    //Check horizontally
    function checkHo($arr){
        $maxh = 0;
        $combination = array();
        $temp = array();
        for ($i = 0; $i < 17; $i++){
            for ($j = 0; $j < 17; $j++){
                $h1 = (int)$arr[$i][$j];
                $h2 = (int)$arr[$i][$j+1];
                $h3 = (int)$arr[$i][$j+2];
                $h4 = (int)$arr[$i][$j+3];
                $product = $h1*$h2*$h3*$h4;  
                if ($product > $maxh){
                    $maxh = $product; 
                    if (empty($combination)){
                        array_push($combination, $maxh, $h1, $h2, $h3, $h4);
                    }
                    else{
                        array_push($temp, $maxh, $h1, $h2, $h3, $h4);
                        $combination = array_replace($combination, $temp);
                        $temp = array();
                    }
                }
            }
        }
        return $combination;
    }

    //Check vertically
    function checkVe($arr){
        $maxv = 0;
        $combination = array();
        $temp = array();
        for ($i = 0; $i < 17; $i++){
            for ($j = 0; $j < 17; $j++){
                $v1 = (int)$arr[$i][$j];
                $v2 = (int)$arr[$i+1][$j];
                $v3 = (int)$arr[$i+2][$j];
                $v4 = (int)$arr[$i+3][$j];
                $product = $v1*$v2*$v3*$v4;  
                if ($product > $maxv){
                    $maxv = $product; 
                    if (empty($combination)){
                        array_push($combination, $maxv, $v1, $v2, $v3, $v4);
                    }
                    else{
                        array_push($temp, $maxv, $v1, $v2, $v3, $v4);
                        $combination = array_replace($combination, $temp);
                        $temp = array();
                    }
                }
            }
        }
        return $combination;
    }

    //Check Diagonally Left to Right
    function checkDLR($arr){
        $maxLR = 0;
        $combination = array();
        $temp = array();
        for ($i = 0; $i < 17; $i++){
            for ($j = 0; $j < 17; $j++){
                $dLR1 = (int)$arr[$i][$j];
                $dLR2 = (int)$arr[$i+1][$j+1];
                $dLR3 = (int)$arr[$i+2][$j+2];
                $dLR4 = (int)$arr[$i+3][$j+3];
                $product = $dLR1*$dLR2*$dLR3*$dLR4;  
                if ($product > $maxLR){
                    $maxLR = $product; 
                    if (empty($combination)){
                        array_push($combination, $maxLR, $dLR1, $dLR2, $dLR3, $dLR4);
                    }
                    else{
                        array_push($temp, $maxLR, $dLR1, $dLR2, $dLR3, $dLR4);
                        $combination = array_replace($combination, $temp);
                        $temp = array();
                    }
                }
            }
        }
        return $combination;
    }

    //Check Diagonally Right to Left
    function checkDRL($arr){
        $maxRL = 0;
        $combination = array();
        $temp = array();
        for ($i = 0; $i < 17; $i++){
            for ($j = 17; $j > 3; $j--){
                $dRL1 = (int)$arr[$i][$j];
                $dRL2 = (int)$arr[$i+1][$j-1];
                $dRL3 = (int)$arr[$i+2][$j-2];
                $dRL4 = (int)$arr[$i+3][$j-3];
                $product = $dRL1*$dRL2*$dRL3*$dRL4;  
                if ($product > $maxRL){
                    $maxRL = $product; 
                    if (empty($combination)){
                        array_push($combination, $maxRL, $dRL1, $dRL2, $dRL3, $dRL4);
                    }
                    else{
                        array_push($temp, $maxRL, $dRL1, $dRL2, $dRL3, $dRL4);
                        $combination = array_replace($combination, $temp);
                        $temp = array();
                    }
                }
            }
        }
        return $combination;
    }

    //Find max product
    function maxProduct($arr){
        $max = 0;
        $result = array();
        $arrh = checkHo($arr);
        $arrv = checkVe($arr);
        $arrDLR = checkDLR($arr);
        $arrDRL = checkDRL($arr);
        $max = max($arrh[0],$arrv[0],$arrDLR[0],$arrDRL[0]);
        echo"Max product found: ".$max."<br>";

        if ($max = $arrh[0])
            $result = $arrh;
        elseif ($max = $arrv[0])
            $result = $arrv;
        elseif ($max = $arrDLR[0])
            $result = $arrDLR;
        elseif ($max = $arrDRL[0])
            $result = $arrDRL;
        return $result;
    }

    echo<<<_END
            <html><head><title>PHP Form Upload</title></head><body>
            <form method='post' action='' enctype='multipart/form-data'>
                Select a TXT file: 
                <input type='file' name='filename' size='10'>
                <input type='submit' value='Upload'>
            </form>
_END;
            if(isset($_FILES['filename'])){
                $name = $_FILES['filename']['name'];                            //access filename
                $name = strtolower(preg_replace("/^A-Za-z0-9/","",$name));      //sanitize filename
                $ext = mime_content_type($name);
                if( $ext == "text/plain") {                                     //check if filename is passed and file is txt  
                    echo"Uploaded file '$name'<br>";                            //take file from sever, not url
                    $open = fopen($name, "r");
                    if ($open){
                        $content = readUpFile($name);
                        $content = preg_replace('/\s+/', '', $content);         //replace all tabs, newlines, and white spaces
                        if (checkContent($content) == 1){
                            $grid = turnto2D($content);
                            $maxProduct = maxProduct($grid);
                            echo "Max product and it's components are: ";
                            print_r($maxProduct);
                        }
                        else echo "Content is not format correctly";
                    }   
                    fclose($open);
                }
                else echo "Invalid file type (txt file only)";
            }
            else echo "No file has been uploaded.";
    echo "</body></html>";

    function tester($content){
        $content = preg_replace('/\s+/', '', $content);
        if (checkContent($content) == 1){
            $grid = turnto2D($content);
            $maxProduct = maxProduct($grid);
            echo "Max product and it's components are: ";
            print_r($maxProduct);
        }
        else echo "Content is not format correctly";
    } 
    
    //TEST PART
        //input is an array with 400 numbers --> array.txt
        //input is a string --> test file string.txt
        //input is an array that contains character --> test arraycontaincharacter.txt
        //input is an array with less than 400 numbers --> test arrayLessThan400.txt
        //wrong file type --> test test1.php
        echo"<br>---------------------------------------<br>";

        //input with less than 400 numbers and one character
        $input1 = "1,3,4,5,a,6,7,8";
        
        //input with 400 numbers (only one 4 in [0][0])
        $input2 = "41111111111111111111 
                11111111111111111111 
                11111111111111111111
                11111111111111111111
                11111111111111111111
                11111111111111111111
                11111111111111111111
                11111111111111111111
                11111111111111111111
                11111111111111111111
                11111111111111111111
                11111111111111111111
                11111111111111111111
                11111111111111111111
                11111111111111111111
                11111111111111111111
                11111111111111111111
                11111111111111111111
                11111111111111111111
                11111111111111111111";
              
    echo "Test input1: ".$input1."<br>"; 
    tester ($input1);
    echo"<br>---------------------------------------<br>";
    echo "Test input2: ".$input2."<br>";
    tester ($input2);

?>