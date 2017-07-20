<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/07/2017
 * Time: 09:32
 */

namespace Namlv\Tutorial\Controller\Adminhtml\Post;
class Index extends \Magento\Backend\App\Action
{
    protected $resultPageFactory;
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->addBreadcrumb(
            'Post Manage',
            'Post Manage'
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Post'));
        $resultPage->getConfig()->getTitle()
            ->prepend('Post Manage');
        return $resultPage;
    }
}
