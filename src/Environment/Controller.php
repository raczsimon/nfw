<?php
namespace raczsimon\nfw\Environment;

class Controller
{
    protected $reflect;
    
    public function setReflect($reflect) {
        $this->reflect = $reflect;
    }
    
    protected function isView($view) {
        return $this->reflect == $view;
    }
}