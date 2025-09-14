<?php

    include("includes/dbconnect.php");
    include("includes/functions.php");

    
                    $modpack_id=$_GET['modpack_id'];
                    $modpack_index_id=0;

                    $sql="SELECT * from modpacks where modpack_id=$modpack_id";
                    //echo $sql;
                    $result=mysqli_query($link, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            $modpack_id=$row['modpack_id'];
                            $modpack_name=$row['modpack_name'];
                            $modpack_description=$row['modpack_description'];
                            $modpack_url=$row['modpack_url'];
                            $is_active=$row['is_active'];
                            $is_visible = $row['is_visible'];
                            $modpack_image=$row['modpack_image'];
                            $modpack_index_id=$row['modpack_index_id'];
                           
                         $ch = curl_init();

                           
                        curl_setopt($ch, CURLOPT_URL, "https://www.modpackindex.com/api/v1/modpack/".$modpack_index_id."/mods");
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                        curl_setopt($ch, CURLOPT_HEADER, FALSE);

                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

                        $response = curl_exec($ch);
                        curl_close($ch);

                        $data= json_decode($response, true);

                        if (isset($data['data'])) {
                        foreach ($data['data'] as $mod) {
                            $mod_name = mysqli_real_escape_string($link,$mod['name']);
                            $mod_name = asciiOnly($mod_name);
                            //check if the mod is in the mods database
                            $check_mod = "SELECT * from mods where cat_name='$mod_name'";
                            //echo $check_mod;
                            $result=mysqli_query($link, $check_mod) or die("MySQLi ERROR: ".mysqli_error($link));
                            if(mysqli_num_rows($result)>0){
                                //mod is in the central database
                                echo "<button type='button' name='modification' class='button blue_button'>". $mod['name']. "</button>";
                                //check if the mod is in the modpacks database
                                                              
                            } else {
                                //mod is not in the database
                                echo "<button type='button' name='modification' class='button small_button'>". $mod['name']. "</button>";
                                //add to mod's central databaase
                                $add_to_mods_database = "INSERT INTO mods (cat_name) VALUES('$mod_name')";
                                $result = mysqli_query($link, $add_to_mods_database) or die("MySQLi ERROR: ".mysqli_error($link));
                                
                            } //if mod is in the mods modpack table
                             $get_mod_id = "SELECT cat_id from mods where cat_name='$mod_name'";
                              $result=mysqli_query($link, $get_mod_id) or die("MySQLi ERROR: ".mysqli_error($link));
                             if(mysqli_num_rows($result)>0){
                                 while ($row = mysqli_fetch_array($result)) {
                                     $mod_id=$row['cat_id'];
                                     
                                     $add_to_modpack = "INSERT INTO modpack_mods (modpack_id, mod_id) VALUES($modpack_id, $mod_id)";
                                     $result_add_to_modpack = mysqli_query($link, $add_to_modpack) or die("MySQLi ERROR: ".mysqli_error($link));
                             } //while  

                           } //if mod is in the mods modpack table
                            }  //foreach
                        } //if isset
                        } 
                ?>