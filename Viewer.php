<?php

/**
 * Description of Viewer
 *
 * @author remi
 */
class Viewer {
    
    public function show($sourceAnalyses) {
        echo("<table>\n");
        echo("<tr><th>Source</th><th>Polarity</th>\n");
        foreach($sourceAnalyses as $analysis) {
            if($analysis->numArticles == 0)
                continue;
            $polarity = ($analysis->positives + $analysis->negatives) / $analysis->numArticles;
            echo("<tr>\n");
            $analysis instanceof SourceAnalysis;
            echo("<td>$analysis->link</td>\n");
            echo("<td>$polarity</td>\n");
            echo("</tr>\n");
        }
    }
    
}

?>
