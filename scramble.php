<?php

/* 
 * This file will randomize the authors of the Topics and Replies created by the 
 * createTopics.php file. To do this, it will connect to the database directly via PDO.
 */

// Using generic vBulletin Utility Configuration file.
require_once ('vbutil_config.php');

$queries = [
  'nodes'       => 'SELECT nodeid FROM `' . $tablePrefix . 'node` WHERE contenttypeid=22',
  'users'       => 'SELECT count(*) as totalusers from `' . $tablePrefix . 'user`',
  'user'        => 'SELECT userid, username, ipaddress from `' . $tablePrefix . 'user` WHERE userid=?',
  'changenode'  => 'UPDATE `' . $tablePrefix . 'node` SET userid=?, authorname=?, ipaddress=? WHERE nodeid=?',
];

$pdoOptions = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES   => false,
];

$dsn = "mysql:host=$host;dbname=$database;charset=$charset";
try {
   $pdo = new PDO($dsn, $username, $password, $pdoOptions);
} catch (\PDOException $e) {
   throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$nodes = $pdo->query($queries['nodes']);
$users = $pdo->query($queries['users'])->fetch();
$counter=0;

foreach ($nodes as $node)
{
  
  $userid = mt_rand(1, $users['totalusers']);
  $stmt = $pdo->prepare($queries['user']);
  $stmt->execute([$userid]);
  $user = $stmt->fetch(); 

  echo 'Changing Node: ' . $node['nodeid'] . ' to User: ' . $user['username'] . " (" . $user ['userid'] . ")\n";
  $stmt2 = $pdo->prepare($queries['changenode']);
  $stmt2->execute([$user['userid'], $user['username'],$user['ipaddress'],$node['nodeid']]);
}