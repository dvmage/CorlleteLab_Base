<?php
$this->startSetup();

Mage::getModel('core/config_data')
        ->setScope('default')
        ->setPath('clbase/feed/installed')
        ->setValue(time())
        ->save(); 

$feedData = array();
$feedData[] = array(
    'severity'      => 4,
    'date_added'    => gmdate('Y-m-d H:i:s', time()),
    'title'         => 'CorlleteLab\'s extension has been installed. Check the Admin > Configuration > CorlleteLab section.',
    'description'   => 'You can see versions of the installed extensions right in the admin, as well as configure notifications about major updates.',
    'url'           => 'http://corllete.com/news/updates-and-notifications-configuration.html'
);

Mage::getModel('adminnotification/inbox')->parse($feedData);

$this->endSetup();