<?php
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

    if ( $method == true ) $this->value = [$this, $func]( ...$args );               // is it's method we don't pass value
    else                   $this->value = $func         ( $this->value, ...$args );

        if ( $this->_MODE == self::RETURN ) return $this->value;
    elseif ( $this->_MODE == self::CHAIN  ) return $this       ;
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

}
