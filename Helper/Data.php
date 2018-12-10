<?php
namespace DIW\AWIN\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
	public function getConfigValue($key, $storeId = null)
	{
		return $this->scopeConfig->getValue(
			'awin/tracking/'.$key,
			ScopeInterface::SCOPE_STORE,
			$storeId
		);
	}

	public function getEnabled($storeId = null)
	{
		return (
			$this->getConfigValue('enable', $storeId) &&
			strlen($this->getAdvertiserId($storeId))
		);
	}

	public function getAdvertiserId($storeId = null)
	{
		return (string)($this->getConfigValue('advertiser_id', $storeId));
	}

	public function getCommissionGroup($storeId = null)
	{
		return (string)($this->getConfigValue('commission_group', $storeId));
	}

	public function getChannel($storeId = null)
	{
		return (string)($this->getConfigValue('channel', $storeId));
	}

	public function getIsTest($storeId = null)
	{
		return (bool)($this->getConfigValue('test', $storeId));
	}
}
