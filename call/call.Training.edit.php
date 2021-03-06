<?php
/**
 * Display formular for editing a training
 * Call:   call/call.Training.edit.php?id=
 */
require '../inc/class.Frontend.php';

$Frontend = new Frontend();

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
	$Deleter = new TrainingDeleter((int)$_GET['delete']);
	$Deleter->delete();

	echo '<div class="panel-content"><p id="submit-info" class="error">'.__('The training has been removed').'</p></div>';
	echo '<script>$("#multi-edit-'.((int)$_GET['delete']).'").remove();Runalyze.Statistics.resetUrl();Runalyze.reloadContent();</script>';
	exit();
}

$Training = new TrainingObject(Request::sendId());
echo $Training->Linker()->editNavigation();

echo '<div class="panel-heading">';
echo '<h1>'.$Training->DataView()->getTitleWithCommentAndDate().'</h1>';
echo '</div>';
echo '<div class="panel-content">';

$Formular = new TrainingFormular($Training, StandardFormular::$SUBMIT_MODE_EDIT);
$Formular->setId('training');
$Formular->setLayoutForFields( FormularFieldset::$LAYOUT_FIELD_W50 );
$Formular->display();

echo '</div>';