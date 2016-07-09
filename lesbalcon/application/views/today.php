
<body>
    <style>
        h4{ font-size: 12px;}
        li{ font-size: 8px;}
    </style>
    <h2 style="text-align: center;width:100%">Programme du <?php  echo date("d/m/Y") ?></h2>
    <?php
        $today = date("Y-m-d");
    ?>
    <?php
        foreach($activites as $activite){
            if(is_array($activite['depart']) || $activite['cleaning'] || is_array($activite['arrive'])){
            ?>
    <h4>  <?php echo  $activite['bungalow']['bunglow_name']  ?>  </h4>
                <ul>
                            <?php
                                if($activite['cleaning']){
										?>
                                            <li>
                                                Ménage
                                            </li>
                                        <?
								}
                            ?>
                            <?php
                                if(is_array($activite['depart'])){
										?>
                                            <li>
                                                Depart de la réservation de : <?php echo $activite['depart']['user_name']  ?>
                                            </li>
                                        <?
								}
                            ?>
                            <?php
                                if(is_array($activite['arrive'])){
										?>
                                            <li>
                                                Arrivé de la réservation de : <?php echo $activite['arrive']['user_name']  ?>
                                            </li>
                                        <?
								}
                            ?>
                </ul>
                
            <?
            }
        }
    ?>
</body>