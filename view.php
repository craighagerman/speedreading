<?php

    // This file is part of Moodle - http://moodle.org/
    //
    // Moodle is free software: you can redistribute it and/or modify
    // it under the terms of the GNU General Public License as published by
    // the Free Software Foundation, either version 3 of the License, or
    // (at your option) any later version.
    //
    // Moodle is distributed in the hope that it will be useful,
    // but WITHOUT ANY WARRANTY; without even the implied warranty of
    // MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    // GNU General Public License for more details.
    //
    // You should have received a copy of the GNU General Public License
    // along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

    /**
     * Prints a particular instance of speedreading
     *
     * You can have a rather longer description of the file as well,
     * if you like, and it can span multiple lines.
     *
     * @package    mod
     * @subpackage speedreading
     * @copyright  2011 Craig Hagerman
     * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
     */

    /// (Replace speedreading with the name of your module and remove this line)

    require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
    require_once(dirname(__FILE__).'/lib.php');
    // suggested to use the following on stackoverflow as part of using an 
    // external javascript file:
    // http://stackoverflow.com/questions/5915258/how-to-load-external-js-file-into-moodle
    require_once($CFG->libdir . '/pagelib.php');

    $id = optional_param('id', 0, PARAM_INT); // course_module ID, or
    $n  = optional_param('n', 0, PARAM_INT);  // speedreading instance ID - it should be named as the first character of the module
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

    //if ($speedreading->intro) { // Conditions to show the intro can change to look for own settings or whatever
    //    echo $OUTPUT->box(format_module_intro('speedreading', $speedreading, $cm->id), 'generalbox mod_introbox', 'speedreadingintro');
    //}

    // Replace the following lines with you own code

    echo $OUTPUT->heading($speedreading->name);

    $renderer = $PAGE->get_renderer('mod_speedreading');
    echo $renderer->display_preamble($sr_article->id, $sr_article->article);
    //echo $renderer->display_preamble($speedreading->name, $sr_article->article);
    echo '<input type="button" onclick="showAlert();" value="Show alert box">';
    echo '<input type="button" onclick="goToGoogle();" value="Google news">';
    echo '<span id="clock">&nbsp;</span>';
    echo  "<div class='greyButton' onclick='goBack();'> <p class ='buttonText'>Go Back</p>   </div> ";


// if $completion (don't update, don't show activity) display results

    //  display time taken on that article, words-per-minute, correct answers, reading_speed/correct_answers 
    // display a table with reading speed / correct answers for all prior attempts (chronological order)
    // display a graph plotting out reading reading & correct answers with a solid lines to represent:
        // excellect reading speed
        // good reading speed
        // fair reading spped
    // v.2 stats on vocab coverage / frequency band of the article's words 


// if !$completion (activity not completed) display the activity

    // 1. display preamble
        // Article Title
        //     instructions: timed reading, can't stop or continue later.
        //          will time out. aim for ~3 min reading time
        //          answer 10 comp questions after reading
        //  buttons to continue/start or abandon 

    // 2. display article in overlay view (distraction-free)
        // Article Title
        // article
        // small clock
        // button to finish / stop the clock


    // 3. display 10 comphrension questions
        // Article Title
        // 10 questions + answer choices
        // small clock
        // submit button



    // Finish the page
    echo $OUTPUT->footer();




?>