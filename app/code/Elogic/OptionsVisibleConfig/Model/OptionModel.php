<?php


namespace Elogic\OptionsVisibleConfig\Model;

use Elogic\OptionsVisibleConfig\Api\Data\OptionInterface;
use Elogic\OptionsVisibleConfig\Model\ResourceModel\OptionResourceModel;
use Magento\Framework\Model\AbstractModel;

class OptionModel extends AbstractModel implements OptionInterface
{

    public function _construct()
    {
        $this->_init(OptionResourceModel::class);
    }

    /**
     * @return array|mixed|null
     */
    public function getOptionId()
    {
        return $this->getData(OptionInterface::OPTION_ID);
    }

    /**
     * @return array|mixed|null
     */
    public function getAttributeId()
    {
        return $this->getData(OptionInterface::ATTRIBUTE_ID);

    }

    /**
     * @return array|mixed|null
     */
    public function getSortOrder()
    {
        return $this->getData(OptionInterface::SORT_ORDER);
    }

    /**
     * @return array|mixed|null
     */
    public function getVisible()
    {
        return $this->getData(OptionInterface::VISIBLE);
    }

    /**
     * @param $id
     * @return OptionInterface
     */
    public function setAttributeId($id): OptionInterface
    {
        return $this->setData(OptionInterface::ATTRIBUTE_ID, $id);
    }

    /**
     * @param $order
     * @return OptionInterface
     */
    public function setSortOrder($order): OptionInterface
    {
        return $this->setData(OptionInterface::SORT_ORDER, $order);
    }

    /**
     * @param $visible
     * @return OptionInterface
     */
    public function setVisible($visible): OptionInterface
    {
        return $this->setData(OptionInterface::VISIBLE, $visible);
    }
}