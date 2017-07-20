<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 13/07/2017
 * Time: 10:27
 */

namespace Namlv\Tutorial\Block\Adminhtml\Post\Edit;


use Magento\Backend\Block\Widget\Form\Generic;

class Form extends Generic
{
    protected function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                     'action' => $this->getData('action'),
                    'method' => 'post',
                    'enctype' => 'multipart/form-data'

                ]
            ]
        );

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}