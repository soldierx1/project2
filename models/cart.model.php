<?php
	class CartModel extends dataAccessHandler{

		public function __construct(){
			parent::__construct("sales.xml");
		}

		public function __destruct(){
			parent::__destruct();
		}

		public function getListing($lowerBound, $upperBound){
			$listing = array();
			for ($i=$lowerBound; $i < $upperBound; $i++) { 
				$item = $this->read("sale_$i");
				$tempEntity = new CartItem($item['itemID'], $item['quantity'], $item['id']);
				array_push($listing, $tempEntity);
			}
			return $listing;
		}
	}
?>