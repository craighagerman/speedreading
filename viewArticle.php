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

   $aId=$_GET["q"];


   // $DB->get_record($table, array $conditions, $fields='*', $strictness=IGNORE_MISSING) 
   /// Get a single database record as an object where all the given conditions met.
   /// @param int $strictness IGNORE_MISSING means compatible mode, false returned if record not found, debug message if more found;
   ///                        IGNORE_MULTIPLE means return first, ignore multiple records found(not recommended);
   ///                        MUST_EXIST means throw exception if no record or multiple records found

   $sr_article = $DB->get_record('sr_article', array('id' => $aId), '*', MUST_EXIST);
   $speedreading = $DB->get_record('speedreading', array('id' => $sr_article->sr_id), '*', MUST_EXIST);


   // create a new table for the student's results
   // set viewed = 1 (true) so that they can't go back and view this article again
   // other fields will be filled in after completing questions
   $newresponse = new stdClass();
   $newresponse->sr_id = $speedreading->id;
   $newresponse->article_id = $sr_article->id;
   $newresponse->datedone = time();
   $newresponse->viewedarticle = 1;
   $newresponse->userid = $USER->id;
   $DB->insert_record("sr_results", $newresponse);

   // make an array to hold the article and title, which can then be encoded as JSON
   // to be sent back through the XMLHTTPrequest
   $current_article = $sr_article->article;
   $current_title = $speedreading->name;
   $cm = $speedreading->course;

   $arr = array('title' => $current_title, 'article' => $current_article, 'courseid' => $cm);

   echo json_encode($arr);
   
?>