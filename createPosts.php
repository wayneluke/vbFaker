<?php

/* Creates a random number of topics. Each topic will have between 0 and 120 replies. Users for each post are randomly selected from a subset of usergroups.

Make sure to set the arrays of channels and posters in your config.php file.

*/

$topicLimit = [
	'min' => 5000,
	'max' => 25000,
];

function random_user() {
	global $mysql;
	global $posters;

	$query = "SELECT userid, username, usergroupid FROM USER WHERE usergroupid IN (" . "'" . implode("','", $posters) . "'" . ") ORDER BY RAND() LIMIT 1";

	$conn = new mysqli($mysql['servername'], $mysql['username'], $mysql['password'], $mysql['dbname']);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$result = $conn->query($query);
	$row = $result->fetch_assoc();
	$conn->close();

	return $row;
}

class topicBuilder
{

	protected $faker;

	public function __construct () 
	{
		// use the factory to create a Faker\Generator instance
		$this->faker = Faker\Factory::create();
  }
  
	protected function createFirstPost($channelid, $title, $text)
	{
		$tags='';
		$tagC=0;
		$timeNow=time();

		$words = preg_split('/[\ \n\r\,\.]+/', $text, -1, PREG_SPLIT_NO_EMPTY);
		while ($tagC < 5) {
			$key = array_rand($words);
			if (strlen($words[$key]) > 3) {
				$tags .= $words[$key] . ',';
				$tagC++;
			}
		}
		$tags = rtrim($tags,',');

		$textData = [
			'parentid' => $channelid,
			'title' => $title,
			'rawtext' => $text,
			'tags' => $tags,
			'created' => $timeNow,
			'published' => $timeNow,
			];

		 	$options = [
		  	'nl2br' => true,
			];

		return vB_Api::instanceInternal('Content_Text')->add($textData, $options);
	}

	protected function createReply($channelid, $firstpostid, $text)
	{
		$timeNow=time();

		$textData = [
			'channelid' => $channelid,
			'parentid' => $firstpostid,
			'rawtext' => $text,
			'nl2br' => true,
			'created' => $timeNow,
			'published' => $timeNow,
		];

		$options = [
			'nl2br' => true,
		];

			return vB_Api::instanceInternal('Content_Text')->add($textData, $options);
	}

	protected function createThread($channelid, $title, $text, $replyCount = 5)
	{
		$nodeid = $this->createFirstPost($channelid, $title, $text);
		echo "Created topic (nodeid:$nodeid) (Title:$title)\n";
		//sleep(60);
		for ($i = 1; $i <= $replyCount; ++$i)
		{
			$user = random_user();
			if ($user['usergroupid'] == 15) {
				$replyCount=0;
			}
			vB::getRequest()->createSessionForUser($user['userid']);
			$reply = "This is reply $i to thread \"$title\"\n\n";
			$characters = mt_rand(10,1000);
			$reply .= $this->faker->text($characters);
			$replynodeid = $this->createReply($channelid, $nodeid, $reply);
			echo "Added reply #$i (nodeid:$replynodeid author:" . $user['userid'] . ") to thread (nodeid:$nodeid)\n";
			//sleep(5);
		}

		return $nodeid;
	}

	public function createThreads($channelid, $threadCount = 5, $replyCount = 5)
	{
		for ($i = 1; $i <= $threadCount; ++$i)
		{
			$user = random_user();
			vB::getRequest()->createSessionForUser($user['userid']);
			$ident = substr(md5(microtime(true) . uniqid('', true)), 0, 5);
      		$title = $this->faker->words(3, true);
      		$paragraphs = mt_rand(5, 15);
			$text = $this->faker->paragraphs($paragraphs, true);
			$this->createThread($channelid, $title, $text, $replyCount);
		}
	}
}

function process($channels)
{
	$topics = new topicBuilder;

	try 
	{
		$key= array_rand($channels);
		$topics->createThreads($channels[$key], 1);
	}
	catch (vB_Exception_Database $e)
	{
		echo "Database Error: " . $e->getMessage() . "\n";
	}
	catch (Exception $e)
	{
		echo "Hit an exception: " . $e->getMessage() . "\n";
	}

}

// require the Faker autoloader
require_once __DIR__ . '/vendor/autoload.php';
// alternatively, use another PSR-4 compliant autoloader


//$mainForum = vB_Api::instanceInternal('Content_Channel')->fetchChannelIdByGUID(vB_Channel::MAIN_FORUM);


$maxtopics = mt_rand($topicLimit['min'],$topicLimit['max']);
echo 'Creating ' . $maxtopics . ' topics' . "\n\r";
sleep(1);

//$lgtopic = new topicBuilder;
//$lgtopic->createThreads(62, 1, 7500);
//die();

for ($topic = 1; $topic <= $maxtopics; ++$topic) {
	$topics = new topicBuilder;
	//init the system
	require_once('config.php');
	require_once($core . 'vb/vb.php');
	vB::init();

	vB::setRequest(new vB_Request_Cli());

	try 
	{
		$key= array_rand($channels);
		$replies = mt_rand(0,120);
		$topics->createThreads($channels[$key], 1, $replies);
	}
	catch (vB_Exception_Database $e)
	{
		echo "Database Error: " . $e->getMessage() . "\n";
	}
	catch (Exception $e)
	{
		echo "Hit an exception: " . $e->getMessage() . "\n";
	}

	$topics=null;
	gc_collect_cycles();

}
echo "Completed \n";
