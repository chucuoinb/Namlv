<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18/07/2017
 * Time: 09:01
 */

namespace Namlv\Tutorial\Controller\Api;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\JsonFactory;

class Session extends Action
{

    /**
     * @var JsonFactory
     */
    protected $resultJson;
    public function __construct(Context $context,
            JsonFactory $resultJson)
    {
        $this->resultJson = $resultJson;
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
        $result                 = $this->resultJson->create();

        if ($this->getRequest()->isAjax())
        {
            $key = $this->getRequest()->getParam('key');
            $value = $this->getRequest()->getParam('value',5);
            $_SESSION[$key] = $value;
            $code=200;
            return $result->setData($code);
        }
        else {
            $code = 201;
            return $result->setData($code);
        }
    }
}