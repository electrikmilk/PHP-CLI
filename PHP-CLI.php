<?php
/**
 * PHP CLI
 * Helper classes for creating PHP CLI scripts
 * @author Brandon Jordan, 06-2022
 */

$args = [];
$command_name = null;
if ($argc !== 0) {
	if (isset($argv[1])) {
		$command_name = $argv[1];
		unset($argv[1]);
	}
	unset($argv[0]);
	foreach ($argv as $arg) {
		$args[] = $arg;
	}
}
--$argc;

function output($line)
{
	echo "$line\n";
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
				output('usage: ' . $command->usage());
			}
			die;
		}
	}
	output("command not found: $command_name\n");
}
$command_list->call();