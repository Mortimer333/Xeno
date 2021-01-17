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
    !method_exists( $this, $func ) or $method = true;

    if ( !is_callable($func) ) {

      /**
        * CALL TREE
        */

      // Check methods first
      if ( is_string( $this->value ) && method_exists($this,"str_" . $func) ) {
        $method = true;
        $func = "str_" . $func;
      } elseif ( is_array ( $this->value ) && method_exists($this,"ary_" . $func) ) {
        $method = true;
        $func = "ary_" . $func;
      } elseif ( is_numeric( $this->value ) && filter_var( $this->value, FILTER_VALIDATE_INT  ) !== false && method_exists($this, "int_" . $func) ) {
        $method = true;
        $func = "int_" . $func;
      } elseif ( is_numeric( $this->value ) && filter_var( $this->value, FILTER_VALIDATE_FLOAT) !== false && method_exists($this, "dec_" . $func) ) {
        $method = true;
        $func = "dec_" . $func;
      } elseif ( is_numeric( $this->value ) && method_exists($this, "num_" . $func) ) {
        $method = true;
        $func = "num_" . $func;
      } elseif ( is_object( $this->value ) && method_exists($this, "obj_" . $func) ) {
        $method = true;
        $func = "obj_" . $func;
      } // Then callable functions
      elseif ( is_array ( $this->value ) && is_callable("array_"  . $func) ) $func = "array_"  . $func;
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

    if ( isset($method) ) $this->value = call_user_func_array( [ $this, $func ], $args );
    else                  $this->value = call_user_func_array( $func           , $args );

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
