<?php

namespace Elogic\OptionsVisibleConfig\Api\Data;

/**
 * Interface OptionInterface
 */
interface OptionInterface{

    const OPTION_ID = 'option_id';

    const ATTRIBUTE_ID = 'attribute_id';

    const SORT_ORDER = 'sort_order';

    const VISIBLE = 'visible';

    const OPTION_TABLE = 'eav_attribute_option';
    /**
     * @return mixed
     */
    public function getOptionId();

    /**
     * @return mixed
     */
    public function getAttributeId();

    /**
     * @return mixed
     */
    public function getSortOrder();

    /**
     * @return mixed
     */
    public function getVisible();

    /**
     * @param $id
     * @return mixed
     */
    public function setAttributeId($id);

    /**
     * @param $order
     * @return mixed
     */
    public function setSortOrder($order);

    /**
     * @param $visible
     * @return mixed
     */
    public function setVisible($visible);

 }