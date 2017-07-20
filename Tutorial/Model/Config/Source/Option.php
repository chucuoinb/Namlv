<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/07/2017
 * Time: 16:37
 */

namespace Namlv\Tutorial\Model\Config\Source;


use Magento\Framework\Option\ArrayInterface;

class Option implements ArrayInterface
{

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        return [];
    }

    public function getOption(){
        $option = [
            '1' => __('Yes'),
            '0' => __('No'),
        ];
        $this->_options = $option;
        return $this->_options;
    }
}