<?php
  require_once '..\src\X.php';
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

      $file = file_get_contents("./array_testcase.json");
      $str_testcase = new Xeno\X( $file );
      $str_testcase->json_decode(true);

      foreach ($str_testcase->get() as $fun) {
        ?><div class='func_block'><?php

        echo "<span class='func_name'>" . $fun['function'] . "</span><span class='vars'> ( ";

        foreach ($fun['values'] as $i => $value) {
          $new_value = $value;
          if (is_string($value)) $new_value = '"' . $new_value . '"';
          if (is_object($value)) $value = (array) $value;
          if (is_array($value))  $new_value = json_encode($new_value, true);
          $new_value = htmlentities($new_value);
          if ($i == 0) echo $new_value;
          else         echo ", " . $new_value;
        }

        echo " )</span></div>";
        ?>
        <div class="result">
          <?php
            $type = new Xeno\X(["a"=>"a","b"=>"b"]);
            $var = call_user_func_array( array($type, $fun['function']), $fun['values'] );
            var_dump($var->get());
          ?>
        </div>
        <?php
      }
     ?>
    <h1 class='title'>Native functions which use user defined function or cannot be defined dynamically</h1>

    <?php
      $ar = ['a' => 'b', 'b' => 'c'];
      $extract = new Xeno\X( $ar );
    ?>
    <div class='func_block'>
      <span class='func_name'>extract</span> <span class='vars'>( )</span>
    </div>
    <div class="result">
      <?php
        $extract->extract();
      ?>
      <br>
      <b>As you can see extract cannot be called by class.</b>
    </div>

    <?php

      function cmp ($a, $b) {
        if ($a == $b) return 0;
        return ($a < $b) ? -1 : 1;
      }

      $ar = ['a' => 4, 'b' => 8, 'c' => -1, 'd' => -9, 'e' => 2, 'f' => 5, 'g' => 3, 'h' => -4];
      $uasort = new Xeno\X( $ar );
    ?>
    <div class='func_block'>
      <span class='func_name'>uasort</span> <span class='vars'>( 'cmp' )</span>
    </div>
    <div class="result">
      <b>Before:</b>
      <br>
      <?php
        print_r( $uasort->get() );
        $uasort->uasort('cmp');
      ?>
      <br>
      <br>
      <b>After:</b>
      <br>
      <?php print_r( $uasort->get() ) ?>
      <br>
      <br>
      <b>usort works differently than normally, it returns sorted array, not bool depending if operation was successful or not</b>
    </div>

    <?php
      $a = "a";
      $b = "b";
      $ar = ['a', 'b'];
      $compact = new Xeno\X( $ar );
    ?>
    <div class='func_block'>
      <span class='func_name'>compact</span> <span class='vars'>( )</span>
    </div>
    <div class="result">
      <?php
        $compact->compact();
        print_r( $compact->get() );
      ?>
      <br>
      <b>As you can see compact like extract cannot be called by class.</b>
    </div>

    <?php
      $ar = ['a' => 'c', 'b' => "a", "b"];
      $recur = new Xeno\X( $ar );
      function test_print($item, $key)
      {
        echo "$key holds $item<br>";
      }
    ?>
    <div class='func_block'>
      <span class='func_name'>array_walk_recursive</span> <span class='vars'>( 'test_print' )</span>
    </div>
    <div class="result">
      <?php
        $recur->walk_recursive('test_print');
      ?>
      <br>
      <br>
      <b>Like usort, array_walk_recursive works differently than normally, it returns sorted array, not bool depending if operation was successful or not</b>
    </div>

    <div class='func_block'>
      <span class='func_name'>array_walk</span> <span class='vars'>( 'test_print' )</span>
    </div>
    <div class="result">
      <?php
        $recur->walk('test_print');
      ?>
      <br>
      <br>
      <b>Like usort, array_walk works differently than normally, it returns sorted array, not bool depending if operation was successful or not</b>
    </div>


    <?php
      // Arrays to compare
      $array1 = array(new stdclass, new stdclass,
                      new stdclass, new stdclass,
                     );

      $array2 = array(
                      new stdclass, new stdclass,
                     );

      // Set some properties for each object
      $array1[0]->width = 11; $array1[0]->height = 3;
      $array1[1]->width = 7;  $array1[1]->height = 1;
      $array1[2]->width = 2;  $array1[2]->height = 9;
      $array1[3]->width = 5;  $array1[3]->height = 7;

      $array2[0]->width = 7;  $array2[0]->height = 5;
      $array2[1]->width = 9;  $array2[1]->height = 2;

      function compare_by_area($a, $b) {
          $areaA = $a->width * $a->height;
          $areaB = $b->width * $b->height;

          if ($areaA < $areaB) {
              return -1;
          } elseif ($areaA > $areaB) {
              return 1;
          } else {
              return 0;
          }
      }
      $ar = new Xeno\X( $array1 );
    ?>
    <div class='func_block'>
      <span class='func_name'>array_udiff</span> <span class='vars'>( $array2, 'compare_by_area' )</span>
    </div>
    <div class="result">
      <?php
        $ar->udiff( $array2, 'compare_by_area' );
        print_r($ar->get());
      ?>
    </div>

    <?php
      function compare($a,$b)
      {
        if ( $a === $b ) return 0;
        return ( $a > $b ) ? 1 : -1;
      }

      $a1 = array( "a" => "red", "b" => "green", "c" => "blue"  );
      $a2 = array( "a" => "red", "b" => "blue" , "c" => "green" );

      $ar = new Xeno\X( $a1 );
    ?>
    <div class='func_block'>
      <span class='func_name'>array_uintersect_assoc</span> <span class='vars'>( $a2, 'compare' )</span>
    </div>
    <div class="result">
      <?php
        $ar->uintersect_assoc( $a2, 'compare');
        print_r( $ar->get() );
      ?>
    </div>

    <?php
      function compare_key($a,$b)
      {
        if ( $a === $b ) return 0;
        return ( $a > $b ) ? 1 : -1;
      }

      function compare_value($a,$b)
      {
        if ( $a === $b ) return 0;
        return ( $a > $b ) ? 1 : -1;
      }

      $a1 = array( "a" => "red", "b" => "green", "c" => "blue" );
      $a2 = array( "a" => "red", "b" => "green", "c" => "green" );

      $ar->set($a1);
    ?>
    <div class='func_block'>
      <span class='func_name'>array_uintersect_uassoc</span> <span class='vars'>( $a2, 'compare_key', 'compare_value' )</span>
    </div>
    <div class="result">
      <?php
        $ar->uintersect_uassoc( $a2, 'compare_key', 'compare_value' );
        print_r( $ar->get() );
      ?>
    </div>

    <?php
      $a1 = array( "a" => "red", "b" => "green", "c" => "blue"  );
      $a2 = array( "a" => "red", "b" => "blue" , "c" => "green" );

      $ar->set($a1);
    ?>
    <div class='func_block'>
      <span class='func_name'>array_udiff_assoc</span> <span class='vars'>( $a2, 'compare' )</span>
    </div>
    <div class="result">
      <?php
        $ar->udiff_assoc( $a2, 'compare' );
        print_r( $ar->get() );
      ?>
    </div>

    <?php
      $a1 = array( "a" => "red", "b" => "green", "c" => "blue" );
      $a2 = array( "a" => "red", "b" => "green", "c" => "green" );

      $ar->set($a1);
    ?>
    <div class='func_block'>
      <span class='func_name'>array_udiff_uassoc</span> <span class='vars'>( $a2, 'compare_key', 'compare_value' )</span>
    </div>
    <div class="result">
      <?php
        $ar->udiff_uassoc( $a2, 'compare_key', 'compare_value' );
        print_r( $ar->get() );
      ?>
    </div>

    <?php
      function sum($carry, $item)
      {
        $carry += $item;
        return $carry;
      }

      $ar->set([1,2,3,4]);

    ?>
    <div class='func_block'>
      <span class='func_name'>array_reduce</span> <span class='vars'>( 'sum' )</span>
    </div>
    <div class="result">
      <?php
        $ar->reduce( 'sum' );
        echo $ar->get();
      ?>
    </div>

    <?php
      function cube($n)
      {
        return ($n * $n * $n);
      }
      $ar->set([0,1,2,3]);
    ?>
    <div class='func_block'>
      <span class='func_name'>array_map</span> <span class='vars'>( 'cube' )</span>
    </div>
    <div class="result">
      <?php
        $ar->map( 'cube' );
        print_r( $ar->get() );
      ?>
    </div>

    <?php
      function key_compare($key1, $key2)
      {
        if ($key1 == $key2)
          return 0;
        else if ($key1 > $key2)
          return 1;
        else
          return -1;
      }

      $array1 = array('blue'  => 1, 'red'  => 2, 'green'  => 3, 'purple' => 4);
      $array2 = array('green' => 5, 'blue' => 6, 'yellow' => 7, 'cyan'   => 8);
      $ar->set($array1);
    ?>
    <div class='func_block'>
      <span class='func_name'>array_intersect_ukey</span> <span class='vars'>( $array2, 'key_compare' )</span>
    </div>
    <div class="result">
      <?php
        $ar->intersect_ukey( $array2, 'key_compare' );
        print_r( $ar->get() );
      ?>
    </div>

    <?php
      $array1 = array("a" => "green", "b" => "brown", "c" => "blue", "red");
      $array2 = array("a" => "GREEN", "B" => "brown", "yellow", "red");
      $ar->set($array1);
    ?>
    <div class='func_block'>
      <span class='func_name'>array_intersect_uassoc</span> <span class='vars'>( $array2, 'strcasecmp' )</span>
    </div>
    <div class="result">
      <?php
        $ar->intersect_ukey( $array2, 'strcasecmp' );
        print_r( $ar->get() );
      ?>
    </div>

    <?php
      function odd($var)
      {
        return $var & 1;
      }

      $array1 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5];
      $array2 = [6, 7, 8, 9, 10, 11, 12];
      $ar->set($array1);
    ?>
    <div class='func_block'>
      <span class='func_name'>array_filter</span> <span class='vars'>( $array2, 'odd' )</span>
    </div>
    <div class="result">
      <?php
        $ar->filter( 'odd' );
        print_r( $ar->get() );
      ?>
    </div>

    <?php
      $array1 = array("a" => "green", "b" => "brown", "c" => "blue", "red");
      $array2 = array("a" => "green", "yellow", "red");
      $ar->set($array1);
    ?>
    <div class='func_block'>
      <span class='func_name'>array_diff_uassoc</span> <span class='vars'>( $array2, 'compare_key' )</span>
    </div>
    <div class="result">
      <?php
        $ar->diff_uassoc( $array2, 'compare_key' );
        print_r( $ar->get() );
      ?>
    </div>

    <?php
      $array1 = array('blue'  => 1, 'red'  => 2, 'green'  => 3, 'purple' => 4);
      $array2 = array('green' => 5, 'blue' => 6, 'yellow' => 7, 'cyan'   => 8);
      $ar->set($array1);
    ?>
    <div class='func_block'>
      <span class='func_name'>array_diff_ukey</span> <span class='vars'>( $array2, 'key_compare' )</span>
    </div>
    <div class="result">
      <?php
        $ar->diff_ukey( $array2, 'key_compare' );
        print_r( $ar->get() );
      ?>
    </div>

    <?php
      $ar->set( array( "a" => 4, "b" => 2, "c" => 8, "d" => 6 ) );
    ?>
    <div class='func_block'>
      <span class='func_name'>uksort</span> <span class='vars'>( 'compare' )</span>
    </div>
    <div class="result">
      <?php
        $ar->uksort( 'compare' );
        print_r( $ar->get() );
      ?>
    </div>

    <?php
      $ar->set( array(3, 2, 5, 6, 1) );
    ?>
    <div class='func_block'>
      <span class='func_name'>usort</span> <span class='vars'>( 'compare' )</span>
    </div>
    <div class="result">
      <?php
        $ar->usort( 'compare' );
        print_r( $ar->get() );
      ?>
    </div>

  </body>
</html>
