<?php
include 'config/config.php';

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