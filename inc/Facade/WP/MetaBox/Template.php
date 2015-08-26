<?php

abstract class Facade_WP_MetaBox_Template
    implements Facade_WP_MetaBox_Template_Interface
{
  public $id;
  public $description;
  public $args;
  protected $_path;

  public function __construct( $id, $description, $args )
  {
    $this->id          = $id;
    $this->description = $description;
    $this->_path       = dirname( __FILE__ )
                       . DIRECTORY_SEPARATOR
                       . 'Template' ;
    $this->args        = $args;
  }

  public function getHtml()
  {
    $filter    = new Facade_Filter_CamelToDashed();
    $ds        = DIRECTORY_SEPARATOR;
    $class     = get_class( $this );
    $name      = explode( '_', $class );
    $template  = $filter->filter(array_pop($name));

    require $this->_path
      . $ds
      . 'html'
      . $ds
      . $template
      . '.phtml';
  }

  protected function getValue( $key )
  {
    return Facade_WP_MetaBox::get( $key );
  }
  
  protected function getArgs()
  {
    return $this->args;
  }
}