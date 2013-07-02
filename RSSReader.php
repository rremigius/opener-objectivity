<?php

/**
 * Description of RSSReader
 *
 * @author remi
 */
class RSSReader {
    
    private $links = array(
            0 => array(0,1),
            1 => array(2,3),
            2 => array(4,5),
            3 => array(6)
        );
    
    public function getLinks($rss) {
        return $this->links[$rss];
    }
    
}

?>
