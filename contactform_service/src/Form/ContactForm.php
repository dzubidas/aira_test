<?php

namespace Drupal\contactform_service\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\contactform_service\Service\SubmissionHandler;

class ContactForm extends FormBase {

  /**
   * The submission handler service.
   *
   * @var \Drupal\contactform_service\Service\SubmissionHandler
   */
  protected $submissionHandler;

  /**
   * Constructs a new ContactForm object.
   *
   * @param \Drupal\contactform_service\Service\SubmissionHandler $submission_handler
   *   The submission handler service.
   */
  public function __construct(SubmissionHandler $submission_handler) {
    $this->submissionHandler = $submission_handler;
  }

  /**
   * {@inheritdoc}
   *
   * Creates a new instance of this form.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('contactform.submission_handler')
    );
  }

  /**
   * {@inheritdoc}
   *
   * Returns a unique string identifying the form.
   */
  public function getFormId() {
    return 'contactform_form_service';
  }

  /**
   * {@inheritdoc}
   *
   * Builds the contact form.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The form structure.
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
   *
   * Form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
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
