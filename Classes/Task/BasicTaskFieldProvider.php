<?php
namespace Wills\WillsBlackboards\Task;

use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Messaging\FlashMessage;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 David Schneiderbauer <david.schneiderbauer@Wills.at>, Wills OG
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * FieldProvider for HashMailImporterTask
 *
 * @package WillsHashmail
 * @license http://www.gnu.org/licenses/lgpl.html
 *          GNU Lesser General Public License, version 3 or later
 */
abstract class BasicTaskFieldProvider implements \TYPO3\CMS\Scheduler\AdditionalFieldProviderInterface {

  /**
   * Field prefix
   *
   * @var string
   */
  private $fieldPrefix;

  /**
   * Additional fields
   *
   * @var array
   */
  private $fields;

  public function __construct($fieldPrefix, $fields) {
    $this->fieldPrefix = $fieldPrefix;
    $this->fields = $fields;
  }

  /**
	 * Gets additional fields to render in the form to add/edit a task
	 *
	 * @param array $taskInfo Values of the fields from the add/edit task form
	 * @param \TYPO3\CMS\Scheduler\Task\AbstractTask $task The task object being edited. Null when adding a task!
	 * @param \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject Reference to the scheduler backend module
	 * @return array A two dimensional array, array('Identifier' => array('fieldId' => array('code' => '', 'label' => '', 'cshKey' => '', 'cshLabel' => ''))
	 */
  public function getAdditionalFields(array &$taskInfo, $task, \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject) {
    if ($parentObject->CMD === 'edit') {
      foreach($this->fields as $field => $fieldConf) {
        $getter = 'get'. ucfirst($field);
        $taskInfo[$field] = $task->$getter();
      }
    }

    $additionalFields = array();
    foreach($this->fields as $field => $fieldConf) {
      $taskInfo[$field] = !empty($taskInfo[$field]) ? $taskInfo[$field] : $fieldConf['defaultValue'];

      $getter = 'get'. ucfirst($fieldConf['type']) .'FieldConfiguration';
      $fieldInfo = $this->$getter(
        array(
          'name' => $field,
          'value' => $taskInfo[$field]
        )
      );

      $additionalFields[$fieldInfo['id']] = array(
        'code' => $fieldInfo['html'],
        'label' => ucfirst(preg_replace('/(?<!\ )[A-Z]/', ' $0', $fieldInfo['id'])),
        'cshKey' => 'task.'. $fieldInfo['id'] .'.description',
        'cshLabel' => $fieldInfo['id']
      );
    }

    return $additionalFields;
  }

  /**
	 * Validates the additional fields' values
	 *
	 * @param array $submittedData An array containing the data submitted by the add/edit task form
	 * @param \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject Reference to the scheduler backend module
	 * @return boolean true if validation was ok (or selected class is not relevant), false otherwise
	 */
  public function validateAdditionalFields(array &$submittedData, \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject) {
    $valid = true;

    foreach($this->fields as $field => $fieldConf) {
      if (!is_array($fieldConf['validation'])) {
        continue;
      }
      foreach($fieldConf['validation'] as $validation) {
        switch ($validation) {
          case 'required':
            if (empty($submittedData[$this->fieldPrefix][$field])) {
              $parentObject->addMessage(ucfirst($field) .' is required', FlashMessage::ERROR);
              $valid = false;
            }
            break;
          case 'email':
            if ($fieldConf['type'] === 'textarea') {
              foreach(GeneralUtility::trimExplode(LF, $submittedData[$this->fieldPrefix][$field], true) as $index => $email) {
                if (!GeneralUtility::validEmail($email)) {
                  $parentObject->addMessage($index + 1 .'. line in '. ucfirst($field) .' is not a valid email address', FlashMessage::ERROR);
                  $valid = false;
                }
              }
            } else {
              if (!GeneralUtility::validEmail($submittedData[$this->fieldPrefix][$field])) {
                $parentObject->addMessage(ucfirst($field) .' is not a valid email address', FlashMessage::ERROR);
                $valid = false;
              }
            }
            break;
        }
      }
    }

    return $valid;
  }

  /**
	 * Takes care of saving the additional fields' values in the task's object
	 *
	 * @param array $submittedData An array containing the data submitted by the add/edit task form
	 * @param \TYPO3\CMS\Scheduler\Task\AbstractTask $task Reference to the scheduler backend module
	 * @return void
	 */
  public function saveAdditionalFields(array $submittedData, \TYPO3\CMS\Scheduler\Task\AbstractTask $task) {
    foreach($this->fields as $field => $fieldConf) {
      $setter = 'set'. ucfirst($field);
      $task->$setter($submittedData[$this->fieldPrefix][$field]);
    }
  }

  private function getFieldConfiguration($field) {
    return array(
      'id' => $field['name'],
      'name' => $this->getPrefixedFieldName($field['name'])
    );
  }

  private function getInputFieldConfiguration($field, $type) {
    $fieldConf = $this->getFieldConfiguration($field);
    $fieldConf['html'] = '<input type="'. $type .'" name="'. $fieldConf['name'] .'" id="'. $fieldConf['id'] .'" value="'. htmlspecialchars($field['value']) .'">';

    return $fieldConf;
  }

  private function getInputTextFieldConfiguration($field) {
    return $this->getInputFieldConfiguration($field, 'text');
  }

  private function getInputPasswordFieldConfiguration($field) {
    return $this->getInputFieldConfiguration($field, 'password');
  }

  private function getTextareaFieldConfiguration($field) {
    $fieldConf = $this->getFieldConfiguration($field);
    $fieldConf['html'] = '<textarea rows="5" cols="50" name="'. $fieldConf['name'] .'" id="'. $fieldConf['id'] .'">'. htmlspecialchars($field['value']) .'</textarea>';

    return $fieldConf;
  }

  private function getCheckboxFieldConfiguration($field) {
    $fieldConf = $this->getFieldConfiguration($field);
    $fieldConf['html'] = '<input type="checkbox" name="'. $fieldConf['name'] .'" id="'. $fieldConf['id'] .'" value="checked" '. ($field['value'] ? 'checked' : '') .'>';

    return $fieldConf;
  }

  private function getPrefixedFieldName($name) {
    return 'tx_scheduler['. $this->fieldPrefix .']['. $name .']';
  }

}
