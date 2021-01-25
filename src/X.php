<?php
namespace Xeno;

class X
{
  protected $value;
  protected $_MODE;
  public const CHAIN  = 1;
  public const RETURN = 0;

  function __construct( $value, $mode = self::CHAIN )
  {
    if ( $mode != self::CHAIN && $mode != self::RETURN ) throw new \Error( "Tried to create new X class with a wrong mode" );

    $this->value = $value;
    $this->_MODE = $mode;
  }

  public function __call( $func, $args )
  {
    $method = false;

    if ( method_exists( $this, $func ) ) $method = true;
    elseif ( !is_callable($func) ) {

      // CALL TREE
      $type = gettype($this->value); // get type of current value so we can quickly get method prefix

      $method_tree = [
        'string'  => 'str_',
        'array'   => 'ary_',
        'integer' => 'int_',
        'double'  => 'dec_',
        'object'  => 'obj_',
        'boolean'      => '',
        'resource'     => '',
        'unknown type' => '',
      ];

      $new_fn = $method_tree[ $type ] . $func;

      if ( method_exists( $this, $new_fn ) )  {

        $method = true;
        $func = $new_fn;

      } else {

        // Can't think of a way to make this quicker
        if     ( $type == 'array'  && is_callable('array_'  . $func) ) $func = 'array_'  . $func;
        elseif ( $type == 'string' ) {

          if     ( is_callable('str_'    . $func) ) $func = 'str_'    . $func;
          elseif ( is_callable('str'     . $func) ) $func = 'str'     . $func;
          elseif ( is_callable('string_' . $func) ) $func = 'string_' . $func;
          else throw new \BadMethodCallException( $func );

        } else throw new \BadMethodCallException( $func );

      }

    }

    if ( $method == true ) $value = [$this, $func]( ...$args );               // is it's method we don't pass value
    else                   $value = $func         ( $this->value, ...$args );

        if ( $this->_MODE == self::RETURN ) return $value;
    elseif ( $this->_MODE == self::CHAIN  ) {
      $this->value = $value;
      return $this;
    }
  }

  /**
    * Gets curent value
    *
    * @return mixin depends on previously used functions
    */

  public function get ()
  {
    return $this->value;
  }

  /**
    *   Sets curent value
    *
    *   @param mixin depened to which value you want to switch
    *
    *   @return Type | mixin
    */

  public function set( $value )
  {
    $this->value = $value;
    if ( $this->_MODE == self::CHAIN ) return $this       ;
    else                               return $this->value;
  }

  /**
    *   Gets curent value
    *
    *   @param int to which mode switch
    *
    *   @return Type|void depends on which mode is enabled
    */

  public function mode( int $mode )
  {
    if ( $mode != self::CHAIN && $mode != self::RETURN ) throw new \Error( "Tried to change mode with wrong value" );

    $this->_MODE = $mode;

    if ($this->_MODE == self::CHAIN) return $this;
  }

  // all exception for native function which don't take value as first parameter
  // making them into methods is quicker than preparing arguments in switch

  public function explode( string $sep, int $limit = PHP_INT_MAX ) : array
  {
    return explode( $sep, $this->value, $limit );
  }

  public function str_replace( $search, $replace, int $count = null ) : string
  {
    return str_replace( $search, $replace, $this->value, $count );
  }

  public function get_html_translation_table( int $table = HTML_SPECIALCHARS , int $flags = ENT_COMPAT , string $encoding = "UTF-8" ) : array
  {
    return get_html_translation_table( $table, $flags, $encoding );
  }

  public function localeconv()
  {
    return localeconv();
  }

  public function nl_langinfo( int $item )
  {
    return nl_langinfo( $item );
  }

  public function setlocale()
  {
    $args = func_get_args();
    return nl_langinfo( ...$args );
  }

  // Array exceptions

  public function array_combine( array $keys ) : array
  {
    return array_combine( $keys, $this->value );
  }

  public function ary_combine( array $keys ) : array
  {
    return array_combine( $keys, $this->value );
  }

  public function array_fill( int $start_index , int $count , mixed $value ) : array
  {
    return array_fill( $start_index, $count, $value );
  }

  public function array_key_exists( $key ) : int
  {
    return array_key_exists( $key, $this->value );
  }

  public function ary_key_exists( $key ) : int
  {
    return array_key_exists( $key, $this->value );
  }

  public function key_exists( $key ) : int
  {
    return array_key_exists( $key, $this->value );
  }

  public function array_search( $needle , bool $strict = false )
  {
    return array_search( $needle , $this->value, $strict );
  }

  public function ary_search( $needle , bool $strict = false )
  {
    return array_search( $needle , $this->value, $strict );
  }

  public function in_array( $needle, bool $strict = false ) : bool
  {
    return in_array( $needle, $this->value, $strict );
  }

  public function range( $start, $end, $step = 1 ) : array
  {
    return range( $start, $end, $step = 1 );
  }

  public function uasort( $callback ) : array
  {
    uasort( $this->value, $callback );
    return $this->value;
  }

  public function array_walk_recursive( $callback ) : array
  {
    array_walk_recursive( $this->value, $callback );
    return $this->value;
  }

  public function ary_walk_recursive( $callback ) : array
  {
    array_walk_recursive( $this->value, $callback );
    return $this->value;
  }

  public function array_walk( $callback ) : array
  {
    array_walk( $this->value, $callback );
    return $this->value;
  }

  public function ary_walk( $callback ) : array
  {
    array_walk( $this->value, $callback );
    return $this->value;
  }

  public function array_map( $callback ) : array
  {
    return array_map( $callback, $this->value );
  }

  public function ary_map( $callback ) : array
  {
    return array_map( $callback, $this->value );
  }

  public function uksort( $callback ) : array
  {
    uksort( $this->value, $callback );
    return $this->value;
  }

  public function usort( $callback ) : array
  {
    usort( $this->value, $callback );
    return $this->value;
  }

}
