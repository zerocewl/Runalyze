<?php
/**
 * This file contains class::MultiImporterFormular
 * @package Runalyze\Import
 */
/**
 * Formular to import multiple trainings
 *
 * @author Hannes Christiansen
 * @package Runalyze\Import
 */
class MultiImporterFormular extends Formular {
	/**
	 * Training objects
	 * @var array[TrainingObject]
	 */
	protected $TrainingObjects = array();

	/**
	 * Construct a new formular
	 * @param string $action
	 * @param string $method 
	 */
	public function __construct($action = '', $method = 'post') {
		parent::__construct($action, $method);

		$this->init();
	}

	/**
	 * Init
	 */
	protected function init() {
		$this->setId('multi-importer');
		$this->addCSSclass('ajax');
		$this->addHiddenValue('multi-importer', 'true');
	}

	/**
	 * Set objects
	 * @param array[TrainingObject] $TrainingObjects
	 */
	public function setObjects(array $TrainingObjects) {
		$this->TrainingObjects = $TrainingObjects;

		$this->initForObjects();
	}

	/**
	 * Init for given objects
	 */
	protected function initForObjects() {
		$Fieldset = new FormularFieldset( __('Choose activities') );
		$Fieldset->addBlock( $this->getFieldsetBlock() );
		$Fieldset->setHtmlCode( $this->getConfigCode() );

		$this->addFieldset($Fieldset);
		$this->addSubmitButton( __('Import selected activities') );
		$this->addHiddenValue('number-of-trainings', count($this->TrainingObjects));
	}

	/**
	 * Get fieldset block
	 * @return string
	 */
	private function getFieldsetBlock() {
		$String = '';

		$String .= HTML::info( sprintf( __('Found %s activities.'), count($this->TrainingObjects)) );
		$String .= '<table class="fullwidth multi-import-table zebra-style c" id="multi-import-table">';
		$String .= '<thead><tr><th>'.__('Import').'</th><th>'.__('Date').'</th><th>'.__('Duration').'</th><th>'.__('Distance').'</th><th colspan="4"></th></tr></thead>';
		$String .= '<tbody>';

		foreach ($this->TrainingObjects as $i => $TrainingObject)
			$String .= '<tr>'.$this->getTableRowFor($TrainingObject, $i).'</tr>';

		$String .= '</tbody>';
		$String .= '</table>';

		$String .= Ajax::wrapJSforDocumentReady('
			$("#multi-import-table td").click(function(e){
				if ($(e.target).closest(\'input[type="checkbox"]\').length == 0)
					$(this).parent().find(\'input:checkbox\').attr(\'checked\', !$(this).parent().find(\'input:checkbox\').attr(\'checked\'));
			});
		');

		return $String;
	}

	/**
	 * Get table row for training
	 * @param TrainingObject $TrainingObject
	 * @param int $i
	 */
	private function getTableRowFor(TrainingObject &$TrainingObject, $i) {
		$TrainingObject->updateAfterParsing();

		$Data  = urlencode(serialize($TrainingObject->getArray()));

		$Inputs  = HTML::checkBox('training-import['.$i.']', true);
		$Inputs .= HTML::hiddenInput('training-data['.$i.']', $Data);

		$Row  = '<td>'.$Inputs.'</td>';
		$Row .= '<td>'.$TrainingObject->DataView()->getDate().'</td>';
		$Row .= '<td>'.Time::toString(round($TrainingObject->getTimeInSeconds()), true, true).'</td>';
		$Row .= '<td>'.$TrainingObject->DataView()->getDistanceStringWithFullDecimals().'</td>';
		$Row .= '<td>'.$TrainingObject->Sport()->IconWithTooltip().'</td>';
		$Row .= '<td>'.$TrainingObject->DataView()->getPulseIcon().'</td>';
		$Row .= '<td>'.$TrainingObject->DataView()->getSplitsIcon().'</td>';
		$Row .= '<td>'.$TrainingObject->DataView()->getMapIcon().'</td>';

		return $Row;
	}

	/**
	 * Get config code
	 * @return string
	 */
	private function getConfigCode() {
		$Input = new FormularCheckbox('multi-edit', __('Show multi editor afterwards'), true);
		$Input->setLayout( FormularFieldset::$LAYOUT_FIELD_W100 );

		return $Input->getCode();
	}
}