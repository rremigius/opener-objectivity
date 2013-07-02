<?php

include_once("TextAnalysis.php");

/**
 * Description of TextAnalyser
 *
 * @author remi
 */
class TextAnalyser {

    public function analyse($string) {
        
        // Post request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://opener.olery.com/language-identifier");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        $tokenizer = "http://opener.olery.com/tokenizer";
        $pos_tagger = "http://opener.olery.com/POS-tagger";
        $polarity_tagger = "http://opener.olery.com/polarity-tagger";
        $outlet = "http://opener.olery.com/outlet";
        $data = "input=" . $string . "&kaf=true&callbacks[]=$tokenizer&callbacks[]=$pos_tagger&callbacks[]=$polarity_tagger&callbacks[]=$outlet";
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = json_decode(curl_exec($ch), true);
        $info = curl_getinfo($ch);
        curl_close($ch);

        // Get results from result url
        $result_url = $output['output_url'];
        $xml = new DOMDocument();
        do {
            @$xml->load($result_url);
            //echo "QUI: ".$xml->hasChildNodes();
        } while (strpos($info['http_code'], "500") === 0 || !$xml->hasChildNodes());

        // Process results
        return $this->processResults($xml);
    }
    
    private function processResults($xml) {
        $dom_xpath = new DOMXPath($xml);

        $positive_nodes = $this->get_polarized_ids($dom_xpath, "positive");
        $negative_nodes = $this->get_polarized_ids($dom_xpath, "negative");

        $xpath = "//text/wf";
        $nodelist = $dom_xpath->query($xpath);
        
        $analysis = new TextAnalysis();
        foreach ($nodelist as $n) {
            $wid = $n->attributes->getNamedItem('wid')->textContent;
            $token = $n->textContent;
            
            if (in_array($wid, $positive_nodes))
                $analysis->positives++;
            else if (in_array($wid, $negative_nodes))
                $analysis->negatives++;
        }
        
        return $analysis;
    }

    private function get_polarized_ids($dom_xpath, $polarity) {
        $xpath = '//node()[sentiment/@polarity="' . $polarity . '"]/span/target/@id';

        $nodelist = $dom_xpath->query($xpath);
        $polarized_nodes = array();

        foreach ($nodelist as $n) {
            $polarized_nodes [] = $n->textContent;
        }
        return $polarized_nodes;
    }

}

?>
