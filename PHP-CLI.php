<?php
/**
 * PHP CLI
 * Helper classes for creating PHP CLI scripts
 * @author Brandon Jordan, 06-2022
 */

$args = [];
$flags = [];
$command_name = null;

if ($argc !== 0) {
	if (isset($argv[1])) {
		$command_name = $argv[1];
		unset($argv[1]);
	}
	unset($argv[0]);
	foreach ($argv as $arg) {
		if (str_starts_with($arg, '-') || str_starts_with($arg, '--')) {
			$flags[] = trim($arg, '-,--');
		} else {
			$args[] = $arg;
		}
	}
}
--$argc;

function output($line, ...$styles)
{
	if ($styles) {
		echo CLI::styles($line, ...$styles) . "\n";
	} else {
		echo "$line\n";
	}
}

include_once 'src/CLI.php';
include_once 'src/Command.php';

$commands = scandir('commands');
foreach ($commands as $command) {
	if ($command === '..' || $command === '.') continue;
	$name = pathinfo($command, PATHINFO_FILENAME);
	include_once "commands/$name.php";
	if ($name === 'Commands') {
		$command_list = new Commands();
		continue;
	}
	new $name();
}

if ($argc !== 0) {
	$commands = Command::instances();
	foreach ($commands as $command) {
		if ($command->name() === $command_name) {
			if ($command->required()) {
				$command->call();
			} else {
				output('DESCRIPTION', GREEN, BOLD, UNDERLINED);
				output($command->description());

				output('USAGE', GREEN, BOLD, UNDERLINED);
				output('$ ' . $command->usage());

				if ($command->options()) {
					output("OPTIONS", GREEN, BOLD, UNDERLINED);
					foreach ($command->options() as $flag => $description) {
						$letter = substr($flag, 0, 1);
						output(" -$letter --$flag	$description");
					}
				}
			}
			die;
		}
	}
	output("command not found: $command_name\n", RED);
}
$command_list->call();