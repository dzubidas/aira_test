<?php

namespace Drupal\contactform_entity\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\contactform_entity\Entity\ContactSubmission;

class ContactEntityForm extends FormBase {

  public function getFormId() {
    return 'contactform_entity_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#required' => TRUE,
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#required' => TRUE,
    ];

    $form['message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Message'),
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (empty($form_state->getValue('name'))) {
      $form_state->setErrorByName('name', $this->t('Name field is required.'));
    }

    if (!filter_var($form_state->getValue('email'), FILTER_VALIDATE_EMAIL)) {
      $form_state->setErrorByName('email', $this->t('Please enter a valid email address.'));
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    // Create a new ContactSubmission entity.
    $submission = ContactSubmission::create([
      'name' => $values['name'],
      'email' => $values['email'],
      'message' => $values['message'],
    ]);

    // Create a new ContactSubmission entity.
    $submission->save();

    // Display a success message to the user.
    $this->messenger()->addMessage($this->t('Thank you for your submission. Your message has been received.'));
  }
}
