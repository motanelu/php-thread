<?php

/**
 *
 * Advanced usage
 *
 * This example is for command-line only execution. Webservers do not support threads.
 *
 * $ php example2.php
 *
 */

namespace PHPThread\Example;

use PHPThread\ThreadQueue;

require __DIR__ . '/../vendor/autoload.php';



// Function is a static method of a class
abstract class class1
{
    public static function parallel_task($arg)
    {
        echo "Task with parameter '$arg' starts\n";
        sleep(rand(2, 5));  // wait for random seconds
        echo "Task with parameter '$arg' ENDS\n";
    }
}


// We want 3 jobs in parallel instead of the default 2
$TQ = new ThreadQueue("PHPThread\Example\class1::parallel_task", 3);

// Add tasks
$TQ->add("one");
$TQ->add("two");
$TQ->add("three");
$TQ->add("four");
$TQ->add("five");
$TQ->add("six");

// Oops! We changed our mind, let's remove awaiting jobs
// Existing threads will run, but jobs not started will be removed
$TQ->flush();

// Let's add jobs again
$TQ->add("seven");
$TQ->add("eight");
$TQ->add("nine");
$TQ->add("ten");
$TQ->add("eleven");
$TQ->add("twelve");

// Wait until all threads exit
while ($numberOfThreads = count($TQ->threads())) {
    usleep(500000); // optional
    
    echo "Waiting for all ($numberOfThreads) jobs done...\n";
    $TQ->tick();    // mandatory!
    
    // ha-ha! We can change the number of parallel executions realtime.
    $TQ->queueSize = 4;
}

echo "All process finished.\n";
