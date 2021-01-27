<?php
/**
 * Magezon
 *
 * This source file is subject to the Magezon Software License, which is available at https://www.magezon.com/license
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to https://www.magezon.com for more information.
 *
 * @item  Magezon
 * @package   Magezon_Builder
 * @copyright Copyright (C) 2019 Magezon (https://www.magezon.com)
 */

namespace Magezon\Builder\Controller\Adminhtml\Ajax;

class LoadConfig extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\LayoutFactory
     */
    protected $layoutFactory;

    /**
     * @var \Magento\Framework\Stdlib\ArrayManager
     */
    protected $arrayManager;

    /**
     * @var \Magezon\Builder\Model\CompositeConfigProvider
     */
    protected $configProvider;

    /**
     * @var \Magezon\Builder\Model\CacheManager
     */
    protected $cacheManager;

    /**
     * @param \Magento\Backend\App\Action\Context            $context        
     * @param \Magento\Framework\View\LayoutFactory          $layoutFactory  
     * @param \Magento\Framework\Stdlib\ArrayManager         $arrayManager   
     * @param \Magezon\Builder\Model\CompositeConfigProvider $configProvider 
     * @param \Magezon\Builder\Model\CacheManager            $cacheManager   
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\LayoutFactory $layoutFactory,
        \Magento\Framework\Stdlib\ArrayManager $arrayManager,
        \Magezon\Builder\Model\CompositeConfigProvider $configProvider,
        \Magezon\Builder\Model\CacheManager $cacheManager
    ) {
        parent::__construct($context);
        $this->layoutFactory  = $layoutFactory;
        $this->arrayManager   = $arrayManager;
        $this->configProvider = $configProvider;
        $this->cacheManager   = $cacheManager;
    }

    /**
     * Add product to shopping cart action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute()
    {
        $result['status'] = false;
        try {
            $class = $this->getRequest()->getPost('class');
            $key   = $this->getRequest()->getPost('key');
            $area  = $this->getRequest()->getPost('area');
            if ($cacheData = $this->cacheManager->getFromCache($key . $area)) {
                $result = $cacheData;
            } else {
                if ($class) {
                    $block  = $this->layoutFactory->create()->createBlock($class);
                    $config = $block->getBuilderConfig();
                } else {
                    $config = $this->configProvider->getConfig();
                }
                $row = $this->arrayManager->get($key, $config, [], '.');
                if (isset($row['class'])) {
                    $obj = $this->_objectManager->create($row['class']);
                    if (method_exists($obj, 'addData')) {
                        $obj->addData($row);
                    }
                    if (method_exists($obj, 'getConfig')) {
                        $result['config'] = $obj->getConfig();    
                    } else if (method_exists($obj, 'getOptions')) {
                        $result['config'] = $obj->getOptions();
                    }
                }
                if ((isset($row['cache']) && $row['cache']) || !isset($row['cache'])) {
                    $this->cacheManager->saveToCache($key . $area, $result);
                }
            }
            $result['status'] = true;
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $result['message'] = $e->getMessage();
        } catch (\Exception $e) {
            $result['message'] = __('Something went wrong while process the request.');
        }
        $this->getResponse()->setBody($this->_objectManager->get(\Magento\Framework\Json\Helper\Data::class)->jsonEncode($result));
    }
}