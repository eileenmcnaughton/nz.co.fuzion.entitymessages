<?php
use CRM_Entitymessages_ExtensionUtil as E;
return [
  'name' => 'EntityMessage',
  'table' => 'civicrm_entity_message',
  'class' => 'CRM_Entitymessages_DAO_EntityMessage',
  'getInfo' => fn() => [
    'title' => E::ts('Entity Message'),
    'title_plural' => E::ts('Entity Messages'),
    'description' => E::ts('Entity Message Connections'),
    'log' => TRUE,
    'add' => '4.6',
    'label_field' => 'label',
  ],
  'getIndices' => fn() => [
    'index_name_entity_id_entity_type' => [
      'fields' => [
        'name' => TRUE,
        'entity_id' => TRUE,
        'entity_type' => TRUE,
      ],
      'unique' => TRUE,
      'add' => '4.6',
    ],
  ],
  'getFields' => fn() => [
    'id' => [
      'title' => E::ts('EntityMessage ID'),
      'sql_type' => 'int unsigned',
      'input_type' => 'Number',
      'required' => TRUE,
      'add' => '4.6',
      'primary_key' => TRUE,
      'auto_increment' => TRUE,
    ],
    'entity_id' => [
      'title' => E::ts('Linked Entity'),
      'sql_type' => 'int unsigned',
      'input_type' => 'Number',
      'add' => '4.6',
    ],
    'entity_type' => [
      'title' => E::ts('Entity Type'),
      'sql_type' => 'varchar(64)',
      'input_type' => 'Text',
      'required' => TRUE,
      'description' => E::ts('Links to an entity_table like civicrm_financial_type'),
      'add' => '4.6',
      'usage' => [
        'import',
        'export',
        'duplicate_matching',
      ],
    ],
    'message_id' => [
      'title' => E::ts('Message'),
      'sql_type' => 'int unsigned',
      'input_type' => 'Select',
      'add' => '4.6',
      'pseudoconstant' => [
        'table' => 'civicrm_message',
        'key_column' => 'id',
        'label_column' => 'title',
      ],
    ],
    'label' => [
      'title' => E::ts('Label'),
      'sql_type' => 'varchar(128)',
      'input_type' => 'Text',
      'required' => TRUE,
      'description' => E::ts('Entity Message Label'),
      'add' => '4.6',
      'usage' => [
        'import',
        'export',
        'duplicate_matching',
      ],
    ],
    'name' => [
      'title' => E::ts('Name'),
      'sql_type' => 'varchar(128)',
      'input_type' => 'Text',
      'required' => TRUE,
      'description' => E::ts('Entity Message Unique name'),
      'add' => '4.6',
      'usage' => [
        'import',
        'export',
        'duplicate_matching',
      ],
    ],
    'is_smarty_render' => [
      'title' => E::ts('Is Smarty Render'),
      'sql_type' => 'int',
      'input_type' => 'Number',
      'description' => E::ts('Render using smarty? This has security and performance implications'),
      'add' => '4.6',
      'default' => 0,
      'usage' => [
        'import',
        'export',
        'duplicate_matching',
      ],
    ],
  ],
];
