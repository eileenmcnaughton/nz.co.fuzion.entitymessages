<?php
use CRM_Entitymessages_ExtensionUtil as E;
return [
  'name' => 'Message',
  'table' => 'civicrm_message',
  'class' => 'CRM_Entitymessages_DAO_Message',
  'getInfo' => fn() => [
    'title' => E::ts('Message'),
    'title_plural' => E::ts('Messages'),
    'description' => E::ts('Message'),
    'log' => TRUE,
    'add' => '4.6',
    'label_field' => 'title',
  ],
  'getIndices' => fn() => [
    'ui_name' => [
      'fields' => [
        'name' => TRUE,
      ],
      'add' => '4.6',
    ],
  ],
  'getFields' => fn() => [
    'id' => [
      'title' => E::ts('Message ID'),
      'sql_type' => 'int unsigned',
      'input_type' => 'Number',
      'required' => TRUE,
      'description' => E::ts('Unique Message ID'),
      'add' => '4.6',
      'primary_key' => TRUE,
      'auto_increment' => TRUE,
    ],
    'name' => [
      'title' => E::ts('name'),
      'sql_type' => 'varchar(128)',
      'input_type' => 'Text',
      'description' => E::ts('Unique machine name of the message'),
      'add' => '4.6',
    ],
    'created_id' => [
      'title' => E::ts('Created By'),
      'sql_type' => 'int unsigned',
      'input_type' => 'EntityRef',
      'description' => E::ts('FK to Contact'),
      'add' => '4.6',
      'entity_reference' => [
        'entity' => 'Contact',
        'key' => 'id',
        'on_delete' => 'CASCADE',
      ],
    ],
    'title' => [
      'title' => E::ts('Message Title'),
      'sql_type' => 'varchar(128)',
      'input_type' => 'Text',
      'description' => E::ts('For UI display'),
      'add' => '4.6',
    ],
    'subject' => [
      'title' => E::ts('Subject Line'),
      'sql_type' => 'varchar(128)',
      'input_type' => 'Text',
    ],
    'body_text' => [
      'title' => E::ts('Message Body (text format)'),
      'sql_type' => 'longtext',
      'input_type' => 'TextArea',
    ],
    'body_html' => [
      'title' => E::ts('Message Body (html format)'),
      'sql_type' => 'longtext',
      'input_type' => 'TextArea',
      'description' => E::ts('Body of the mailing in html format.'),
    ],
  ],
];
