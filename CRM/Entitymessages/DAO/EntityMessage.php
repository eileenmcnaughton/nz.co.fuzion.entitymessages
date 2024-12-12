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
 * @property string $entity_id 
 * @property string $entity_type 
 * @property string $message_id 
 * @property string $label 
 * @property string $name 
 * @property int|string $is_smarty_render 
 */
class CRM_Entitymessages_DAO_EntityMessage extends CRM_Entitymessages_DAO_Base {

  /**
   * Required by older versions of CiviCRM (<5.74).
   * @var string
   */
  public static $_tableName = 'civicrm_entity_message';

}
