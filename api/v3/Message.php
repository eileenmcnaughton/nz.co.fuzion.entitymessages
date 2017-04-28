<?php

/**
 * Message.create API specification (optional).
 *
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 *
 * @see http://wiki.civicrm.org/confluence/display/CRM/API+Architecture+Standards
 */
function _civicrm_api3_message_create_spec(&$spec) {
  //$spec['created_id']['api.default'] = 'user_contact_id';
}

/**
 * Message.create API.
 *
 * @param array $params
 * @return array API result descriptor
 * @throws API_Exception
 */
function civicrm_api3_message_create($params) {
  if (empty($params['id']) && empty($params['name'])) {
    $name = $params['name'] = $params['title'];
    $found = 1;
    $count = 0;
    while ($found !== 0) {
      $found = civicrm_api3('Message', 'getcount', array(
        'name' => $params['name'],
      ));
      if ($found) {
        $count++;
        $name = $params['name'] . $count;
      }
    }
  }
  $params['name'] = $name;
  return _civicrm_api3_basic_create(_civicrm_api3_get_BAO(__FUNCTION__), $params);
}

/**
 * Message.delete API
 *
 * @param array $params
 * @return array API result descriptor
 * @throws API_Exception
 */
function civicrm_api3_message_delete($params) {
  return _civicrm_api3_basic_delete(_civicrm_api3_get_BAO(__FUNCTION__), $params);
}

/**
 * Message.get API
 *
 * @param array $params
 * @return array API result descriptor
 * @throws API_Exception
 */
function civicrm_api3_message_get($params) {
  return _civicrm_api3_basic_get(_civicrm_api3_get_BAO(__FUNCTION__), $params);
}
