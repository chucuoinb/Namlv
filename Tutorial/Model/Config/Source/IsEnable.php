<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/07/2017
 * Time: 11:58
 */

namespace Namlv\Tutorial\Model\Config\Source;


class IsEnable implements \Magento\Framework\Option\ArrayInterface
{
    const STATUS_ENABLED = 1;

    const STATUS_DISABLED = 0;

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 0, 'label' => __('Disable')],
            ['value' => 1, 'label' => __('Enable')]
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

        $options[self::STATUS_DISABLED] = __('Disable');
        $options[self::STATUS_ENABLED] = __('Enable');

        $this->_options = $options;
        return $this->_options;
    }
}
