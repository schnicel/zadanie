<?
/******************************************************************************
 *	   BBBB	     AAA    RRRR    BBBB      AAA    ZZZZZZ  U     U  L           *
 *	   B   B	A	A	R	R   B   B	 A   A       ZZ  U     U  L           *
 *	   B   B   A	 A  R	R   B   B	A	  A	    ZZ   U     U  L           *
 *	   BBBB	   A	 A  RRRR    BBBB    A     A     Z    U     U  L           *
 *	   B   B   AAAAAAA  R  R    B   B   AAAAAAA    Z     U     U  L           *
 *     B    B  A     A  R   R   B    B  A     A   ZZ     U     U  L           *
 *     B    B  A     A  R    R  B    B  A     A  ZZ       U   U   L           *
 *     BBBBB   A     A  R    R  BBBBB   A     A  ZZZZZZ    UUU    LLLLLLL     *
 ******************************************************************************/

/**
 * Title: Sorted Double linked list
 * Description: Implementation of a double linked list in PHP
 * @requires ListNode.php, Iterator.php, ListIterator.php adn LinkedList.php
 * @author Oddleif Halvorsen | leif-h@online.no
 * @enhaced by Mat as "Barbazul" Montes | barbazul@xasamail.com
 * @version 1.0
 */

include_once("LinkedList.php");

/**
 * Definition for comparison results
 */

if (!defined("SMALLER")) define("SMALLER", -1);
if (!defined("EQUAL")) define("EQUAL",  0);
if (!defined("BIGGER")) define("BIGGER",  1);

class SortedList extends LinkedList{

    //@Private:
    var $compare; // The function that receives two elements and compares them

    //@Public:
    /**
     * Initializes a SortedList
     * @param $fcnCompare: String that corresponds to the name of the
     * comparison function. It MUST match the sintax described above or the list
     * won't work.
     */
    function SortedList($fcnCompare){
		//head and tail only points to the head and tail of the list,
		//the list nodes does not point on head and tail! Hence, head and
		//tail are not part of the list.
		$this->head = new ListNode();
		$this->tail = new ListNode();
        $this->head->setNext($this->tail);
        $this->tail->setPrevious($this->head);
		$this->size = 0;

        //checks that the function exists.
        //WARNING: it doesn't check if the function matches the two parameter
        //syntax or its return value. In C++ I used a pointer to function to
        //achieve this but I don't think that's possible with PHP references.
        $fcnCompare = (string) $fcnCompare;
        if (function_exists($fcnCompare)) $this->compare = $fcnCompare;
		else die("The comparison function does not exist<br />\n");

    }

    /**
     * Creates a new node
     * If the list is Empty sets it as the only Node
     * If the list is not empty:
     * Locates the position in which to insert the element
     * Inserts the element mantaining the increasing order
     * @param &$element The element you want to insert in the list.
     */

	function add($element){

        $cursor = $this->head->getNext();
        $located = false;
        $compare = $this->compare;

        // Iterates through the list to locate the place for the insertion
        while ( ($cursor->getNext() != NULL) && (!$located) )
        {
        	$data = $cursor->getNodeValue();
            /* The position is located when the following element is bigger than
            the one given */
            if ($compare($data, $element) == BIGGER)
            	$located = true;

            else
            	$cursor = $cursor->getNext();
        }

        //if the list is empty..
        if ($this->isEmpty())
        {
            //Creates the node
            $newNode = $this->getNewNode($element);

            //Sets both tail and head to point to the node
            $this->head->setNext($newNode);
            $this->tail->setPrevious($newNode);
            $newNode->setNext($this->tail);
            $newNode->setPrevious($this->head);
        }

        //if the position is FIRST and the list isn't empty
        elseif ( $compare($cursor->getNodeValue(),
        					$this->head->nextNode->getNodeValue())==EQUAL )
        {

             //... inserts the node at the begining of the list
             //creates the node
             $newNode = $this->getNewNode($element);

             //add it following the head
             $newNode->setNext($this->head->getNext());
             $newNode->setPrevious($this->head);
             $this->head->setNext($newNode);
             $cursor->setPrevious($newNode);
        }

        else //What regularly does
        	$this->insertNodeInList($this->getNewNode($element), $cursor);

        $this->size++;
    }

    /**
     * Searches for the element in the list
     * If it's found in the list, returns the first Node containing it
     * If it is not found, returns NULL
     * @param $element: The element you want to locate in the list
     */
    function locateElement($element){

        $compare = $this->compare;
     	$located = false;
        $cursor = $this->head->getNext();

        while (($cursor->getNext() != NULL) && (!$located)){
        	//Advances the cursor and retrieves its content
        	$data = $cursor->getNodeValue();

            //If the retrieved element is equal than the one you're looking for
            //then you've found the node!

        	if($compare($data, $element) == EQUAL)
            	$located = true;
            else
            	$cursor = $cursor->getNext();
        }

        if ($located)
        	$locatedNode = $cursor;
        else
        	$locatednode = NULL;

        return $locatedNode;
    }

    /**
     * Searches for the element in the list
     * If it's found in the list, returns a reference to it.
     * If it's not found, returns NULL
     * @param $element: The element you want to locate in the list
     */
    function fetchElement($element){

       $locatedNode = $this->locateElement($element);
       if (is_null($locatedNode))
       		$locatedElement = NULL;
       else
       		$locatedElement = $locatedNode->getNodeValue();
       return $locatedElement;
    }

    /**
     * Locates the element in the list
     * if it's found, detes hte node containing it
     * if it's not found does nothing
     */
    function deleteElement($element){

    	$this->deleteNode( $this->locateElement($element) );

    }

    /**
      * Eliminates the Node indicated by &$node
      * If it's not a Node or the List is empty it does nothing
      * @param &$node: The node you want to delete
      */
    function deleteNode($node){

        if ( !$this->isEmpty() && is_a($node, 'ListNode') ){
        	$nextNode = $node->getNext();
        	$prevNode = $node->getPrevious();

        	$nextNode->setPrevious($node->getPrevious());
        	$prevNode->setNext($node->getNext());

        	$this->size--;
        }

    }
}
?>
