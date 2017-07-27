<?php declare(strict_types=1);
/**
 * Bright Nucleus View Component.
 *
 * @package   BrightNucleus\View
 * @author    Alain Schlesser <alain.schlesser@gmail.com>
 * @license   MIT
 * @link      http://www.brightnucleus.com/
 * @copyright 2016 Alain Schlesser, Bright Nucleus
 */

namespace BrightNucleus\View\View;

use BrightNucleus\Config\Exception\FailedToProcessConfigException;
use BrightNucleus\View\Exception\FailedToInstantiateView;
use BrightNucleus\View\View;
use BrightNucleus\View\Engine\Engine;
use BrightNucleus\View\ViewBuilder;
use BrightNucleus\Views;
use Closure;

/**
 * Abstract class AbstractView.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\View\View
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
abstract class AbstractView implements View
{

    /**
     * URI of the view.
     *
     * @since 0.1.0
     *
     * @var string
     */
    protected $uri;

    /**
     * Engine to use for the view.
     *
     * @since 0.1.0
     *
     * @var Engine
     */
    protected $engine;

    /**
     * ViewBuilder instance.
     *
     * @since 0.2.0
     *
     * @var ViewBuilder
     */
    protected $builder;

    /**
     * The context with which the view will be rendered.
     *
     * @since 0.4.0
     *
     * @var array
     */
    protected $context = [];

    /**
     * Instantiate an AbstractView object.
     *
     * @since 0.1.0
     *
     * @param string $uri    URI for the view.
     * @param Engine $engine Engine to use for the view.
     */
    public function __construct(string $uri, Engine $engine)
    {
        $this->uri    = $uri;
        $this->engine = $engine;
    }

    /**
     * Render the view.
     *
     * @since 0.1.0
     *
     * @param array $context Optional. The context in which to render the view.
     * @param bool  $echo    Optional. Whether to echo the output immediately. Defaults to false.
     *
     * @return string Rendered HTML.
     * @throws FailedToProcessConfigException If the Config could not be processed.
     */
    public function render(array $context = [], bool $echo = false): string
    {
        $this->initializeViewBuilder();
        $this->assimilateContext($context);

        $closure = Closure::bind(
            $this->engine->getRenderCallback($this->uri, $context),
            $this,
            static::class
        );

        $output = $closure();

        if ($echo) {
            echo $output;
        }

        return $output;
    }

    /**
     * Render a partial view for a given URI.
     *
     * @since 0.2.0
     *
     * @param string      $view    View identifier to create a view for.
     * @param array       $context Optional. The context in which to render the view.
     * @param string|null $type    Type of view to create.
     *
     * @return string Rendered HTML content.
     * @throws FailedToProcessConfigException If the Config could not be processed.
     * @throws FailedToInstantiateView If the View could not be instantiated.
     */
    public function renderPart(string $view, array $context = null, $type = null): string
    {
        if (null === $context) {
            $context = $this->context;
        }

        $this->initializeViewBuilder();
        $viewObject = $this->builder->create($view, $type);

        return $viewObject->render($context);
    }

    /**
     * Associate a view builder with this view.
     *
     * @since 0.2.0
     *
     * @param ViewBuilder $builder
     *
     * @return View
     */
    public function setBuilder(ViewBuilder $builder): View
    {
        $this->builder = $builder;

        return $this;
    }

    /**
     * Initialize the view builder associated with the view.
     *
     * @since 0.2.0
     *
     * @throws FailedToProcessConfigException If the Config could not be processed.
     */
    protected function initializeViewBuilder()
    {
        if (null === $this->builder) {
            $this->builder = Views::getViewBuilder();
        }
    }

    /**
     * Assimilate the context to make it available as properties.
     *
     * @since 0.2.0
     *
     * @param array $context Context to assimilate.
     */
    protected function assimilateContext(array $context = [])
    {
        $this->context = $context;
        foreach ($context as $key => $value) {
            $this->$key = $value;
        }
    }
}
