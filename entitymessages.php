<?php

require_once 'entitymessages.civix.php';

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function entitymessages_civicrm_config(&$config) {
  _entitymessages_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @param array $files array
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function entitymessages_civicrm_xmlMenu(&$files) {
  _entitymessages_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function entitymessages_civicrm_install() {
  _entitymessages_civix_civicrm_install();
  $messageTemplatesDirectory = __DIR__ . '/templates/Messages/';

  $templatesToLoad = array(
    'all_contributions_summary_block' => ts('All contributions for a contact (in a table)'),
    'thank_you_letter_summary_block' => ts('Thank you letter Contribution Summary'),
    'all_contributions_last_fy_summary_block' => ts('All contributions last financial year for contact (in a table)'),
    'all_contributions_this_fy_summary_block' => ts('All contributions this financial year for contact (in a table)'),
  );
  // Can't do this by api here & in managed it causes errors on uninstall.
  foreach ($templatesToLoad as $name => $title) {
    CRM_Core_DAO::executeQuery("
      INSERT INTO civicrm_message (title, name, body_html)
      VALUES('{$title}', '{$name}', \"" .  addslashes(file_get_contents($messageTemplatesDirectory . $name . '.tpl')) . "\")
    ");
    CRM_Core_DAO::executeQuery("
      INSERT INTO civicrm_entity_message (label, name, is_smarty_render, entity_id, entity_type, message_id)
      VALUES('{$title}', '{$name}', 1, " . CRM_Core_Config::domainID() . ", 'Domain', LAST_INSERT_ID())
    ");
  }
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function entitymessages_civicrm_uninstall() {
  _entitymessages_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function entitymessages_civicrm_enable() {
  _entitymessages_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function entitymessages_civicrm_disable() {
  _entitymessages_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @param string $op The type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed
 *   Based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function entitymessages_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _entitymessages_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function entitymessages_civicrm_managed(&$entities) {
  _entitymessages_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function entitymessages_civicrm_caseTypes(&$caseTypes) {
  _entitymessages_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function entitymessages_civicrm_angularModules(&$angularModules) {
_entitymessages_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function entitymessages_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _entitymessages_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements civicrm_tokens().
 */
function entitymessages_civicrm_tokens(&$tokens) {
  $entityMessages = civicrm_api3('EntityMessage', 'get', array());
  $civitokens = array();
  foreach ($entityMessages['values'] as $token) {
    if ($token['entity_type'] == 'Domain' && empty($token['entity_id']) || $token['entity_id'] == CRM_Core_Config::domainID()) {
      $civitokens['entitymessages.'  .  $token['entity_type'] . '__' .  $token['name']] = $token['label'];
    }
  }
  $tokens['entitymessages'] = $civitokens;
}

/**
 * Implements CiviCRM hook.
 *
 * @param array $values
 * @param array $contactIDs
 * @param null $job
 * @param array $tokens
 * @param null $context
 */
function entitymessages_civicrm_tokenValues(&$values, $contactIDs, $job = NULL, $tokens = array(), $context = NULL) {

  if (empty($tokens['entitymessages'])) {
    return;
  }
  static $categories = array();
  if (empty($categories)) {
    $categories = array();
    CRM_Utils_Hook::tokens($categories);
    $categories = array_keys($categories);
  }
  $resolvedTokens = array();
  $tokenList = isset($tokens['entitymessages'][0]) ? $tokens['entitymessages'] : array_keys($tokens['entitymessages']);
  foreach ($tokenList as $token) {
    list($entity, $name) = explode('__', $token);
    $entityClause = array();
    if ($entity == 'Domain') {
      $entityClause['entity_id'] = array('IN' => array(0, CRM_Core_Config::domainID()));
    }
    // Note that 0 denotes 'all entities' - ie. a default. It is sorted to the bottom
    // and only is used if another is not found.
    $entityMessages = civicrm_api3('EntityMessage', 'get', array_merge(array(
      'entity_type' => $entity,
      'name' => $name,
      'sequential' => 1,
      'options' => array('sort' => 'entity_id DESC'),
    ), $entityClause));

    if ($entityMessages['count']) {
      $entityMessage = $entityMessages['values'][0];
      $message = civicrm_api3('Message', 'getvalue', array(
        'id' => $entityMessage['message_id'],
        'return' => 'body_html',
      ));

      // $tokenHtml = CRM_Utils_Token::replaceEntityTokens('membership', $membership, $tokenHtml, $messageToken);
      //$tokenHtml = CRM_Utils_Token::replaceHookTokens($message, $contacts[$contactId], $categories, TRUE);

      if (!empty($entityMessage['is_smarty_render'])) {
        static $fiscalVarsAssigned = FALSE;
        if (!$fiscalVarsAssigned) {
          _entitymessages_assign_fiscal_vars();
          $fiscalVarsAssigned = TRUE;
        }
        $tokensToRender = CRM_Utils_Token::getTokens($message);
        foreach ($contactIDs as $contactID) {
          // @todo calculate return properties.
          $contact = civicrm_api3('Contact', 'getsingle', array('id' => $contactID));
          CRM_Core_Smarty::singleton()->assign('messageContactID', $contactID);
          $message = CRM_Utils_Token::replaceContactTokens($message, $contact, TRUE, $tokensToRender);
          $message = entitymessages_civicrm_pass_through_smarty($message, $contact);

          // also call a hook and get token details
          $resolvers = array($contactID => $contact);
          CRM_Utils_Hook::tokenValues($resolvers,
            array($contactID),
            NULL,
            $tokensToRender,
            'entity_message'
          );
          $message = CRM_Utils_Token::replaceHookTokens($message, $resolvers[$contactID], $categories, TRUE);
          $values[$contactID]['entitymessages.' . $token] = $message;
        }
      }
      else {
        $resolvedTokens['entitymessages.' . $token] = $message;
      }
    }
    else {
      $resolvedTokens['entitymessages.' . $token] = '';
    }
  }

  if (!empty($resolvedTokens)) {
    foreach ($contactIDs as $contactID) {
      $values[$contactID] = array_merge($values[$contactID], $resolvedTokens);
    }
  }

}

/**
 * Assign some consistent fiscal date variables to smarty.
 */
function _entitymessages_assign_fiscal_vars() {
  $config = CRM_Core_Config::singleton();
  $month = str_pad($config->fiscalYearStart['M'], 2, 0, STR_PAD_LEFT);
  $day = str_pad($config->fiscalYearStart['d'], 2, 0, STR_PAD_LEFT);
  $fYear = CRM_Utils_Date::calculateFiscalYear($day, $month);
  $smarty = CRM_Core_Smarty::singleton();
  $thisFiscalYearStart = strtotime($fYear . '-' . $month . '-' . $day);
  $nextFiscalYearStart = strtotime('+ 1 year ', $thisFiscalYearStart);
  $lastFiscalYearStart = strtotime('- 1 year ', $thisFiscalYearStart);
  $thisFiscalYearEnd = strtotime('- 1 second ', $nextFiscalYearStart);
  $lastFiscalYearEnd = strtotime('- 1 second ', $thisFiscalYearStart);
  $smarty->assign('em_this_fiscal_year_start', date('YmdHis', $thisFiscalYearStart));
  $smarty->assign('em_this_fiscal_year_end', date('YmdHis', $thisFiscalYearEnd));
  $smarty->assign('em_last_fiscal_year_start', date('YmdHis', $lastFiscalYearStart));
  $smarty->assign('em_last_fiscal_year_end', date('YmdHis', $lastFiscalYearEnd));
  $smarty->assign('em_this_year_clause', array(
    'BETWEEN' => array(
      date('YmdHis', $thisFiscalYearStart),
      date('YmdHis', $thisFiscalYearEnd),
    ),
  ));
  $smarty->assign('em_last_year_clause', array(
    'BETWEEN' => array(
      date('YmdHis', $lastFiscalYearStart),
      date('YmdHis', $lastFiscalYearEnd),
    ),
  ));
}

/**
 * Parse html through Smarty resolving any smarty functions.
 *
 * Unlike the core version this one does not check for the smarty var to be
 * defined on a site-wide basis and can be added on a nuanced basis.
 *
 * @param string $tokenHtml
 * @param array $entity
 * @param string $entityType
 * @return string
 *   html parsed through smarty
 */
function entitymessages_civicrm_pass_through_smarty($tokenHtml, $entity, $entityType = 'contact') {
  $smarty = CRM_Core_Smarty::singleton();
  // also add the tokens to the template
  $smarty->assign($entityType, $entity);
  return \CRM_Utils_String::parseOneOffStringThroughSmarty($tokenHtml);
}

/**
 * Functions below this ship commented out. Uncomment as required.
 *

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function entitymessages_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 */
function entitymessages_civicrm_navigationMenu(&$menu) {

  _entitymessages_civix_insert_navigation_menu($menu, 'Administer/Communications', array(
    'label' => ts('Site Message Tokens', array('domain' => 'nz.co.fuzion.entitymessages')),
    'name' => 'entity_message_tokens',
    'url' => 'civicrm/a/#/entitymessages',
    'permission' => 'administer CiviCRM',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _entitymessages_civix_navigationMenu($menu);
}

/**
 * Implements hook_civicrm_entityTypes.
 *
 * @param array $entityTypes
 *   Registered entity types.
 */
function entitymessages_civicrm_entityTypes(&$entityTypes) {
  $entityTypes['CRM_Entitymessages_DAO_EntityMessage'] = array(
    'name' => 'EntityMessage',
    'class' => 'CRM_Entitymessages_DAO_EntityMessage',
    'table' => 'civicrm_entity_message',
  );
  $entityTypes['CRM_Entitymessages_DAO_Message'] = array(
    'name' => 'Message',
    'class' => 'CRM_Entitymessages_DAO_Message',
    'table' => 'civicrm_message',
  );
}
