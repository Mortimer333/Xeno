<?php
class X
{
  protected $value;
  protected $_MODE;
  public const CHAIN  = 1;
  public const RETURN = 0;

  function __construct( $value, $mode = self::CHAIN )
  {
    if ( $mode != self::CHAIN && $mode != self::RETURN ) throw new \Error( "Tried to create new X class with wrong mode" );

    $this->value = $value;
    $this->_MODE = $mode;
  }

  public function __call( $func, $args )
  {

    if ( !is_callable($func) ) {

          if ( is_array( $this->value  ) && is_callable("array_"  . $func) ) $func = "array_"  . $func;
      elseif ( is_string( $this->value ) && is_callable("str_"    . $func) ) $func = "str_"    . $func;
      elseif ( is_string( $this->value ) && is_callable("str"     . $func) ) $func = "str"     . $func;
      elseif ( is_string( $this->value ) && is_callable("string_" . $func) ) $func = "string_" . $func;
      else throw new \BadMethodCallException( $func );

    }

    switch ( $func ) {
      case 'explode' :
        if ( sizeof($args) < 1 ) throw new \BadMethodCallException( "{$func} too few arguments" );
        $args = array_merge( array_merge( [ $args[0] ], [ $this->value ] ), array_slice($args, 1) );
        break;

      case 'implode' :
      case 'join'    :
        $args = array_merge( $args, [ $this->value ] );
        break;

      case 'str_replace' :
        if (sizeof($args) < 2) throw new \BadMethodCallException( "{$func} too few arguments" );
        $args = array_merge( array_merge( array_slice($args,0,2), [ $this->value ] ), array_slice($args,2) );
        break;

      // all cases when we are not using value
      case 'get_html_translation_table' :
      case 'localeconv' :
      case 'nl_langinfo' :
      case 'setlocale' :
        break;

      default :
        $args = array_merge( [ $this->value ], $args );
        break;
    }

    $this->value = call_user_func_array( $func, $args );

        if ( $this->_MODE == self::RETURN ) return $this->value;
    elseif ( $this->_MODE == self::CHAIN  ) return $this       ;
  }

  public function get ()
  {
    return $this->value;
  }

  public function set( $value )
  {
    $this->value = $value;
    if ( $this->_MODE == self::CHAIN ) return $this       ;
    else                               return $this->value;
  }

  public function mode( $mode )
  {
    if ( $mode != self::CHAIN && $mode != self::RETURN ) throw new \Error( "Tried to change mode with wrong value" );

    $this->_MODE = $mode;

    if ($this->_MODE == self::CHAIN) return $this;
  }
}
