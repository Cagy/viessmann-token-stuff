# viessmann-token-stuff
Generate OAuth bearer and refresh tokens for Viessmann API's using a tiny web interface

## Configuration
Open the config.php file to populate the values for token generation.

Install XAMPP (or similar) and create a viessmann folder in /htdocs/ and drop these files in there. 

Generate an API Client at https://app.developer.viessmann.com/ 
+ Do not check the Google reCAPTCHA option!
+ use Redirect URIs: http://localhost/viessmann/
+ Copy paste the Client ID to: $CONFIG['client_id']

Next open https://developer.pingidentity.com/en/tools/pkce-code-generator.html to generate codes.
+ Use SHA-256
+ Click Create
+ Copy the values to the config file in the correct key value pairs.

## Usage
Run Apachec via XAMPP (or similar) and open http://localhost/viessmann/. There are 3 options
+ Generate a new OAuth Bearer token and Refresh token
+ Generate a new OAuth Bearer token using a Refresh token
+ Reset / Start over

## Output
The bearer and refresh tokens will be stored in tokens.json in a json format for further usage.
