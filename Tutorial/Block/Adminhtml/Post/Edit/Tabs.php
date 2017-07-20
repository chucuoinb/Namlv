<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 13/07/2017
 * Time: 16:17
 */

namespace Namlv\Tutorial\Block\Adminhtml\Post\Edit;


class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * Internal constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('post_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('New Post Manage'));
    }

    protected function _beforeToHtml()
    {
        $this->setActiveTab('general_section');
        return parent::_beforeToHtml();
    }
}
