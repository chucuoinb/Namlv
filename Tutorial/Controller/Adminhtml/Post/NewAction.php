<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/07/2017
 * Time: 14:20
 */

namespace Namlv\Tutorial\Controller\Adminhtml\Post;


use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;

class NewAction extends Action
{
    const ADMIN_RESOURCE = 'Namlv_Tutorial::post_new';
    protected $resultForwardFactory;
    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $resultForwardFactory = $this->resultForwardFactory->create();
        return $resultForwardFactory->forward('edit');
    }
}