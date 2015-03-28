<?php
include_once("functions.inc.php");

global $AGENDA_FILE;

$pathAgenda = PLX_PLUGINS.'/simpleAgenda/'.$AGENDA_FILE;

$cal = array();

if(file_exists($pathAgenda)) {
        $cal = unserialize(file_get_contents($pathAgenda));
}

if($DISLAY_FULL_AGENDA) {
        displayAgenda($cal, false);
} else {
        nextEvent($cal);
}

?>
