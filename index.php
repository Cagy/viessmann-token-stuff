
<?php

require_once('config.php');
require_once('viessmann.class.php');

$vm = new viessmann($CONFIG);

?>

<h1>
    <li><a href="<?php echo $vm->authRequest(); ?>">Generate an Authorization code</a>
    <li><a href="?refresh=true">Use Refresh Token</a>
    <li><a href="?">Reset / Restart</a>
</h1>

<?php
if( !empty($_REQUEST['refresh']) ){
    $output = $vm->refreshRequest();
    echo '<h3>Tokens dumped in file: <a href="tokens.json" target="blank">tokens.json</a></h3>';
    exit();
}

if( !empty($_REQUEST['code']) ){
    $vm->tokenRequest($_REQUEST['code']);
    echo '<h3>Tokens dumped in file: <a href="tokens.json" target="blank">tokens.json</a></h3>';
    exit();
}

?>
