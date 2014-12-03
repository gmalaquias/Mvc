<?php
/**
 * Created by PhpStorm.
 * User: Gabriel
 * Date: 23/11/2014
 * Time: 21:49
 */

namespace Mvc;

/**
 * Class Controller
 * @package Mvc
 */
class Controller
{
    /**
     * @param null $folder
     * @param null $model
     */
    public function View($folder = null, $model = null)
    {
        $file = $this->getAddressView($folder);
        if (file_exists($file))
            require_once $file;
    }


    /**
     *
     */
    public function Model()
    {
        $file = $this->getAddressModel();
        if(file_exists($file)) {
            $model = $this->getClassModel();
            $this->model = new $model();
        }
    }

    /**
     * @param $folder
     * @return string
     */
    private function getAddressView($folder)
    {
        //fora das areas
        if (Request::getArea() == null)
            return PATH_VIEWS . Request::getController() . DS . ($folder != null ? $folder . DS : "") . Request::getAction() . ".php";

        //dentro das areas
        return PATH_AREA . Request::getArea() . 'Views' . DS . Request::getController() . DS . ($folder != null ? $folder . DS : "") . Request::getAction() . ".php";
    }

    /**
     * @return string
     */
    private function getAddressModel()
    {
        //fora das areas
        if (Request::getArea() == null)
            return PATH_MODELS . Request::getController() . ".php";

        //dentro das areas
        return PATH_AREA . Request::getArea() . DS . 'Models' . DS . Request::getController() . ".php";
    }

    /**
     * @return string
     */
    private function getClassModel()
    {
        //fora das areas
        if (Request::getArea() == null)
            return $model = NAMESPACE_MODELS . '\\' . Request::getController();

        //dentro das areas
        return NAMESPACE_AREAS . '\\' . Request::getArea() . '\\' . 'Models' . '\\' . Request::getController();

    }
} 