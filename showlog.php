<?php

declare(strict_types=1);

if (PHP_VERSION_ID < 70400) {
    fwrite(STDERR, "SPF2DLF requires PHP 7.4 or newer. Current: " . PHP_VERSION . PHP_EOL);
    return;
}

/**
 * Display the last N lines of a log file as safe HTML.
 *
 * @param string $file  Path to the log file
 * @param int    $lines Number of trailing lines to show
 * @return string HTML markup
 */
function util_show_log(string $file, int $lines = 150): string
{
    if (!is_readable($file)) {
        return sprintf(
            '<p class="log-error">Log file not found or not readable: %s</p>',
            htmlspecialchars($file, ENT_QUOTES, 'UTF-8')
        );
    }

    $content = tail_file($file, $lines);

    return sprintf(
        '<style>%s</style>
<div class="log-meta">Log File: %s<br>Count: last %d</div>
<pre class="log-output">%s</pre>',
        log_css(),
        htmlspecialchars($file, ENT_QUOTES, 'UTF-8'),
        $lines,
        htmlspecialchars($content, ENT_QUOTES, 'UTF-8')
    );
}

/**
 * Read the last $lines lines of a file without invoking a shell command.
 * Only the requested number of lines is kept in memory.
 */
function tail_file(string $file, int $lines): string
{
    $handle = fopen($file, 'r');
    if ($handle === false) {
        return '';
    }

    $buffer = [];
    while (($line = fgets($handle)) !== false) {
        $buffer[] = $line;
        if (count($buffer) > $lines) {
            array_shift($buffer);
        }
    }
    fclose($handle);

    return implode('', $buffer);
}

/**
 * Scoped CSS for the log viewer.
 */
function log_css(): string
{
    return '
        .log-meta {
            font-family: monospace;
            margin-bottom: .5em;
        }
        .log-output {
            white-space: pre-wrap;
            word-wrap: break-word;
            background: #1e1e1e;
            color: #d4d4d4;
            padding: 1em;
            border-radius: 4px;
            overflow-x: auto;
        }
        .log-error {
            color: #c00;
            font-family: monospace;
        }
    ';
}

// Example usage (remove or guard behind an auth check in production):
// echo util_show_log('/var/www/clients/client2/web8/log/error.log', 150);

