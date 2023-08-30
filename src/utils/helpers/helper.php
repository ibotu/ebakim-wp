<?php
/*
Plugin Name: Custom Helpers Plugin
Description: Adds custom helper functions for the project.
*/

function dd($data)
{
  echo "<pre>";
  print_r($data);
  die();
}

function patient_fields()
{
  $sample_columns = [
    '_created', '_edited', 'status', 'patientID', 'patientFullName', 'patientBirthDate', 'patientTcNumber',
    'clinicAcceptanceDate', 'clinicPlacementType', 'clinicPlacementStatus', 'clinicEndDate', 'clinicLifePlanDate',
    'clinicEskrDate', 'clinicGuardianDate', 'clinicAllowanceStatus'
  ];
  return $sample_columns;
}

function get_flash_error_cookie() {
  if (isset($_COOKIE['flash_error'])) {
      $message = $_COOKIE['flash_error'];
      
      // Clear the cookie immediately to prevent further display
      unset($_COOKIE['flash_error']);
      setcookie('flash_error', '', time() - 3600, '/');
      
      return $message;
  }
  return false;
}



function set_flash_error_cookie($message) {
  // Set a session-like cookie with an expiration time (e.g., 1 minute)
  setcookie('flash_error', $message, time() + 60, '/');
}

function redirect_back() {
  $referer = wp_get_referer();
  
  // Make sure the referer is not empty and is a safe URL
  if ($referer && wp_validate_redirect($referer, home_url())) {
      wp_safe_redirect($referer);
  } else {
      // If referer is empty or not safe, redirect to home page
      wp_safe_redirect(home_url());
  }
  
  exit();
}

function redirect_to_login_and_logout() {
  wp_logout();
  wp_redirect(wp_login_url());
  exit();
}

function get_2fa_key()
{

  $current_user = wp_get_current_user();
  if ($current_user->user_email) {
    $user_identifier = $current_user->user_email;
  } elseif ($current_user->user_login) {
    $user_identifier = $current_user->user_login;
  } else {
    $user_identifier = $current_user->ID;
  }
  return 'WP_eBakim_' . $user_identifier;
}

function base32_encode($data)
{
  $base32Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';

  $inputLength = strlen($data);
  $output = '';

  $i = 0;
  while ($i < $inputLength) {
    $byte = ord($data[$i]);
    $i++;

    $output .= $base32Chars[($byte >> 3)];
    $byte = ($byte & 7) << 2;

    if ($i >= $inputLength) {
      $output .= $base32Chars[$byte];
      break;
    }

    $byte = $byte | (ord($data[$i]) >> 6);
    $output .= $base32Chars[$byte];
    $output .= $base32Chars[(ord($data[$i]) >> 1) & 31];
    $byte = (ord($data[$i]) & 1) << 4;
    $i++;

    if ($i >= $inputLength) {
      $output .= $base32Chars[$byte];
      break;
    }

    $byte = $byte | (ord($data[$i]) >> 4);
    $output .= $base32Chars[$byte];
    $byte = (ord($data[$i]) & 15) << 1;
    $i++;

    if ($i >= $inputLength) {
      $output .= $base32Chars[$byte];
      break;
    }

    $byte = $byte | (ord($data[$i]) >> 7);
    $output .= $base32Chars[$byte];
    $output .= $base32Chars[(ord($data[$i]) >> 2) & 31];
    $byte = (ord($data[$i]) & 3) << 3;
    $i++;

    if ($i >= $inputLength) {
      $output .= $base32Chars[$byte];
      break;
    }

    $byte = $byte | (ord($data[$i]) >> 5);
    $output .= $base32Chars[$byte];
    $output .= $base32Chars[ord($data[$i]) & 31];
    $i++;
  }

  return $output;
}


class Custom_Helper_Class
{
  // Your code here
}

define('CUSTOM_HELPER_CONSTANT', 'ebakim-wp');
