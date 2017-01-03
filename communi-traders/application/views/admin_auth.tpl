<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title>CommuniTraders | Analysis tool admin panel</title>
        <link href="{$url}assets/css/admin_style.css" rel="stylesheet" type="text/css"/>
        <link href="{$url}assets/css/bootstrap.css" rel="stylesheet" type="text/css"/>
    </head>
    <body data-spy="scroll" data-target=".subnav" data-offset="50" data-twttr-rendered="true" style="padding-top: 170px;">
        <div id="input_center" class="span6">
            <form action="" method="post" class="form-inline log_form">
                <div class="login_head">
                    <h4><span class="glyphicon glyphicon-stats"></span>  | CommuniTraders - Analysis tool</h4>
                </div>

                <br/>
                {$ci_csrf_token}
                <input id="login" type="text" name="login" class="textbox" placeholder="Login"/>
                <input type="password" name="password" class="textbox" placeholder="Password"/>
                <div class="button_wrap">
                <button type="submit" class="btn btn-primary text-center">Sign in</button>
                </div>
            </form>
            {$error_string}


        </div>
        <div class="admin_login_footer"></div>
    </body>
</html>