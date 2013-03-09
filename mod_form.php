<?php

/**
 * The main speedreading configuration form
 *
 * It uses the standard core Moodle formslib. For more info about them, please
 * visit: http://docs.moodle.org/en/Development:lib/formslib.php
 *
 * @package    mod
 * @subpackage speedreading
 * @copyright  2011 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/course/moodleform_mod.php');

/**
 * Module instance settings form
 */
class mod_speedreading_mod_form extends moodleform_mod {   

      private function questions($mform) {
    
         for ($q = 1; $q <= 10; $q++) {
            $mform->addElement('header', 'questionfieldset', $q);
            $ques = "Question {$q}";
            // textarea
            $mform->addElement('textarea', "question{$q}", $ques, 'wrap="virtual" rows="2" cols="90"');
            // textareas for answer choices
            for ($a = 1; $a <= 4; $a++) {
               $ans = "answer {$a}";
               $quesarray=array();
               $quesarray[] =& $mform->createElement('textarea', "answer{$q}-{$a}", "Choice $a", 'wrap="virtual" rows="1" cols="80"');
               $quesarray[] =& $mform->createElement('advcheckbox', "score{$q}-{$a}", '  ', 'correct', array('group' => $a), array(0, 1));
               $mform->addGroup($quesarray, 'quesar', $ans, array(' '), false);
            }
         }
      }


    /**
     * Defines forms elements
     */
    public function definition() {
   
        $mform = $this->_form;

        //-------------------------------------------------------------------------------
        // Adding the "general" fieldset, where all the common settings are showed
        $mform->addElement('header', 'general', get_string('general', 'form'));

        // Adding the standard "name" field
        $mform->addElement('text', 'name', get_string('speedreadingname', 'speedreading'), array('size'=>'64'));
        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEAN);
        }
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $mform->addHelpButton('name', 'speedreadingname', 'speedreading');

        // Adding the standard "intro" and "introformat" fields
        // No reason why this would be useful? so it is commented out.
        $this->add_intro_editor();

        //-------------------------------------------------------------------------------
        // Adding the rest of speedreading settings, spreeading all them into this fieldset
        // or adding more fieldsets ('header' elements) if needed for better logic

        $mform->addElement('header', 'articlefieldset', "Article");
        // ------------------------------------------------------------------------------
        
        
        $mform->addElement('static', 'label2', '', 'Copy the speed reading article below');

        
        // editor
        $mform->addElement('editor', 'article', 'Speed Reading Article');
        $mform->setType('article', PARAM_RAW);
        


        //$mform->addElement('static', 'label3', '', "Hello World");
        $dir = '/Library/WebServer/Documents/moodle/mod/speedreading/mylogfile.log';
        //$dir = $CFG->wwwroot.'/mylogfile.log';
        $fp =  fopen($dir, 'a');   
        fwrite($fp, "My 2nd log message\n");
        fclose($fp);
    
    
        // add 10 questions with 4 answers each
        $this->questions($mform);



        //-------------------------------------------------------------------------------
        // add standard elements, common to all modules
        $this->standard_coursemodule_elements();
        //-------------------------------------------------------------------------------
        // add standard buttons, common to all modules
        $this->add_action_buttons();
    }
}
