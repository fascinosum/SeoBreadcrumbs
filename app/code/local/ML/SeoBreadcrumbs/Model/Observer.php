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
            $categoryId = reset($product->getCategoryIds());
            $category = Mage::getModel('catalog/category')->load($categoryId);
            if ($category->getId()) {
                $request->setParam('category', $category->getId());
            }
        }
    }
}
