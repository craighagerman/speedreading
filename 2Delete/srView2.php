<?php

class mod_speedreading_view2 {

    public function setView($title) {
        $html2 =
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
        return $html2;
    }
}
?>