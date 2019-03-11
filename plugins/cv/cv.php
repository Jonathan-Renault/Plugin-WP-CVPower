<?php
/*
Plugin Name: JSON power
Plugin URI: renault-jonathan.com
Description: Un plugin permettant la récupération et l'utilisation de données sous format JSON 
Version: 0.1
Author: Jonathan Renault
Author URI: 
License:
*/

function listcv() {

    $json = wp_remote_get( 'http://localhost/cvpower/API_restfull' );
    $jsonprofile = wp_remote_get( 'http://localhost/cvpower/API_restlist' );
    $allcv = json_decode($json["body"],true);
    $allprofile = json_decode($jsonprofile["body"],true);
    $content = (array)$allcv;
    $profile = (array)$allprofile;

    $page = get_post();

    $countcv = count($content);


    if (is_page($page)) {

      ?>
        <title>CV Power</title>

        <div id="wrapper">

            <div id="header">
                <h1>CV POWER</h1>
            </div>


            <div id="intro">
                <p><?=$countcv ?> CV envoyé sur la plateforme</p>
            </div>


            <div class="section">


            <div class="section-body">


            <?php


                for ($i = 0; $i != $countcv; $i++) {

                    $id = $content[$i][0]['id'];
                    ?>


                    <div class="item-template">
                        <div>
                            <a class="text-small" href="http://localhost/WP-cvpower/cv?id=<?php echo $id ; ?>"><h2><?php echo $profile[$i]['name'] . " " . $profile[$i]['lastname']; ?></h2></a>
                            <span class="text-small"><?php echo $content[$i][0]['name'] ?> </span>


                        </div>

                    </div>

                    <p><?php echo $content[$i][0]['description'] ?></p>
                <?php } ?>



                </div>
                </div>



                <?php

               /* echo "<pre>";
                var_dump($content);
                echo "</pre>";


                echo "<pre>";
                var_dump($profile);
                echo "</pre>";*/



        }
    }

function cv() {

    $json = wp_remote_get( 'http://localhost/cvpower/API_restfull' );
    $jsonprofile = wp_remote_get( 'http://localhost/cvpower/API_restlist' );
    $allcv = json_decode($json["body"],true);
    $allprofile = json_decode($jsonprofile["body"],true);
    $content = (array)$allcv;
    $profile = (array)$allprofile;

    $page = get_post();

    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $url_explode = explode('=' , $actual_link);
    $id = $url_explode[1]-1 ;
    $id_pdf = $url_explode[1];


    if (is_page($page)) {



        ?>
        
<body style="background-image:linear-gradient(to right bottom, rgba(<?php echo $content[$id][0]['color'];?>, 0.8), rgba(119, 155, 236, 0.8))">

        <title>CV de <?php echo $profile[$id]['name'] ." ".$profile[$id]['lastname'] ;?></title>

        <div id="wrapper">

	<div id="contact-info">
		<div  class="links" style="margin-left:0px !important;">
			<div class="col1">Email :</div>
			<div class="col2"><a href="mailto: <?php echo $profile[$id]['mail'] ;  ?>" target="_blank"> <?php echo $profile[$id]['mail'] ;  ?></a></div>
		</div>

		<div  class="links">
			<div class="col1">Tel :</div>
			<div class="col2"><a href="tel:<?php echo "0" . $profile[$id]['phone_number']  ; ?>" target="_blank"><?php echo "0" . $profile[$id]['phone_number'] ; ?></a></div>
		</div>

        <div  class="links">
            <div class="col1">Permis B :</div>
            <div class="col2">
                <?php if ($profile[$id]['driving_licence'] == 1) {
                    $publier = "Oui";
                } else {
                    $publier = "Non";
                }
                echo $publier;
                ?></div>
        </div>

        <div  class="links">
            <div class="col1">Version papier :</div>
            <div class="col2"><a href="http://localhost/cvpower/API_pdf/<?= $id_pdf ?> " target="_blank"> PDF</a></div>
        </div>

	</div>

		<div id="header">
			<h1><?php echo $profile[$id]['name'] ." ".$profile[$id]['lastname'] ;?> </h1>
		</div>


		<div id="intro">
			<p><?php echo $content[$id][0]['description'];?></p>
		</div>


            <div class="section">
                <div class="section-title" style="background-image:url(http://localhost/WP-cvpower/wp-content/uploads/2019/03/section-title-bg.png); background-repeat:no-repeat; width:171px; height:41px; float:left;"><p id="education-section">Formation</p></div>

                <div class="clear"></div>

                <div class="section-body">

                    <?php for ($i = 0; $i != count($content[$id]["edu"]); $i++) { ?>

                    <div class="item-template">
                        <div>
                            <h2><?php  echo $content[$id]["edu"][$i]['diploma'];?></h2>
                            <h3><?php  echo $content[$id]["edu"][$i]['school'];?></h3>
                            <span class="text-small"><?php echo date_i18n( get_option('date_format'), strtotime( $content[$id]['edu'][$i]['beginning'])) ." au ".
                                    date_i18n( get_option('date_format'), strtotime( $content[$id]['edu'][$i]['ending']));
                                ?> </span>
                        </div>

                        <div class="your-details">
                            <?php switch ($content[$id]["edu"][$i]['level']) {
                                case 1:
                                    echo " I ex : Master, doctorat";
                                    break;
                                case 2:
                                    echo "II ex : Licence";
                                    break;
                                case 3:
                                    echo "III ex : BTS, DUT...";
                                    break;
                                case 4:
                                    echo "IV ex : Bac";
                                    break;
                                case 5:
                                    echo "V ex : Brevet des collèges";
                                    break;
                            };
                            ?>

                        </div>
                    </div>

                    <p><?php echo $content[$id]["edu"][$i]['description'];?></p>

                    <?php } ?>

                    <div class="clear"></div>

            </div

                    <!-- Experience Section-->
                <div class="section">
                    <div class="section-title" style="background-image:url(http://localhost/WP-cvpower/wp-content/uploads/2019/03/section-title-bg.png); background-repeat:no-repeat; width:171px; height:41px; float:left;"><p id="experience-section">Experience</p></div>

                    <div class="clear"></div>

                    <div class="section-body">

                          <?php for ($i = 0; $i != count($content[$id]["exp"]); $i++) { ?>

                        <div class="item-template">
                            <div>
                                <h2><?php  echo $content[$id]["exp"][$i]['name_job'];?></h2>
                                <span class="text-small"><?php echo date_i18n( get_option('date_format'), strtotime( $content[$id]['exp'][$i]['beginning'])) ." au ".
                                        date_i18n( get_option('date_format'), strtotime( $content[$id]['exp'][$i]['ending']));
                                    ?> </span>
                            </div>

                            <div class="your-details">
                                <?php echo $content[$id]["exp"][$i]['compagny'];?>
                            </div>
                        </div>

                        <p><?php echo $content[$id]["exp"][$i]['description'];?> <br></p>


                      <?php } ?>
                 </div>

                    <!-- Skills -->

                    <div class="section">
                        <div class="section-title" style="background-image:url(http://localhost/WP-cvpower/wp-content/uploads/2019/03/section-title-bg.png); background-repeat:no-repeat; width:171px; height:41px; float:left;"><p id="skills-section">Compétences</p></div>

                        <div class="clear"></div>

                        <div class="section-body">

                          <?php  for ($i = 0; $i != count($content[$id]["skp"]); $i++) { ?>

                            <div class="item-template">
                                <div>
                                    <h2><?php echo $content[$id]["skp"][$i]['name'];?></h2>
                                </div>

                                <div class="your-details">
                                  Principales
                                </div>

                            </div>

                            <?php  } ?>

                            <?php  for ($i = 0; $i != count($content[$id]["sks"]); $i++) { ?>

                                <div class="item-template">
                                    <div>
                                        <h2><?php echo $content[$id]["sks"][$i]['name'];?></h2>
                                    </div>

                                    <div class="your-details">
                                        Secondaires
                                    </div>

                                </div>

                            <?php  } ?>

                            <?php  for ($i = 0; $i != count($content[$id]["sko"]); $i++) { ?>

                                <div class="item-template">
                                    <div>
                                        <h2><?php echo $content[$id]["sko"][$i]['name'];?></h2>
                                    </div>

                                    <div class="your-details">
                                        Organisationelles
                                    </div>

                                </div>


                            <?php  } ?>
                        </div>

                        <div class="section">
                            <div class="section-title" style="background-image:url(http://localhost/WP-cvpower/wp-content/uploads/2019/03/section-title-bg.png); background-repeat:no-repeat; width:171px; height:41px; float:left;"><p id="Language-section">Langue</p></div>

                            <div class="clear"></div>

                            <div class="section-body">

                                <?php   for ($i = 0; $i != count($content[$id]["lan"]); $i++) { ?>

                                <div class="item-template">
                                    <div>
                                        <h2><?php echo $content[$id]["lan"][$i]['name'];?></h2>
                                    </div>
                                </div>

                                <p><u>Ecrit :</u>
                                    <?php
                                    if ($content[$id]["lan"][$i]['lan_write'] == 1) {
                                        $lan_write = "Oui";
                                    } else {
                                        $lan_write = "Non";
                                    }
                                    echo  $lan_write;

                                    ?>,

                                    <u>Lu :</u>
                                    <?php
                                    if ($content[$id]["lan"][$i]['lan_read'] == 1) {
                                        $lan_read = "Oui";
                                    } else {
                                        $lan_read = "Non";
                                    }
                                    echo  $lan_read;

                                    ?>,
                                    <u>Parlé :</u>
                                    <?php
                                    if ($content[$id]["lan"][$i]['lan_speak'] == 1) {
                                        $lan_speak = "Oui";
                                    } else {
                                        $lan_speak = "Non";
                                    }
                                    echo  $lan_speak;

                                    ?>
                                </p>

                                <?php } ?>

                            </div>

                            <div class="section">
                                <div class="section-title" style="background-image:url(http://localhost/WP-cvpower/wp-content/uploads/2019/03/section-title-bg.png); background-repeat:no-repeat; width:171px; height:41px; float:left;"><p id="others-section">Hobby</p></div>

                                <div class="clear"></div>

                                <div class="section-body">

                                    <?php   for ($i = 0; $i != count($content[$id]["hob"]); $i++) { ?>

                                    <div class="item-template">
                                        <div>
                                            <h2><?php echo $content[$id]["hob"][$i]['name'];?></h2>
                                        </div>

                                    </div>

                                    <?php } ?>
                                </div>

                                <body class="section">
                                    <div class="section-title" style="background-image:url(http://localhost/WP-cvpower/wp-content/uploads/2019/03/section-title-bg.png); background-repeat:no-repeat; width:171px; height:41px; float:left;"><p id="award-section">Récompence</p></div>

                                    <div class="clear"></div>

                                    <div class="section-body">

                                       <?php for ($i = 0; $i != count($content[$id]["awa"]); $i++) { ?>

                                        <div class="item-template">
                                            <div>
                                                <h2><?php echo $content[$id]["awa"][$i]['name'];?></h2>
                                            </div>

                                            <div class="your-details">
                                                <?php echo date_i18n( get_option('date_format'), strtotime( $content[$id]['awa'][$i]['year']))?>
                                            </div>

                                        </div>

                                        <p><?php echo $content[$id]["awa"][$i]['description'];?></p>

                                    </div>

                                    <?php } ?>
                                </body>
                            <?php

?>



<?php



    }
}

function pdf(){



}


add_shortcode("listcv", "listcv");
add_shortcode("cv", "cv");
add_shortcode("pdf", "pdf");


