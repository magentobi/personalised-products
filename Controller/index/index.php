<?php

namespace Richdynamix\PersonalisedProducts\Controller\Index;

use \Magento\Framework\Session\SessionManager;
use \Richdynamix\PersonalisedProducts\Model\Frontend\Catalog\Product\ProductList\Crosssell as PersonalisedCrosssell;
use \Magento\Customer\Model\Session as CustomerSession;

class Index extends \Magento\Framework\App\Action\Action {

    protected $resultPageFactory;

    protected $_sessionManager;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        SessionManager $sessionManager,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        CustomerSession $customerSession,
        PersonalisedCrosssell $crosssell
    )
    {
        $this->_sessionManager = $sessionManager;
        $this->_productFactory = $productFactory;
        $this->_customerFactory = $customerFactory;
        $this->_orderFactory = $orderFactory;
        $this->_crosssell = $crosssell;
        $this->_customerSession = $customerSession;
        parent::__construct($context);
    }

    public function execute()
    {

        $product = $this->_productFactory->create();
        $collection = $product->getCollection()
            ->addAttributeToFilter('visibility', 4);

        var_dump($collection->getAllIds());
//        return $collection->getAllIds();

        foreach ($collection->getAllIds() as $productId) {
            $cats = $this->_getProductCategoryCollection($productId);

            var_dump($cats);
            exit;
        }

    }

        protected function _getProductCategoryCollection($productId)
    {
        // todo fix issue with session area not being set when filtering categories
        $product = $this->_productFactory->create()->load($productId);
        return $product->getCategoryIds();
//        return [];
    }


}