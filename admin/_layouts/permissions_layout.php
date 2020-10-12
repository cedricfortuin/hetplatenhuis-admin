<?php
include_once 'config/config.php';
include_once 'models/define_variables.php';

if(userRole === 'visitor')
{
    $isDisabledForVisitors = true;
} else {
    $isDisabledForVisitors = false;
}

if (userRole === 'visitor' || userRole === 'subadmin')
{
    $isDisabledForVisitorsAndSubadmins = true;
} else {
    $isDisabledForVisitorsAndSubadmins = false;
}
?>