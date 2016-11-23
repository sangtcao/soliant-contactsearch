<?php
/**
 * Autoloader; automatically attempts to load undefined classes.
 */
function __autoload($class_name) {
    require_once $class_name . '.php';
}

$contacts = new ContactSearch('sample_data.csv');
$data = $contacts->getContacts();
$contacts->getByEmail('AmyJGhent@dayrep.com');
echo'<br><br>';
$contacts->getByEmail('TeresaCMcCrea@teleworm.us');
echo'<br><br>';
$contacts->getByEmail('WilliamLShryock@rhyta.com');
echo'<br><br>';
$contacts->getByEmail('LisaESauceda@armyspy.com');
echo'<br><br>';
$contacts->getByLastInitial('s');