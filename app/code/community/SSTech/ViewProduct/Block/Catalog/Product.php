<?php

class SSTech_ViewProduct_Block_Catalog_Product extends SSTech_ViewProduct_Block_Abstract
{
	public function getItemType()
	{
		return 'Product';
	}
	
	public function shouldAddButton()
	{
		return $this->getRequest()->getParam('id', false) && $this->getItemUrl();
	}

	public function getItemUrl()
	{
		if (!$this->hasItemUrl()) {
			$this->setItemUrl(false);

			if ($this->getProduct() && $this->canShow($this->getProduct())) {
				if ($this->getStore()) {
					$this->getProduct()->setStoreId($this->getStore()->getId());
				}
				
				$itemUrl = $this->getProduct()->getProductUrl();
				
				$this->setItemUrl($itemUrl);
			}
		}
		
		return $this->getData('item_url');
	}
	public function getProduct()
	{
		return Mage::registry('product');
	}
	public function canShow(Mage_Catalog_Model_Product $product)
	{
		return is_object($product) && $product->getId() 
				&& in_array($product->getVisibility(), array(2,4)) && $product->getStatus() == 1;
	}
}	
