<?php
define('ID', 1);

require_once 'athletescan.civix.php';

/**
 * Implementation of hook_civicrm_config
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function athletescan_civicrm_config(&$config) {
  _athletescan_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function athletescan_civicrm_xmlMenu(&$files) {
  _athletescan_civix_civicrm_xmlMenu($files);
}

/**
 * Implementation of hook_civicrm_install
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function athletescan_civicrm_install() {
  _athletescan_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function athletescan_civicrm_uninstall() {
  _athletescan_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function athletescan_civicrm_enable() {
  _athletescan_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function athletescan_civicrm_disable() {
  _athletescan_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function athletescan_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _athletescan_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function athletescan_civicrm_managed(&$entities) {
  _athletescan_civix_civicrm_managed($entities);
}

/**
 * Implementation of hook_civicrm_caseTypes
 *
 * Generate a list of case-types
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function athletescan_civicrm_caseTypes(&$caseTypes) {
  _athletescan_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implementation of hook_civicrm_alterSettingsFolders
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function athletescan_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _athletescan_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_validateForm().
 *
 * @param string $formName
 * @param array $fields
 * @param array $files
 * @param CRM_Core_Form $form
 * @param array $errors
 */
function athletescan_civicrm_validateForm($formName, &$fields, &$files, &$form, &$errors) {
  if ($formName == "CRM_Contribute_Form_Contribution_Main" && $form->_id == ID) {
    if (!array_key_exists('is_recur', $fields)) {
      $errors['is_recur'] = ts('Please choose if you want to contribute this amount automatically every year or if you wish to be prompted at the next payment.');
    }
  }
}

/**
 * Implementation of hook_civicrm_alterSettingsFolders
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function athletescan_civicrm_buildForm($formName, &$form) {
  if ($formName == "CRM_Contribute_Form_Contribution_Main" && $form->_id == ID) {
    if (CRM_Utils_Array::value('is_recur', $form->_submitValues)) {
      $form->assign('recur_selected', TRUE);
    }
  }
}

/**
 * Implementation of hook_civicrm_alterCalculatedMembershipStatus
 *
 * @param array $membershipStatus the calculated membership status array
 * @param array $arguments arguments used in the calculation
 * @param array $membership the membership array from the calling function
 */
function athletescan_civicrm_alterCalculatedMembershipStatus(&$membershipStatus, $arguments, $membership) {
  if (empty($arguments['membership_type_id']) || !in_array($arguments['membership_type_id'], array(1))) {
    return;
  }
  if (empty($membership['membership_id'])) {
    return;
  }
  // Get retirement date.
  $cid = CRM_Core_DAO::singleValueQuery("SELECT contact_id FROM civicrm_membership WHERE id = " . $membership['membership_id']);
  $retirementDate = CRM_Core_DAO::singleValueQuery("SELECT retirement_date_42 FROM civicrm_value_athlete_info_33 WHERE entity_id = $cid");
  if (empty($retirementDate)) {
    return;
  }
  $statusDate = $arguments['status_date'];
  $endDate = $arguments['end_date'];
  $expiryDate = date("Ymd", strtotime(date("Y-m-d", strtotime($retirementDate)) . " + 8 year"));

  if ($statusDate > $endDate && $statusDate >= $expiryDate) {
    $membershipStatus['name'] = 'Expired';
    $membershipStatus['id'] = 4;
  }
  if ($statusDate > $endDate && $statusDate <= $expiryDate) {
    $membershipStatus['name'] = 'Current';
    $membershipStatus['id'] = 2;
  }
}

function athletescan_civicrm_pageRun(&$page) {
  if (get_class($page) == "CRM_Contact_Page_View_Summary") {
    $cid = $page->getVar('_contactId');
    $demographics = CRM_Core_DAO::executeQuery("SELECT gender_id, birth_date FROM civicrm_contact WHERE id = $cid")->fetchAll()[0];
    if (empty($demographics['gender_id'])) {
      $page->assign('hideGender', TRUE);
    }
    if (empty($demographics['birth_date'])) {
      $page->assign('hideDOB', TRUE);
    }

    // Check if custom data present for contact.
    $table = "civicrm_value_status_31";
    $column = "status_non_member_40";
    $status = CRM_Core_DAO::singleValueQuery("SELECT $column FROM $table WHERE entity_id = $cid");
    if (!$status) {
      $page->assign('isHide', TRUE);
    }
    else {
      $page->assign('hidemember', TRUE);
    }
    $columnMember = "membership_or_other_status_37";
    $statusMember = CRM_Core_DAO::singleValueQuery("SELECT $columnMember FROM $table WHERE entity_id = $cid");
    if ($statusMember) {
      $page->assign('hidenonmember', TRUE);
    }
    $statusesToIgnore = [
      'id',
      'entity_id',
      'membership_or_other_status_37',
      'status_non_member_40',
      'ability_41',
      'sport_43',
      'discipline_44',
    ];
    $selectedStatus = CRM_Core_DAO::executeQuery("SELECT * FROM $table WHERE entity_id = $cid")->fetchAll()[0];
    if (empty($selectedStatus)) {
      //$page->assign('hideStatus', TRUE);
    }
    $athTable = "civicrm_value_athlete_info_33";
    $selectedAth = CRM_Core_DAO::executeQuery("SELECT * FROM $athTable WHERE entity_id = $cid")->fetchAll()[0];
    if (!empty($selectedAth)) {
      $selectedStatus = array_merge($selectedStatus, $selectedAth);
    }
    else {
      $page->assign('hideAth', TRUE);
    }
    // More athlete info.
    $infoTable = "civicrm_value_more_athlete__35";
    $infoColumn = "other_name_95";
    $infoStatus = CRM_Core_DAO::singleValueQuery("SELECT $infoColumn FROM $infoTable WHERE entity_id = $cid");
    if (empty($infoStatus)) {
      $page->assign('hideInfo', TRUE);
    }
    foreach ($selectedStatus as $key => $value) {
      if ($value != '0' && empty($value) && !array_key_exists($key, array_flip($statusesToIgnore))) {
        $label = CRM_Core_DAO::singleValueQuery("SELECT label FROM civicrm_custom_field WHERE column_name = '$key'");
        $fieldsToHide[$key] = $label;
      }
    }
    $page->assign('fieldsToHide', json_encode($fieldsToHide));
    CRM_Core_Region::instance('page-body')->add(array(
      'template' => 'CRM/AC/ContactSummary.tpl',
    ));
  }
}
