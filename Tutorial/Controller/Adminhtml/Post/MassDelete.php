<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 14/07/2017
 * Time: 15:33
 */

namespace Namlv\Tutorial\Controller\Adminhtml\Post;


use Magento\Backend\App\Action;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Namlv\Tutorial\Model\ResourceModel\Post\CollectionFactory;

class MassDelete extends Action
{

    /**
     *
     * @var \Magento\Framework\App\Filesystem\DirectoryList
     */
    protected $_directoryList;
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Namlv_Tutorial::post_delete';

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Action\Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList

    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->_directoryList=$directoryList;
        parent::__construct($context);
    }
    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $postPathUpload = $this->_directoryList->getRoot() . DIRECTORY_SEPARATOR . DirectoryList::PUB . DIRECTORY_SEPARATOR . DirectoryList::MEDIA . DIRECTORY_SEPARATOR;
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $size = $collection->getSize();
        foreach ($collection as $item){
            $image = $item->getData('image');
            $item->delete();
            if (file_exists($postPathUpload.$image))
                unlink($postPathUpload.$image);

        }
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $size));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}