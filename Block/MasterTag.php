<?php
namespace DIW\AWIN\Block;

class MasterTag extends \Magento\Framework\View\Element\Template
{
    protected $_awinHelper;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \DIW\AWIN\Helper\Data $awinHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_awinHelper = $awinHelper;
    }

    protected function _beforeToHtml()
    {
        $this->prepareBlockData();
        return parent::_beforeToHtml();
    }

    protected function prepareBlockData()
    {
        if( !$this->_awinHelper->getEnabled() ){
            $this->addData(['awin_enabled' => false]);
            return;
        }

        $this->addData(
            [
                'awin_enabled' => true,
                'awin_advertiser_id' => $this->_awinHelper->getAdvertiserId()
            ]
        );
    }
}
