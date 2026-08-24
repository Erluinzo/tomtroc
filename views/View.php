<?php

//class that builds the views
class View
{
    private string $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    //show a template inside the main layout
    public function render(string $viewName, array $params = []): void
    {
        $viewPath = $this->buildViewPath($viewName);

        //variables used in the main layout
        $content = $this->renderViewFromTemplate($viewPath, $params);
        $title = $this->title;

        ob_start();
        require(MAIN_VIEW_PATH);
        echo ob_get_clean();
    }

    //get the html of one template
    private function renderViewFromTemplate(string $viewPath, array $params = []): string
    {
        if (file_exists($viewPath)) {
            //make the params usable as variables in the template
            extract($params);
            ob_start();
            require($viewPath);
            return ob_get_clean();
        }

        throw new Exception("La vue '$viewPath' est introuvable.");
    }

    private function buildViewPath(string $viewName): string
    {
        return TEMPLATE_VIEW_PATH . $viewName . '.php';
    }
}
