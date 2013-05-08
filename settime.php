<?php
   /*
      NOTE
      Version 1 of this file: simply returned the article with:
         echo $sr_article->article;
      Version 2: return both the article and title as a JSON object
         in order to do so, have to do a new $DB->get_record call
         and create a json object with json_encode()
   */

   require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
   require_once(dirname(__FILE__).'/lib.php');

   $aId=$_POST["q"];


   // $DB->get_record($table, array $conditions, $fields='*', $strictness=IGNORE_MISSING) 
   /// Get a single database record as an object where all the given conditions met.
   /// @param int $strictness IGNORE_MISSING means compatible mode, false returned if record not found, debug message if more found;
   ///                        IGNORE_MULTIPLE means return first, ignore multiple records found(not recommended);
   ///                        MUST_EXIST means throw exception if no record or multiple records found


   $sr_article = $DB->get_record('sr_article', array('id' => $aId), '*', MUST_EXIST);
   $speedreading = $DB->get_record('speedreading', array('id' => $sr_article->sr_id), '*', MUST_EXIST);


   
   $sr_article->timetaken = aId;


   
?>