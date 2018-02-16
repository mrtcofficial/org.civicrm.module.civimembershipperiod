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

/**
 * This API exposes Period tracking records.
 *
 * Period codes are provided by the CiviMembershipPeriod extension.
 *
 * @package CiviMembershipPeriod
 */

/**
 * Create or update a Period code.
 *
 * @param array $params
 *
 * @return array
 */
function civicrm_api3_period_track_create($params) {
  return _civicrm_api3_basic_create(_civicrm_api3_get_BAO(__FUNCTION__), $params);
}

/**
 * Adjust Metadata for Create action.
 *
 * The metadata is used for setting defaults, documentation & validation
 *
 * @param array $params
 *   Array of parameters determined by getfields
 */
function _civicrm_api3_period_track_create_spec(&$params) {
  $params['start_date']['api.default'] = 'now';
  $params['period']['api.required'] = TRUE;
  $params['contact_id']['api.required'] = TRUE;
  $params['membership_id']['api.required'] = TRUE;
  $params['contribution_id']['api.required'] = TRUE;
  $params['entity_table']['api.required'] = TRUE;
  $params['entity_id']['api.required'] = TRUE;
}

/**
 * Get Period tracking records.
 *
 * @param array $params
 *   If $params is empty, all items will be returned
 *
 * @return array
 *   Period Tracking records.
 */
function civicrm_api3_period_track_get($params) {
  return _civicrm_api3_basic_get(_civicrm_api3_get_BAO(__FUNCTION__), $params);
}

/**
 * Delete an existing Period tracking record.
 *
 * @param array $params
 *   Array containing id of the item to be deleted.
 *
 * @return array
 *   API result Array
 */
function civicrm_api3_period_track_delete($params) {
  return _civicrm_api3_basic_delete(_civicrm_api3_get_BAO(__FUNCTION__), $params);
}

/**
 * Because this api doesn't follow the usual naming pattern we have to explicitly declare dao name.
 *
 * @return string
 *   BAO name.
 */
function _civicrm_api3_period_track_DAO() {
  return 'CRM_CiviMembershipPeriod_BAO_Track';
}
