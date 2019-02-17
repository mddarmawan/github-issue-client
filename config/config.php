<?php

class Config
{
  /**
   * The environtment variable.
   *
   * @var array
   */
  private $__attributes;

  /**
   * This function used to set the attributes variable. 
   *
   * @return void
   */
  public function __set($property, $value)
  {
    return $this->__attributes[$property] = $value;
  }

  /**
   * This function used to get the attributes variable.
   *
   * @return attribute
   */
  public function __get($property)
  {
    return array_key_exists($property, $this->__attributes)
      ? $this->__attributes[$property]
      : null
    ;
  }
}

?>