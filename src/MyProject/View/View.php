<?php

namespace MyProject\View;

class View
{
    /** @var string */
    private $templatesPath;

    /** @var array  */
    private $extraVars = [];

    /**
     * View constructor.
     * @param string $templatesPath
     */
    public function __construct(string $templatesPath)
    {
        $this->templatesPath = $templatesPath;
    }

    /**
     * @param string $name
     * @param $value
     */
    public function setVar(string $name, $value): void
    {
        $this->extraVars[$name] = $value;
    }

    /**
     * @param string $templateName
     * @param array $vars
     * @param int $code
     */
    public function renderHtml(string $templateName, array $vars = [], int $code = 200)
    {
        http_response_code($code);
        extract($this->extraVars);
        extract($vars);

        ob_start();
        include $this->templatesPath . '/' . $templateName;
        $buffer = ob_get_contents();
        ob_end_clean();

        echo $buffer;
    }
}