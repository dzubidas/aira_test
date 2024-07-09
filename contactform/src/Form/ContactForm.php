<?php

namespace Drupal\contactform\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\File\FileSystemInterface;

class ContactForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'contactform_form';
  }

  /**
   * {@inheritdoc}
   */
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

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (empty($form_state->getValue('name'))) {
      $form_state->setErrorByName('name', $this->t('Name field is required.'));
    }

    if (!filter_var($form_state->getValue('email'), FILTER_VALIDATE_EMAIL)) {
      $form_state->setErrorByName('email', $this->t('Please enter a valid email address.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $name = $form_state->getValue('name');
    $email = $form_state->getValue('email');
    $message = $form_state->getValue('message');

    $data = [$name, $email, $message];
    $csv_data = implode(',', $data) . "\n";

    $file_path = 'public://contactform_submissions.csv';

    $file_system = \Drupal::service('file_system');
    $directory = $file_system->dirname($file_path);
    $file_system->prepareDirectory($directory, FileSystemInterface::CREATE_DIRECTORY);

    if (file_put_contents($file_path, $csv_data, FILE_APPEND) !== FALSE) {
      $this->messenger()->addMessage($this->t('Thank you for your submission. Your message has been received.'));
    }
    else {
      $this->messenger()->addError($this->t('There was an error saving your submission. Please try again.'));
    }
  }
}
