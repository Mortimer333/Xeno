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
    </style>
  </head>
  <body>
    <?php

      $file = file_get_contents("./str_testcase.json");
      $str_testcase = new Xeno\X( $file );
      $str_testcase->json_decode();

      foreach ($str_testcase->get() as $fun) {
        ?><div class='func_block'><?php

        echo "<span class='func_name'>" . $fun->function . "</span><span class='vars'> ( ";

        foreach ($fun->values as $i => $value) {
          $new_value = $value;
          if (is_string($value)) $new_value = '"' . $new_value . '"';
          if (is_array($value))  $new_value = json_encode($new_value);
          $new_value = htmlentities($new_value);
          if ($i == 0) echo $new_value;
          else         echo ", " . $new_value;
        }

        echo " )</span></div>";
        ?>
        <div class="result">
          <?php
            if (sizeof($fun->values) == 0) $fun->values[0] = "";
            $type = new Xeno\X($fun->values[0]);
            $var = call_user_func_array( array($type, $fun->function), array_slice($fun->values,1) );
            var_dump($var->get());
          ?>
        </div>
        <?php
      }

     ?><div class='func_block'><?php

     echo "<span class='func_name'>parse_str</span><span class='vars'> ( \"TEST=Something\" )</span></div>";
     ?>
     <div class="result">
        <?php
          parse_str("TEST=Something");
          var_dump($TEST);
        ?>
     </div>
  </body>
</html>
