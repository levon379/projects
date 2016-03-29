<?php

if (file_exists(ABSPATH . "config/blogger.local.php")) {
    return include "blogger.local.php";
} else {
    return array(
        'client_id'        => '189761124777-onetr9c9n70hfpuv2p1vi8cdftoi4643.apps.googleusercontent.com',
        'client_secret'    => 'mB8xjJmJidDFZ4VON63ZR5hT',
    );
}