<?php
/***************************************************************
*
*  (c) 2011-2012 Chi Hoang (info@chihoang.de)
*  All rights reserved
*  
***************************************************************/

define ( "EMPTY_NODE", "0" );	
define ( "START_CHAR_COUNT","0" );

class TernaryTreeSub {
		
		//_n - the current node to insert at
		//_payload - the class to associate with the string of text
		//_pos - the position of the char in the key to check against
		//////////////////////////////////////////////////////////////////////////
	function insertSub ( &$_n, $_payload, $_pos )
	{
			//empty pointer from an internal node
		if ( ! is_object ( $_n ) )
		{
			//auto leaf
			$_n = new Node ( $_payload->payload [ $_pos ] );
		}                                                                                        
		
			//we placed the leaf in an appropriate position and will
			//now continue with our new internal node.
		if ( ord ( $_payload->payload [ $_pos ] ) < ord ( $_n->char )  )
		{
			$this->insertSub ( &$_n->left, $_payload,  $_pos );	
		
		} else if ( ord ( $_payload->payload [ $_pos ] ) > ord ( $_n->char ) )
		{
			$this->insertSub ( &$_n->right, $_payload, $_pos );
			
		}  else {
		
			if ( $_pos+1 == strlen ( $_payload->payload ) )
			{
				$_n->word = $_payload; 
				$this->is_leaf = false;
			
			} else {
				
				$this->insertSub ( &$_n->mid, $_payload, $_pos+1 );
		
			}
		}		
	}

	//////////////////////////////////////////////////////////////////////////
	function searchSub ( &$_n, $_key, $_pos )
	{
		//if tree is empty
		if ( !is_object ( $_n ) ) 
			return EMPTY_NODE;

		//if we found a leaf, then this is either it or it does not exist
		else if ( $_n->is_leaf == false )
		{
			//check if we found it or not
			if ( $_n->word->payload == $_key )
			{
				//found it
				return $_n->payload->fetch();

			} else
			{
				//does not exist
				return  $_n->payload->error();
			}
		}

		if ( ord ( $_key[ $_pos ] ) < ord ( $_n->char ) )
		{
			$this->searchSub ( $_n->left, $_key, $_pos );
		}
		else if ( ord ( $_key [ $_pos ] ) > ord ( $_n->char ) )
		{
		
			$this->searchSub ( $_n->right, $_key, $_pos );
		}
	        else
		{
			if ( $_pos+1 == strlen ( $_key ) )
			{
			    return $_n->word->fetch();
			}
			
			    $this->searchSub ( $_n->mid, $_key, $_pos+1 );
			}
		}
	}

///////////////////////////////////////////////////////////////////////////////////////////
//PURPOSE::: the data that is associated with a key, you can store anything in this 
//:::::::::: class that you want to link to your search key
//:::::::::: 
//:::::::::: 
//:::::::::: 
//NOTES::::: use polymorphism and make your own class or just edit this one....
//:::::::::: 
//:::::::::: 
///////////////////////////////////////////////////////////////////////////////////////////
class Payload extends TernaryTreeSub
{
	var $payload;
	
	public function __construct ( $string )
	{
		$this->payload = $string;
	}
	
	public function fetch ( )
	{
		echo $this->payload."\n";
	}
	
	public function error ( )
	{
		echo "Not Found!\n";
	}
};
///////////////////////////////////////////////////////////////////////////////////////////
//PURPOSE::: every node in the tree is a collection of either left, middle and right links
//:::::::::: or the payload. 
//:::::::::: 
//:::::::::: 
//NOTES::::: a node will either store links to nodes or the payload
//:::::::::: 
//:::::::::: 
///////////////////////////////////////////////////////////////////////////////////////////
class Node 
{
		//remember if we are a leaf or not
	var $is_leaf;
		//we are either internal or a leaf (we can overlap the data to save space)
	var $left, $mid, $right;
	var $word, $char;
			
		//if payload is given, then create a leaf
	public function __construct ( $_char=null )
	{ 
		if  ( $_char == null )
		{
			$this->left = EMPTY_NODE; 
			$this->right = EMPTY_NODE;
			$this->mid = EMPTY_NODE;
			$this->is_leaf = false;
			$this->word = $this->char = "";

		} else
		{
			$this->char = $_char; 
			$this->is_leaf = true; 
		}
	}
	
	public function __unset ( $name )
	{
		echo "$name";
	}
}

///////////////////////////////////////////////////////////////////////////////////////////
//PURPOSE::: to store strings of text and associate that text with a container class. 
//:::::::::: 
//:::::::::: 
//:::::::::: 
//:::::::::: 
///////////////////////////////////////////////////////////////////////////////////////////
class TernaryTree extends Payload
{
	var $head;
	
	public function __construct ( )
	{ 
	}
	
	public function Insert ( $_key )
	{
		$this->insertSub ( &$this->head, new Payload ( $_key ), START_CHAR_COUNT );
	}

	public function Search ( $key )
	{
		return $this->searchSub ( $this->head, $key , START_CHAR_COUNT ); 
	}
	
	public function varDump ( )
	{
		var_dump ( $this );
	}
}
?>