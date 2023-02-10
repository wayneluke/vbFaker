<?php
/*
 * Creates a random number of users and inserts them into the selected
 * database. Users include first name, last name, email address, password,
 * and an IP address.
 * 
 * Example User: 
 * "Cassandre Wisozk"	"cassandre.wisozk@yahoo.com"	"46.172.244.164"
 * 
 * Note: Users if verify email is turned on for registration, users will be placed in 
 * Users Awaiting Email Confirmation. You will need to manually move them.
 */

################# Set Variables ############################
// How many users? 
$limits = [
	'min' => 1500,
	'max' => 6000,
];


################# START SCRIPT ############################

function buildUser($switchLocale=false)
{
	$locales = ['en_US','en_GB','fr_CA','vi_VN','es_ES','es_ES','es_ES','en_US','en_US','en_US','en_US','en_US','en_US','en_US','en_US','en_US',];

	$newUser = [];	
	$percentage=0;

	$locale = 'en_US';

	if ($switchLocale) 
	{
		$key=array_rand($locales);
		$locale = $locales[$key];
	}

	// Init Faker
	$faker = Faker\Factory::create($locale);

	$newUser['username'] = $faker->firstname . ' ' . $faker->lastname;
	
	// encourage a mix of free email providers and random domains.
	$percentage = mt_rand (1,100);
	$emailType = $percentage < 60 ? 'freeEmailDomain' : 'domainName';
	$email = str_replace([' ', '\''],['.',''],$newUser['username']) . '@' . $faker->$emailType;
	setlocale(LC_ALL, 'de_DE');
    $newUser['email'] = strtolower(iconv('UTF-8', 'utf-8//TRANSLIT', $email));

	$birthday = $faker->dateTimeBetween('-80 years','-15 years');
	$newUser['birthday'] = $birthday->format('m-d-Y');
	
	$percentage = mt_rand (1,100);
	$ipType = $percentage < 85 ? 'ipv4' : 'ipv6';
	$newUser['ipaddress'] = $faker->$ipType;

	// Users should be placed in multiple usergroups. 
	// This is configured for a vBulletin installation with two custom usergroups
	// These custom usergroups are usergroupid 14 and usergroupid 15. 
	// If you don't want to use custom usergroups, you will need to adjust the switch below. 
	
	$groupChance=mt_rand(1,100);
	switch (true) {
		case ($groupChance < 4): 
			$newUser['usergroupid']=8;
			break;
		case ($groupChance < 10):
			$newUser['usergroupid']=3;
			break;
		case ($groupChance < 20):
			$newUser['usergroupid']=4;
			break;
		case ($groupChance < 30):
			$newUser['usergroupid']=14;
			break;
		case ($groupChance < 40):
				$newUser['usergroupid']=15;
				break;
		default:
			$newUser['usergroupid']=2;
			break;
	}

	unset($faker);
	return $newUser;
}

function getPassword()
{
	// Init Faker
	$faker = Faker\Factory::create('en_US');

	return $faker->password;
}

function createUser($count, $userApi)
{
	$user = buildUser(true);
	
	echo $count . ' - Creating user ' . $user['username'] . " (" . $user['email'] . ")\n";
	
	try 
	{
		$userId = $userApi->save(0, getPassword(), $user, array(), array(), array());
	} 	
	catch (vB_Exception_Database $e)
	{
		echo "Hit an exception: " . $e->getMessage() . "\n";
	}
	catch (Exception $e)
	{
		echo "Hit an exception: " . $e->getMessage() . "\n";
	}

	$user = NULL;
}
// require the autoloader to start Faker
require_once __DIR__ . '/vendor/autoload.php';

//init the vBulletin system
require_once('config.php');
require_once($core . 'vb/vb.php');
vB::init();

vB::setRequest(new vB_Request_Cli());

vB::getRequest()->createSessionForUser(1);
vB::getCurrentSession()->fetchCpsessionHash();


$maxUsers= mt_rand ($limits['min'], $limits['max']);

$userApi = vB_Api::instance('user');
echo 'Attempting to create ' . $maxUsers . ' Users.' . "\n";
sleep(2);

$users=0;
while($users++ <= $maxUsers)
{
	createUser($users, $userApi);
}

echo "Completed \n";