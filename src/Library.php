<? 

include_once("SortedList.php"); ?>
<html>

<head>
  <title></title>
</head>

<body>

<?php

// compare integer or string input into the list
// input1 data of current node ( cursor ) from integer or string type
// input2 data of added node from integer or string type
function comp ($input1, $input2)
{
    // ak je vstup integer
    if ( is_int($input2) ){
    	if ($input1< $input2) return SMALLER;
    	if ($input1> $input2) return BIGGER;
        if ($input1==$input2) return EQUAL;
    } 
    //ak je vstup string
    elseif ( is_string($input2)  )
    {
        if ( strcasecmp($input1,$input2) <0 ) 
        { 
            return SMALLER;
        } elseif ( strcasecmp($input1,$input2) >0 ) 
        {
            return BIGGER;
        } else 
            return EQUAL;        
    } else 
        echo "Input <b>".$input2."</b> isn`t of integer or text type !";exit;
}

$integer_tituly = array(79,41,48,3,80,90,74,24,83);
$text_tituly = array("orange", "apple", "banana", "raspberry", "mango", "avocado", "kiwi");


echo "I'm about to add integer items ".implode(", ", $integer_tituly)." and text items ".implode(", ", $text_tituly)." into the Library.<br>";
$myIntlist = new SortedList("comp");
$myStrlist = new SortedList("comp");

foreach ($integer_tituly as $num)
{
	$myIntlist->add($num);
}

foreach ($text_tituly as $num)
{
	$myStrlist->add($num);
}


$cursor_int = $myIntlist->head->getNext();
$library_total = $myIntlist->size() + $myStrlist->size();

echo "The Library has ".$library_total." titles in total. Integer titles : ".$myIntlist->size()." String titles : ".$myStrlist->size().".</br>";

echo "<h3>Iterating Library Integer List (increasing order)</h3>";
while ($cursor_int->getNext() != NULL){

	echo $cursor_int->getNodeValue();
    echo "<br>";
    $cursor_int= $cursor_int->getNext();
}

$cursor_str = $myStrlist->head->getNext();
echo "<h3>Iterating Library String List (increasing order) </h3>";
while ($cursor_str->getNext() != NULL){

	echo $cursor_str->getNodeValue();
    echo "<br>";
    $cursor_str= $cursor_str->getNext();
}

echo "<h3>Iterating Library Integer List (decreasing order)</h3>";
$cursor_int = $myIntlist->tail->getPrevious();

while ($cursor_int->getPrevious() != NULL){

	echo $cursor_int->getNodeValue();
    echo "<br>";
    $cursor_int= $cursor_int->getPrevious();
}

echo "<h3>Iterating Library String List (decreasing order)</h3>";
$cursor_str = $myStrlist->tail->getPrevious();

while ($cursor_str->getPrevious() != NULL){

	echo $cursor_str->getNodeValue();
    echo "<br>";
    $cursor_str= $cursor_str->getPrevious();
}

$findme = 24;

echo "<h3>Now I'll try to find an element</h3>";

$gotit = $myIntlist->fetchElement($findme);
if ($gotit)
	echo "I've found: ".$gotit;
else
	echo $findme." is not on the list";

echo "<h3>Now i'll erase a caouple of elements and show the resulting list</h3>";

$toerase = array(3, 41, 80, 10);

echo "Deleting ".implode(", ", $toerase)."<br>";

foreach($toerase as $e)
{
	$myIntlist->deleteElement($e);
}

echo "The list contains ".$myIntlist->size()." elements";

$cursor =& $myIntlist->head->getNext();
echo "<h3>Iterating Forward (increasing order)</h3>";
while ($cursor->getNext() != NULL){

	echo $cursor->getNodeValue();
    echo "<br>";
    $cursor=& $cursor->getNext();
}


echo "<h3>Iterating Backwards (decreasing)</h3>";
$cursor =& $myIntlist->tail->getPrevious();

while ($cursor->getPrevious() != NULL){

	echo $cursor->getNodeValue();
    echo "<br>";
    $cursor=& $cursor->getPrevious();
}


?>
</p>
</body>

</html>
