# Xeno
Makes native PHP functions more bearable and useable.

```php

  $str = new X(' Hello world ');
  $str->trim()->substr(0,6)->tolower()->replace('ello','ow');
  
  $array = new X(['s','i']);
  $array->merge(['c','k'])->implode(' ');
  
  echo $str->get() . ' ' . $array->get();

```
# About

This library allows user to use native PHP functions (and all functions defined globally) with chain syntax making them a lot more readable and easier to use.

# How to use

Class is named `X` and has two arguments: 
 - the value you operate on
 - mode defining class behaviour [OPTIONAL]
```php
 $int = new X(1);
```
Modes :
 - CHAIN - default, allows you to make one operation after another without returning the result and saving it into `value`
 - RETURN - after each method returns the result
 
To specify using different modes you can, while defining the variable, pass as second argument one of the constants `CHAIN` or `RETURN` or use method `mode` (with passed mode to it) to change it . It will set the mode accordingly.
```php
 $str = new X(1, X::RETURN);  // defining new instance with return mode 
 $str->mode(X::CHAIN)         // changing mode to chain
```
To get variable you can use `get` method, to set it use `set`. 
```php
  $array = new X(['a']);
  $array->set(['b']);     // changing content
  print_r($array->get())  // output Array ( [0] => b ) 
```
Any other methods are defined by you or are native PHP functions.
