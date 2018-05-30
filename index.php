<?php
    include 'includes/simple_html_dom.php';
    require __DIR__.'/requests.php';
    $_request = new SendRequests();
?>
<?php
    $url = 'http://www.inecnigeria.org/?page_id=20';
    $html1 = file_get_html($url);
    $states = [];
    foreach($html1->find('select[id=sel_states] option') as $key1 => $option1){ //states
        if($key1 >= 1){
            $option1->innertext = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $option1->innertext);
            $states[$option1->innertext] = [];

            $html2 = $_request->Post('http://www.inecnigeria.org/wp-content/themes/inec/lgass.php', ['id' => $option1->value]);
            $html2 = str_get_html($html2);

            foreach($html2->find('option') as $key2 => $option2) { //lgas
                if($key2 >= 1){
                    $option2->innertext = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $option2->innertext);
                    $states[$option1->innertext][$option2->innertext] = [];

                    $html3 = $_request->Post('http://www.inecnigeria.org/wp-content/themes/inec/ra.php', ['id' => $option2->value]);
                    $html3 = str_get_html($html3);

                    foreach($html3->find('option') as $key3 => $option3) {  //wards
                        if($key3 >= 1){
                            $option3->innertext = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $option3->innertext);
                            $states[$option1->innertext][$option2->innertext][$option3->innertext] = [];
                            $data = ['sel_states' => $option1->value, 'sel_lgas' => $option2->value, 'sel_ra' => $option3->value, 'MM_insert' => 'form1'];
                            $html4 = $_request->Post('http://www.inecnigeria.org/?page_id=20', $data);
                            $html4 = str_get_html($html4);

                            foreach($html4->find('table tr td a') as $key4 => $option4) {  //centres
                                    $option4->innertext = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $option4->innertext);
                                    $option4->innertext = str_replace("/","/",$option4->innertext);
                                    //$option4->innertext = stripslashes($option4->innertext);
                                    array_push($states[$option1->innertext][$option2->innertext][$option3->innertext], $option4->innertext);

                            }
                        }
                    }

                }
            }

        }
    }

    header('Content-Type: application/json');
    $myJSON = json_encode($states, JSON_PRETTY_PRINT);
     echo $myJSON;
    echo '<br>';


    $myfile = fopen("election_centres.json", "w") or die("Unable to open file!");
    fwrite($myfile, $myJSON);
    fclose($myfile);
    //echo 'done';

?>
