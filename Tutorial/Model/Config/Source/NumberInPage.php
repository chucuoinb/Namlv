<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18/07/2017
 * Time: 10:28
 */

namespace Namlv\Tutorial\Model\Config\Source;


class NumberInPage implements \Magento\Framework\Option\ArrayInterface
{
    const SELECT_1 = 5;

    const SELECT_2 = 10;

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 5, 'label' => __('5')],
            ['value' => 10, 'label' => __('10')]
        ];
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function getStatusOptions($flag = false)
    {
        $options = [];

        if ($flag) {
            $options[''] = '-- Status --';
        }

        $options[self::SELECT_1] = __('5');
        $options[self::SELECT_2] = __('10');

        $this->_options = $options;
        return $this->_options;
    }
}