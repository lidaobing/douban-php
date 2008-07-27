<?php
require_once 'DouBan.php';

class TestDouBan
{
	protected $_client = null;

	public function __construct()
	{
		$this->_client = new Zend_Gdata_DouBan();
	}

	/*********************************************************/
	public function testPeople()
	{
		$peopleEntry = $this->_client->getPeople('ahbei');
		assert($peopleEntry->getId() == 'http://api.douban.com/people/1000001');
		
		print $peopleEntry->getTitle();
		print "\n";
		print $peopleEntry->getLocation();
		print "\n";
	}
	
	public function testSearchPeople()
	{
		$peopleFeed = $this->_client->searchPeople('ahbei', 2, 4);
		$arr = $peopleFeed->getEntry();
		$arr_title = array();
		foreach ($arr as $entry) {
			if ($entry->getTitle()) {
				$arr_title[] = $entry->getTitle()->getText();
			}
			print "\n";
		}
		var_dump($arr_title);
	}
	
	/***********************************************************/	
	public function testBook()
	{
		$bookEntry = $this->_client->getBook('2023013');
		assert($bookEntry->getId() == 'http://api.douban.com/book/subject/2023013');
		
		print "title=";
		print $bookEntry->getTitle();
		print "\n";

		print "summary=";
		print $bookEntry->getSummary();
		print "\n";
		
		print "attribute = ";
		print "\n";
		foreach ($bookEntry->getAttribute() as $attribute) {
			print $attribute->getName();
			print "\n";
			print $attribute->getText();
			print "\n";
		}
		
		print "rating = ";
		print "\n";
		print $bookEntry->getRating()->getMin();
		print "\n";
		print $bookEntry->getRating()->getMax();
		print "\n";
		print $bookEntry->getRating()->getNumRaters();
		print "\n";
		print $bookEntry->getRating()->getAverage();
		print "\n";
		print $bookEntry->getRating()->getValue();
		print "\n";
		
		print "tag = ";
		print "\n";
		foreach ($bookEntry->getTag() as $tag) {
			print $tag->getCount();
			print "\n";
			print $tag->getName();
			print "\n";
		}
	}

	public function testQueryBookByTag()
	{
		$bookFeed = $this->_client->queryBookByTag('boy', 1, 3);
		$arr = $bookFeed->getEntry();
		foreach ($arr as $entry) {
			if ($entry->getTitle()) {
				print $entry->getTitle();
			}
			print "\n";
		}
	}
	
	public function testSearchBook()
	{
		$bookFeed = $this->_client->searchBook('boy', 1, 3);
		$arr = $bookFeed->getEntry();
		foreach ($arr as $entry) {
			if ($entry->getTitle()) {
				print $entry->getTitle();
			}
			print "\n";
		}
	}
	
	/***********************************************************/	
	public function testMusic()
	{
		$musicEntry = $this->_client->getMusic('2272292');
		assert($musicEntry->getId() == 'http://api.douban.com/music/subject/2272292');
		
		print "title=";
		print $musicEntry->getTitle();
		print "\n";

		print "summary=";
		print $musicEntry->getSummary();
		print "\n";
		
		print "attribute = ";
		print "\n";
		foreach ($musicEntry->getAttribute() as $attribute) {
			print $attribute->getName();
			print "\n";
			print $attribute->getText();
			print "\n";
		}
		
		print "rating = ";
		print "\n";
		print $musicEntry->getRating()->getMin();
		print "\n";
		print $musicEntry->getRating()->getMax();
		print "\n";
		print $musicEntry->getRating()->getNumRaters();
		print "\n";
		print $musicEntry->getRating()->getAverage();
		print "\n";
		print $musicEntry->getRating()->getValue();
		print "\n";
		
		print "tag = ";
		print "\n";
		foreach ($musicEntry->getTag() as $tag) {
			print $tag->getCount();
			print "\n";
			print $tag->getName();
			print "\n";
		}
	}

	public function testQueryMusicByTag()
	{
		$musicFeed = $this->_client->queryMusicByTag('boy', 1, 3);
		$arr = $musicFeed->getEntry();
		foreach ($arr as $entry) {
			if ($entry->getTitle()) {
				print $entry->getTitle();
			}
			print "\n";
		}
	}
	
	public function testSearchMusic()
	{
		$musicFeed = $this->_client->searchmusic('boy', 1, 3);
		$arr = $musicFeed->getEntry();
		foreach ($arr as $entry) {
			if ($entry->getTitle()) {
				print $entry->getTitle();
			}
			print "\n";
		}
	}
	
	/***********************************************************/	
	public function testMovie()
	{
		$movieEntry = $this->_client->getMovie('1424406');
		assert($movieEntry->getId() == 'http://api.douban.com/movie/subject/1424406');
		
	#	print "title=";
	#	print $movieEntry->getTitle();
	#	print "\n";

	#	print "summary=";
	#	print $movieEntry->getSummary();
	#	print "\n";
	#	
	#	print "attribute = ";
	#	print "\n";
		foreach ($movieEntry->getAttribute() as $attribute) {
			if ($attribute->getName()) {
				print "name = ";
				print $attribute->getName();
				print "\n";
				print $attribute->getText();
				print "\n";
				
			}
			if ($attribute->getIndex()) {
				print "index = ";
				print $attribute->getIndex();
				print "\n";
				print $attribute->getText();
				print "\n";
				
			}
			if ($attribute->getLang()) {
				print "lang = ";
				print $attribute->getLang();
				print "\n";
				print $attribute->getText();
				print "\n";
				
			}
		}
		
		print "rating = ";
		print "\n";
		print $movieEntry->getRating()->getMin();
		print "\n";
		print $movieEntry->getRating()->getMax();
		print "\n";
		print $movieEntry->getRating()->getNumRaters();
		print "\n";
		print $movieEntry->getRating()->getAverage();
		print "\n";
		print $movieEntry->getRating()->getValue();
		print "\n";
		
		print "tag = ";
		print "\n";
		foreach ($movieEntry->getTag() as $tag) {
			print $tag->getCount();
			print "\n";
			print $tag->getName();
			print "\n";
		}
		
	}

	public function testQueryMovieByTag()
	{
		$movieFeed = $this->_client->queryMovieByTag('boy', 1, 3);
		$arr = $movieFeed->getEntry();
		foreach ($arr as $entry) {
			if ($entry->getTitle()) {
				print $entry->getTitle();
			}
			print "\n";
		}
	}
	
	public function testSearchMovie()
	{
		$movieFeed = $this->_client->searchmovie('boy', 1, 3);
		$arr = $movieFeed->getEntry();
		foreach ($arr as $entry) {
			if ($entry->getTitle()) {
				print $entry->getTitle();
			}
			print "\n";
		}
	}

	/***********************************************************/
	public function testGetTagFeed()
	{
		$tagFeed = $this->_client->getTagFeed('music', '2272292');
		$arr = $tagFeed->getEntry();
		print "111";
		print "\n";
		foreach ($arr as $entry) {
			if ($entry->getCount()) {
				print $entry->getCount()->getText();
			}
			print "\n";
		}
	}
	
	/***********************************************************/
	public function testGetReview()
	{
		$reviewEntry = $this->_client->getReview('1424406');
		
		print "rating = ";
		print "\n";
		print $reviewEntry->getRating()->getMin();
		print "\n";
		print $reviewEntry->getRating()->getMax();
		print "\n";
		print $reviewEntry->getRating()->getNumRaters();
		print "\n";
		print $reviewEntry->getRating()->getAverage();
		print "\n";
		print $reviewEntry->getRating()->getValue();
		print "\n";
		
		print "subject = ";
		print "\n";
		foreach ($reviewEntry->getSubject()->getAttribute() as $attribute) {
			if ($attribute->getName()) {
				print "name = ";
				print $attribute->getText();
				print "\n";
				
			}
			if ($attribute->getIndex()) {
				print "index = ";
				print $attribute->getText();
				print "\n";
				
			}
			if ($attribute->getLang()) {
				print "lang = ";
				print $attribute->getText();
				print "\n";
				
			}
		}
		
	}
	
	public function testGetMyReview()
	{
		$reviewFeed = $this->_client->getMyReview("ahbei");
		$arr = $reviewFeed->getEntry();
                foreach ($arr as $entry) {
                        if ($entry->getTitle()) {
                                print $entry->getTitle();
                        }
                        print "\n";
                }
	}

	/***********************************************************/
	public function testGetCollectionFeed()
	{
		$collectionFeed = $this->_client->getCollectionFeed("ahbei", "book");
		$arr = $collectionFeed->getEntry();
                foreach ($arr as $entry) {
                        if ($entry->getTitle()) {
				print "title = ";
                                print $entry->getTitle();
				print "\n";
                        }
			if ($entry->getRating()) {
				print "rating = ";
				print $entry->getRating()->getMin();
				print "\n";
				print $entry->getRating()->getMax();
				print "\n";
				print $entry->getRating()->getNumRaters();
				print "\n";
				print $entry->getRating()->getAverage();
				print "\n";
				print $entry->getRating()->getValue();
				print "\n";
			}
			if ($entry->getSubject()) {
				print "subject = ";
				print "\n";
				foreach ($entry->getSubject()->getAttribute() as $attribute) {
					if ($attribute->getName()) {
						print "name = ";
						print $attribute->getText();
						print "\n";
						
					}
					if ($attribute->getIndex()) {
						print "index = ";
						print $attribute->getText();
						print "\n";
						
					}
					if ($attribute->getLang()) {
						print "lang = ";
						print $attribute->getText();
						print "\n";
						
					}
				}
			}
                }
		
	}
}





$test = new TestDouBan();
#$$test->testPeople();
#$test->testSearchPeople();
#
#$test->testBook();
#$test->testQueryBookByTag();
#$test->testSearchBook();
#
$test->testMusic();
#$test->testQueryMusicByTag();
#$test->testSearchMusic();
#
#$test->testMovie();
#$test->testQueryMovieByTag();
#$test->testSearchMovie();
#
#$test->testGetTagFeed();
#
#$test->testGetReview();
#$test->testGetMyReview();
#
#$test->testGetCollectionFeed();

