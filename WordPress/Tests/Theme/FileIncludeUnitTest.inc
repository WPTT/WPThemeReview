<?php

include('/file.ext'); // Warning.
include_once('/file.ext'); // Warning.
require('/file.ext'); // Warning.
require_once('/file.ext'); // Warning.
include dirname( __FILE__ ) . '/myfile.php'; // Warning.
require_once $path_to_file; // Warning.
