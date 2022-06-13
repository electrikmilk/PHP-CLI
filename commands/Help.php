<?php

class Help extends Command
{
	protected string $name = 'help';
	protected string $description = 'Get description and usage of command';
	protected string $usage = 'help [command]';
	protected array $require_args = [0];

	public function call()
	{
		$commands = Command::instances();
		foreach ($commands as $command) {
			if ($command->name() === $this->args[0]) {
				$this->console->output('NAME')
					->style(UNDERLINED)
					->style(BOLD)
					->style(GREEN)
					->echo();
				$this->console->output($command->name())
					->echo();

				$this->console->output('DESCRIPTION')
					->style(UNDERLINED)
					->style(BOLD)
					->style(GREEN)
					->echo();
				$this->console->output($command->description())->echo();

				$this->console->output('USAGE')
					->style(UNDERLINED)
					->style(BOLD)
					->style(GREEN)
					->echo();
				output('$ ' . $command->usage());

				$this->console->output('OPTIONS')
					->style(UNDERLINED)
					->style(BOLD)
					->style(GREEN)
					->echo();
				foreach ($command->options() as $flag => $description) {
					$letter = substr($flag, 0, 1);
					output(" -$letter --$flag	$description");
				}
				die;
			}
		}
		output("help: command not found: {$this->args[0]}");
	}
}