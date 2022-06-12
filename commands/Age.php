<?php

class Age extends Command
{
	protected string $name = 'age';
	protected string $description = 'Tells you how old you will be in 30 years';

	public function call() {
		$this->console->get_input('Enter your age');
		$this->console->output('You will be '.((int)$this->console->input+30).' in 30 years. Sorry about that.')->echo();
	}
}