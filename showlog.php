<?php 


$pagetitle = 'Latest 150 error';

function util_showerror() {
	$file = '/var/www/clients/client2/web8/log/error.log';
	$c = 150;
	ob_start();
	passthru("tail -$c $file");
	$reader = ob_get_clean();
	$data = "
	<style type='text/css'>

	pre {
    white-space: pre-wrap;       /* Since CSS 2.1 */
    white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
    white-space: -pre-wrap;      /* Opera 4-6 */
    white-space: -o-pre-wrap;    /* Opera 7 */
    word-wrap: break-word;       /* Internet Explorer 5.5+ */
}
	xmp { white-space: pre-wrap }
</style>
<div>
    Log File: $file
    <br />
    Count: last $c
</div>
<div>
<pre>
<xmp>
$reader
</xmp>
</pre>
</div>";
	return $data;
}
