<?php

require_once 'Zend/Gdata.php';
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
require_once 'client.php';

class Zend_Gdata_DouBan extends Zend_Gdata
{
	const SERVER_URL = 'http://api.douban.com';
	protected $_APIKey = null;
	protected $_client = null;
	
	public static $namespaces = array(
		'db' => 'http://www.douban.com/xmlns/',
		'gd' => 'http://schemas.google.com/g/2005',
	);
	
	public function __construct($api_key = null, $secret = null)
    	{
		//FIXME
        	$this->registerPackage('Zend_Gdata_DouBan');
		$this->_client = new OAuthClient($api_key, $secret);
		$this->_APIKey = $api_key;
		parent::__construct($this->_client, $this->_APIKey);
    	}
	
	//API authorization
	public function getAuthorizationURL($api_key = null, $secret = null, $callback = null)
	{
		return $this->_client->getAuthorizationUrl($api_key, $secret, $callback);
	}
	
	public function programmaticLogin($token_key = null, $token_secret = null)
	{
		return $this->_client->login($token_key, $token_secret);
	}
	
	public function Post()
	{//TODO

	}
	
	public  function Put()
	{//TODO

	}
	
	public  function Cut()
	{//TODO
	 //delete is a key word!
	}

	//people	
	public function getPeople($peopleId = null, $location = null)
	{
		if ($peopleId !== null) {
			$url = self::SERVER_URL . "/people/" . $peopleId;
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return parent::getEntry($url, 'Zend_Gdata_DouBan_PeopleEntry');
	}

	public function getPeopleFeed($location = null)
	{
		if ($location == null) {
			$url = self::SERVER_URI . "/people";
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return parent::getFeed($url, 'Zend_Gdata_DouBan_PeopleFeed');
	}
	
	public function searchPeople($queryText, $startIndex = null, $maxResults = null)
	{
		$query =new Zend_Gdata_Query(self::SERVER_URL . "/people");
		$query->setQuery($queryText);
		$query->setMaxResults($maxResults);
		$query->setStartIndex($startIndex);
		return $this->getPeopleFeed($query);
		
	}
	
	//book	
	public function getBook($bookId = null, $location = null)
	{
		if ($bookId !== null) {
			$url = self::SERVER_URL . "/book/subject/" . $bookId;
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return parent::getEntry($url, 'Zend_Gdata_DouBan_BookEntry');
	}

	public function getBookFeed($location = null)
	{
		if ($location == null) {
			$url = self::PEOPLE_URI . "/book/subjects";
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return parent::getFeed($url, 'Zend_Gdata_DouBan_BookFeed');
	}
	
	public function searchBook($queryText, $startIndex = null, $maxResults = null)
	{
		$query = new Zend_Gdata_Query(self::SERVER_URL . "/book/subjects");
		$query->setQuery($queryText);
		$query->setMaxResults($maxResults);
		$query->setStartIndex($startIndex);
		return $this->getBookFeed($query);
		
	}
	
	public function queryBookByTag($tag, $startIndex = null, $maxResults = null)
	{
		$query = new Zend_Gdata_Query(self::SERVER_URL . "/book/subjects");
		$query->setParam('tag', $tag);
		$query->setMaxResults($maxResults);
		$query->setStartIndex($startIndex);
		return $this->getBookFeed($query);
	
	}
	
	//music
	public function getMusic($musicId = null, $location = null)
	{
		if ($musicId !== null) {
			$url = self::SERVER_URL . "/music/subject/" . $musicId;
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return parent::getEntry($url, 'Zend_Gdata_DouBan_MusicEntry');
	}

	public function getMusicFeed($location = null)
	{
		if ($location == null) {
			$url = self::PEOPLE_URI . "/music/subjects";
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return parent::getFeed($url, 'Zend_Gdata_DouBan_MusicFeed');
	}
	
	public function searchMusic($queryText, $startIndex = null, $maxResults = null)
	{
		$query = new Zend_Gdata_Query(self::SERVER_URL . "/music/subjects");
		$query->setQuery($queryText);
		$query->setMaxResults($maxResults);
		$query->setStartIndex($startIndex);
		return $this->getMusicFeed($query);
		
	}
	
	public function queryMusicByTag($tag, $startIndex = null, $maxResults = null)
	{
		$query = new Zend_Gdata_Query(self::SERVER_URL . "/music/subjects");
		$query->setParam('tag', $tag);
		$query->setMaxResults($maxResults);
		$query->setStartIndex($startIndex);
		return $this->getMusicFeed($query);
	
	}
	
	//movie
	public function getMovie($movieId = null, $location = null)
	{
		if ($movieId !== null) {
			$url = self::SERVER_URL . "/movie/subject/" . $movieId;
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return parent::getEntry($url, 'Zend_Gdata_DouBan_MovieEntry');
	}

	public function getMovieFeed($location = null)
	{
		if ($location == null) {
			$url = self::PEOPLE_URL . "/movie/subjects";
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return parent::getFeed($url, 'Zend_Gdata_DouBan_MovieFeed');
	}
	
	public function searchMovie($queryText, $startIndex = null, $maxResults = null)
	{
		$query = new Zend_Gdata_Query(self::SERVER_URL . "/movie/subjects");
		$query->setQuery($queryText);
		$query->setMaxResults($maxResults);
		$query->setStartIndex($startIndex);
		return $this->getMovieFeed($query);
		
	}
	
	public function queryMovieByTag($tag, $startIndex = null, $maxResults = null)
	{
		$query = new Zend_Gdata_Query(self::SERVER_URL . "/movie/subjects");
		$query->setParam('tag', $tag);
		$query->setMaxResults($maxResults);
		$query->setStartIndex($startIndex);
		return $this->getMovieFeed($query);
	
	}

	//tags
	public function getTagFeed($category = null, $subjectId = null)
	{
		if (($subjectId != null) && ($category != null)) {
			$url = self::SERVER_URL . "/" . $category . "/subject/" . $subjectId . "/tags";
		}
		return parent::getFeed($url, 'Zend_Gdata_DouBan_TagFeed');
	}
	
	//review
	public function getReview($reviewId = null, $location = null)
	{
		if ($reviewId !== null) {
			$url = self::SERVER_URL . "/review/" . $reviewId;
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return parent::getEntry($url, 'Zend_Gdata_DouBan_ReviewEntry');
	}
	
	public function getReviewFeed($location = null)
	{
		if ($location == null) {
			$url = self::PEOPLE_URL . "/review";
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return parent::getFeed($url, 'Zend_Gdata_DouBan_ReviewFeed');
	}

	public function getMyReview($myId = null, $location = null)
	{
		if ($myId != null) {
			$url = self::SERVER_URL . "/people/" . $myId . "/reviews";
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return parent::getFeed($url, 'Zend_Gdata_DouBan_ReviewFeed');
	}
	
	public function createReview()
	{//TODO
	
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
	
	public function getCollectionFeed($peopleId = null, $cat = null)
	{
		if ($peopleId !== null) {
			$url = self::SERVER_URL . "/people/" . $peopleId . "/collection?cat=" . $cat;
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return parent::getEntry($url, 'Zend_Gdata_DouBan_CollectionFeed');

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
