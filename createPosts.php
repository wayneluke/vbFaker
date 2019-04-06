<?php

$channels = [3];

$topics = [
	'min' => 10000,
	'max' => 50000,
];

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
		$textData = [
			'parentid' => $channelid,
			'title' => $title,
      'rawtext' => $text,
			'tags' => 'tagone,tagtwo,tagthree,tagfour,tagfive',
    ];
    
    $options = [
      'nl2br' => true,
    ];

		return vB_Api::instanceInternal('Content_Text')->add($textData, $options);
	}

	protected function createReply($channelid, $firstpostid, $text)
	{
		$textData = [
			'channelid' => $channelid,
			'parentid' => $firstpostid,
      'rawtext' => $text,
      'nl2br' => true,
    ];

    $options = [
      'nl2br' => true,
    ];

    return vB_Api::instanceInternal('Content_Text')->add($textData, $options);
	}

	protected function createThread($channelid, $title, $text, $replyCount = 3)
	{
		$nodeid = $this->createFirstPost($channelid, $title, $text);
		echo "Created topic (nodeid:$nodeid) (Title:$title)\n";

		for ($i = 1; $i <= $replyCount; ++$i)
		{
      $reply = "This is reply #$i to thread \"$title\"\n\n";
      $characters = mt_rand(10,1000);
      $reply .= $this->faker->text($characters);
			$replynodeid = $this->createReply($channelid, $nodeid, $reply);
			echo "Added reply #$i (nodeid:$replynodeid) to thread (nodeid:$nodeid)\n";
		}

		return $nodeid;
	}

	public function createThreads($channelid, $threadCount = 5)
	{

    for ($i = 1; $i <= $threadCount; ++$i)
		{
			$replyCount = mt_rand(1,50);
			$ident = substr(md5(microtime(true) . uniqid('', true)), 0, 5);
      $title = $this->faker->words(3, true);
      $paragraphs = mt_rand(5, 15);
			$text = $this->faker->paragraphs($paragraphs, true);
			$this->createThread($channelid, $title, $text, $replyCount);
		}
	}
}

// require the Faker autoloader
require_once __DIR__ . '/vendor/autoload.php';
// alternatively, use another PSR-4 compliant autoloader


//init the system
require_once('../vb/vb.php');
vB::init();

vB::setRequest(new vB_Request_Test(
	array(
		'userid' => 1,
		'ipAddress' => '127.0.0.1',
		'altIp' => '127.0.0.1',
		'userAgent' => 'CLI'
	)
));
vB::getRequest()->createSession();

//$mainForum = vB_Api::instanceInternal('Content_Channel')->fetchChannelIdByGUID(vB_Channel::MAIN_FORUM);
$topics = new topicBuilder;

$maxtopics = mt_rand($topics['min'],$topics['max']);

echo 'Creating ' . $maxtopics . ' topics' . "\n\r";
sleep(2);

$topic = 0;
while ($topic++ < $maxtopics) {
	try 
	{
    $key= array_rand($channels);
		$topics->createThreads($channels[$key], 1);
	}
	catch (vB_Exception_Database $e)
	{
		echo "Hit an exception: " . $e->getMessage() . "\n";
	}
	catch (Exception $e)
	{
		echo "Hit an exception: " . $e->getMessage() . "\n";
	}
}
echo "Completed \n";
