<?php

class Help extends Command
{
	protected string $name = 'help';
	protected string $description = 'Get description and usage of command';
	protected string $usage = 'help [COMMAND]';
	protected array $require_args = [0];

	public function call()
	{
		$commands = Command::instances();
		foreach ($commands as $command) {
			if($command->name() === $this->args[0]) {
				$this->console->output('Command: '.$command->name())
					->style(UNDERLINED)
					->style(BOLD)
					->echo();
				$this->console->output("{$command->description()}\nUsage: {$command->usage()}")->echo();
				die;
			}
		}
		output("help: command not found: {$this->args[0]}");
	}
}