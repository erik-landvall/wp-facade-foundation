<?php

class Facade_Validator_OneOrTheOtherIsSet implements Facade_Validator_Interface
{
  /**
   * @param array $data 
   * @return boolean 
   */
  public function validate($data)
  {
    foreach ($data as $tmp)
      if($tmp)
        return true;
    
    return false;
  }
}