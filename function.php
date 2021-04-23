<?php
function removeStopWords($string)
{
	$blocklistArray = array("a", "about", "above", "after", "again", "against", "all", "am", "an", "and", "any", "are", "aren't", "as",
							"at", "be", "because", "been", "before", "being", "below", "between", "both", "but", "by", "can't", "cannot", "could", 
							"couldn't", "did", "didn't", "do", "does", "doesn't", "doing", "don't", "down", "during", "each", "few", "for", "from", 
							"further", "had", "hadn't", "has", "hasn't", "have", "haven't", "having", "he", "he'd", "he'll", "he's", "her", "here", 
							"here's", "hers", "herself", "him", "himself", "his", "how", "how's", "i", "i'd", "i'll", "i'm", "i've", "if", "in", "into", 
							"is", "isn't", "it", "it's", "its", "itself", "let's", "me", "more", "most", "mustn't", "my", "myself", "no", "nor", "not", 
							"of", "off", "on", "once", "only", "or", "other", "ought", "our", "ours", "ourselves", "out", "over", "own", "same", "shan't", 
							"she", "she'd", "she'll", "she's", "should", "shouldn't", "so", "some", "such", "than", "that", "that's", "the", "their", "theirs", 
							"them", "themselves", "then", "there", "there's", "these", "they", "they'd", "they'll", "they're", "they've", "this", "those", 
							"through", "to", "too", "under", "until", "up", "us", "very", "vs", "was", "wasn't", "we", "we'd", "we'll", "we're", "we've", "were", 
							"weren't", "what", "what's", "when", "when's", "where", "where's", "which", "while", "who", "who's", "whom", "why", "why's", "with",
							"won't", "would", "wouldn't", "you", "you'd", "you'll", "you're", "you've", "your", "yours", "yourself", "yourselves");
	$blacklist = implode("|", $blocklistArray);

	$string = preg_replace('/(?<=\s)('.$blacklist.')(?=\s)/Su', '', $string);
	$string = preg_replace('/^('.$blacklist.')(?=\s)/Su', '', $string);
	$string = preg_replace('/(?<=\s)('.$blacklist.')$/Su', '', $string);
	$string = preg_replace('/^('.$blacklist.')$/Su', '', $string);
	
	return $string;
}
	
function crawlUrl($url)
{
    $dom = new DOMDocument('1.0');
    @$dom->loadHTMLFile($url);
    
	$title = $dom->getElementsByTagName('title')[0]->nodeValue;
	$keywords = '';
	
	$metas = $dom->getElementsByTagName('meta');
    foreach ($metas as $element) {
        $type = $element->getAttribute('name');
		
		if (strtolower($type) == 'keywords') {
			$keywords = strtolower($element->getAttribute('content'));
			break;
		}
    }
	$tagsRemove = array('script', 'style', 'iframe', 'link', 'img', 'a');
	$bodyEle = $dom->getElementsByTagName('body')[0];
	foreach($tagsRemove as $tag){
		$elements = $bodyEle->getElementsByTagName($tag);
		foreach ($elements as $item) {
			$item->parentNode->removeChild($item); 
		}
	}
	
	$body = trim(preg_replace('/\s\s+/', ' ', removeStopWords(strtolower($bodyEle->nodeValue))));
	
	return array('title' => $title, 'keywords' => $keywords, 'body' => $body);
}