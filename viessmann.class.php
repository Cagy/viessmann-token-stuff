<?php

/*

    By KFRJanssens@gmail.com
    v0.1337.42.001

    3rd party STUFF.:
        https://documentation.viessmann.com/static/authentication
        https://developer.pingidentity.com/en/tools/pkce-code-generator.html
        https://app.developer.viessmann.com/

*/


class viessmann {
    
    var $args;
    var $refresh_token;
    var $response;

    /*
        Load Config
    */
    public function __construct($CONFIG){
        $this->args = $CONFIG;
    }


    /*
        Generate an Authorization code (only valid vor 20 seconds!)
     */
    public function authRequest(){

        $fields = array("client_id", "redirect_uri", "scope", "response_type", "code_challenge", "code_challenge_method");
        $params = array();
        foreach($fields as $key){
            $params[] = $key . "=" . $this->args[$key];
        }

        $get_uri = $this->args['auth_uri'] . "?" . implode("&", $params);
        return $get_uri;

    }

    /* 
        Generate an oAuth Bearer token & Refresh token
    */
    public function tokenRequest($code){
        
        $headers['Content-Type'] = "application/x-www-form-urlencoded";
        
        // Build POST fields
        $fields = array("client_id", "redirect_uri", "code_verifier");
        $params = array();
        foreach($fields as $key){
            $params[$key] =  $this->args[$key];
        }
        
        $params['grant_type'] = "authorization_code";
        $params['code'] = $code;

        $postfields = http_build_query($params, "", "&");

        // Send request
        $options = array(
            CURLOPT_URL => $this->args['token_uri'],
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_HEADER => false,
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 20
        );
        
        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $this->reponse = curl_exec($ch);
        curl_close($ch);

        $this->saveTokenVault();
        
        return true;
    }
    
    public function saveTokenVault(){
        $data = json_decode($this->reponse, true);
        $data['stamp'] = date("Y-m-d H:i:s");
        $data['epoch'] = time();
        file_put_contents($this->args['token_vault'], json_encode($data));
    }

    public function loadRefreshToken(){
        $json = json_decode( file_get_contents($this->args['token_vault']), true);
        $this->refresh_token = $json['refresh_token'];
    }


    public function refreshRequest(){

        $this->loadRefreshToken();
        
        $headers['Content-Type'] = "application/x-www-form-urlencoded";

        $params["client_id"] = $this->args['client_id'];
        $params["grant_type"] = "refresh_token";
        $params["refresh_token"] = $this->refresh_token;
        $postfields = http_build_query($params, "", "&");

        $options = array(
            CURLOPT_URL => $this->args['token_uri'],
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_HEADER => false,
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 20
        );
        
        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $this->reponse = curl_exec($ch);
        curl_close($ch);

        $this->saveTokenVault();

        return true;

    }

}

?>