<?php
namespace DIW\AWIN\Block;

use Magento\Sales\Model\Order;

class OrderConfirmation extends \Magento\Framework\View\Element\Template
{
    protected $_checkoutSession;
    protected $_awinHelper;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Checkout\Model\Session $checkoutSession,
        \DIW\AWIN\Helper\Data $awinHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_checkoutSession = $checkoutSession;
        $this->_awinHelper = $awinHelper;
    }

    protected function _beforeToHtml()
    {
        $this->prepareBlockData();
        return parent::_beforeToHtml();
    }

    protected function buildAwinData(Order $order)
    {
        // The grand total is the full amount, taking into account all Taxes,
        // Discounts, and Shipping Cost.

        // The shipping subtotal is our attempt to calculate the amount of the
        // Grand Total which would relate to shipping costs.
        // The formula we use is:
        // [The full original shipping amount, including all taxes, before
        //  discounts have been applied]
        // Minus:
        // [ The amount that the shipping price was discounted ]

        // The shipping discount tax compensation amount is not taken into
        // consideration. That is: it assumes that shipping costs are not taxed,
        // or that the shipping discount is inclusive of any tax.

        // The item tax is our attempt to calculate the amount of tax which is
        // related only to items, not to shipping.

        // The commissionable amount is the grand total, excluding all shipping
        // related costs and item related taxes.

        // There may be some tax setting configurations where this is not the
        // case. In testing we were not able to find any such configurations,
        // and so those configurations, if they exist, are not handled.
        $shipping_subtotal = (
            $order->getShippingInclTax() -
            $order->getShippingDiscountAmount()
        );
        $item_tax = (
            $order->getTaxAmount() -
            $order->getShippingTaxAmount()
        );
        $commisionable_subtotal = (
            $order->getGrandTotal() -
            $item_tax -
            $shipping_subtotal
        );
        return array(
            'order_id'  => $order->getIncrementId(),
            'order_subtotal' => number_format($commisionable_subtotal, 2, '.', ''),
            'order_currency_code' => $order->getOrderCurrencyCode(),
            'order_coupon_code' => $order->getCouponCode(),
            'awin_advertiser_id' => $this->_awinHelper->getAdvertiserId(),
            'awin_commission_group' => $this->_awinHelper->getCommissionGroup(),
            'awin_channel' => $this->_awinHelper->getChannel(),
            'awin_is_test' => $this->_awinHelper->getIsTest()
        );
    }

    protected function buildAwinPixelUrl(Order $order)
    {
        $awin_data = $this->buildAwinData($order);
        $query_data = array(
            'merchant' => $awin_data['awin_advertiser_id'],
            'amount' => $awin_data['order_subtotal'],
            'ch' => $awin_data['awin_channel'],
            'parts' => $awin_data['awin_commission_group'].':'.$awin_data['order_subtotal'],
            'vc' => $awin_data['order_coupon_code'],
            'cr' => $awin_data['order_currency_code'],
            'ref' => $awin_data['order_id'],
            'testmode' => $awin_data['awin_is_test'] ? '1' : '0'
        );

        $query = '';
        foreach( $query_data as $key => $value ){
            $query .= '&'.urlencode($key).'='.urlencode($value);
        }

        return 'https://www.awin1.com/sread.img?tt=ns&tv=2'.$query;
    }

    protected function prepareBlockData()
    {
        if( !$this->_awinHelper->getEnabled() ){
            $this->addData(['awin_enabled' => false]);
            return;
        }

        $this->addData(['awin_enabled' => true]);
        $order = $this->_checkoutSession->getLastRealOrder();
        if ($order) {
            $this->addData( $this->buildAwinData($order) );
            $this->addData(
                [
                    'awin_pixel_url' => $this->buildAwinPixelUrl($order)
                ]
            );
        }
    }
}
