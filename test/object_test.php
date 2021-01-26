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

      $file = file_get_contents("./object_testcase.json");
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

            if ( sizeof($fun['values']) > 0 ) {
              $type = new Xeno\X($fun['values'][0]);
              $fun['values'] = array_slice($fun['values'], 1);
            } else   $type = new Xeno\X('x');

            $var = call_user_func_array( array($type, $fun['function']), $fun['values'] );
            var_dump($var->get());
          ?>
        </div>
        <?php
      }
     ?>

     <?php
       $obj = new Xeno\X( new DirectoryIterator('D:') );
     ?>
     <div class='func_block'>
       <span class='func_name'>get_class</span> <span class='vars'>( new DirectoryIterator )</span>
     </div>
     <div class="result">
       <?php
         echo $obj->get_class()->get();
       ?>
     </div>

     <?php
       $obj = new Xeno\X( new DirectoryIterator('D:') );
     ?>
     <div class='func_block'>
       <span class='func_name'>get_object_vars</span> <span class='vars'>( new DirectoryIterator )</span>
     </div>
     <div class="result">
       <?php
         print_r($obj->get_object_vars()->get());
       ?>
     </div>

     <?php
       $obj = new Xeno\X( new DirectoryIterator('D:') );
     ?>
     <div class='func_block'>
       <span class='func_name'>get_parent_class</span> <span class='vars'>( new DirectoryIterator )</span>
     </div>
     <div class="result">
       <?php
         print_r($obj->get_parent_class()->get());
       ?>
     </div>

     <?php
       $obj = new Xeno\X( new DirectoryIterator('D:') );
     ?>
     <div class='func_block'>
       <span class='func_name'>method_exists</span> <span class='vars'>( new DirectoryIterator, 'isDot' )</span>
     </div>
     <div class="result">
       <?php
         var_dump($obj->method_exists('isDot')->get());
       ?>
     </div>

     <?php
       $obj = new Xeno\X( new DirectoryIterator('D:') );
     ?>
     <div class='func_block'>
       <span class='func_name'>property_exists</span> <span class='vars'>( new DirectoryIterator, 'file' )</span>
     </div>
     <div class="result">
       <?php
         var_dump($obj->property_exists('file')->get());
       ?>
     </div>

     <?php
       $obj = new Xeno\X( new DirectoryIterator('D:') );
     ?>
     <div class='func_block'>
       <span class='func_name'>is_a</span> <span class='vars'>( new DirectoryIterator, 'SplFileInfo' )</span>
     </div>
     <div class="result">
       <?php
         var_dump($obj->is_a('SplFileInfo')->get());
       ?>
     </div>

  </body>
</html>
