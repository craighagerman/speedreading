<?php


class mod_speedreading_renderer extends plugin_renderer_base {

    /**
    *   Returns HTML to display instructions and warn students that once they 
    *   have only one attempt, should take as much time as possible and 
    *   must finish within a time limit once they start.
    * @param object
    * @return string (html code)
    **/
  
    public function display_article($article_id, $article) {
      $html =  html_writer::start_tag('div', array('id' => 'srcontentblock', 
                                                    'style' => 'left:50px; width: 600px; font-family:Georgia, Times, serif; font-size:16px; line-height:25px;'));
      $html .= html_writer::tag('h2', 'Instructions:');
      $html .= html_writer::tag('p', 'This is a test of your reading speed. When you are ready click on the Start button below. You will then see a short article of about 500 words. Try to read the article quickly but smoothly. As soon as you finish click on the Continue button. You will then be given 10 multiple-choice comprehension questions on the article. You may not go back to the article. You should answer based on your understanding and memory of the article.', array('id' => 'srtext'));
      $html .= html_writer::tag('h3', 'Note');
      $items = array(
               'The following pages have time limits. This is a test of reading speed so you are not allowed to keep either the article or question page open for a long time. After ~5 minutes the page will automatically close.',
               'You are only allowed one attempt. If you close either the article or question page you will not be allowed to restart again. Once you begin you must finish.',
               'The whole activity should take less than 15 minutes.',
               'You should aim to read the article in about 3 minutes and complete the questions in about 12 minutes.'
                     );
      $html .= html_writer::alist($items);
      $html .= html_writer::end_tag('div');
      $html .= html_writer::tag('button', 'Start reading', array(  'type' => 'button', 
                                                                  'class' => 'g-button green', 
                                                                     'id' => 'start',                                                               
                                                                'onclick' => 'expandOverlay(' . $article_id . ')'
                                                                ));
      $html .= html_writer::tag('button', 'Stop reading', array(  'type' => 'button', 
                                                                  'class' => 'g-button red', 
                                                                     'id' => 'stop',
                                                                'onclick' => 'getFinishTime()'
                                                                ));
      return $html;
    }



 
    /**
    *   Returns HTML to display 10 comphrension questions + four multiple choice answers
    *  @param object
    *  @return string (html code)
    **/

    public function display_questions($id, $sr_questions) {
      global $DB;
      global $PAGE;
      $url = new moodle_url($PAGE->url);
      
      
      $html =  html_writer::start_tag('div');
          $html .= html_writer::start_tag('form', array(  'name' => 'input', 
                                                        'action' => $url,
                                                        'method' => 'POST' ));
         $html .= html_writer::tag('input', '', array( 'type' => 'hidden',
                                                       'name' =>'id',
                                                      'value' => $id ));

         $html .= html_writer::start_tag('ol');
            // print a question from the database
            foreach($sr_questions as $ques){
               $html .= html_writer::tag('li', $ques->question);
               
               $html .= html_writer::start_tag('ul');
               $html .= html_writer::start_tag('ol');
               $sr_answers = $DB->get_records('sr_answers', array('question_id' => $ques->id));
               foreach($sr_answers as $ans) {
               // use the answer's score (0 or 1) as it's value setting. Then on POST, simply convert each to int and sum.
                  $name = 'ques' . $ques->id;
                  $value = $ans->score;
                  $html .= html_writer::tag('li', '');
                     $html .= html_writer::tag('input', $ans->answer, array( 'type' => 'radio',
                                                                             'name' => $name,
                                                                            'value' => $value ));
               }
               $html .= html_writer::end_tag('ol');
               $html .= html_writer::end_tag('ul');
               $html .= html_writer::tag('hr', '');
            }
         $html .= html_writer::end_tag('ol');
         $html .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
         $html .= html_writer::tag('input', $ans->answer, array( 'type' => 'submit',
                                                                  'name' => 'submit',
                                                                 'class' => 'g-button green',
                                                                 'value' => 'Submit' ));
      $html .= html_writer::end_tag('form');   
      $html .= html_writer::end_tag('div');
      return $html;
    }



    /**
     * Returns HTML to display time and number of correct answers result
     * @param object $timetaken
     * @return string (html code)
     */
    public function display_results($time_taken, $correctanswers) {
        global $PAGE;
        
        $html = html_writer::tag('H2', 'Results');
        $tt = 'Time: ' . $time_taken . '<br>';
        $html .= html_writer::tag('P', $tt);
        $scr = 'Score: ' . $correctanswers . '/10 <br>';
        $html .= html_writer::tag('P', $scr);
        return $html;
    }
    
    
}