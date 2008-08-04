<?php

require_once 'OAuth.php';
require_once 'Zend/Http/Client.php';

class OAuthClient extends Zend_Http_Client
{
	const REQUEST_TOKEN_URL = 'http://www.douban.com/service/auth/request_token';
	const ACCESS_TOKEN_URL = 'http://www.douban.com/service/auth/access_token';
	const AUTHORIZATION_URL = 'http://www.douban.com/service/auth/authorize';

	protected $_server = NULL;
	protected $_consumer = NULL;
	protected $_token = NULL;
	protected $_method = NULL;
	
	public function __construct($key = NULL, $secret = NULL, $server = 'http://www.douban.com')
	{
		$this->_server = $server;
		$this->_consumer =  new OAuthConsumer($key, $secret);	
		$this->_method = new OAuthSignatureMethod_PLAINTEXT();
		parent::__construct();
	}

	public function login($key = NULL, $secret = NULL)
	{
		if ($key && $secret) {
			$this->_token = new OAuthToken($key, $secret);
			return true;
		}
		$result = $this->getRequestToken();
		$key = $result["oauth_token"];
		$secret = $result["oauth_token_secret"];
		if (!$key) {
			print 'get request token failed';
            		return false;
		}	
		$url = $this->getAuthorizationUrl($key,$secret);
		print 'please paste the url in your webbrowser, complete the authorization then come back:';
		print "\n";
		print $url;
		print "\n";
		$fp = fopen("php://stdin", "r");
		if ($fp) {
			$line = fread($fp, 1);
		}
		
		$token = $this->getAccessToken($key, $secret);
		$key = $token["oauth_token"];
		$secret = $token["oauth_token_secret"];
        	if ($key) {
            		 $this->login($key, $secret);
		} else {
            		print "get access token failed";
            		return False;
		}
	}
	
	public function parse($content = NULL) 
	{
		$arr = explode("&", $content);
		$size = sizeof($arr);
		$result = array();
		if ($size == 2) {
			$token = explode("=", $arr[1]);
			$secret = explode("=", $arr[0]);
			$result["oauth_token"] = $token[1];
			$result["oauth_token_secret"] = $secret[1];
			$result["douban_user_id"] = NULL;
		} else if ($size == 3) {
			$token = explode("=", $arr[1]);
			$secret = explode("=", $arr[0]);
			$user = explode("=", $arr[2]);
			$result["oauth_token"] = $token[1];
			$result["oauth_token_secret"] = $secret[1];
			$result["douban_user_id"] = $user[1];
		}
		return $result;
	}

	public function fetchToken($oauthRequest = NULL)
	{
		$httpRequest = new HttpRequest($oauthRequest->http_url(), HttpRequest::METH_GET);
		$httpRequest->addHeaders($oauthRequest->to_header());
		$httpRequest->send();
		$r = $httpRequest->getResponsebody();
		return $this->parse($r);
		
	}

	public function getRequestToken()
	{
		$oauthRequest = OAuthRequest::from_consumer_and_token($this->_consumer, NULL, NULL, self::REQUEST_TOKEN_URL);
		$oauthRequest->sign_request($this->_method, $this->_consumer, NULL);
		return $this->fetchToken($oauthRequest);
	}

	public function getAuthorizationUrl($key = NULL, $secret = NULL, $callback = NULL)
	{
		$parameters = array();
		$parameters["oauth_token"] = $key;
 		if ($callback) {
			$parameters["oauth_callback"] = $callback;
			$oauthRequest = new OAuthRequest('GET', self::AUTHORIZATION_URL, $parameters);
		} else {
			$oauthRequest = new OAuthRequest('GET', self::AUTHORIZATION_URL, $parameters);
		}
		return $oauthRequest->to_url();
	}

	public function getAccessToken($key = NULL, $secret = NULL, $token = NULL)
	{
		if ($key && $secret) {
			$token = new OAuthToken($key, $secret);
		}
		$oauthRequest = OAuthRequest::from_consumer_and_token($this->_consumer, $token, NULL, self::ACCESS_TOKEN_URL);
		$oauthRequest->sign_request($this->_method, $this->_consumer, $token);
		return $this->fetchToken($oauthRequest);
	}

	public function getAuthHeader($method = NULL, $uri = NULL, $parameters = NULL)
	{
		if ($this->_token) {
			$oauthRequest = OAuthRequest::from_consumer_and_token($this->_consumer, $this->_token, $method, $uri, $parameters);
		$oauthRequest->sign_request($this->_method, $this->_consumer, $this->_token);
		return array($oauthRequest->to_header(), $oauthRequest->getString());
		}
	}

	public function accessResource($method = NULL, $url = NULL)
	{
		$oauthRequest = OAuthRequest::from_consumer_and_token($this->_consumer, $this->_token, NULL, $url);
		$oauthRequest->sign_request($this->_method, $this->_consumer, $this->_token);
		$headers = $oauthRequest->to_header();
		if (($method == 'POST')||($method == 'PUT')) {
			$headers['Content-Type'] = 'application/atom+xml; charset=utf-8';
		}
		$httpRequest = new HttpRequest($url, $method);
		$httpRequest->setHeaders($headers);
		$httpRequest->send();
		return $httpRequest->getResponseBody();
	}

}

#$API_KEY = '';
#$SECRET = '';
#$client = new OAuthClient($key=$API_KEY, $secret=$SECRET);
#$client->login();
#$res = $client->accessResource(HttpRequest::METH_GET, 'http://api.douban.com/test?a=b&c=d');
#print "*********************\n";
#print $res;
#print "\n";
?>
