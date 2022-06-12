<?php

class Output extends Command
{
	protected string $name = 'echo';
	protected string $description = 'Print a string';
	protected string $usage = "echo \"Hello World\"";
	protected array $require_args = [0];

	public function call()
	{
		output($this->args[0]);
	}
}