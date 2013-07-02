<?php

/**
 * Description of Scraper
 *
 * @author remi
 */
class Scraper {
    
    public $texts = array(
        "This is text",
        "This is a lot of text",
        
        "This text sucks",
        "This text is very bad",
        
        "This text is very good",
        "I don't like this text at all",
        
        "I would eat at this restaurant all day"
    );
    
    public function scrape($link) {
        return $this->texts[$link];
    }
    
}

?>
