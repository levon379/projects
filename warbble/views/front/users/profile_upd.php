<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/user_profile/css/reset.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>

    <link href="<?php echo BASE_URL; ?>assets/front/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/front/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/front/css/fonts.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/front/css/responsive.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/front/css/style.css"> <!-- Gem style -->

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/user_profile/css/main.css">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="<?php echo BASE_URL; ?>assets/front/js/jquery-1.11.2.min.js"></script>

    <script src="<?php echo BASE_URL; ?>assets/front/js/bootstrap.min.js"></script>

    <!-- <script src="<?php echo BASE_URL; ?>assets/front/js/main-script.js"></script>-->
    <script src="<?php echo BASE_URL; ?>assets/front/js/modernizr.js"></script><!--  Modernizr -->
    <script src="<?php echo BASE_URL; ?>assets/front/js/jquery.validate.js"></script>

    <script src="<?php echo BASE_URL; ?>assets/front/js/main.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/front/js/main-old.js"></script> <!-- Gem jQuery -->

    <script src="https://www.google.com/recaptcha/api.js"></script>


</head>
<body class="my-account">

<?php $this->view('front/init/header_menu', array('userlogin' => $user)) ?>

<section id="register" class="main">
    <?php if( isset( $mes ) && !empty( $mes )) echo '<center>'.$mes.'</center>'; ?>
    <h1>Profile settings</h1>

    <?php if( !empty( $user ) ): ?>
    <form class="base flex" action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="user_id" value="<?= $user->user_id; ?>">
        <div class="avatar">
            <?php
            if(is_null($user->avatar)) {
                ?>
                <div
                    style="opacity: 1;z-index:11;background-color: rgba(239, 76, 122, 0.9);width:120px;height:120px;text-align: center;vertical-align:middle;">
                <span style="line-height:120px;font-size: 36px;color: #fff;font-weight: 600;">
                    <?php
                    echo ucfirst(mb_substr($user->first_name, 0, 1, 'UTF-8')).'.';
                    echo ucfirst(mb_substr($user->last_name, 0, 1, 'UTF-8')).'.';

                    ?>
                </span>
                </div>
                <?php
                }else{
                ?><img src="<?php echo BASE_URL. $user->avatar;?>" alt="avatar" class="avatar-img">
                <?php
                }

            ?>
            <div class="oh"></div>

            <img src="<?php echo BASE_URL; ?>assets/user_profile/images/edit.png" alt="edit avatar" class="edit_avatar">
            <input type="file" name="avatar" size="1">
        </div>
        <ul>
            <li><input name="first_name" id="first-name" value="<?= $user->first_name ?>" type="text"><label>First name</label></li>
            <li><input name="last_name" id="last-name" value="<?= $user->last_name ?>" type="text"><label>Last name</label></li>
            <li><input name="email" id="email" value="<?= $user->email ?>" type="text" disabled><label>Email</label></li>
            <li class="bio-container"><textarea name="bio" id="bio" rows="6"><?= $user->bio ?></textarea></li>
        </ul>
        <ul class="nor">
            <li><input type="text" name="website" id="website" value="<?= $user->website ?>"/><label>Website</label></li>
            <li><input type="text" id="i6" name="facebook" value="facebook.com/gregfurlong"><label>Facebook</label></li>
            <li><input type="text" id="i5" name="twitter" value="twitter.com/gregfurlong"><label>Twitter</label></li>
            <li><input type="text" id="vat_number" value="<?= $user_package->vat_number ?>" name="vat_number"  placeholder="FR60528551658"><label>Tax identification number</label></li>

            <li><div class="btn"><button name="cancel" value="cancel" style="float: left;">Cancel</button><button name="update" value="update">Update</button></div></li>
        </ul>
    </form>
     <?php endif; ?>
</section>

<style>
    .success{
        padding: 5px 10px;
        color: #fefefe;
        position: relative;
        font: 14px/20px Museo300Regular, Helvetica, Arial, sans-serif;
        background: #006505;

        width: 50%;
        margint-top: -80px;

    }
    </style>

</body>
</html>