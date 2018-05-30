<?php require 'vendor/autoload.php'; ?>
<?php
    class SendRequests {

        public function __construct() {
            // Initialize Guzzle client
            $this->client = new GuzzleHttp\Client();
        }

		public function Post($url, $data) {
            // Create a POST request
            $response = $this->client->request(
                'POST',
                $url,
                [
                    'form_params' => $data
                ]
            );

            $headers = $response->getHeaders();
            $body = $response->getBody();
            return $body->getContents();
        }
    }

 ?>
