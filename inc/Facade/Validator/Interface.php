<?php

interface Facade_Validator_Interface
{
  /**
   * @param array $data 
   * @return boolean 
   */
  public function validate($data);
}