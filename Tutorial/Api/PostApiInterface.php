<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 17/07/2017
 * Time: 15:46
 */

namespace Namlv\Tutorial\Api;


interface PostApiInterface
{

    /**
     * @param $key
     * @return mixed
     */
    public function getPost($key);


    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function setSession($key, $value);
}