<?php
class Controller {
    public function view($view, $data = [])
    {
        // Extract $data so views can access $data['key'] AND individual $key variables
        extract($data);
        require_once '../app/Views/' . $view . '.php';
    }

    public function model($model)
    {
        $file = '../app/Models/' . $model . '.php';
        if (!class_exists($model)) {
            require_once $file;
        }
        return new $model;
    }
}
