<?php

class Facade_Validator_UserCan_ManageOptions implements Facade_Validator_Interface
{
  /**
   * @param array $data 
   * @return boolean 
   */
  public function validate($data)
  {
    return current_user_can('manage_options');
  }
}