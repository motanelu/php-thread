<?php	/*

  Basic usage
  
  for beginners: it is for command-line only execution. Webservers do not support threads.
  
  */

require_once("ThreadQueue.php");




// it is the function that will be called several times

function parallel_task($arg){
  echo "task with parameter '$arg' starts\n";
  sleep( rand(2,5) );	// wait for random seconds
  echo "task with parameter '$arg' ENDS\n";
}



// create a queue instance with a callable function name
$TQ = new ThreadQueue("parallel_task");


// add tasks
$TQ->add("one");
$TQ->add("two");
$TQ->add("three");
$TQ->add("four");
$TQ->add("five");




// wait until all threads exit

while(  count( $TQ->threads() )  ){	// there are existing processes in the background?
  sleep(1);	// optional 
  
  echo "waiting for all jobs done...\n";
  $TQ->tick();	// mandatory!
  
}

echo "all process finished.\n";

