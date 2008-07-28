<?php

require_once 'OAuth.php';

class OAuthClient
{
	const REQUEST_TOKEN_URL = 'http://www.douban.com/service/auth/request_token';
	const ACCESS_TOKEN_URL = 'http://www.douban.com/service/auth/access_token';
	const AUTHORIZATION_URL = 'http://www.douban.com/service/auth/authorize';

	protected $_server = null;
	protected $_consumer = null;
	protected $_token = null;
	protected $_method = null;
	
	public function __construct($server = "http://www.douban.com", $key = null, $secret = null)
	{
		$this->_server = $server;
		$this->_consumer =  new OAuthConsumer($key, $secret);	
		$this->_method = new OAuthSignatureMethod_HMAC_SHA1();
	}

	public function login($key = null, $secret = null)
	{
		if ($key && $secret) {
			$this->_token = new OAuthToken($key, $secret);
			return true;
		}
		print "1";
		$result = $this->getRequestToken();
		$key = $result["oauth_token"];
		$secret = $result["oauth_token_secret"];
		if (!$key) {
			print 'get request token failed';
            		return false;
		}	
		$url = $this->getAuthorizationUrl($key,$secret);
		print 'please paste the url in your webbrowser, complete the authorization then come back:';
        	print $url;
		$fp = fopen("php://stdin", "r");
		if ($fp) {
			$line = fread($fp, 1);
		}
		
		$token = $this->getAccessToken($key, $secret);
		$key = $token[0];
		$secret = $token[1];
        	if ($key) {
            		 $this->login($key, $secret);
		} else {
            		print "get access token failed";
            		return False;
		}
	}
	
	public function parse($content = null) 
	{
		$arr = explode("&", $content);
		$size = sizeof($arr);
		var_dump($arr);
		$result = array();
		if ($size == 2) {
			$token = explode("=", $arr[0]);
			$secret = explode("=", $arr[1]);
			$result["oauth_token"] = $token[1];
			$result["oauth_token_secret"] = $secret[1];
			$result["douban_user_id"] = null;
		} else if ($size == 3) {
			$token = explode("=", $arr[0]);
			$secret = explode("=", $arr[1]);
			$user = explode("=", $arr[2]);
			$result["oauth_token"] = $token[1];
			$result["oauth_token_secret"] = $secret[1];
			$result["douban_user_id"] = $user[1];
		}
		return $result;
	}

	public function fetchToken($oauth_request = null)
	{
		$http_request = new HttpRequest($oauth_request->to_url(), HttpRequest::METH_GET);
		$http_request->send();
		$r = $httpre_quest->getResponseBody();
		print "2";
		print $r;
		return $this->parse($r);
		
	}

	public function getRequestToken()
	{
		$oauth_request = OAuthRequest::from_consumer_and_token($this->_consumer, NULL, "GET",REQUEST_TOKEN_URL);
		$oauth_request->sign_request($this->_method, $this->_consumer, NULL);
		return $this->fetchToken($oauth_request);
	}

	public function getAuthorizationUrl($key = null, $secret = null, $callback = null)
	{
		$parameters = array();
		$parameters["oauth_token"] = $key;
		$parameters["oauth_callback"] = $callback;
		$oauth_request = new OAuthRequest('GET', AUTHORIZATION_URL, $parameters);

		return $oauth_request->to_url();
	}

	public function getAccessToken($key = null, $secret = null, $token = null)
	{
		if ($key && $secret) {
			$token = new OAuthToken($key, $secret);
		}
		$oauth_request = OAuthRequest::from_consumer_and_token($this->_consumer, $token, "GET",REQUEST_TOKEN_URL);
		$oauth_request->sign_request($this->_mothod, $this->_consumer, $token);
		return $this->fetchToken($oauth_request);
	}

	public function getAuthHeader($method = null, $uri = null, $parameters = null)
	{
		if ($this->_token) {
			$oauth_request = OAuthRequest::from_consumer_and_token($this->_consumer, $this->_token, $method, $uri, $paramters);
		$oauth_request->sign_request($this->_mothod, $this->_consumer, $this->_token);
		return $oauth_request->to_header();
		}
	}

	public function accessResource($method = null, $url = null)
	{
		$oauth_request = OAuthRequest::from_consumer_and_token($this->_consumer, $this->_token, "GET", $url);
		$oauth_request->sign_request($this->_mothod, $this->_consumer, $this->_token);
		$headers = $oauth_request.to_header();
		if (($method == 'POST')||($method == 'PUT')) {
			$headers['Content-Type'] = 'application/atom+xml; charset=utf-8';
			$http_request = new HttpRequest($this->_server . ":80", $method);
			$http_request->setHeaders($headers);
			$http_request->send();
			return $httpre_quest->getResponseBody();
		}
	}

}

$API_KEY = '698805e0675f9cb33c9811a1361ed619';
$SECRET = '4b3ef67ecd3ffe21';
$client = new OAuthClient($key=$API_KEY, $secret=$SECRET);
$client->login();
$res = $client->access_resource('GET', 'http://api.douban.com/test?a=b&c=d').read();
print "*********************";
print $res;
?>
