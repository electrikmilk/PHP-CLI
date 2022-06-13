<?php

// resets
const RESET = 0;
const RESET_BOLD_BRIGHT = 21;
const RESET_DIM = 22;
const RESET_UNDERLINED = 24;
const RESET_BLINK = 25;
const RESET_REVERSE = 27;
const RESET_HIDDEN = 28;
const RESET_FOREGROUND = 39;
const RESET_BACKGROUND = 49;

// styles
const BOLD = 1;
const DIM = 2;
const UNDERLINED = 4;
const BLINK = 5;
const INVERTED = 7;
const HIDDEN = 8;

// color (foreground)
const BLACK = 30;
const RED = 31;
const GREEN = 32;
const YELLOW = 33;
const BLUE = 34;
const MAGENTA = 35;
const CYAN = 36;
const LIGHT_GRAY = 37;
const LIGHT_GREY = 37;
const DARK_GRAY = 90;
const DARK_GREY = 90;
const LIGHT_RED = 91;
const LIGHT_GREEN = 92;
const LIGHT_YELLOW = 93;
const LIGHT_BLUE = 94;
const LIGHT_MAGENTA = 95;
const LIGHT_CYAN = 96;
const WHITE = 97;

// color (background)
const BLACK_BG = 40;
const RED_BG = 41;
const GREEN_BG = 42;
const YELLOW_BG = 43;
const BLUE_BG = 44;
const MAGENTA_BG = 45;
const CYAN_BG = 46;
const LIGHT_GRAY_BG = 47;
const LIGHT_GREY_BG = 47;
const DARK_GRAY_BG = 100;
const DARK_GREY_BG = 100;
const LIGHT_RED_BG = 101;
const LIGHT_GREEN_BG = 102;
const LIGHT_YELLOW_BG = 103;
const LIGHT_BLUE_BG = 104;
const LIGHT_MAGENTA_BG = 105;
const LIGHT_CYAN_BG = 106;
const WHITE_BG = 107;

const SUCCESS = GREEN . ';' . BOLD;
const ERROR = RED . ';' . BOLD;
const NOTICE = BOLD . ';' . YELLOW;
const INFO = BOLD . ';' . CYAN;
const WARN = YELLOW_BG . ';' . BLACK;

class CLI
{

	public string $input;
	private string $output;

	public function __construct(string $line = null)
	{
		if ($line) {
			$this->output = $line;
		}
	}

	public function echo(): void
	{
		echo CLI::reset() . "$this->output\n" . CLI::reset();
	}

	public function output(string $new_line): CLI
	{
		$this->output = $new_line;
		return $this;
	}

	public function style($style): CLI
	{
		$this->output = "\033[{$style}m$this->output";
		return $this;
	}

	public function get_input(string $prompt)
	{
		echo CLI::reset() . "$prompt: ";
		$handle = fopen("php://stdin", 'rb');
		do {
			$line = fgets($handle);
		} while ($line === '');
		fclose($handle);
		$this->input = trim($line);
	}

	public static function styles(string $line, ...$styles): string
	{
		return self::reset() . "\033[" . implode(';', $styles) . "m$line" . self::reset();
	}

	public static function flag(string $flag)
	{
		global $flags;
		$letter = substr($flag, 0, 1);
		if (in_array($letter, $flags)) {
			return true;
		}
		foreach ($flags as $f) {
			if (substr($f, 0, 1) === $letter) {
				return true;
			}
		}
		return false;
	}

	public static function reset(): string
	{
		return "\033[0m";
	}

	public static function progress(int $progress): void
	{
		$progress /= 100;
		$percent = round($progress * 100, 2);
		$blocks = 50;
		$progress_blocks = $progress * $blocks;
		$remaining = $blocks - $progress_blocks - 1;
		if ($percent % 2 === 0) {
			++$remaining;
		}
		$digits = strlen((string)$percent);
		if ($digits === 1) {
			$percent = '0' . $percent;
		}
		echo "[";
		for ($i = 0; $i < $progress_blocks; $i++) {
			echo '#';
		}
		for ($i = 0; $i < $remaining; $i++) {
			echo '-';
		}
		echo "]";
		if ((int)$percent === 100) {
			echo " ... done.\r\n";
		} else {
			echo " $percent% \r";
		}
	}
}