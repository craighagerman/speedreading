<?php
   // lib.php contains utility functions used to submit user responses to the database
   // and update completion status.
   require_once(dirname(__FILE__).'/lib.php');



   $html = ' <html>  <body> ';
   
   
   if (isset($_POST['submit'])) {
      $html .= '<p>' . $_POST['submit'] . '</p>';
      $html .= '<p> Got it </p>';
   }
   $html .= '<hr>';
   
   
   $score = 0;
   for ($i=1; $i<=10; $i++) {
      $var = 'ques' . $i;
      if (isset($_POST[$var])) {
         $score += intval($_POST[$var]);
      }
      else {
         $score += 0;
      }
   }
   
   
   $html .= 'TOTAL = ' . $score . '<br>';

   $html .= '</body>  </html> ';
   echo $html;

?>