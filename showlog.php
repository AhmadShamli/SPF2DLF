<?php 

function util_showerror() {
	//log file location
	$file = '/var/www/clients/client2/web8/log/error.log';
	//last line to tail
	$c = 150;
	//start buffering output data
	ob_start();
	passthru("tail -$c $file");
	//flush buffer data to variable
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
