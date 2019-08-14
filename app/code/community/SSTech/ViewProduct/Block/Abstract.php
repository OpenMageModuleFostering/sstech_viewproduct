<?php

abstract class SSTech_ViewProduct_Block_Abstract extends Mage_Adminhtml_Block_Template
{
	abstract public function shouldAddButton();
	abstract public function getItemType();
	abstract public function getItemUrl();

	public function getButtonId()
	{
		return 'sstech.view-button';
	}
	
	public function getButtonHtml()
	{
		$buttonenable = Mage::getStoreConfig('viewproduct/settings/view_column_enabled');
		if($buttonenable == "1"){
		$buttonHtml = '<button class="scalable form-button" type="button" id="%s"><span>View %s</span></button>';
		$buttonHtml = '<a href="%s" class="form-button" id="%s" target="_blank" style="margin-left: 5px; padding: 3px 8px 2px; position: relative; text-decoration: none; top: 1px;"><span>%s</span></a>';
		}
		return addslashes(sprintf($buttonHtml, $this->getItemUrl(), $this->getButtonId(), $this->getButtonLabel()));
	}
	
	public function getButtonLabel()
	{
		return $this->__('View %s', $this->getItemType());
	}


	public function getPrimaryStore()
	{
		if (!$this->hasPrimaryStore()) {
			$this->setPrimaryStore(false);
			$websites = Mage::getResourceModel('core/website_collection');
			
			foreach($websites as $website) {
				if ($website->getIsDefault()) {
					$this->setPrimaryStore($website->getDefaultStore());
					break;
				}
			}
		}
		
		return $this->getData('primary_store');
	}

	public function getStore()
	{
		if ($storeId = $this->getRequest()->getParam('store', false)) {
			$currentStore = Mage::getModel('core/store')->load($storeId);
	
			if ($currentStore->getCode() != 'admin') {
				return $currentStore;
			}
		}

		return $this->getPrimaryStore();
	}

}
