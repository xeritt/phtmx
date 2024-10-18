<?php


/**
 * Process
 *
 */
class Proc {
    
    /**
     * Executes process
     *
     * @param string $command
     * @param string $cwd
     * @param bool $exitOnError
     * @return void
     */
    static public function exec(string $command, string $cwd = null, bool $exitOnError = true): string {
        $descriptorSpec = array(
            0 => array('pipe', 'r'), // stdin is a pipe that the child will read from
            1 => array('pipe', 'w'), // stdout is a pipe that the child will write to
            2 => array("pipe", "w"), // stderr is a pipe that the child will write to
        );

        $process = proc_open($command, $descriptorSpec, $pipes, $cwd);
        $acc = '';
        if (is_resource($process)) {
            do {
                $read = array($pipes[1], $pipes[2]);
                $write = null;
                $except = null;

                if (stream_select($read, $write, $except, 0)) {
                    foreach ($read as $c) {
                        if (feof($c)) {
                            continue;
                        }
                        $read = fread($c, 1024);

                        if ($read === false) {
                            continue;
                        }

                        //echo $read;
                        $acc .= $read;
                    }
                }
            } while (!feof($pipes[1]) | !feof($pipes[2]));

            fclose($pipes[0]);
            fclose($pipes[1]);
            fclose($pipes[2]);

            // It is important to close any pipes before calling
            // proc_close to avoid a deadlock
            $returnValue = proc_close($process);

            if ($returnValue != 0) {
                if ($exitOnError) {
                    exit(1);
                }
            }
            return $acc;
        } else {
            echo "Couldn't open $command";
            if ($exitOnError) {
                exit(1);
            }
        }
    }    
}
