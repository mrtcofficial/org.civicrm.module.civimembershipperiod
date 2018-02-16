<?php
/*
 +--------------------------------------------------------------------+
 | CiviCRM version 4.6                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2015                                |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the GNU Affero General Public License           |
 | Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the GNU Affero General Public License for more details.        |
 |                                                                    |
 | You should have received a copy of the GNU Affero General Public   |
 | License and the CiviCRM Licensing Exception along                  |
 | with this program; if not, contact CiviCRM LLC                     |
 | at info[AT]civicrm[DOT]org. If you have questions about the        |
 | GNU Affero General Public License or the licensing of CiviCRM,     |
 | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
 +--------------------------------------------------------------------+
 */
require_once 'civimembershipperiod.include.php';

/**
 * Implements hook_civicrm_install().
 */
function civimembershipperiod_civicrm_install() {
  return _civimembershipperiod_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 */
function civimembershipperiod_civicrm_uninstall() {
  return _civimembershipperiod_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_config().
 */
function civimembershipperiod_civicrm_config(&$config) {
  _civimembershipperiod_civicrm_config($config);
}

/**
 * Implements hook_civicrm_perm().
 *
 * Module extensions dont implement this hook as yet, will need to add for 4.2
 */
function civimembershipperiod_civicrm_perm() {
  return array('view CiviMembershipPeriod', 'administer CiviMembershipPeriod');
}

/**
 * Implements hook_civicrm_xmlMenu().
 */
function civimembershipperiod_civicrm_xmlMenu(&$files) {
  _civimembershipperiod_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_enable().
 */
function civimembershipperiod_civicrm_enable() {
  return _civimembershipperiod_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 */
function civimembershipperiod_civicrm_disable() {
  return _civimembershipperiod_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param CRM_Queue_Queue $queue  (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 */
function civimembershipperiod_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _civimembershipperiod_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @param array $entities
 */
function civimembershipperiod_civicrm_managed(&$entities) {
  return _civimembershipperiod_civicrm_managed($entities);
}
// mrtc
/**
 * Implementation of hook_civicrm_tabs()
 *
 * Display a Periods tab listing Period code usage for that contact.
 */
function civimembershipperiod_civicrm_tabs(&$tabs, $cid) { 
  $count = _civimembershipperiod_get_tracking_count($cid);
  $tabs[] = array(
    'id' => 'membership_period',
    'count' => $count,
    'title' => ts('Membership Periods'),
    'weight' => '99',
    'url' => CRM_Utils_System::url('civicrm/civimembershipperiod/view', "reset=1&cid={$cid}", false, null, false),
  );
}
 
 
/**
 * Implementation of hook_civicrm_postProcess()
 *
 * Record information about a Time/Period .
 */
function civimembershipperiod_civicrm_postProcess($class, &$form) {
  if (!in_array($class, array( 
    'CRM_Member_Form_Membership',
    'CRM_Member_Form_MembershipRenewal' 
  ))) {
    return;
  } 

  $params = $form->getVar('_params');
  $periodParams = array( 
    'contribution_id' => CRM_Utils_Array::value('contributionID', $params),
  );
  
    $contribution_id = NULL;
     
    // for membership.
    if ( in_array($class, array('CRM_Member_Form_Membership','CRM_Member_Form_MembershipRenewal') ) ) {
      $membership_types = $form->getVar('_memTypeSelected');
      $membership_type = isset($membership_types[0]) ? $membership_types[0] : NULL;

      if (!$membership_type) {
        $membership_type = $form->getVar('_memType');
      } 

      $periodParams['entity_table'] = 'civicrm_membership';
      $periodParams['entity_id'] = $entity_id = $form->getVar('_id');

      $membership_payment = _civimembershipperiod_get_membership_payment($entity_id);
      $periodParams['contribution_id'] = $membership_payment['contribution_id']; 
      $membership = _civimembershipperiod_get_membership($entity_id); 
      $dateResult = _civimembershipperiod_get_last_date($membership['contact_id'],$membership['id']);
      // this will be Membership  Term Period Start Date 
      if($dateResult!=NULL)
      { 
       $periodParams['start_date'] = $dateResult;
      }else
      { 
       $periodParams['start_date'] = $membership['start_date']; 
      }

      // this will be membership Term Period End date
      $periodParams['end_date'] = $membership['end_date'];
      $periodParams['membership_name'] = $membership['membership_name'];
      $periodParams['membership_id'] = $membership['id'];
      $periodParams['contact_id'] = $membership['contact_id'];
      $termCount = _civimembershipperiod_get_period_count($membership['contact_id'],$membership['id']);
      $periodParams['period'] = "Term/Period ".$termCount ;
    }
    else {
      $periodParams['entity_table'] = 'civicrm_contribution';
      $periodParams['entity_id'] = $contribution_id;
    }
    
    try {
      civicrm_api3('PeriodTrack', 'create', $periodParams);
    }
    catch (CiviCRM_API3_Exception $e) {
      print_r($periodParams);
      echo $e;
      exit();
    }
   
  

}
 
  /**
 * Get Term/Period Count Count of that Membership with Contact id.
 *
 * @param int $cid
 *
 * @return int|count
 */

function _civimembershipperiod_get_tracking_count($cid) {
  $sql = "SELECT count(id) as count FROM civimembershipperiod_track WHERE contact_id = $cid";
  $count = CRM_Core_DAO::singleValueQuery($sql, array());

  return $count;
}
  /**
 * Get Term/Period Count Count of that Membership with Contact id and membership id.
 *
 * @param int $cid,int $mid
 *
 * @return int|count
 */
function _civimembershipperiod_get_period_count($cid,$mid) {
  $sql = "SELECT count(id) as count FROM civimembershipperiod_track WHERE contact_id = $cid and membership_id= $mid";
  $count = CRM_Core_DAO::singleValueQuery($sql, array());
  $count++;

  return $count;
}
  /**
 * Get EndDate/LastDate of Previous Membership if its Exist.
 *
 * @param int $cid,int $mid
 *
 * @return int|count
 */
function _civimembershipperiod_get_last_date($cid,$mid) { 

  $sql = "SELECT end_date
FROM civimembershipperiod_track 
WHERE contact_id = $cid and membership_id= $mid
ORDER BY end_date DESC";
  $dao = CRM_Core_DAO::executeQuery($sql, array());
  $PeriodDateEntries = array();
  if ($dao->fetch()) {
   // if Membership Found then return New Date for Current Term Period 
      $endDate = $dao->end_date;
      $timestamp = strtotime($endDate); 
      $newEndDate = date('Y-m-d H:i:s', strtotime('+1 day', $timestamp));
      return $newEndDate;
    }
   // if no membership found with that contact then return null
    return NULL;
}
 
 
 /**
 * Get Membership Info .
 *
 * @param int $mid
 *
 * @return bool|mixed
 */

function _civimembershipperiod_get_membership($mid = 0) {
  $result = civicrm_api('Membership', 'get', array('version' => '3', 'membership_id' => $mid));
  if ($result['is_error'] == 0) {
    return array_shift($result['values']);
  }

  return FALSE;
}

/**
 * Get Membership Payment record.
 *
 * @param int $mid
 *
 * @return bool|mixed
 */
function _civimembershipperiod_get_membership_payment($mid = 0) {
  $result = civicrm_api('MembershipPayment', 'get', array('version' => '3', 'membership_id' => $mid));
  if ($result['is_error'] == 0) {
    return array_shift($result['values']);
  }

  return FALSE;
}

/**
 * Get Membership Start Date .
 *
 * @param int $mid
 *
 * @return bool|mixed
 */
function _civimembershipperiod_get_membership_start_date($mid = 0) {
  $result = civicrm_api('MembershipPayment', 'get', array('version' => '3', 'membership_id' => $mid));
  if ($result['is_error'] == 0) {
    return array_shift($result['values']);
  }

  return FALSE;
}
 
 

/**  
 * Add navigation for civimembershipperiod under "Administer" menu
 *
 * Implementation of hook_civicrm_navigationMenu
 * @param $params associated array of navigation menus
 */
function civimembershipperiod_civicrm_navigationMenu( &$params ) {
  // get the id of Administer Menu
  $administerMenuId = CRM_Core_DAO::getFieldValue('CRM_Core_BAO_Navigation', 'Administer', 'id', 'name');

  // skip adding menu if there is no administer menu
  if ($administerMenuId) {
    // get the maximum key under adminster menu
    $maxKey = max( array_keys($params[$administerMenuId]['child']));
    $params[$administerMenuId]['child'][$maxKey+1] =  array (
      'attributes' => array (
        'label'      => 'CiviMembershipPeriod',
        'name'       => 'CiviMembershipPeriod',
        'url'        => 'civicrm/civimembershipperiod',
        'permission' => 'administer CiviCRM',
        'operator'   => NULL,
        'separator'  => TRUE,
        'parentID'   => $administerMenuId,
        'navID'      => $maxKey+1,
        'active'     => 1
      )
    );
  }
}

/**
 * Implementation of hook_civicrm_entityTypes
 */
function civimembershipperiod_civicrm_entityTypes(&$entityTypes) { 
  $entityTypes['CRM_CiviMembershipPeriod_DAO_Track'] = array(
    'name' => 'PeriodTrack',
    'class' => 'CRM_CiviMembershipPeriod_DAO_Track',
    'table' => 'civimembershipperiod_track'
  );

}
