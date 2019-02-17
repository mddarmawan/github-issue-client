<?php

class Environment extends Config
{
  /**
   * The environment variable.
   *
   * @var array
   */
  private $__env;

  /**
   * Function that will be called automatically.
   *
   * @return void
   */
  public function __construct()
  {
    $handle = fopen(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '.env', 'r');

    if ($handle) {
      while (($line = fgets($handle)) !== false) {
        if(!trim($line)) continue;

        $env = explode('=', $line);
        $property = $env[0];
        $value = $env[1];

        $this->env($property, $value);
      }

      fclose($handle);
    } else {
      // handle the error
    }
  }

  /**
   * Gets the value of an environment variable.
   *
   * @param  string  $key
   * @param  mixed   $default
   * @return mixed
   */
  public function env($key, $default = null)
  {
    if ($default) {
      $this->__env[$key] = $default;
    }

    if (empty($this->__env[$key])) {
      $this->__env[$key] = 'undefined';
    } else {
      $value = $this->__env[$key];
    }

    switch (strtolower($value)) {
      case 'true':
      case '(true)':
          return true;
      case 'false':
      case '(false)':
          return false;
      case 'empty':
      case '(empty)':
          return '';
      case 'null':
      case '(null)':
          return;
    }

    if (($valueLength = strlen($value)) > 1 && $value[0] === '"' && $value[$valueLength - 1] === '"') {
      return substr($value, 1, -1);
    }

    return rtrim($value);
  }
}

/**
 * Gets the value of an environment variable.
 *
 * @param  string  $key
 * @param  mixed   $default
 * @return mixed
 */
function env($key, $default = null) {
  return (new Environment)->env($key, $default);
}

?>