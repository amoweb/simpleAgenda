<?php if(!defined('PLX_ROOT')) exit; ?>

<h2><?php $plxPlugin->lang('L_TITLE') ?></h2>

<?php

include("functions.inc.php");

$pathAgenda = PLX_PLUGINS.'simpleAgenda/'.$AGENDA_FILE;

$cal = array();
if(file_exists($pathAgenda)) {
        $cal = unserialize(file_get_contents($pathAgenda));
}

$defPeriodic = false;
$defDate = "";
$defName = "";
$defDescription = "";

// Suppression d'un événement
if(isset($_POST['rmevt'])) {
        foreach($cal as $k=>$e) {
                $d = $cal[$k]['date'];
                if(isset($_POST['rm'.$k.$d])) {
                        $defPeriodic = $cal[$k]['periodic'];
                        $defDate = $d;
                        $defName = $cal[$k]['name'];
                        $defDescription = $cal[$k]['descr'];
                        unset($cal[$k]);
                        echo "<p>Suppression d'un évènement.</p>";
                }
        }

        file_put_contents($pathAgenda, serialize($cal));
}

// Ajouter d'un événement
if(isset($_POST['addevt'])) {
        $periodic = 0;
        if(isset($_POST['periodic'])) {
                $periodic = 1;
                $_POST['annee'] = 2099;
        }

        if($_POST['nom'] == "") {
                ?> <p>Le nom ne peut pas être vide.</p> <?php
        } elseif(!plxDate::checkDate($_POST['jours'], $_POST['mois'], $_POST['annee'], "23:59") ) {
                //?> <p>Format de date non valide</p> <?php
        } else {
                $date = $_POST['annee'].$_POST['mois'].$_POST['jours']."00";
                addEvent($cal, $date, $periodic, $_POST['nom'], $_POST['description']);

                file_put_contents($pathAgenda, serialize($cal));
                echo "<p>Événement ajouté.</p>";
        }
}

?>

<h3>Gestion des événements</h3>

<?php if($defDate != "") {
                $d = plxDate::date2Array($defDate);
        }
?>
<form action="" method="post">
        <fieldset style="width:490px; margin: auto; text-align:right;">
                <legend>Ajouter un évènement</legend>
                <input name="addevt" value="42" type="hidden" />
                <label for="nom">Nom</label>
                <input id="nom" name="nom" type="text" value="<?php echo $defName; ?>" /><br />
                <label for="description">Description</label>
                <input id="description" name="description" type="text" value="<?php echo $defDescription; ?>" /><br />
                Date (JJ MM AAAA)
                <input id="jours" name="jours" type="text" size="2" maxlength="2" value="<?php if($defDate != "") echo $d['day']; ?>"/>
                <input id="mois" name="mois" type="text" size="2" maxlength="2" value="<?php if($defDate != "") echo $d['month']; ?>" /><input id="annee" name="annee" type="text" size="4" maxlength="4" value="<?php if($defDate != "") echo $d['year']; ?>" /><br />
                Chaque année : <input type="checkbox" name="periodic" id="periodic" value="periodic" <?php if($defPeriodic) echo "checked" ; ?> /><br />
                <input type="submit" value="Ajouter" /><br />
        </fieldset>
</form>

<form action="" method="post">
        <fieldset style="width:490px; margin: auto; text-align:left;">
                <legend>Liste des événements</legend>
                <input name="rmevt" value="42" type="hidden" />
                <?php
                        foreach($cal as $k=>$e) {
                                $periodic = $e['periodic'];
                                $date = $e['date'];
                                $name = $e['name'];
                                $description = $e['descr'];
                                $d = plxDate::date2Array($date);
                                echo '<p>';
                                echo '<input name="rm'.$k.$date.'" type="submit" value="X" />&nbsp;';
                                if($periodic)
                                        echo $d['day'].'/'.$d['month']." : $name : </h2>";
                                else
                                        echo $d['day'].'/'.$d['month'].'/'.$d['year']." : $name : </h2>";
                                echo "$description";
                                echo '</p>';

                        }
                ?>
        </fieldset>
</form>
