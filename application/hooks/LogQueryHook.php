<?php
class LogQueryHook {
 
    function log_queries() {

        $CI = & get_instance();

        $microtime_full = microtime(TRUE);
		$microtime_short = sprintf("%06d", ($microtime_full - floor($microtime_full)) * 1000000);
        $date = new DateTime(date('Y-m-d H:i:s.'.$microtime_short, $microtime_full));
		$date = $date->format('Y-m-d H:i:s');
        $filepath = APPPATH . 'logs/Query-log-' . date('Y-m-d') . '.txt'; 
        $handle = fopen($filepath, "a+");                        

        $times = $CI->db->query_times;
        foreach ($CI->db->queries as $key => $query) 
        { 
            $sql = $date . " \n " . $query . " \n Execution Time:" . round(doubleval($times[$key]), 3); 

            fwrite($handle, $sql . "\n\n");    
        }

        fclose($handle);  
    }
}
?>