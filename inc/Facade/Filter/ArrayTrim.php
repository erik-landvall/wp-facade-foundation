<?php

class Facade_Filter_ArrayTrim implements Facade_Filter_Interface
{
  /**
   * @param mix $data 
   * @return string 
   */
  public function filter($data)
  {
    array_map('trim', $data);
    return $data;
  }
}