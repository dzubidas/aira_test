<?php

namespace Drupal\contactform_entity\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the Contact Submission entity.
 *
 * @ingroup contactform_entity
 *
 * @ContentEntityType(
 *   id = "contact_submission",
 *   label = @Translation("Contact Submission"),
 *   base_table = "contact_submission",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *   },
 * )
 */
class ContactSubmission extends ContentEntityBase {

  /**
   * Defines the base field definitions for the contact submission entity.
   *
   * This method is used to define the fields that will be stored in the
   * entity's base table. It sets up the structure for storing contact form
   * submissions, including the submitter's name, email, message content,
   * and the timestamp of submission.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type definition.
   *
   * @return array
   *   An array of base field definitions for this entity type.
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    // Get the base fields from the parent class.
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setRequired(TRUE)
      ->setSetting('max_length', 255);

    $fields['email'] = BaseFieldDefinition::create('email')
      ->setLabel(t('Email'))
      ->setRequired(TRUE);

    $fields['message'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Message'))
      ->setRequired(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the submission was created.'));

    return $fields;
  }
}
