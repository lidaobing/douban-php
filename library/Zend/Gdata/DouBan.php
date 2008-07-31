<?php

require_once 'Zend/Gdata.php';
require_once 'Zend/Gdata/App/Extension/Title.php';
require_once 'Zend/Gdata/App/Extension/Content.php';
require_once 'Zend/Gdata/Extension/Rating.php';
require_once 'Zend/Gdata/Query.php';
require_once 'DouBan/PeopleEntry.php';
require_once 'DouBan/PeopleFeed.php';
require_once 'DouBan/BookEntry.php';
require_once 'DouBan/BookFeed.php';
require_once 'DouBan/MusicEntry.php';
require_once 'DouBan/MusicFeed.php';
require_once 'DouBan/MovieEntry.php';
require_once 'DouBan/MovieFeed.php';
require_once 'DouBan/ReviewEntry.php';
require_once 'DouBan/ReviewFeed.php';
require_once 'DouBan/TagEntry.php';
require_once 'DouBan/TagFeed.php';
require_once 'DouBan/CollectionEntry.php';
require_once 'DouBan/CollectionFeed.php';
require_once 'DouBan/Subject.php';
require_once 'client.php';

class Zend_Gdata_DouBan extends Zend_Gdata
{
	const SERVER_URL = 'http://api.douban.com';
	protected $_APIKey = NULL;
	protected $_client = NULL;
	
	public static $namespaces = array(
		'db' => 'http://www.douban.com/xmlns/',
		'gd' => 'http://schemas.google.com/g/2005',
	);
	
	public function __construct($api_key = NULL, $secret = NULL)
    	{
		//FIXME
        	$this->registerPackage('Zend_Gdata_DouBan');
		$this->_client = new OAuthClient($api_key, $secret);
		$this->_APIKey = $api_key;
		parent::__construct(NULL,  $this->_APIKey);
    	}
	
	//API authorization
	public function getAuthorizationURL($api_key = NULL, $secret = NULL, $callback = NULL)
	{
		return $this->_client->getAuthorizationUrl($api_key, $secret, $callback);
	}
	
	public function programmaticLogin($token_key = NULL, $token_secret = NULL)
	{
		return $this->_client->login($token_key, $token_secret);
	}
	
	public function getEntry($url = NULL, $classname = NULL)
	{
		$auth_header_arr = $this->_client->getAuthHeader('GET', $url);
		$auth_header = $auth_header_arr[0];
		$header_str = $auth_header_arr[1];
		if ($auth_header) {
			if (stristr($url, '?')) {
				$url = $url . '&' . $header_str;
			} else {
				$url = $url . '?' . $header_str;
			}
		} 
	        else if ($this->_APIKey) {
			$param = 'apikey=' . urlencode($this->_APIKey);
			if (stristr($url, '?')) {
				$url = $url . '&' . $param;
			} else {
				$url = $url . '?' . $param;
			}
		}
		return parent::getEntry($url, $classname);
	}
	
        public function getFeed($url = NULL, $classname = NULL)
	{
		$auth_header_arr = $this->_client->getAuthHeader('GET', $url);
		$auth_header = $auth_header_arr[0];
		$header_str = $auth_header_arr[1];
		if ($auth_header) {
			if (stristr($url, '?')) {
				$url = $url . '&' . $header_str;
			} else {
				$url = $url . '?' . $header_str;
			}
		} 
	        else if ($this->_APIKey) {
			$param = 'apikey=' . urlencode($this->_APIKey);
			if (stristr($url, '?')) {
				$url = $url . '&' . $param;
			} else {
				$url = $url . '?' . $param;
			}
		}
		return parent::getFeed($url, $classname);
	}
	
  	public function Post($data = NULL, $url = NULL, $content_type = NULL, $extra_headers = NULL, $parameters = NULL)
	{
		if ($extra_headers == NULL) {
			$extra_headers = array();
		}
		$extra_headers_arr = $this->_client->getAuthHeader('POST', $url);
		$extra_headers = $extra_headers_arr[0];
		$header_str = $extra_headers_arr[1];
		$url = self::SERVER_URL . $url;
		$http_request = new HttpRequest($url, HttpRequest::METH_POST);
		$http_request->setRawPostData($data->saveXML());
		$http_request->addHeaders($extra_headers);
		$http_request->setContentType($content_type);
		$http_request->send();
		$result = new Zend_Gdata_DouBan_ReviewEntry();
		$result->transferFromXML($http_request->getResponseBody());
		return $result;
	}
	
	public  function Put()
	{//TODO

	}
	
	public  function Cut()
	{//TODO
	 //delete is a key word!
	}

	//people	
	public function getPeople($peopleId = NULL, $location = NULL)
	{
		if ($peopleId !== NULL) {
			$url = self::SERVER_URL . "/people/" . $peopleId;
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return $this->getEntry($url, 'Zend_Gdata_DouBan_PeopleEntry');
	}

	public function getPeopleFeed($location = NULL)
	{
		if ($location == NULL) {
			$url = self::SERVER_URI . "/people";
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return $this->getFeed($url, 'Zend_Gdata_DouBan_PeopleFeed');
	}
	
	public function searchPeople($queryText, $startIndex = NULL, $maxResults = NULL)
	{
		$query =new Zend_Gdata_Query(self::SERVER_URL . "/people");
		$query->setQuery($queryText);
		$query->setMaxResults($maxResults);
		$query->setStartIndex($startIndex);
		return $this->getPeopleFeed($query);
		
	}
	
	//book	
	public function getBook($bookId = NULL, $location = NULL)
	{
		if ($bookId !== NULL) {
			$url = self::SERVER_URL . "/book/subject/" . $bookId;
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return $this->getEntry($url, 'Zend_Gdata_DouBan_BookEntry');
	}

	public function getBookFeed($location = NULL)
	{
		if ($location == NULL) {
			$url = self::PEOPLE_URI . "/book/subjects";
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return $this->getFeed($url, 'Zend_Gdata_DouBan_BookFeed');
	}
	
	public function searchBook($queryText, $startIndex = NULL, $maxResults = NULL)
	{
		$query = new Zend_Gdata_Query(self::SERVER_URL . "/book/subjects");
		$query->setQuery($queryText);
		$query->setMaxResults($maxResults);
		$query->setStartIndex($startIndex);
		return $this->getBookFeed($query);
		
	}
	
	public function queryBookByTag($tag, $startIndex = NULL, $maxResults = NULL)
	{
		$query = new Zend_Gdata_Query(self::SERVER_URL . "/book/subjects");
		$query->setParam('tag', $tag);
		$query->setMaxResults($maxResults);
		$query->setStartIndex($startIndex);
		return $this->getBookFeed($query);
	
	}
	
	//music
	public function getMusic($musicId = NULL, $location = NULL)
	{
		if ($musicId !== NULL) {
			$url = self::SERVER_URL . "/music/subject/" . $musicId;
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return $this->getEntry($url, 'Zend_Gdata_DouBan_MusicEntry');
	}

	public function getMusicFeed($location = NULL)
	{
		if ($location == NULL) {
			$url = self::PEOPLE_URI . "/music/subjects";
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return $this->getFeed($url, 'Zend_Gdata_DouBan_MusicFeed');
	}
	
	public function searchMusic($queryText, $startIndex = NULL, $maxResults = NULL)
	{
		$query = new Zend_Gdata_Query(self::SERVER_URL . "/music/subjects");
		$query->setQuery($queryText);
		$query->setMaxResults($maxResults);
		$query->setStartIndex($startIndex);
		return $this->getMusicFeed($query);
		
	}
	
	public function queryMusicByTag($tag, $startIndex = NULL, $maxResults = NULL)
	{
		$query = new Zend_Gdata_Query(self::SERVER_URL . "/music/subjects");
		$query->setParam('tag', $tag);
		$query->setMaxResults($maxResults);
		$query->setStartIndex($startIndex);
		return $this->getMusicFeed($query);
	
	}
	
	//movie
	public function getMovie($movieId = NULL, $location = NULL)
	{
		if ($movieId !== NULL) {
			$url = self::SERVER_URL . "/movie/subject/" . $movieId;
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return $this->getEntry($url, 'Zend_Gdata_DouBan_MovieEntry');
	}

	public function getMovieFeed($location = NULL)
	{
		if ($location == NULL) {
			$url = self::PEOPLE_URL . "/movie/subjects";
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return $this->getFeed($url, 'Zend_Gdata_DouBan_MovieFeed');
	}
	
	public function searchMovie($queryText, $startIndex = NULL, $maxResults = NULL)
	{
		$query = new Zend_Gdata_Query(self::SERVER_URL . "/movie/subjects");
		$query->setQuery($queryText);
		$query->setMaxResults($maxResults);
		$query->setStartIndex($startIndex);
		return $this->getMovieFeed($query);
		
	}
	
	public function queryMovieByTag($tag, $startIndex = NULL, $maxResults = NULL)
	{
		$query = new Zend_Gdata_Query(self::SERVER_URL . "/movie/subjects");
		$query->setParam('tag', $tag);
		$query->setMaxResults($maxResults);
		$query->setStartIndex($startIndex);
		return $this->getMovieFeed($query);
	
	}

	//tags
	public function getTagFeed($category = NULL, $subjectId = NULL)
	{
		if (($subjectId != NULL) && ($category != NULL)) {
			$url = self::SERVER_URL . "/" . $category . "/subject/" . $subjectId . "/tags";
		}
		return $this->getFeed($url, 'Zend_Gdata_DouBan_TagFeed');
	}
	
	//review
	public function getReview($reviewId = NULL, $location = NULL)
	{
		if ($reviewId !== NULL) {
			$url = self::SERVER_URL . "/review/" . $reviewId;
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return $this->getEntry($url, 'Zend_Gdata_DouBan_ReviewEntry');
	}
	
	public function getReviewFeed($location = NULL)
	{
		if ($location == NULL) {
			$url = self::PEOPLE_URL . "/review";
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return $this->getFeed($url, 'Zend_Gdata_DouBan_ReviewFeed');
	}

	public function getMyReview($myId = NULL, $location = NULL)
	{
		if ($myId != NULL) {
			$url = self::SERVER_URL . "/people/" . $myId . "/reviews";
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return $this->getFeed($url, 'Zend_Gdata_DouBan_ReviewFeed');
	}
	
	public function createReview($title = NULL, $content = NULL, $subject = NULL, $rating = NULL)
	{
		$sub_id =  $subject->getId();
		$sub_rating =  $subject->getRating();
		$subject = new Zend_Gdata_DouBan_Subject();
		$subject->setId($sub_id);
		$subject->setRating($sub_rating);
		$entry = new Zend_Gdata_DouBan_ReviewEntry();
		$rating = new Zend_Gdata_DouBan_Extension_Rating($rating);
		$entry->setSubject($subject);
		if ($rating) {
			$entry->setRating($rating);
		}
		$title = new Zend_Gdata_App_Extension_Title($title);
		$content = new Zend_Gdata_App_Extension_Content($content);
		$entry->setContent($content);
		$entry->setTitle($title);
		return $this->Post($entry, "/reviews", "application/atom+xml; charset=utf-8");
	}

	public function updateReview()
	{//TODO

	}
	
	public function deleteReview()
	{//TODO

	}

	//collection
	public function getCollection()
	{//TODO

	}
	
	public function getCollectionFeed($peopleId = NULL, $cat = NULL)
	{
		if ($peopleId !== NULL) {
			$url = self::SERVER_URL . "/people/" . $peopleId . "/collection?cat=" . $cat;
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return $this->getEntry($url, 'Zend_Gdata_DouBan_CollectionFeed');

	}
	
	public function getMyCollection()
	{//TODO

	}
	
	public function addCollection()
	{//TODO

	}
	
	public function updateCollection()
	{//TODO

	}
	
	public function deleteCollection()
	{//TODO

	}
}
?>
