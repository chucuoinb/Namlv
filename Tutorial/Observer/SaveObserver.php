<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 19/07/2017
 * Time: 15:05
 */

namespace Namlv\Tutorial\Observer;


use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Namlv\Tutorial\Model\PostFactory;

class SaveObserver implements ObserverInterface
{
    protected $loggerInterface;

    /**
     * @var Post
     */
    protected $modelFactory;


    function __construct(PostFactory $modelFactory,
                         \Psr\Log\LoggerInterface $loggerInterface)
    {
        $this->modelFactory=$modelFactory;
        $this->loggerInterface=$loggerInterface;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $this->loggerInterface->debug("hello observer");
        $data = $observer->getData('id');
        $model = $this->modelFactory->create()->load($data);
        $model->setObserver($model->getTitle());
        $model->save();
        return $this;
//        $data = $observer->getData('observer');
//        $model->setObserver($data['title']);
        // TODO: Implement execute() method.
    }
}