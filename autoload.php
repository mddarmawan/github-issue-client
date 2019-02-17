<?php 

/**
 * Include all configs.
 *
 * @return void
 */
foreach (glob(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config/*.php') as $filename) {
  require_once($filename);
}

?>