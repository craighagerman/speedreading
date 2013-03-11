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
     * Moodle renderer used to display special elements of the lesson module
     *
     * You can have a rather longer description of the file as well,
     * if you like, and it can span multiple lines.
     *
     * @package    mod
     * @subpackage speedreading
     * @copyright  2011 Craig Hagerman
     * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
     */





class mod_speedreading_renderer extends plugin_renderer_base {




    /**
    *   Returns HTML to display instructions and warn students that once they 
    *   have only one attempt, should take as much time as possible and 
    *   must finish within a time limit once they start.
    * @param object
    * @return string (html code)
    **/
    public function display_preamble($title, $article) {
        $html = "<h2>Instructions:</h2><br>";
        $html .= "<p>This is a test of your reading speed. When you are ready click on the Start button below. You will then see a short article of about 500 words. Try to read the article quickly but smoothly. As soon as you finish click on the Continue button. YOu will then be given 10 multiple-choice comprehension questions on the article. You may not go back to the article. You should answer based on your understanding and memory of the article.</p>";
        $html .= "<h3>Note</h3><br>";
        $html .= "<ul>
                      <li>The following pages have time limits. This is a test of reading speed so you are not allowed to keep either the article or question page open for a long time. After ~5 minutes the page will automatically close.</li>
                      <li>You are only allowed one attempt. If you close either the article or question page you will not be allowed to restart again. Once you begin you must finish.</li>
                      <li>The whole activity should take less than 15 minutes.</li>
                      <li>You should aim to read the article in about 3 minutes and complete the questions in about 12 minutes.</li>
                  </ul>";
        $html .= "<div class='greyButton' onclick='history.back()'> <p class ='buttonText'>Cancel</p>   </div>";
        $html .= 
            <<<EOD
            <div class='greenButton' onclick="expandOverlay('
EOD;
        $html .= $title;
        $html .= 
            <<<EOD
            ')"> <p class ='buttonText'>Start</p>    </div>
EOD;

        return $html;
    }


    /**
    *   Returns HTML to display the speed reading article in a distraction-free overlay
    *  @param object 
    *  @return string (html code)   
    **/
    public function display_article($title, $article) {
        $html =
            <<<EOD
            <div class = "overlay">
                <div id="main">

                <div id="leftblock"></div>

                <div id="middleblock">

                    <h1> $title </h1>
                    <p>
                    For he to-day that sheds his blood with me 
                    Shall be my brother; be he ne'er so vile, 
                    This day shall gentle his condition; 
                    And gentlemen in England now-a-bed 
                    Shall think themselves accurs'd they were not here, 
                    And hold their manhoods cheap whiles any speaks 
                    That fought with us upon Saint Crispin's day.
                    </p>
                        <div class="bigButton" onclick="expandOverlay()">
                            <p class ="buttonText">Page 2</p>
                        </div>        
                    </div>
 
                    <div id="rightblock"></div>
                </div>
            </div>
    
EOD;
        return $html;
    }


    /**
    *   Returns HTML to display 10 comphrension questions + four multiple choice answers
    *  @param object
    *  @return string (html code)
    **/
    public function display_questions() {
        $html ='';
        $html .= "<p>display_questions()</p>";
        return $html;
    }


    /**
     * Returns HTML to display time and number of correct answers result
     * @param object $timetaken
     * @return string (html code)
     */
    public function display_results($time_taken, $correctanswers) {
        global $PAGE;
        $html ='';
        $html .= "<p>display_results()</p>";
        return $html;
    }
    
    
    
    

}

