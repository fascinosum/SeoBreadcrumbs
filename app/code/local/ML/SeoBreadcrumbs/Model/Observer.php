<?php
/**
 * @package     ML_SeoBreadcrumbs
 * @author      ML <fascinano(at)gmail.com>
 * @license     http://opensource.org/licenses/gpl-3.0.html GPL-3.0
 */

class ML_SeoBreadcrumbs_Model_Observer
{
    public function checkBreadcrumbs($observer)
    {
        $action = $observer->getControllerAction();
        $request = $action->getRequest();
        $categoryId = (int) $request->getParam('category');
        $productId  = (int) $request->getParam('id');
        if (!$categoryId && $productId) {
            $product = Mage::getModel('catalog/product')
                ->setId($productId);

            $categoryCollection = Mage::getModel('catalog/category')->getCollection()
                ->addFieldToFilter('entity_id', array('in' => $product->getCategoryIds()))
                ->addFieldToFilter('level', array('gt' => 1))
                ->setStoreId(Mage::app()->getStore()->getId());
            $categoryCollection->getSelect()
                ->order('level ASC');

            $category = $categoryCollection->getFirstItem();

            if ($category->getId()) {
                $request->setParam('category', $category->getId());
            }
        }
    }
}
