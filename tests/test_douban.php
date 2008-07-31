<?php
require_once 'Zend/Gdata/DouBan.php';

$API_KEY = '698805e0675f9cb33c9811a1361ed619';
$SECRET = '4b3ef67ecd3ffe21';

class TestDouBan
{
	protected $_client = null;
        const TOKEN_KEY = '4c45a313637835afe4d0e93a2a68a10d';
        const TOKEN_SECRET = '47ffe601bdffa302';

	public function __construct($api, $secret)
	{
		$this->_client = new Zend_Gdata_DouBan($api, $secret);
                $this->_client->programmaticLogin(self::TOKEN_KEY, self::TOKEN_SECRET);
	}

	/*********************************************************/
	public function testPeople()
	{
		$peopleEntry = $this->_client->getPeople('ahbei');
		assert ($peopleEntry->getId() == 'http://api.douban.com/people/1000001');
		assert ($peopleEntry->getLocation()->getText() == '北京');
		assert ($peopleEntry->getTitle()->getText() == '阿北');
	}
	
	public function testSearchPeople()
	{
		$peopleFeed = $this->_client->searchPeople('ahbei', 2, 4);
		$arr = $peopleFeed->getEntry();
		$arr_title = array();
		foreach ($arr as $entry) {
			if ($entry->getTitle()) {
				$arr_title[$entry->getTitle()->getText()] = 1;
			}
		}
		assert (array_key_exists('阿北', $arr_title));
	}
	
	/***********************************************************/	
	public function testBook()
	{
		$bookEntry = $this->_client->getBook('2023013');
		assert($bookEntry->getId() == 'http://api.douban.com/book/subject/2023013');
		
		$arr_name = array();
		$arr_text = array();
		foreach ($bookEntry->getAttribute() as $attribute) {
			$arr_name[$attribute->getName()] = 1;
			$arr_text[$attribute->getText()] = 1;
		}
		assert (array_key_exists("isbn10", $arr_name));
		assert (array_key_exists("7543639130", $arr_text));
		assert (array_key_exists("isbn13", $arr_name));
		assert (array_key_exists("9787543639133", $arr_text));
		assert (array_key_exists("pages", $arr_name));
		assert (array_key_exists("193", $arr_text));
		assert (array_key_exists("translator", $arr_name));
		assert (array_key_exists("张兴", $arr_text));
		assert (array_key_exists("price", $arr_name));
		assert (array_key_exists("14.0", $arr_text));
		assert (array_key_exists("author", $arr_name));
		assert (array_key_exists("片山恭一", $arr_text));
		assert (array_key_exists("publisher", $arr_name));
		assert (array_key_exists("青岛出版社", $arr_text));
		assert (array_key_exists("binding", $arr_name));
		assert (array_key_exists("平装", $arr_text));
		assert (array_key_exists("pubdate", $arr_name)); 
		assert (array_key_exists("2007-01-01", $arr_text));
		
		assert ($bookEntry->getRating()->getMin() == "1");
		assert ($bookEntry->getRating()->getMax() == "5");
		assert ($bookEntry->getRating()->getNumRaters() == "22");
		assert ($bookEntry->getRating()->getAverage() == "3.59");

		$arr_count = array();
		$arr_namefc = array();
		foreach ($bookEntry->getTag() as $tag) {
			$arr_count[$tag->getCount()] = 1;
			$arr_namefc[$tag->getName()] = 1;
		}
		assert (array_key_exists("32", $arr_count));
		assert (array_key_exists("片山恭一", $arr_namefc));
		assert (array_key_exists("12", $arr_count));
		assert (array_key_exists("日本文学", $arr_namefc));
		assert (array_key_exists("32", $arr_count));
		assert (array_key_exists("小说", $arr_namefc));
		assert (array_key_exists("10", $arr_count));
		assert (array_key_exists("日本小说", $arr_namefc));
		assert (array_key_exists("7", $arr_count));
		assert (array_key_exists("日本", $arr_namefc));
	}

	public function testQueryBookByTag()
	{
		$bookFeed = $this->_client->queryBookByTag('boy', 1, 3);
		$arr_title = array();
		$arr = $bookFeed->getEntry();
		foreach ($arr as $entry) {
			if ($entry->getTitle()) {
				$arr_title[$entry->getTitle()->getText()] = 1;
			}
		}
		assert (array_key_exists("男孩的冒险书", $arr_title));
		assert (array_key_exists("A Long Way Gone", $arr_title));
		assert (array_key_exists("The Lost Boy", $arr_title));
	}
	
	public function testSearchBook()
	{
		$bookFeed = $this->_client->searchBook('boy', 1, 3);
		$arr = $bookFeed->getEntry();
		$arr_title = array();
		foreach ($arr as $entry) {
			if ($entry->getTitle()) {
				$arr_title[$entry->getTitle()->getText()] = 1;
			}
		}
		assert (array_key_exists("BOY圣子到", $arr_title));
		assert (array_key_exists("娼年Call Boy", $arr_title));
		assert (array_key_exists("D-Boys - D-Boys", $arr_title));
	}
	
	/***********************************************************/	
	public function testMusic()
	{
		$musicEntry = $this->_client->getMusic('2272292');
		assert ($musicEntry->getId() == 'http://api.douban.com/music/subject/2272292');
		assert ($musicEntry->getTitle()->getText() == "无与伦比的美丽");
		$arr_name = array();
		$arr_text = array();
		foreach ($musicEntry->getAttribute() as $attribute) {
			$arr_name[$attribute->getName()] = 1;
			$arr_text[$attribute->getText()] = 1;
		}
		assert (array_key_exists("discs", $arr_name));
		assert (array_key_exists("1", $arr_text));
		assert (array_key_exists("ean", $arr_name));
		assert (array_key_exists("tu130639", $arr_text));
		assert (array_key_exists("pubdate", $arr_name));
		assert (array_key_exists("2007-11-02", $arr_text));
		assert (array_key_exists("title", $arr_name));
		assert (array_key_exists("无与伦比的美丽", $arr_text));
		assert (array_key_exists("singer", $arr_name));
		assert (array_key_exists("苏打绿", $arr_text));
	
		assert ($musicEntry->getRating()->getMin() == "1");
		assert ($musicEntry->getRating()->getMax() == "5");
		assert ($musicEntry->getRating()->getAverage() == "4.20");

		$arr_count = array();
		$arr_namefc = array();
		foreach ($musicEntry->getTag() as $tag) {
			$arr_count[$tag->getCount()] = 1;
			$arr_namefc[$tag->getName()] = 1;
		}
		assert (array_key_exists("苏打绿", $arr_namefc));
		assert (array_key_exists("无与伦比的美丽", $arr_namefc));
		assert (array_key_exists("台湾", $arr_namefc));
		
	}

	public function testQueryMusicByTag()
	{
		$musicFeed = $this->_client->queryMusicByTag('boy', 1, 3);
		$arr = $musicFeed->getEntry();
		$arr_title = array();
		foreach ($arr as $entry) {
			if ($entry->getTitle()) {
				$arr_title[$entry->getTitle()->getText()] = 1;
			}
		}
		assert (array_key_exists("The Boy with No Name", $arr_title));
		assert (array_key_exists("The Boy Who Couldn't Stop Dreaming", $arr_title));
		assert (array_key_exists("Soul Boy", $arr_title));
	}
	
	public function testSearchMusic()
	{
		$musicFeed = $this->_client->searchmusic('boy', 1, 3);
		$arr = $musicFeed->getEntry();
		$arr_title = array();
		foreach ($arr as $entry) {
			if ($entry->getTitle()) {
				$arr_title[$entry->getTitle()->getText()] = 1;
			}
		}
		assert (array_key_exists("Soul Boy", $arr_title));
		assert (array_key_exists("Boy", $arr_title));
		assert (array_key_exists("Backstreet Boys", $arr_title));
	}
	
	/***********************************************************/	
	public function testMovie()
	{
		$movieEntry = $this->_client->getMovie('1424406');
		assert($movieEntry->getId() == 'http://api.douban.com/movie/subject/1424406');
		
		assert ($movieEntry->getTitle()->getText() == "Cowboy Bebop");

		$arr_text = array();
		$arr_name = array();
		$arr_index = array();
		$arr_lang = array();
		foreach ($movieEntry->getAttribute() as $attribute) {
			if ($attribute->getName()) {
				$arr_name[$attribute->getName()] = 1;
				$arr_text[$attribute->getText()] = 1;
			}
			if ($attribute->getIndex()) {
				$arr_index[$attribute->getIndex()] = 1;
				$arr_text[$attribute->getText()] = 1;
				
			}
			if ($attribute->getLang()) {
				$arr_lang[$attribute->getLang()] = 1;
				$arr_text[$attribute->getText()] = 1;
				
			}
		}
		assert (array_key_exists("pubdate", $arr_name));
		assert (array_key_exists("title", $arr_name));
		assert (array_key_exists("director", $arr_name));
		assert (array_key_exists("episodes", $arr_name));
		assert (array_key_exists("language", $arr_name));
		assert (array_key_exists("website", $arr_name));
		assert (array_key_exists("zh_CN", $arr_lang));
		assert (array_key_exists("1998", $arr_text));
		assert (array_key_exists("Cowboy Bebop", $arr_text));
		assert (array_key_exists("渡边信一郎", $arr_text));
		assert (array_key_exists("26", $arr_text));
		assert (array_key_exists("日语", $arr_text));
		assert (array_key_exists("http://www.cowboybebop.org/", $arr_text));
		assert (array_key_exists("赏金猎人", $arr_text));
	       
		assert ($movieEntry->getRating()->getMin() == "1");
		assert ($movieEntry->getRating()->getMax() == "5");
		assert ($movieEntry->getRating()->getAverage() == "4.74");
		
		$arr_count = array();
		$arr_namefc = array();
		foreach ($movieEntry->getTag() as $tag) {
			$arr_count[$tag->getCount()] = 1;
			$arr_namefc[$tag->getName()] = 1;
		}
		assert (array_key_exists("渡边信一郎", $arr_namefc));
		assert (array_key_exists("动画", $arr_namefc));
		assert (array_key_exists("cowboy", $arr_namefc));
		assert (array_key_exists("日本", $arr_namefc));

		
	}

	public function testQueryMovieByTag()
	{
		$movieFeed = $this->_client->queryMovieByTag('boy', 1, 3);
		$arr = $movieFeed->getEntry();
		$arr_title = array();
		foreach ($arr as $entry) {
			if ($entry->getTitle()) {
				$arr_title[$entry->getTitle()->getText()] = 1;
			}
		}
		assert (array_key_exists("About a Boy", $arr_title));
		assert (array_key_exists("It's a Boy Girl Thing", $arr_title));
		assert (array_key_exists("Old Boy", $arr_title));

	}
	
	public function testSearchMovie()
	{
		$movieFeed = $this->_client->searchmovie('boy', 1, 3);
		$arr = $movieFeed->getEntry();
		$arr_title = array();
		foreach ($arr as $entry) {
			if ($entry->getTitle()) {
				$arr_title[$entry->getTitle()->getText()] = 1;
			}
		}
		assert (array_key_exists("Old Boy", $arr_title));
		assert (array_key_exists("Water boys", $arr_title));
		assert (array_key_exists("Bad Boys", $arr_title));
	}

	/***********************************************************/
	public function testGetTagFeed()
	{
		$tagFeed = $this->_client->getTagFeed('music', '2272292');
		$arr = $tagFeed->getEntry();
		$arr_count = array();
		foreach ($arr as $entry) {
			if ($entry->getCount()) {
				$arr_count[$entry->getCount()->getText()] = 1;
			}
		}
		assert (array_key_exists("1203", $arr_count));
		assert (array_key_exists("579", $arr_count));
	}
	
	/***********************************************************/
	public function testGetReview()
	{
		$reviewEntry = $this->_client->getReview('1424406');
		
		assert ($reviewEntry->getRating()->getMin() == "1");
		assert ($reviewEntry->getRating()->getMax() == "5");
		assert ($reviewEntry->getRating()->getValue() == "3");
		
		$arr_text = array();
		$arr_name = array();
		$arr_index = array();
		$arr_lang = array();
		foreach ($reviewEntry->getSubject()->getAttribute() as $attribute) {
			if ($attribute->getName()) {
				$arr_name[$attribute->getName()] = 1;
				$arr_text[$attribute->getText()] = 1;
			}
			if ($attribute->getIndex()) {
				$arr_index[$attribute->getIndex()] = 1;
				$arr_text[$attribute->getText()] = 1;
				
			}
			if ($attribute->getLang()) {
				$arr_lang[$attribute->getLang()] = 1;
				$arr_text[$attribute->getText()]  = 1;
				
			}
		}
		assert (array_key_exists("2007", $arr_text));
		assert (array_key_exists("香港", $arr_text));
		assert (array_key_exists("粤语", $arr_text));
		assert (array_key_exists("徐子珊", $arr_text));
		assert (array_key_exists("吴卓羲", $arr_text));
		assert (array_key_exists("马浚伟", $arr_text));
		assert (array_key_exists("廖碧儿", $arr_text));
		assert (array_key_exists("杨思琦", $arr_text));
		assert (array_key_exists("米雪", $arr_text));
		assert (array_key_exists("岳华", $arr_text));
	}
	
	public function testGetMyReview()
	{
		$reviewFeed = $this->_client->getMyReview("ahbei");
		$arr = $reviewFeed->getEntry();
		$arr_title = array();
		foreach ($arr as $entry) {
                        if ($entry->getTitle()) {
                                $arr_title[$entry->getTitle()->getText()] = 1;
                        }
		}
		assert (array_key_exists("永玉寓言", $arr_title));
		assert (array_key_exists("长尾年代", $arr_title));
		assert (array_key_exists("看自己的妻子长大", $arr_title));
		assert (array_key_exists("伪书一号", $arr_title));
	}

	public function testCreateReview()
	{
		$bookEntry = $this->_client->getBook("1489401");
		$entry = $this->_client->createReview("it's so so good!", "it's very good good goodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgoodgood", $bookEntry, "4");
		assert ($entry->getTitle() == "it's so so good!");
	}
	/***********************************************************/
	public function testGetCollectionFeed()
	{
		$collectionFeed = $this->_client->getCollectionFeed("ahbei", "book");
		$arr = $collectionFeed->getEntry();
		$arr_title = array();
		$arr_rating_min = array();
		$arr_rating_max = array();
		$arr_rating_numraters = array();
		$arr_rating_average = array();
		$arr_rating_value = array();
		$arr_subject_name = array();
		$arr_subject_index = array();
		$arr_subject_lang = array();
                foreach ($arr as $entry) {
                        if ($entry->getTitle()) {
                                $arr_title[$entry->getTitle()->getText()] = 1;
                        }
			if ($entry->getRating()) {
				$arr_rating_min[$entry->getRating()->getMin()] = 1;
				$arr_rating_max[$entry->getRating()->getMax()] = 1;
				$arr_rating_numraters[$entry->getRating()->getNumRaters()] = 1;
				$arr_rating_average[$entry->getRating()->getAverage()] = 1;
				$arr_rating_value[$entry->getRating()->getValue()] = 1;
			}
			if ($entry->getSubject()) {
				foreach ($entry->getSubject()->getAttribute() as $attribute) {
					if ($attribute->getName()) {
						$arr_subject_name[$attribute->getText()] = 1;
						
					}
					if ($attribute->getIndex()) {
						$arr_subject_index[$attribute->getText()] = 1;
					}
					if ($attribute->getLang()) {
						$arr_subject_lang[$attribute->getText()] = 1;
						
					}
				}
			}
		}
		assert(array_key_exists("阿北 读过 Ambient Findability", $arr_title));
		assert(array_key_exists("1", $arr_rating_min));
		assert(array_key_exists("5", $arr_rating_max));
		assert(array_key_exists("3", $arr_rating_value));
		assert(array_key_exists("0596007655", $arr_subject_name));
		assert(array_key_exists("9780596007652", $arr_subject_name));
		assert(array_key_exists("Peter Morville", $arr_subject_name));
		assert(array_key_exists("USD 29.95", $arr_subject_name));
		assert(array_key_exists("O'Reilly Media, Inc.", $arr_subject_name));
		assert(array_key_exists("阿北 读过 Small Is Beautiful", $arr_title));
		assert(array_key_exists("1", $arr_rating_min));
		assert(array_key_exists("5", $arr_rating_max));
		assert(array_key_exists("5", $arr_rating_value));
		assert(array_key_exists("0060916303", $arr_subject_name));
		assert(array_key_exists("9780060916305", $arr_subject_name));
		assert(array_key_exists("E. F. Schumacher", $arr_subject_name));
		assert(array_key_exists("USD 14.00", $arr_subject_name));
		assert(array_key_exists("Harper Perennial", $arr_subject_name));
		
	}
}





$test = new TestDouBan($API_KEY, $SECRET);
$test->testPeople();
$test->testSearchPeople();

$test->testBook();
$test->testQueryBookByTag();
$test->testSearchBook();

$test->testMusic();
$test->testQueryMusicByTag();
$test->testSearchMusic();

$test->testMovie();
$test->testQueryMovieByTag();
$test->testSearchMovie();

$test->testGetTagFeed();

$test->testGetReview();
$test->testGetMyReview();
$test->testCreateReview();

$test->testGetCollectionFeed();

