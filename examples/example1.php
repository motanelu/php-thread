<?php

/**
 *
 * Basic usage
 *
 * This example is for command-line only execution. Webservers do not support threads.
 *
 * $ php example1.php
 *
 */

namespace PHPThread\Example;

use PHPThread\ThreadQueue;

require __DIR__ . '/../vendor/autoload.php';



// It is the function that will be called several times
function parallel_task($arg)
{
    echo "Task with parameter '$arg' starts\n";
    sleep(rand(2, 5));    // wait for random seconds
    echo "Task with parameter '$arg' ENDS\n";
}


// Create a queue instance with a callable function name
$TQ = new ThreadQueue("PHPThread\Example\parallel_task");

// Add tasks
$TQ->add("one");
$TQ->add("two");
$TQ->add("three");
$TQ->add("four");
$TQ->add("five");

// Wait until all threads exit
while (count($TQ->threads())) {
    sleep(1);    // optional
    echo "Waiting for all jobs done...\n";
    $TQ->tick();    // mandatory!
}

echo "All process finished.\n";
