<?php
	class CatalogModel extends dataAccessHandler{

		public function __construct(){
			parent::__construct("catalog.xml");
		}

		public function __destruct(){
			parent::__destruct();
		}

		/**
		 * Takes in a collection of entities (cart or sales) and returns catalog entities in thier place
		 *
		 * @param list $entities
		 */
		public function getCatalogItems($entities){
			$catalogEntities = array();
			foreach ($entities as $entity) {
				$itemID = $entity->getItemID();
				$item = $this->read($itemID);
				$tempEntity = new CatalogItem($item['name'], $item['description'], $item['price'], $item['quantity'], $item['image'], $item['salePrice'], $item['id']);
				array_push($catalogEntities, $tempEntity);
			}

			return $catalogEntities;
		}

		public function getListing($lowerBound, $upperBound){
			$listing = array();
			for ($i=$lowerBound; $i < $upperBound; $i++) { 
				$item = $this->read("item_$i");
				if(is_null($item)){
					continue;
				}
				$tempEntity = new CatalogItem($item['name'], $item['description'], $item['price'], $item['quantity'], $item['image'], $item['salePrice'], $item['id']);
				array_push($listing, $tempEntity);
			}
			return $listing;
		}

		public function getItem($partialID){
			$itemID = "item_".$partialID;
			$item = $this->read($itemID);
			return new CatalogItem($item['name'], $item['description'], $item['price'], $item['quantity'], $item['image'], $item['salePrice'], $item['id']);
		}

		public function getAll(){
			$listing = array();
			for ($i=0; $i <= $this->getLastInsertID(); $i++) { 
				$item = $this->read("item_$i");
				if(is_null($item)){
					continue;
				}
				$tempEntity = new CatalogItem($item['name'], $item['description'], $item['price'], $item['quantity'], $item['image'], $item['salePrice'], $item['id']);
				array_push($listing, $tempEntity);
			}
			return $listing;
		}

		public function updateItem($entity){
			return $this->updateXML($entity);
		}

		public function updateCatalog($name, $description, $price, $quantity, $image, $salePrice, $id = null){
			$catalogEntity = new CatalogItem($name, $description, $price, $quantity, $image, $salePrice, $id);
			return $this->updateXML($catalogEntity);
		}
	}
?>