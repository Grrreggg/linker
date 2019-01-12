<?php
require_once('database.php');

//GET CURRENT PAGE URL
$url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

$db = new linker;
$config = $db -> read_config();

//IF CURRENT URL DOES NOT MATCH ROUTING URL DO REDIRECT
if ($url != $config['home_url']){
    $real_url = $db -> use_url($url);
    header('Location: '.$real_url);
    die();
}
//ELSE JUST RETURN BORING HTML PAGE
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>GREG'S LINKER</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="main">
            <form>
                <span id="copy">COPY</span>
                <input id="field" type="url">
                <span id="submit">SUBMIT</span>
            </form>
        </div>

    <script type="text/javascript" src="js/script.js"></script>
    </body>
</html>    