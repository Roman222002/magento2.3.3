<?php


namespace Elogic\OptionsVisibleConfig\Model\ResourceModel\Option;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

use Elogic\OptionsVisibleConfig\Model\ResourceModel\OptionResourceModel;
use Elogic\OptionsVisibleConfig\Model\OptionModel;

class Collection extends AbstractCollection
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(
            OptionModel::class,
            OptionResourceModel::class
        );
    }
}