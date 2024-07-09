# Custom Drupal 10 Modules

This repository contains three custom Drupal 10 modules that demonstrate different approaches to creating a contact form.

## Modules

### 1. Contact Form

A simple contact form module that saves submissions to a CSV file.

- **Path:** `/contact-form`
- **Key Features:**
  - Basic form with name, email, and message fields
  - Form validation
  - Saves submissions to a CSV file

### 2. Contact Form Entity

A contact form module that stores submissions as custom entities.

- **Path:** `/contact-form-entity`
- **Key Features:**
  - Custom entity for storing submissions
  - Integrates with Drupal's entity API
  - Improved data management and retrieval

### 3. Contact Form Service

A contact form module that uses Drupal's service container and dependency injection.

- **Path:** `/contact-form-service`
- **Key Features:**
  - Utilizes Drupal's service container
  - Separates submission handling logic into a service
  - Demonstrates dependency injection
