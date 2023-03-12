<?php

$CONFIG['client_id'] = ""; // Client ID from Viessmann
$CONFIG['redirect_uri'] = "http://localhost/viessmann/"; // put the php files here (use XAMPP)
$CONFIG['code_challenge'] = ""; // Use https://developer.pingidentity.com/en/tools/pkce-code-generator.html
$CONFIG['code_verifier'] = "";  // Use https://developer.pingidentity.com/en/tools/pkce-code-generator.html

// No changes needed here
$CONFIG['scope'] = "IoT%20User%20offline_access";
$CONFIG['response_type'] = "code";
$CONFIG['code_challenge_method'] = "S256";
$CONFIG['auth_uri'] = "https://iam.viessmann.com/idp/v2/authorize";
$CONFIG['token_uri'] = "https://iam.viessmann.com/idp/v2/token";
$CONFIG['token_vault'] = "tokens.json";
