<?php

namespace App\Core;

/**
 * Class Controller
 *
 * Base controller class providing shared functionality for all controllers.
 */
class Controller
{
    /**
     * Loads and returns a model instance.
     *
     * @param string $model The name of the model to load.
     * @return mixed An instance of the requested model class.
     */
    protected function loadModel(string $model): mixed
    {
        $modelClass = 'App\\Models\\' . $model;
        if (!class_exists($modelClass)) {
            throw new \Exception("Model $modelClass not found");
        }

        return new $modelClass;
    }

    /**
     * Renders a view within the layout.
     *
     * @param string $viewPath The relative path to the view file (within the views directory).
     * @param array $data Optional associative array of data to be extracted and used in the view.
     * @return void
     */
    protected function renderView(string $viewPath, array $data = []): void
    {
        extract($data);
        require_once __DIR__ . '/../views/layout.php';
    }
}