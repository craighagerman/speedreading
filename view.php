<?php

    require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
    require_once(dirname(__FILE__).'/lib.php');
    
    // suggested to use the following on stackoverflow as part of using an 
    // external javascript file:
    // http://stackoverflow.com/questions/5915258/how-to-load-external-js-file-into-moodle
    require_once($CFG->libdir . '/pagelib.php');

    $id = optional_param('id', 0, PARAM_INT); // course_module ID, or
    $duration = optional_param('tt', 0, PARAM_INT);   // time taken to read the article
    $n  = optional_param('n', 0, PARAM_INT);  // speedreading instance ID - it should be named as the first character of the module

   //$ans1 = optional_param('', null, PARAM_INT);
   for ($i=1; $i<=10; $i++) {
      $var = 'ques' . $i;
      ${"ans".$i} = optional_param($var, 0, PARAM_INT);
   }

    /*
    $action  = optional_param('action', '', PARAM_ALPHA);

    $url = new moodle_url('/mod/speedreading/view.php', array('id'=>$id));
    if ($action !== '') {
        $url->param('action', $action);
    }
    $PAGE->set_url($url);
    */

    if ($id) {
        $cm         = get_coursemodule_from_id('speedreading', $id, 0, false, MUST_EXIST);
        $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
        $speedreading  = $DB->get_record('speedreading', array('id' => $cm->instance), '*', MUST_EXIST);
        $sr_article = $DB->get_record('sr_article', array('sr_id' => $cm->instance), '*', MUST_EXIST);
        
        

    } elseif ($n) {
        $speedreading  = $DB->get_record('speedreading', array('id' => $n), '*', MUST_EXIST);
        $sr_article = $DB->get_record('sr_article', array('sr_id' => $n), '*', MUST_EXIST);
        $course     = $DB->get_record('course', array('id' => $speedreading->course), '*', MUST_EXIST);
        $cm         = get_coursemodule_from_instance('speedreading', $speedreading->id, $course->id, false, MUST_EXIST);
    } else {
        error('You must specify a course_module ID or an instance ID');
    }

    require_login($course, true, $cm);
    $context = get_context_instance(CONTEXT_MODULE, $cm->id);

    add_to_log($course->id, 'speedreading', 'view', "view.php?id={$cm->id}", $speedreading->name, $cm->id);

    /// Print the page header

    $PAGE->set_url('/mod/speedreading/view.php', array('id' => $cm->id));
    $PAGE->set_title(format_string($speedreading->name));
    $PAGE->set_heading(format_string($course->fullname));
    $PAGE->set_context($context);
    $PAGE->requires->css('/mod/speedreading/styles.css');

    // suggested to use the following on stackoverflow as part of using an 
    // external javascript file:
    // http://stackoverflow.com/questions/5915258/how-to-load-external-js-file-into-moodle
    global $PAGE;
    $PAGE->requires->js(new moodle_url($CFG->wwwroot . '/mod/speedreading/javascript/sr.js'), true );


    // Output starts here
    echo $OUTPUT->header();

// ------------------------------------------------------------------------------------------------
    // Replace the following lines with you own code

    echo $OUTPUT->heading($speedreading->name);

    $renderer = $PAGE->get_renderer('mod_speedreading');
    

   $current = $DB->get_record('sr_results', array('sr_id' => $speedreading->id, 'article_id' => $sr_article->id, 'userid' => $USER->id));

   // Display preamble -> (button click) -> speed reading article
   if (!$current ) {
      echo $renderer->display_preamble($sr_article->id, $sr_article->article);

   }
   
   // Display 10 comprehension questions
   else if ($current->viewedquestions == 0) {
      $current->timetaken = $duration;
      $sr_questions = $DB->get_records('sr_questions', array('sr_id' => $cm->instance, 'article_id' => $sr_article->id));
      echo $renderer->display_questions($cm->id, $sr_questions);
      $current->viewedquestions = 1;
      $DB->update_record("sr_results", $current);
   }

   // Display results
   else if (($current->viewedquestions == 1) && !($current->score)) {
      $score = 0;
      for ($i=1; $i<=10; $i++) {
         if (isset(${"ans".$i})) {
            $score += intval(${"ans".$i});
         }
      }
      echo 'Score is: ' . $score;
      $current->score = $score;
      $DB->update_record("sr_results", $current);
      echo $renderer->display_results(gmdate("i:s", $current->timetaken), $current->score);
   }

   else {
      echo $renderer->display_results(gmdate("i:s", $current->timetaken), $current->score);
   }


    // Finish the page
    echo $OUTPUT->footer();





?>