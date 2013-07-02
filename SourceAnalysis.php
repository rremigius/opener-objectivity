<?php

include_once ("TextAnalysis.php");

/**
 * Description of SourceAnalysis
 *
 * @author remi
 */
class SourceAnalysis {
    
    public $link;
    public $articles;
    public $positives;
    public $negatives;
    public $numArticles;
    
    public function __construct($link) {
        $this->link = $link;
    }
    
    public function add($analysis) {
        $analysis instanceof TextAnalysis;
        $this->articles[] = $analysis;
        $this->numArticles++;
        $this->positives += $analysis->positives;
        $this->negatives += $analysis->negatives;
    }
    
}

?>
