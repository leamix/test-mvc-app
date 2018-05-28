<?php

namespace src;

use Psr\Container\ContainerInterface;

final class View
{
    /**
     * @var string
     */
    private $path;
    /**
     * @var string
     */
    private $parentView;
    /**
     * @var array
     */
    private $blocks = [];
    /**
     * @var array
     */
    private $blockNames = [];
    /**
     * @var array
     */
    private $params = [];
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(string $path, ContainerInterface $container)
    {
        $this->path = $path;
        $this->container = $container;
    }

    public function render(string $name, array $params = []): string
    {
        $filePath = $this->path . '/' . $name . '.php';
        $level = ob_get_level();

        $this->parentView = null;

        try {
            ob_start();
            extract($params, EXTR_OVERWRITE);

            require $filePath;

            $content = ob_get_clean();
        } catch (\Throwable $e) {
            while (ob_get_level() > $level) {
                ob_end_clean();
            }

            throw $e;
        }

        if ($this->parentView) {
            return $this->render($this->parentView, \array_merge($params, [
                'content' => $content,
            ]));
        }

        return $content;
    }

    public function extend(string $view)
    {
        $this->parentView = $view;
    }

    public function beginBlock(string $name)
    {
        $this->blockNames[] = $name;
        ob_start();
    }

    public function endBlock()
    {
        $name = \array_pop($this->blockNames);

        if ($this->hasBlock($name)) {
            return;
        }

        $this->blocks[$name] = ob_get_clean();
    }

    /**
     * @param string $name
     * @return string
     */
    public function renderBlock(string $name): string
    {
        return $this->blocks[$name] ?? '';
    }

    /**
     * @param string $name
     * @param $value
     * @return void
     */
    public function addParam(string $name, $value)
    {
        $this->params[$name] = $value;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getParam(string $name)
    {
        return $this->params[$name] ?? null;
    }

    /**
     * @param string $class
     * @return string
     */
    public function widget(string $class): string
    {
        $widget = $this->container->get($class);

        \assert($widget instanceof WidgetInterface);

        return $widget->run();
    }

    /**
     * @param string $string
     * @return string
     */
    public function encode(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE);
    }

    /**
     * @param $name
     *
     * @return bool
     */
    private function hasBlock($name): bool
    {
        return array_key_exists($name, $this->blocks);
    }
}
