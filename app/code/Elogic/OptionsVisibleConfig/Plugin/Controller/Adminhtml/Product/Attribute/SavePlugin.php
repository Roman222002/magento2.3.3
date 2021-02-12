<?php

namespace Elogic\OptionsVisibleConfig\Plugin\Controller\Adminhtml\Product\Attribute;

use Magento\Framework\App\Action\Context;
use Elogic\OptionsVisibleConfig\Api\Data\OptionInterface;
use Elogic\OptionsVisibleConfig\Model\ResourceModel\Option\CollectionFactory as OptionCollectionFactory;
use Magento\Catalog\Controller\Adminhtml\Product\Attribute\Save;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Serialize\Serializer\FormData;
use Magento\Framework\Controller\ResultFactory;

class SavePlugin
{
    /**
     * @var OptionCollectionFactory
     */
    private $optionsCollectionFactory;
    /**
     * @var mixed
     */
    private $formDataSerializer;


    public function __construct(
        OptionCollectionFactory $optionsCollectionFactory,
        FormData $formDataSerializer = null
    )
    {
        $this->optionsCollectionFactory = $optionsCollectionFactory;
        $this->formDataSerializer = $formDataSerializer
        ?: ObjectManager::getInstance()->get(FormData::class);
    }

    public function afterExecute(Save $subject, $result)
    {
        $attributeId = $subject->getRequest()->getParam('attribute_id');

        $optionData = $this->formDataSerializer
            ->unserialize($subject->getRequest()->getParam('serialized_options', '[]'));

        $optionCollection = $this->optionsCollectionFactory->create();
        $optionCollection->addFieldToFilter('attribute_id',$attributeId);
        $arrayOrder = $optionData['option']['order'];
        $arrayOrder = array_diff(array_keys($arrayOrder),array_keys(array_diff($optionData['option']['delete'],array(""))));
        $optionArray = array_combine(array_keys($optionCollection->getItems()),$arrayOrder);
        $arrayVisibleOptions = array();
        foreach (array_keys($optionData['option']['visible']) as $item){
             if(array_search($item,$optionArray))
                 array_push($arrayVisibleOptions,array_search($item,$optionArray));
        }
        foreach ($optionCollection->getItems() as $option){
            /**
             * @var OptionInterface $option
             */
           if(in_array($option->getOptionId(), $arrayVisibleOptions))
               $option->setVisible(1);
           else $option->setVisible(0);
           $option->save();
        }
        return $result;
    }
}