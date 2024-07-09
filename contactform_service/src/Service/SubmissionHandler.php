<?php

namespace Drupal\contactform_service\Service;

use Drupal\Core\File\FileSystemInterface;

class SubmissionHandler {

  protected $fileSystem;

  public function __construct(FileSystemInterface $file_system) {
    $this->fileSystem = $file_system;
  }

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
