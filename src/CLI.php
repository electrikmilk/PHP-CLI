<?php

const RESETS = [RESET, RESET_BOLD_BRIGHT, RESET_DIM, RESET_UNDERLINED, RESET_BLINK, RESET_REVERSE, RESET_HIDDEN, RESET_FOREGROUND, RESET_BACKGROUND];

class CLI
{
	public static function style(string $line, ...$styles)
	{
		return self::reset() . "\033[" . implode(';', $styles) . "m$line" . self::reset();
	}

	public static function reset()
	{
		return "\033[" . implode(';', RESETS) . "m";
	}

	public static function progress(int $progress)
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