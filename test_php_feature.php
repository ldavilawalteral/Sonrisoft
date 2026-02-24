<?php
echo "PHP Version: " . phpversion() . "\n";
try {
    eval('readonly class TestFeature {}');
    echo "Readonly classes supported.\n";
}
catch (Throwable $e) {
    echo "Readonly classes NOT supported: " . $e->getMessage() . "\n";
}
