<?php

class Facade_Validator_IsSet implements Facade_Validator_Interface
{
  /**
   * @param array $data 
   * @return boolean 
   */
  public function validate($data)
  {
    foreach ($data as $tmp)
      if(is_null($tmp) || empty($tmp))
        return false;
    
    return true;
  }
}