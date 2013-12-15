<?php
/**
 * Phing Global "Registry" task
 *
 * Enables values to be set in sub tasks and phingcalls to other files as well.
 *
 * USAGE:
 * ------
 *
 * Setter
 *
 * <global name="foo" value="bar" />
 * <global mode="set" name="foo" value="${bar}" />
 *
 * Both syntaxes are equivalent. The code above sets the global value of "foo" to "bar". Properties (${baz)}) may be used as values.
 *
 *
 * Getter
 *
 * <global mode="get" property="foo" />
 *
 * Gets the current global value of "foo" as most recently set and assigns it to the local "foo" property. If "foo" has not been rpeviously
 * nothing happens.
 *
 *
 * Enabling
 *
 * <taskdef name="global" classname="phing.tasks.my.GlobalPropertyTask" />
 *
 */
require_once "phing/Task.php";

class GlobalPropertyTask extends Task
{

	/**
	 * Array to hold assigned values
	 */
	private static $values = array();

	/**
	 * Mode parameter
	 */
    private $mode = null;

	/**
	 * Value parameter
	 */
	private $value = null;

	/**
	 * Name parameter
	 */
    private $name = null;

	/**
	 * Property parameter
	 */
    private $property = null;

	/**
	 * Mode parameter setter
	 */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }

	/**
	 * Value parameter setter
	 */
    public function setValue($value)
    {
        $this->value = $value;
    }

	/**
	 * Name parameter setter
	 */
    public function setName($name)
    {
        $this->name = $name;
    }

	/**
	 * Property  parameter setter
	 */
    public function setProperty($property)
    {
        $this->property = $property;
        $this->name = $property;
    }

	/**
	 * Main logic
	 *
	 * Acts as a Registry setter / getter, depending on the mode parameter
	 *
	 * If no mode is specified, it acts as a setter. This enables a shorter "set" syntax and makes the mode option in those cases. For
	 * gets, the mode is required.
	 *
	 * (This could easily be modified to eliminate the "set" as default or even add other modes.)
	 */
    public function main()
    {

		switch (strtolower($this->mode))
		{
			case 'get':
	            $this->project->setProperty(
					$this->property,
					self::$values[$this->name]
	            );
			break;

			default:
				self::$values[$this->name] = $this->value;
		}
    }
