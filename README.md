# Xeno

```php

  $str = new Xeno\X(' Hello world ');
  $str->trim()->substr(0,6)->tolower()->replace('ello','ow');

  $array = new Xeno\X(['s','i']);
  $array->merge(['c','k'])->implode(' ');

  echo $str->get() . ' ' . $array->get();

```
# About

This library allows user to use native PHP functions (and all functions defined globally) with chain syntax making them a lot more readable and easier to use.

# Installation

Installation method is via composer and its packagist package [xeno/xeno](https://packagist.org/packages/xeno/xeno).
```
$ composer require xeno/xeno
```

# How to use

Class is named `Xeno\X` and has one argument - the value you want to operate on.

```php
 $int = new Xeno\X(1);
```
## Get, Set

To get a variable - use `get` method and to set it to a new value - use `set`.
```php
  $array = new Xeno\X(['a']);
  $array->set(['b']);     // changing content
  print_r($array->get())  // output Array ( [0] => b )
```
Any other methods are defined by you, are `exceptions` (are native functions redefined as methods because they don't pass `value` as first argument) or are native PHP functions.

# Methods

## Replacing native functions

Xeno methods are placed higher then functions in call tree. If you want to replace native php function with your own just add method with the same name.

### Example
```php
[...] // previous elements in class
  // here we add method which is replacing substr
  public substr ( string $value )
  {
    $this->value = "sub";
    return $this;
  }
[...] // the rest of class

$str = new Xeno\X('a');
// now this methods changes our value to "sub" every time we use it
echo $str->substr()->get(); // output "sub"

```

## Multi assigning

When you want to create method named the same for all types (ex. cut) then add prefix to its name which will define the type it will be operating on:
 - `str_` - string
 - `ary_` - array
 - `obj_` - object
 - `int_` - only integer
 - `dec_` - only float

### Example

```php
[...] // previous elements in class

  public function str_cut (string $value)
  {
    // code
  }

  public function ary_cut (array $value)
  {
    // code
  }

[...] // the rest of class
```

Here I have added two methods `str_cut` and `array_cut`. Both of them you can call by `cut` and script will choose right one by its prefix and current value (or none if you call it on non supported type, in this example it would be integer). Of course you can still call them by their full name but you need to be sure that you are using right values.

```php
  $str = new Xeno\X('Hello world');
  echo $str->cut( 1, 2 )->get();       // output "el"

  $ary = new Xeno\X([' Hello', 'world ']);
  print_r( $ary->cut( 1, 2 )->get() ); // output Array ( [0] => world )

  $int = new Xeno\X(1);
  echo $int->cut( 1, 2 )->get();       // Fatal error: Uncaught BadMethodCallException: cut
```
# Different behavior

Few functions (for purpose of continuity of chain) have different return values :
 - `uasort` - returns sorted array not bool
 - `array_walk_recursive` and `array_walk` - returns sorted array not bool
 - `get_called_class` - will always return `"Xeno\X`;

When class is treated as string it will return current value:

```php
  $str = new Xeno\X('x');
  echo $str; // output 'x'
```

# Performance

The performance depends on how you call methods. Using full names of functions is much faster (3~4x) so in a case when you have thousands of operations it's better to call by using functions full names.

### Some numbers (million iterations):

Full names and native functions :
 - ~0.26 s - without new instance of Xeno each iteration
 - ~0.32 s - with new instance of Xeno each iteration

Full names and methods :
  - ~0.11 s - without new instance of Xeno each iteration
  - ~0.18 s - with new instance of Xeno each iteration

Short names and native function :
 - ~0.67 s - without new instance of Xeno each iteration
 - ~0.79 s - with new instance of Xeno each iteration

Short names and methods :
 - ~0.68 s - without new instance of Xeno each iteration
 - ~0.84 s - with new instance of Xeno each iteration

# Disclaimer

## Performance

For some comparison a million iterations of str_replace on my computer was 0.05 s. That means you shouldn't use this library for any big operations. It's purpose is to enable chain syntax on primitives without installing new packages and having library which will be always updated. If you can install additional stuff on your server I recommend https://github.com/nikic/scalar_objects for better syntax on primitives.

## Dynamic functions

You cannot use few native function with this library because of `Cannot call dynamically` warning. Functions :
 - compact
 - extract
