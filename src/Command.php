<?php

class Command
{
	protected static $_instances = [];

	protected string $name;
	protected string $description;
	protected string $usage;

	protected array $args = [];
	protected array $require_args = [];
	protected Console $console;

	public function __construct()
	{
		global $args;
		$this->args = $args;
		$this->console = new Console();
		self::$_instances[] = $this;
	}

	public function __destruct()
	{
		unset(self::$_instances[array_search($this, self::$_instances, true)]);
	}

	/**
	 * @return string
	 */
	public function name(): string
	{
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function description(): string
	{
		if(isset($this->description)) {
			return $this->description;
		}
		return false;
	}

	/**
	 * @return string
	 */
	public function usage(): string
	{
		if(isset($this->usage)) {
			return $this->usage;
		}
		return false;
	}

	/**
	 * @return mixed
	 */
	public function required()
	{
		if(isset($this->require_args)) {
			foreach ($this->require_args as $require_arg) {
				if (!isset($this->args[$require_arg])) {
					return false;
				}
			}
		}
		return true;
	}

	public static function instances()
	{
		return self::$_instances;
	}
}