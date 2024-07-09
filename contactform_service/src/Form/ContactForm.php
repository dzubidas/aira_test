<?php

namespace Drupal\contactform_service\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\contactform_service\Service\SubmissionHandler;

class ContactForm extends FormBase {

  protected $submissionHandler;

  public function __construct(SubmissionHandler $submission_handler) {
    $this->submissionHandler = $submission_handler;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('contactform.submission_handler')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'contactform_form_service';
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
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $data = [
      $form_state->getValue('name'),
      $form_state->getValue('email'),
      $form_state->getValue('message'),
    ];

    if ($this->submissionHandler->saveSubmission($data)) {
      $this->messenger()->addMessage($this->t('Thank you for your submission. Your message has been received.'));
    }
    else {
      $this->messenger()->addError($this->t('There was an error saving your submission. Please try again.'));
    }
  }
}
