<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 17/07/2017
 * Time: 16:22
 */

namespace Namlv\Tutorial\Model;


use Namlv\Tutorial\Api\PostApiInterface;

class PostApi implements PostApiInterface
{

    /**
     * @param $key
     * @return string
     */
    public function getPost($key){
//        return $this->getRe
//        Mage
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function setSession($key, $value)
    {
//        $_SESSION[$key] = $value;
        return 123;
    }
}