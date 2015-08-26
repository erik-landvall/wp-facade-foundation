<?php

class Facade_Validator_IsEqual implements Facade_Validator_Interface
{
  /**
   * @param array $data 
   * @return boolean 
   */
  public function validate($data)
  {
    return count(array_unique($data)) == 1;
  }
}