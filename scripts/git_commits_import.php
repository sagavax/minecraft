<?php
// CLI-only: imports git commit history into the git_commits table.
// Usage:
//   php scripts/git_commits_import.php        -> imports full history
//   php scripts/git_commits_import.php latest  -> imports only HEAD (used by the post-commit hook)

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("This script can only be run from the command line.\n");
}

include __DIR__ . "/../includes/dbconnect.php";

mysqli_query($link, "
    CREATE TABLE IF NOT EXISTS git_commits (
        id INT AUTO_INCREMENT PRIMARY KEY,
        commit_hash VARCHAR(40) NOT NULL UNIQUE,
        author VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        committed_at DATETIME NOT NULL
    )
");

$mode = $argv[1] ?? "all";
$rangeArgs = $mode === "latest" ? ["-1", "HEAD"] : ["--all"];

$separatorField = "\x1f";
$separatorEntry = "\x1e";
$format = "%H{$separatorField}%an{$separatorField}%aI{$separatorField}%s{$separatorEntry}";

$repoRoot = dirname(__DIR__);

// Using proc_open with an argument array (instead of shell_exec/escapeshellarg)
// avoids cmd.exe mangling the % characters in the --pretty=format string on Windows.
$command = array_merge(["git", "-C", $repoRoot, "log"], $rangeArgs, ["--pretty=format:$format"]);
$descriptors = [1 => ["pipe", "w"], 2 => ["pipe", "w"]];
$process = proc_open($command, $descriptors, $pipes);
$output = stream_get_contents($pipes[1]);
fclose($pipes[1]);
fclose($pipes[2]);
proc_close($process);

if (!$output) {
    echo "No commits found.\n";
    exit;
}

$inserted = 0;
$entries = explode($separatorEntry, trim($output, $separatorEntry . "\n"));

foreach ($entries as $entry) {
    $entry = trim($entry);
    if ($entry === "") {
        continue;
    }

    [$hash, $author, $date, $message] = explode($separatorField, $entry);

    $hash = mysqli_real_escape_string($link, $hash);
    $author = mysqli_real_escape_string($link, $author);
    $message = mysqli_real_escape_string($link, $message);
    $committedAt = date("Y-m-d H:i:s", strtotime($date));

    $sql = "INSERT IGNORE INTO git_commits (commit_hash, author, message, committed_at)
            VALUES ('$hash', '$author', '$message', '$committedAt')";

    mysqli_query($link, $sql) or die("MySQLi ERROR: " . mysqli_error($link));
    if (mysqli_affected_rows($link) > 0) {
        $inserted++;
    }
}

echo "Imported $inserted new commit(s).\n";
