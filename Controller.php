<?php

include_once("RSSReader.php");
include_once("SourceAnalysis.php");
include_once("Viewer.php");
include_once("Scraper.php");
include_once("TextAnalyser.php");

/**
 * Description of Controller
 *
 * @author remi
 */
class Controller {
    
    private $rssReader;
    private $rssList = array(0,1,2,3);
    private $sourceAnalysis = array();
    private $scraper;
    private $analyser;
    
    public function __construct() {
        $this->rssReader = new RSSReader();
        $this->scraper = new Scraper();
        $this->analyser = new TextAnalyser();
    }
    
    public function run() {
        foreach($this->rssList as $rsslink) {
            $this->sourceAnalysis[$rsslink] = new SourceAnalysis($rsslink);
            $articlelinks = $this->rssReader->getLinks($rsslink);
            foreach($articlelinks as $articlelink) {
                $text = $this->scraper->scrape($articlelink);
                $analysis = $this->analyser->analyse($text);
		$this->sourceAnalysis[$rsslink]->add($analysis);
            }
        }
        
        $viewer = new Viewer();
        $viewer->show($this->sourceAnalysis);
    }
    
}

?>
