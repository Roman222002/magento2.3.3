<?php


namespace Elogic\OptionsVisibleConfig\Model\ResourceModel;

use Elogic\OptionsVisibleConfig\Api\Data\OptionInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class OptionResourceModel extends AbstractDb
{


    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(
            OptionInterface::OPTION_TABLE,
            OptionInterface::OPTION_ID
        );
    }
}