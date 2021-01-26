<?php
  require_once '..\src\X.php';

  function microtime_float()
  {
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
  }
?>
<html dir="ltr">
  <head>
    <style media="screen">
      * {
        font-family: sans-serif;
      }

      .func_block {
        padding: 10px 20px;
        border-bottom: 2px solid grey;
        max-width: 1000px;
        width: 95%;
        margin: 40px auto;
        font-size: 24px;
      }

      .func_name {
        font-size: 36px;
        color: #333;
      }

      .vars {
        opacity: .5;
      }

      .result {
        max-width: 800px;
        width: 90%;
        margin: auto;
        background-color: #F6F8FA;
        padding: 20px 40px;
      }

      .title {
        max-width: 800px;
        width: 90%;
        text-align: center;
        margin: 20px auto;
      }
    </style>
  </head>
  <body>
    <?php
      // Milion iterations of full name of native functions with new instance of Xeno each iteration

      $fullNamesNatXeno = [];

      for ($j=0; $j < 6; $j++) {
        $time_start = microtime_float();

        for ($i=0; $i < 10**6; $i++) {
          (new Xeno\X('x'))->substr(0,1);
        }

        $time_end = microtime_float();

        $time = $time_end - $time_start;

        $fullNamesNatXeno[] = $time;
      }

      $sumWith = array_sum($fullNamesNatXeno)/6;

      // Milion iterations of full name of native functions without new instance of Xeno each iteration

      $fullNamesNatNoXeno = [];

      for ($j=0; $j < 6; $j++) {

        $time_start = microtime_float();
        $xeno = new Xeno\X('x');

        for ($i=0; $i < 10**6; $i++) {
          $xeno->substr(0,1);
        }

        $time_end = microtime_float();

        $time = $time_end - $time_start;

        $fullNamesNatNoXeno[] = $time;
      }

      $sumWithout = array_sum($fullNamesNatNoXeno)/6;
    ?>

    <div class='func_block'>
      <span class='func_name'>Full names native functions </span> <span class='vars'>( average of 6 iteration of 10**6 operations  ) :</span>
    </div>
    <div class="result">
      <ul>
        <li>~<?= round($sumWith,4) ?> s - with new instance of Xeno each iteration</li>
        <li>~<?= round($sumWithout,4) ?> s - without new instance of Xeno each iteration</li>
      </ul>
    </div>

    <?php
      // Milion iterations of full name of methods with new instance of Xeno each iteration

      $fullNamesNatXeno = [];

      for ($j=0; $j < 6; $j++) {
        $time_start = microtime_float();

        for ($i=0; $i < 10**6; $i++) {
          (new Xeno\X('x'))->str_replace('x','a');
        }

        $time_end = microtime_float();

        $time = $time_end - $time_start;

        $fullNamesNatXeno[] = $time;
      }

      $sumWith = array_sum($fullNamesNatXeno)/6;

      // Milion iterations of full name of methods without new instance of Xeno each iteration

      $fullNamesNatNoXeno = [];

      for ($j=0; $j < 6; $j++) {

        $time_start = microtime_float();
        $xeno = new Xeno\X('x');

        for ($i=0; $i < 10**6; $i++) {
          $xeno->str_replace('x','a');
        }

        $time_end = microtime_float();

        $time = $time_end - $time_start;

        $fullNamesNatNoXeno[] = $time;
      }

      $sumWithout = array_sum($fullNamesNatNoXeno)/6;
    ?>

    <div class='func_block'>
      <span class='func_name'>Full names methods </span> <span class='vars'>( average of 6 iteration of 10**6 operations  ) :</span>
    </div>
    <div class="result">
      <ul>
        <li>~<?= round($sumWith,4) ?> s - with new instance of Xeno each iteration</li>
        <li>~<?= round($sumWithout,4) ?> s - without new instance of Xeno each iteration</li>
      </ul>
    </div>

    <?php
      // Milion iterations of short name of native functions with new instance of Xeno each iteration

      $shortNamesNatXeno = [];

      for ($j=0; $j < 6; $j++) {
        $time_start = microtime_float();

        for ($i=0; $i < 10**6; $i++) {
          (new Xeno\X(['x']))->count_values();
        }

        $time_end = microtime_float();

        $time = $time_end - $time_start;

        $shortNamesNatXeno[] = $time;
      }

      $sumWith = array_sum($shortNamesNatXeno)/6;

      // Milion iterations of short name of native functions without new instance of Xeno each iteration

      $shortNamesNatNoXeno = [];

      for ($j=0; $j < 6; $j++) {

        $time_start = microtime_float();
        $xeno = new Xeno\X(['x']);

        for ($i=0; $i < 10**6; $i++) {
          $xeno->count_values();
        }

        $time_end = microtime_float();

        $time = $time_end - $time_start;

        $shortNamesNatNoXeno[] = $time;
      }

      $sumWithout = array_sum($shortNamesNatNoXeno)/6;
    ?>

    <div class='func_block'>
      <span class='func_name'>Short names native functions </span> <span class='vars'>( average of 6 iteration of 10**6 operations  ) :</span>
    </div>
    <div class="result">
      <ul>
        <li>~<?= round($sumWith,4) ?> s - with new instance of Xeno each iteration</li>
        <li>~<?= round($sumWithout,4) ?> s - without new instance of Xeno each iteration</li>
      </ul>
    </div>

    <?php
      // Milion iterations of short name of methods with new instance of Xeno each iteration

      $shortNamesNatXeno = [];

      for ($j=0; $j < 6; $j++) {
        $time_start = microtime_float();

        for ($i=0; $i < 10**6; $i++) {
          (new Xeno\X('x'))->replace('x','a');
        }

        $time_end = microtime_float();

        $time = $time_end - $time_start;

        $shortNamesNatXeno[] = $time;
      }

      $sumWith = array_sum($shortNamesNatXeno)/6;

      // Milion iterations of short name of methods without new instance of Xeno each iteration

      $shortNamesNatNoXeno = [];

      for ($j=0; $j < 6; $j++) {

        $time_start = microtime_float();
        $xeno = new Xeno\X('x');

        for ($i=0; $i < 10**6; $i++) {
          $xeno->replace('x','a');
        }

        $time_end = microtime_float();

        $time = $time_end - $time_start;

        $shortNamesNatNoXeno[] = $time;
      }

      $sumWithout = array_sum($shortNamesNatNoXeno)/6;
    ?>

    <div class='func_block'>
      <span class='func_name'>Short names methods </span> <span class='vars'>( average of 6 iteration of 10**6 operations  ) :</span>
    </div>
    <div class="result">
      <ul>
        <li>~<?= round($sumWith,4) ?> s - with new instance of Xeno each iteration</li>
        <li>~<?= round($sumWithout,4) ?> s - without new instance of Xeno each iteration</li>
      </ul>
    </div>

  </body>
</html>
