<?php

/**
 * Library of interface functions and constants for module speedreading
 *
 * All the core Moodle functions, neeeded to allow the module to work
 * integrated in Moodle should be placed here.
 * All the speedreading specific functions, needed to implement all the module
 * logic, should go to locallib.php. This will help to save some memory when
 * Moodle is performing actions across all modules.
 *
 * @package    mod
 * @subpackage speedreading
 * @copyright  2011 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/** example constant */
//define('NEWMODULE_ULTIMATE_ANSWER', 42);

////////////////////////////////////////////////////////////////////////////////
// Moodle core API                                                            //
////////////////////////////////////////////////////////////////////////////////

/**
 * Returns the information on whether the module supports a feature
 *
 * @see plugin_supports() in lib/moodlelib.php
 * @param string $feature FEATURE_xx constant for requested feature
 * @return mixed true if the feature is supported, null if unknown

function speedreading_supports($feature) {
    switch($feature) {
        case FEATURE_MOD_INTRO:         return true;
        default:                        return null;
    }
}
 */
 
 
 
 
 
 
 
 /**
 * @global object
 * @param int $mytimetaken
 * @param int $myscore
 * @param object $speedreading
 * @param object $sr_article
 * @param int $userid
 * @param object $course Course object
 * @param object $cm
 */
 // function will be called after anwering comprehension questions and clicking on a 'submit' button
function speedreading_user_submit_response($mytimetaken, $myscore, $speedreading, $sr_article, $userid, $course, $cm) {

    global $DB, $CFG;
    require_once($CFG->libdir.'/completionlib.php');


   // get an object to represent the table already created (on viewing the article)
   // to hold the student's responses
   $current = $DB->get_record('sr_results', array('sr_id' => $speedreading->id, 'article_id' => $sr_article->id, 'userid' => $userid));
   $newresponse = $current;
   //$newresponse->userid = $userid;
   $newresponse->timetaken = $mytimetaken;
   $newresponse->score = $myscore;
   $DB->update_record("sr_results", $newresponse);

   // Update completion state
   $completion = new completion_info($course);
   if ($completion->is_enabled($cm) && $speedreading->completionsubmit) {
       $completion->update_state($cm, COMPLETION_COMPLETE);
   }
   //add_to_log($course->id, "choice", "choose", "view.php?id=$cm->id", $speedreading->id, $cm->id);
        
}
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
/**
 * Saves a new instance of the speedreading into the database
 *
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will create a new instance and return the id number
 * of the new instance.
 *
 * @param object $speedreading An object from the form in mod_form.php
 * @param mod_speedreading_mod_form $mform
 * @return int The id of the newly inserted speedreading record
 */
function speedreading_add_instance(stdClass $speedreading, mod_speedreading_mod_form $mform = null) {
    global $DB;

    $speedreading->timecreated = time();

    # You may have to add extra stuff in here #
    /**
    *   to insert into the database use this format:
    *       return $DB->insert_record('table_name', $module_name);
    *   e.g.
    *       return $DB->insert_record('speedreading', $speedreading);
    *   here $speedreading is a class instance that contains / is passed
    *   all of the variables which were set in mod_form.php
    *   e.g.
    *       variable article would be accesses as $speedreading->article
    **/

    
    
    $dir = '/Library/WebServer/Documents/moodle/mod/speedreading/mylogfile.log';
    $fp =  fopen($dir, 'a');   
    fwrite($fp, "----------------------------------\n");
    fwrite($fp, "Name:  $speedreading->name");
    
    /*
    for ($a = 1; $a<article.count(); $a++) {
        $next = $speedreading->article[$a];
        fwrite($fp, "Article:\n $next"); 
    }
    */    
    



    
    // speedreading top level table    
    $speedreading->id = $DB->insert_record('speedreading', $speedreading);
    

    // article
    $article = new stdClass();
    $article->sr_id = $speedreading->id;
    $text = $speedreading->article['text'];
    $article->article = $text;
    $article->numberofwords = str_word_count($text);
    $article->timetaken = 180;    
    $article->id = $DB->insert_record("sr_article", $article);
    
    
    fwrite($fp, "\n-------------- IDs -------------\n");
    fwrite($fp, "speedreading id: {$speedreading->id} \n");
    fwrite($fp, "article id: {$article->id} \n");
    
        

    for ($q = 1; $q <= 10; $q++) {
    
         // questions
        $questions = new stdClass();
        $questions->sr_id = $speedreading->id;
        $questions->article_id = $article->id;   
        $que = "question{$q}";
        // format:  question{$q}
        $questions->question = $speedreading->$que;
        $questions->id = $DB->insert_record("sr_questions", $questions);
        fwrite($fp, "questions id: {$questions->id} \n");
        
        for ($a = 1; $a <= 4; $a++) {
            $ans = "answer{$q}-{$a}";
            $sco = "score{$q}-{$a}";
            // answers
            $answers = new stdClass();
            $answers->sr_id = $speedreading->id;
            $answers->article_id = $article->id;
            $answers->question_id = $questions->id;
            
                // format:  answer{$q}-{$a}
            $answers->answer = $speedreading->$ans;
            $answers->score = $speedreading->$sco;
            $answers->id = $DB->insert_record("sr_answers", $answers);
            fwrite($fp, "answers id: {$answers->id} \n");
        }
    }
    




    fclose($fp);
    return $speedreading->id;
}







































/**
 * Updates an instance of the speedreading in the database
 *
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will update an existing instance with new data.
 *
 * @param object $speedreading An object from the form in mod_form.php
 * @param mod_speedreading_mod_form $mform
 * @return boolean Success/Fail
 */
function speedreading_update_instance(stdClass $speedreading, mod_speedreading_mod_form $mform = null) {
    global $DB;

    $speedreading->timemodified = time();
    $speedreading->id = $speedreading->instance;

    # You may have to add extra stuff in here #

    return $DB->update_record('speedreading', $speedreading);
}

/**
 * Removes an instance of the speedreading from the database
 *
 * Given an ID of an instance of this module,
 * this function will permanently delete the instance
 * and any data that depends on it.
 *
 * @param int $id Id of the module instance
 * @return boolean Success/Failure
 */
function speedreading_delete_instance($id) {
    global $DB;

    if (! $speedreading = $DB->get_record('speedreading', array('id' => $id))) {
        return false;
    }

    # Delete any dependent records here #

    $DB->delete_records('speedreading', array('id' => $speedreading->id));

    return true;
}

/**
 * Returns a small object with summary information about what a
 * user has done with a given particular instance of this module
 * Used for user activity reports.
 * $return->time = the time they did it
 * $return->info = a short text description
 *
 * @return stdClass|null
 */
function speedreading_user_outline($course, $user, $mod, $speedreading) {

    $return = new stdClass();
    $return->time = 0;
    $return->info = '';
    return $return;
}

/**
 * Prints a detailed representation of what a user has done with
 * a given particular instance of this module, for user activity reports.
 *
 * @param stdClass $course the current course record
 * @param stdClass $user the record of the user we are generating report for
 * @param cm_info $mod course module info
 * @param stdClass $speedreading the module instance record
 * @return void, is supposed to echp directly
 */
function speedreading_user_complete($course, $user, $mod, $speedreading) {
}

/**
 * Given a course and a time, this module should find recent activity
 * that has occurred in speedreading activities and print it out.
 * Return true if there was output, or false is there was none.
 *
 * @return boolean
 */
function speedreading_print_recent_activity($course, $viewfullnames, $timestart) {
    return false;  //  True if anything was printed, otherwise false
}

/**
 * Prepares the recent activity data
 *
 * This callback function is supposed to populate the passed array with
 * custom activity records. These records are then rendered into HTML via
 * {@link speedreading_print_recent_mod_activity()}.
 *
 * @param array $activities sequentially indexed array of objects with the 'cmid' property
 * @param int $index the index in the $activities to use for the next record
 * @param int $timestart append activity since this time
 * @param int $courseid the id of the course we produce the report for
 * @param int $cmid course module id
 * @param int $userid check for a particular user's activity only, defaults to 0 (all users)
 * @param int $groupid check for a particular group's activity only, defaults to 0 (all groups)
 * @return void adds items into $activities and increases $index
 */
function speedreading_get_recent_mod_activity(&$activities, &$index, $timestart, $courseid, $cmid, $userid=0, $groupid=0) {
}

/**
 * Prints single activity item prepared by {@see speedreading_get_recent_mod_activity()}

 * @return void
 */
function speedreading_print_recent_mod_activity($activity, $courseid, $detail, $modnames, $viewfullnames) {
}

/**
 * Function to be run periodically according to the moodle cron
 * This function searches for things that need to be done, such
 * as sending out mail, toggling flags etc ...
 *
 * @return boolean
 * @todo Finish documenting this function
 **/
function speedreading_cron () {
    return true;
}

/**
 * Returns all other caps used in the module
 *
 * @example return array('moodle/site:accessallgroups');
 * @return array
 */
function speedreading_get_extra_capabilities() {
    return array();
}

////////////////////////////////////////////////////////////////////////////////
// Gradebook API                                                              //
////////////////////////////////////////////////////////////////////////////////

/**
 * Is a given scale used by the instance of speedreading?
 *
 * This function returns if a scale is being used by one speedreading
 * if it has support for grading and scales. Commented code should be
 * modified if necessary. See forum, glossary or journal modules
 * as reference.
 *
 * @param int $speedreadingid ID of an instance of this module
 * @return bool true if the scale is used by the given speedreading instance
 */
function speedreading_scale_used($speedreadingid, $scaleid) {
    global $DB;

    /** @example */
    if ($scaleid and $DB->record_exists('speedreading', array('id' => $speedreadingid, 'grade' => -$scaleid))) {
        return true;
    } else {
        return false;
    }
}

/**
 * Checks if scale is being used by any instance of speedreading.
 *
 * This is used to find out if scale used anywhere.
 *
 * @param $scaleid int
 * @return boolean true if the scale is used by any speedreading instance
 */
function speedreading_scale_used_anywhere($scaleid) {
    global $DB;

    /** @example */
    if ($scaleid and $DB->record_exists('speedreading', array('grade' => -$scaleid))) {
        return true;
    } else {
        return false;
    }
}

/**
 * Creates or updates grade item for the give speedreading instance
 *
 * Needed by grade_update_mod_grades() in lib/gradelib.php
 *
 * @param stdClass $speedreading instance object with extra cmidnumber and modname property
 * @return void
 */
function speedreading_grade_item_update(stdClass $speedreading) {
    global $CFG;
    require_once($CFG->libdir.'/gradelib.php');

    /** @example */
    $item = array();
    $item['itemname'] = clean_param($speedreading->name, PARAM_NOTAGS);
    $item['gradetype'] = GRADE_TYPE_VALUE;
    $item['grademax']  = $speedreading->grade;
    $item['grademin']  = 0;

    grade_update('mod/speedreading', $speedreading->course, 'mod', 'speedreading', $speedreading->id, 0, null, $item);
}

/**
 * Update speedreading grades in the gradebook
 *
 * Needed by grade_update_mod_grades() in lib/gradelib.php
 *
 * @param stdClass $speedreading instance object with extra cmidnumber and modname property
 * @param int $userid update grade of specific user only, 0 means all participants
 * @return void
 */
function speedreading_update_grades(stdClass $speedreading, $userid = 0) {
    global $CFG, $DB;
    require_once($CFG->libdir.'/gradelib.php');

    /** @example */
    $grades = array(); // populate array of grade objects indexed by userid

    grade_update('mod/speedreading', $speedreading->course, 'mod', 'speedreading', $speedreading->id, 0, $grades);
}

////////////////////////////////////////////////////////////////////////////////
// File API                                                                   //
////////////////////////////////////////////////////////////////////////////////

/**
 * Returns the lists of all browsable file areas within the given module context
 *
 * The file area 'intro' for the activity introduction field is added automatically
 * by {@link file_browser::get_file_info_context_module()}
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param stdClass $context
 * @return array of [(string)filearea] => (string)description
 */
function speedreading_get_file_areas($course, $cm, $context) {
    return array();
}

/**
 * File browsing support for speedreading file areas
 *
 * @package mod_speedreading
 * @category files
 *
 * @param file_browser $browser
 * @param array $areas
 * @param stdClass $course
 * @param stdClass $cm
 * @param stdClass $context
 * @param string $filearea
 * @param int $itemid
 * @param string $filepath
 * @param string $filename
 * @return file_info instance or null if not found
 */
function speedreading_get_file_info($browser, $areas, $course, $cm, $context, $filearea, $itemid, $filepath, $filename) {
    return null;
}

/**
 * Serves the files from the speedreading file areas
 *
 * @package mod_speedreading
 * @category files
 *
 * @param stdClass $course the course object
 * @param stdClass $cm the course module object
 * @param stdClass $context the speedreading's context
 * @param string $filearea the name of the file area
 * @param array $args extra arguments (itemid, path)
 * @param bool $forcedownload whether or not force download
 * @param array $options additional options affecting the file serving
 */
function speedreading_pluginfile($course, $cm, $context, $filearea, array $args, $forcedownload, array $options=array()) {
    global $DB, $CFG;

    if ($context->contextlevel != CONTEXT_MODULE) {
        send_file_not_found();
    }

    require_login($course, true, $cm);

    send_file_not_found();
}



/**         added by Craig - copied from choice module
 * @uses FEATURE_GROUPS
 * @uses FEATURE_GROUPINGS
 * @uses FEATURE_GROUPMEMBERSONLY
 * @uses FEATURE_MOD_INTRO
 * @uses FEATURE_COMPLETION_TRACKS_VIEWS
 * @uses FEATURE_GRADE_HAS_GRADE
 * @uses FEATURE_GRADE_OUTCOMES
 * @param string $feature FEATURE_xx constant for requested feature
 * @return mixed True if module supports feature, null if doesn't know
 */
function speedreading_supports($feature) {
    switch($feature) {
        case FEATURE_GROUPS:                  return true;
        case FEATURE_GROUPINGS:               return true;
        case FEATURE_GROUPMEMBERSONLY:        return true;
        case FEATURE_MOD_INTRO:               return true;
        case FEATURE_COMPLETION_TRACKS_VIEWS: return true;
        case FEATURE_COMPLETION_HAS_RULES:    return true;
        case FEATURE_GRADE_HAS_GRADE:         return false;
        case FEATURE_GRADE_OUTCOMES:          return false;
        case FEATURE_BACKUP_MOODLE2:          return true;
        case FEATURE_SHOW_DESCRIPTION:        return true;

        default: return null;
    }
}




////////////////////////////////////////////////////////////////////////////////
// Navigation API                                                             //
////////////////////////////////////////////////////////////////////////////////

/**
 * Extends the global navigation tree by adding speedreading nodes if there is a relevant content
 *
 * This can be called by an AJAX request so do not rely on $PAGE as it might not be set up properly.
 *
 * @param navigation_node $navref An object representing the navigation tree node of the speedreading module instance
 * @param stdClass $course
 * @param stdClass $module
 * @param cm_info $cm
 */
function speedreading_extend_navigation(navigation_node $navref, stdclass $course, stdclass $module, cm_info $cm) {
}

/**
 * Extends the settings navigation with the speedreading settings
 *
 * This function is called when the context for the page is a speedreading module. This is not called by AJAX
 * so it is safe to rely on the $PAGE.
 *
 * @param settings_navigation $settingsnav {@link settings_navigation}
 * @param navigation_node $speedreadingnode {@link navigation_node}
 */
function speedreading_extend_settings_navigation(settings_navigation $settingsnav, navigation_node $speedreadingnode=null) {
}
