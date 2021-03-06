<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/07/2017
 * Time: 16:01
 */

namespace Namlv\Tutorial\Block\Adminhtml\Post;


use Magento\Backend\Block\Widget\Form\Container;

class Edit extends Container
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    )
    {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $this->_objectId = 'tutorial_post_id';
        $this->_blockGroup = 'Namlv_Tutorial';
        $this->_controller = 'adminhtml_post';
        parent::_construct();
    }

    protected function _prepareLayout()
    {
        if ($this->_isAllowedAction('Namlv_Tutorial::post_new')
            || $this->_isAllowedAction('Namlv_Tutorial::post_edit')
        ) {
            $this->buttonList->update('save', 'label', __('Save Post'));
        }
        return parent::_prepareLayout(); // TODO: Change the autogenerated stub
    }

    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    public function getDeleteUrl()
    {
        return $this->getUrl(
            '*/*/delete',
            [
                '_current' => true,
                'id' => $this->getRequest()->getParam('id')
            ]
        );
    }

    /**
     * Getter of url for "Save and Continue" button
     * tab_id will be replaced by desired by JS later
     *
     * @return string
     */
//    protected function _getSaveAndContinueUrl()
//    {
//        return $this->getUrl(
//            '*/*/save',
//            [
//                '_current' => true,
//                'back' => 'edit',
//                'active_tab' => ''
//            ]
//        );
//    }
}