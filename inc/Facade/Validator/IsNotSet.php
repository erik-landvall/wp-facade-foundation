<?php

class Facade_Validator_IsNotSet implements Facade_Validator_Interface
{
  /**
   * @param array $data 
   * @return boolean 
   */
  public function validate($data)
  {
    foreach ($data as $tmp)
      if(is_string($tmp) && strlen($tmp) > 0)
        return false;
    
    return true;
  }
}