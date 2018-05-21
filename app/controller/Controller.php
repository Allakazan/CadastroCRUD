<?php

namespace app\controller;


class Controller
{
    public $content;

    public function __construct() {

    }

    public function view($viewPath, Array $options = null) {
        ob_start();
        ob_implicit_flush(false);
        if (isset($options)) {
            foreach ($options as $key => $value) {
                $$key = $value;
                extract($$key, EXTR_OVERWRITE);
            }
        }

        require('./app/view/' . $viewPath . '.php');
        $this->content = ob_get_clean();
        $this->template('template');
    }

    public function template($templatePath) {
        include './app/view/core/' . $templatePath . '.php';
    }
}