<?php
namespace Xeno;

class X
{
  protected $value;

  function __construct( $value )
  {
    $this->value = $value;
  }

  function __toString()
  {
    return $this->get();
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

    if ( $method == true ) return [$this, $func] ( ...$args );              // if it's method we don't pass value
    else                   $this->value = $func  ( $this->value, ...$args );

    return $this;
  }

  /**
    *   Gets curent value
    *
    *   @return mixin depends on previously used functions
    */

  public function get ()
  {
    return $this->value;
  }

  /**
    *   Sets curent value
    *
    *   @param mixin depened to which value you want to set
    *
    *   @return X | mixin
    */

  public function set( $value )
  {
    $this->value = $value;
    return $this;
  }

  // all exception for native function which don't take value as its first parameter
  // making them into methods is quicker than preparing arguments in switch or map

  public function explode( string $sep, int $limit = PHP_INT_MAX )
  {
    $this->value = explode( $sep, $this->value, $limit );
    return $this;
  }

  public function str_replace( $search, $replace, int $count = null )
  {
    $this->value = str_replace( $search, $replace, $this->value, $count );
    return $this;
  }

  public function get_html_translation_table( int $table = HTML_SPECIALCHARS , int $flags = ENT_COMPAT , string $encoding = "UTF-8" )
  {
    $this->value = get_html_translation_table( $table, $flags, $encoding );
    return $this;
  }

  public function localeconv()
  {
    $this->value = localeconv();
    return $this;
  }

  public function nl_langinfo( int $item )
  {
    $this->value = nl_langinfo( $item );
    return $this;
  }

  public function setlocale()
  {
    $args = func_get_args();
    $this->value = nl_langinfo( ...$args );
    return $this;
  }

  // Array exceptions

  public function array_combine( array $keys )
  {
    $this->value = array_combine( $keys, $this->value );
    return $this;
  }

  public function ary_combine( array $keys )
  {
    $this->value = array_combine( $keys, $this->value );
    return $this;
  }

  public function array_fill( int $start_index , int $count , mixed $value )
  {
    $this->value = array_fill( $start_index, $count, $value );
    return $this;
  }

  public function array_key_exists( $key )
  {
    $this->value = array_key_exists( $key, $this->value );
    return $this;
  }

  public function ary_key_exists( $key )
  {
    $this->value = array_key_exists( $key, $this->value );
    return $this;
  }

  public function key_exists( $key )
  {
    $this->value = array_key_exists( $key, $this->value );
    return $this;
  }

  public function array_search( $needle , bool $strict = false )
  {
    $this->value = array_search( $needle , $this->value, $strict );
    return $this;
  }

  public function ary_search( $needle , bool $strict = false )
  {
    $this->value = array_search( $needle , $this->value, $strict );
    return $this;
  }

  public function in_array( $needle, bool $strict = false )
  {
    $this->value = in_array( $needle, $this->value, $strict );
    return $this;
  }

  public function range( $start, $end, $step = 1 )
  {
    $this->value = range( $start, $end, $step = 1 );
    return $this;
  }

  public function uasort( $callback )
  {
    uasort( $this->value, $callback );
    return $this;
  }

  public function array_walk_recursive( $callback )
  {
    array_walk_recursive( $this->value, $callback );
    return $this;
  }

  public function ary_walk_recursive( $callback )
  {
    array_walk_recursive( $this->value, $callback );
    return $this;
  }

  public function array_walk( $callback )
  {
    array_walk( $this->value, $callback );
    return $this;
  }

  public function ary_walk( $callback )
  {
    array_walk( $this->value, $callback );
    return $this;
  }

  public function array_map( $callback )
  {
    $this->value = array_map( $callback, $this->value );
    return $this;
  }

  public function ary_map( $callback )
  {
    $this->value = array_map( $callback, $this->value );
    return $this;
  }

  public function uksort( $callback )
  {
    uksort( $this->value, $callback );
    return $this;
  }

  public function usort( $callback )
  {
    usort( $this->value, $callback );
    return $this;
  }

  // object exceptions

  public function get_called_class()
  {
    $this->value = get_called_class(); // it will always return Xeno
    return $this;
  }

  public function get_declared_classes()
  {
    $this->value = get_declared_classes();
    return $this;
  }

  public function get_declared_interfaces()
  {
    $this->value = get_declared_interfaces();
    return $this;
  }

  public function get_declared_traits()
  {
    $this->value = get_declared_traits();
    return $this;
  }

  // PCRE exceptions

  public function preg_replace( $pattern, $replacement, int $limit = -1 , int &$count = null )
  {
    $this->value = preg_replace( $pattern, $replacement, $this->value, $limit, $count );
    return $this;
  }

  public function preg_filter( $pattern, $replacement, int $limit = -1 , int &$count = null )
  {
    $this->value = preg_filter( $pattern, $replacement, $this->value, $limit, $count );
    return $this;
  }

  public function preg_grep( string $pattern, int $flags = 0 )
  {
    $this->value = preg_grep( $pattern, $this->value, $flags );
    return $this;
  }

  // PHP 8
  public function preg_last_error_msg()
  {
    preg_last_error_msg();
    return $this;
  }

  public function preg_last_error() : int
  {
    preg_last_error();
    return $this;
  }

  public function preg_match_all( string $pattern, array &$matches = null , int $flags = 0 , int $offset = 0 )
  {
    $this->value = preg_match_all( $pattern, $this->value, $matches, $flags, $offset );
    return $this;
  }

  public function preg_match( string $pattern, array &$matches = null , int $flags = 0 , int $offset = 0 )
  {
    $this->value = preg_match( $pattern, $this->value, $matches, $flags, $offset );
    return $this;
  }

  public function preg_replace_callback_array( array $pattern, int $limit = -1, int &$count = null, int $flags = 0 )
  {
    $this->value = preg_replace_callback_array( $pattern, $this->value, $limit, $count, $flags );
    return $this;
  }

  public function preg_replace_callback( $pattern, $callback, int $limit = -1, int &$count = null, int $flags = 0 )
  {
    $this->value = preg_replace_callback( $pattern, $callback, $this->value , $limit, $count, $flags );
    return $this;
  }

  public function preg_split( string $pattern, int $limit = -1, int $flags = 0 )
  {
    $this->value = preg_replace_callback( $pattern, $this->value, $limit, $flags );
    return $this;
  }
}
