<?php
// Init the VB API system
    require_once('config.php');
    
    require_once($core."includes/config.php");
    require_once($core."vb/vb.php");
    
    vB::init();
    
    vB::setRequest(new vB_Request_Web());
    
    $user['userid'] = 1;
    
    vB::getRequest()->createSessionForUser($user['userid']);
    
    $title = "Rob Automated Event 3";
    $now = new DateTime();
    $date = $now->getTimestamp();
    
    $textData['parentid']        = 17131;
    $textData['authorname']        = "Rob Musquetier (41157)";
    $textData['userid']         = 33;
    $textData['ipaddress']        = "188.90.37.51";
    $textData['protected']        = 0;
    $textData['prefixid']        = "";
    $textData['iconid']            = 0;
    $textData['lastupdate']        = time();
    $textData['created']        = time();
    $textData['publishdate']    = time();
    $textData['showpublished']    = 1;
    $textData['viewperms']        = 2;
    $textData['featured']        = 0;
    $textData['htmltitle']        = $title;
    $textData['title']            = $title;
    $textDAta['description']    = "This is an automatically generated test event";
    $textData['urlident']        = str_replace(" ", "-", strtolower($title));
    $textData['contenttypeid']  = 21;
    
    // Set event data
    $textData['location']        = "Limmen";
    $textData['allday']            = true;
    $textData['eventstartdate']    = $date;
    $textData['eventenddate']    = $date;
    $textData['ignoredst']        = true;
    $textData['rawtext']        = "12345";
    
    $options=[];
    
    $result = vB_Api::instanceInternal('Content_Event')->add($textData, $options);
    if (empty($result) || !empty($result['errors'])) {
        echo "Failed adding the event.";
    }
    else {
        echo "Node ID: " . $result;
    }  
