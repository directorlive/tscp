<?php
require_once 'config.php';

$auth_url = LOGIN_URI
        . "/services/oauth2/authorize?response_type=code&client_id="
        . CLIENT_ID . "&redirect_uri=" . urlencode(REDIRECT_URI);

header('Location: ' . $auth_url);

/*$auth_url = LOGIN_URI
        . "/services/oauth2/authorize?grant_type=basic-credentials&client_id="
        . CLIENT_ID . "&client_secret=".CLIENT_SECRET."&username=mfalgares%40gaminride.com&password=lr567plus";

header('Location: ' . $auth_url);*/
?>