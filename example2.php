<?php	/*

  Advanced  usage
  
  */

require_once("ThreadQueue.php");




// it is the function that will be called several times

function parallel_task($arg){
  echo "task with parameter '$arg' starts\n";
  sleep( rand(2,5) );	// wait for random seconds
  echo "task with parameter '$arg' ENDS\n";
}



// we want 3 jobs in parallel instead of the default 2
$TQ = new ThreadQueue("parallel_task", 3);


// add tasks
$TQ->add("one");
$TQ->add("two");
$TQ->add("three");
$TQ->add("four");
$TQ->add("five");
$TQ->add("six");

// Oops! We changed our mind, let's remove awaiting jobs.
// Existing threads will run, but jobs not started will be removed.
$TQ->flush(); 


// let's add jobs again.
$TQ->add("seven");
$TQ->add("eight");
$TQ->add("nine");
$TQ->add("ten");
$TQ->add("eleven");
$TQ->add("twelve");




// wait until all threads exit

while( $numberOfThreads = count($TQ->threads()) ){
  usleep(500000);	// optional 
  
  echo "waiting for all ($numberOfThreads) jobs done...\n";
  $TQ->tick();	// mandatory!
  
  // ha-ha!   we can change the number of parallel executions realtime.
  $TQ->queueSize = 4;
  
}

echo "all process finished.\n";

