<?php

$AGENDA_FILE = "agenda.data";

function cmp($a, $b) {
        if($a['date'] == $b['date']) {
                return 0;
        }
        return ($a['date'] < $b['date']) ? -1 : 1;
}

/**
 * @param &$event
 * @param $date : YYYYMMDD
 * @param $periodic : is the event periodic (every year)
 * @param $name
 * @param $description
 */
function addEvent(&$events, $date, $periodic, $name, $description) {

        // Anti XSS
        if(!is_integer($date))
                return;
        if(!is_integer($periodic))
                return;
        $name = strip_tags($name);
        $name = strip_tags($description);

        $events[] = array("date"=>$date."2359", "periodic"=>$periodic, "name"=>$name, "descr"=>$description);
        uasort($events, 'cmp');
}

function displayEvent($date, $periodic, $name, $description) {
        $d = plxDate::date2Array($date);
        if($d['periodic'])
                echo '<h2>'.$d['day'].'/'.$d['month'].'/'.$d['year']." : $name</h2>";
        else
                echo '<h2>'.$d['day'].'/'.$d['month']." : $name</h2>";
        echo "<p>$description</p>";
}

function displayAgenda(&$events, $past) {
        foreach($events as $e) {
                if(($past && $e['date']+0 <= date('YmdHi')+0)
                        || (!$past && $e['date']+0 > date('YmdHi')+0))
                        displayEvent($e['date'], $e['periodic'], $e['name'], $e['descr']);
        }
}

function displayEventTitle($date, $periodic, $name, $description) {
        $d = plxDate::date2Array($date);
        if($periodic)
                echo '<b>'.$d['day'].'/'.$d['month']." : $name</b>";
        else
                echo '<b>'.$d['day'].'/'.$d['month'].'/'.$d['year']." : $name</b>";
}

function nextEvent(&$events) {
        foreach($events as $e) {
                displayEventTitle($e['date'], $e['periodic'], $e['name'], $e['descr']);
                return;
        }

        echo "Il n'y a pas d'événement prévu en ce moment.";
}
?>
