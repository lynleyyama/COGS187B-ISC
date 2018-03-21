<?php
$your_google_calendar="https://google-calendar.galilcloud.wixapps.net/?cacheKiller=1521145987497&amp;compId=comp-ivzvv3fp&amp;deviceType=desktop&amp;height=863&amp;instance=Pj58r2AScWHDbAh3ST4-4IHZQ1tA613g4dbAs98oyAM.eyJpbnN0YW5jZUlkIjoiOTA5ZWE5MWYtYWQ5ZS00NzY0LWJmM2QtN2VjOTllY2I2YWU4IiwiYXBwRGVmSWQiOiIxMjlhY2I0NC0yYzhhLTgzMTQtZmJjOC03M2Q1Yjk3M2E4OGYiLCJzaWduRGF0ZSI6IjIwMTgtMDMtMTVUMjA6MzI6NTcuODgwWiIsInVpZCI6bnVsbCwiaXBBbmRQb3J0IjoiMTY5LjIyOC45OS4xMjgvNTkxMjQiLCJ2ZW5kb3JQcm9kdWN0SWQiOm51bGwsImRlbW9Nb2RlIjpmYWxzZSwiYWlkIjoiMWMyOGM3MWMtZTI0Mi00YjM1LWI1MjEtYjQxZmQ4M2Y3NGFhIiwiYmlUb2tlbiI6IjViYWFiN2E3LWQwZTUtMDdlNC0wZDBiLWIzMDI4NWE3OWUyMyIsInNpdGVPd25lcklkIjoiYzcwNmUyNjMtZmUxYS00MzdkLWI4N2UtNjgzM2E2OTNhNzczIn0&amp;locale=en&amp;pageId=c1dmp&amp;viewMode=site&amp;vsi=8f35cb07-f031-417f-97c9-3252bc9360f8&amp;width=980";

$url= parse_url($your_google_calendar);
$google_domain = $url['scheme'].'://'.$url['host'].dirname($url['path']).'/';

// Load and parse Google's raw calendar
$dom = new DOMDocument;
$dom->loadHTMLfile($your_google_calendar);

// Create a link to a new CSS file called schedule.min.css
$element = $dom->createElement('link');
$element->setAttribute('type', 'text/css');
$element->setAttribute('rel', 'stylesheet');
$element->setAttribute('href', '/css/schedule.min.css');

// Change Google's JS file to use absolute URLs
$scripts = $dom->getElementsByTagName('script');

foreach ($scripts as $script) {
  $js_src = $script->getAttribute('src');
  
  if ($js_src) {
    $parsed_js = parse_url($js_src, PHP_URL_HOST);
    if (!$parsed_js) {
      $script->setAttribute('src', $google_domain . $js_src);      
    }
  }
}

 // Append this link at the end of the element
$head = $dom->getElementsByTagName('head')->item(0);
$head->appendChild($element);

// Remove old stylesheet
$oldcss = $dom->documentElement;
$link = $oldcss->getElementsByTagName('link')->item(0);
$head->removeChild($link);

// Export the HTML
echo $dom->saveHTML();
?>