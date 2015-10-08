<?php

abstract class Facade_Form
{
  protected
   /**
    * Validation rules
    * @var Array
    */
    $_rules = [],

   /**
    * What keys to filter
    * @var Array
    */
    $_filter = [],

   /**
    * Filtered data
    * @var Array
    */
    $_data = [];

  /**
   * All errors will be saved to session in a flash message before reloding url.
   * @see Facade_FlashMessage
   */
  private final function __construct()
  {
    $this->_init();
  }

  /**
   * Good for setting validation rules and filter keys or other what ever
   */
  protected function _init() {}

 /**
  * Composes the data.
  * @throws Facade_Form_Exception
  */
  protected function _composeData()
  {
    foreach( $_POST as $key => $value )
      if( isset( $this->_filter[ $key ] ))
      {
        if( !is_array( $this->_filter[ $key ] ) )
          $this->_filter[ $key ] = [ $this->_filter[ $key ] ];

        foreach( $this->_filter[ $key ] as $filter )
        {
          try
          {
            $filter = new $filter();

            if( !( $filter instanceof Facade_Filter_Interface ))
              throw new Exception();
          }
          catch( Exception $exc )
          {
            throw new Facade_Form_Exception(
              'Unrecognized filter: "' . $rule . '"' );
          }

          $this->_data[ $key ] = $filter->filter( $value );
        }
      }
      else
        $this->_data[ $key ] = $value;
  }

 /**
  * Validates the data.
  * @throws Facade_Form_Exception
  */
  protected function _validateData()
  {
    foreach($this->_rules as $onInvalidation => $rules)
      foreach($rules as $rule => $fields)
      {
        if(is_string($fields))
          $fields = [$fields];

        try
        {
          $rule = new $rule();

          if(!($rule instanceof Facade_Validator_Interface))
            throw new Exception;
        }
        catch(Exception $exc)
        {
          throw new Facade_Form_Exception(
            'Unrecognized validation rule: "' . $rule . '"' );
        }

        $data = array();
        foreach ($fields as $field)
          $data[] = isset($this->_data[$field])
                  ? $this->_data[$field]
                  : null;
        
        if(!$rule->validate($data))
          $this->$onInvalidation();
      }
  }

  public static function mapper($handler)
  {
    if(!class_exists($handler, true))
      return false;
    
    if(!in_array('Facade_Form', class_parents($handler, true)))
      return false;

    $form = new $handler();

    $form->_composeData();
    $form->onComposedData();
    $form->_validateData();
    $form->validated();

    return true;
  }

  protected function onInvalidation( $message = '' )
  {
    if( $message !== '' )
      Facade_FlashMessage::getInstance()->addMessage( $message, 'error' );

    Facade_Request::reload();
  }
  
  /**
   * This event is triggered after data been composed and filtered. but before 
   * validation process has taken place
   */
  protected function onComposedData()
  {
    // Placeholder if you wanna hook in to this event. Can't be abstract 
    // becouse it then makes a promise to be used in the child classes. This 
    // hook was not constructed to be forced.
  }
  
  abstract protected function validated();
}