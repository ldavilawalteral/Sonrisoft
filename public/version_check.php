<?php
echo 'PHP Version: ' . phpversion();
echo '<br>';
echo 'Readonly classes supported: ' . (version_compare(PHP_VERSION, '8.2.0', '>=') ? 'Yes' : 'No');
