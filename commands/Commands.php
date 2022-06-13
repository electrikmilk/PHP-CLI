<?php

class Commands extends Command
{
	protected string $name = 'list';
	protected string $description = 'List available commands';

	public function call()
	{
		$commands = Command::instances();
		$this->console->output('Available commands:')
			->style(UNDERLINED)
			->style(BOLD)
			->echo();
		foreach ($commands as $command) {
			$this->console->output(CLI::styles($command->name(), GREEN) . "	{$command->description()}")->echo();
		}
	}
}