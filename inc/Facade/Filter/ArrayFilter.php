<?php

class Facade_Filter_ArrayFilter implements Facade_Filter_Interface
{
  /**
   * @param mix $data 
   * @return string 
   */
  public function filter($data)
  {
    return array_filter($data, 'strlen');
  }
}