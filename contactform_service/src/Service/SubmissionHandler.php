<?php

namespace Drupal\contactform_service\Service;

use Drupal\Core\File\FileSystemInterface;

class SubmissionHandler {

  protected $fileSystem;

  /**
   * Constructs a new SubmissionHandler object.
   *
   * @param \Drupal\Core\File\FileSystemInterface $file_system
   *   The file system service.
   */
  public function __construct(FileSystemInterface $file_system) {
    $this->fileSystem = $file_system;
  }

  /**
   * Saves a form submission to a CSV file.
   *
   * This method takes an array of form submission data, converts it to a CSV
   * format, and appends it to a file in the public files directory. It ensures
   * the target directory exists before attempting to write the file.
   *
   * @param array $data
   *   An array containing the form submission data.
   *
   * @return bool
   *   TRUE if the submission was successfully saved, FALSE otherwise.
   */
  public function saveSubmission(array $data) {
    $csv_data = implode(',', $data) . "\n";
    $file_path = 'public://contactform_submissions2.csv';

    $directory = $this->fileSystem->dirname($file_path);
    $this->fileSystem->prepareDirectory($directory, FileSystemInterface::CREATE_DIRECTORY);

    if (file_put_contents($file_path, $csv_data, FILE_APPEND) !== FALSE) {
      return TRUE;
    }
    return FALSE;
  }
}
