<?php
namespace Codeception;

use Codeception\Specify\Config;
use Codeception\Specify\ConfigBuilder;

trait Specify {

    private $beforeSpecify;
    private $afterSpecify;

    /**
     * @var Specify\Config
     */
    private $specifyConfig;

    /**
     * @var \DeepCopy\DeepCopy()
     */
    private $copier;

    private function specifyInit()
    {
        if ($this->copier) return;
        $this->copier = new \DeepCopy\DeepCopy();
        $this->copier->skipUncloneable();
        if (!$this->specifyConfig) $this->specifyConfig = Config::create();
    }

	function specify($specification, \Closure $callable = null, $params = [])
	{
        if (!$callable) return;
        $this->specifyInit();

        $test = $callable->bindTo($this);
        $name = $this->getName();
        $this->setName($this->getName().' | '.$specification);

        $properties = get_object_vars($this);

        // prepare for execution
        $throws = $this->getSpecifyExpectedException($params);
        $examples = $this->getSpecifyExamples($params);

        foreach ($examples as $example) {
            // copy current object properties
            $this->specifyCloneProperties($properties);

            if ($this->beforeSpecify instanceof \Closure) $this->beforeSpecify->__invoke();
            $this->specifyExecute($test, $throws, $example);

            // restore object properties
            foreach ($properties as $property => $val) {
                if ($this->specifyConfig->propertyIgnored($property)) continue;
                $this->$property = $val;
            }
            if ($this->afterSpecify instanceof \Closure) $this->afterSpecify->__invoke();
        }

        // restore test name
        $this->setName($name);
	}

    /**
     * @param $params
     * @return array
     * @throws \RuntimeException
     */
    private function getSpecifyExamples($params)
    {
        if (isset($params['examples'])) {
            if (!is_array($params['examples'])) throw new \RuntimeException("Examples should be an array");
            return $params['examples'];
        }
        return [[]];
    }

    private function getSpecifyExpectedException($params)
    {
        $throws = false;
        if (isset($params['throws'])) {
            $throws = $params['throws'];
            if (is_object($throws)) {
                $throws = get_class($throws);
            }
            if ($throws === 'fail') {
                $throws = 'PHPUnit_Framework_AssertionFailedError';
            }
        }
        return $throws;
    }

    private function specifyExecute($test, $throws = false, $examples = array())
    {
        $result = $this->getTestResultObject();
        try {
            call_user_func_array($test, $examples);
        } catch (\PHPUnit_Framework_AssertionFailedError $e) {
            if ($throws !== get_class($e)) $result->addFailure(clone($this), $e, $result->time());
        } catch (\Exception $e) {
            if ($throws) {
                if ($throws !== get_class($e)) {
                    $f = new \PHPUnit_Framework_AssertionFailedError("exception '$throws' was expected, but " . get_class($e) . ' was thrown');
                    $result->addFailure(clone($this), $f, $result->time());
                }
            } else {
                throw $e;
            }
        }

        if ($throws) {
            if (isset($e)) {
                $this->assertTrue(true, 'exception handled');
            } else {
                $f = new \PHPUnit_Framework_AssertionFailedError("exception '$throws' was not thrown as expected");
                $result->addFailure(clone($this), $f, $result->time());
            }
        }
    }

    public function specifyConfig()
    {
        if (!$this->specifyConfig) $this->specifyConfig = Config::create();
        return new ConfigBuilder($this->specifyConfig);
    }

    function beforeSpecify(\Closure $callable = null)
    {
        $this->beforeSpecify = $callable->bindTo($this);
    }

    function afterSpecify(\Closure $callable = null)
    {
        $this->afterSpecify = $callable->bindTo($this);
    }

    function cleanSpecify()
    {
        $this->beforeSpecify = $this->afterSpecify = null;
    }

    /**
     * @param $properties
     * @return array
     */
    private function specifyCloneProperties($properties)
    {
        foreach ($properties as $property => $val) {
            if ($this->specifyConfig->propertyIgnored($property)) {
                continue;
            }
            if ($this->specifyConfig->classIgnored($val)) {
                continue;
            }

            if ($this->specifyConfig->propertyIsShallowCloned($property)) {
                if (is_object($val)) {
                    $this->$property = clone $val;
                } else {
                    $this->$property = $val;
                }
            }
            if ($this->specifyConfig->propertyIsDeeplyCloned($property)) {
                $this->$property = $this->copier->copy($val);
            }
        }
    }
}
