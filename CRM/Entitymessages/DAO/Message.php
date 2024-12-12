<?php

/**
 * DAOs provide an OOP-style facade for reading and writing database records.
 *
 * DAOs are a primary source for metadata in older versions of CiviCRM (<5.74)
 * and are required for some subsystems (such as APIv3).
 *
 * This stub provides compatibility. It is not intended to be modified in a
 * substantive way. Property annotations may be added, but are not required.
 * @property string $id 
 * @property string $name 
 * @property string $created_id 
 * @property string $title 
 * @property string $subject 
 * @property string $body_text 
 * @property string $body_html 
 */
class CRM_Entitymessages_DAO_Message extends CRM_Entitymessages_DAO_Base {

  /**
   * Required by older versions of CiviCRM (<5.74).
   * @var string
   */
  public static $_tableName = 'civicrm_message';

}
