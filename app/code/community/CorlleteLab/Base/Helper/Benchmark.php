<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2010 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * Benchmark handler
 *
 * $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.8/e107_handlers/benchmark.php $
 * $Id: Benchmark.php 4520 2013-11-26 12:16:11Z sonice $
 */

 /**
 * @package e107
 * @subpackage e107_handlers
 * @version $Id: Benchmark.php 4520 2013-11-26 12:16:11Z sonice $
 * @author secretr
 *
 * Simple, quick and efective way of testing performance of parts of your code
 * Example:
 * <code> <?php
 * require_once e_HANDLER.'benchmark.php';
 *
 * $bench = new e_benchmark();
 * $bench->start();
 *
 * // Do something, e.g. loop 1000000 times
 *
 * // stop timer and check your e_LOG folder
 * $bench->end()->logResult('myevent');
 * //OR print out the result (don't forget to stop the timer if used without the above line!
 * $bench->printResult();
 * </code>
 */
class CorlleteLab_Base_Helper_Benchmark
{
	protected $time_start;
	protected $time_end;

	/**
	 * Constructor
	 */
	function __construct()
	{
		$this->time_end = $this->time_start = 0;
	}

	/**
	 * Start timer
	 * @return benchmark
	 */
	public function start()
	{
		$this->time_start = microtime(true);
		return $this;
	}

	/**
	 * Stop timer
	 * @return benchmark
	 */
	public function end()
	{
		$this->time_end = microtime(true);
		return $this;
	}

	/**
	 * Calculate result
	 * @return integer
	 */
	public function result()
	{
		return ($this->time_end - $this->time_start);
	}

	/**
	 * Write result to a file in system log
	 * @param string $fname full file path
	 * @param string $heading additional data to be shown in the log (header) e.g. '[Some Event]'
	 * @param boolean $append overwrite or append to the log file
	 * @return benchmark
	 */
	public function logResult($fname, $heading = '', $append = true)
	{
		file_put_contents($fname, $this->formatData($heading), ($append ? FILE_APPEND : 0));
		return $this;
	}

	/**
	 * Send result to the stdout
	 *
	 * @param string $heading
	 * @return string
	 */
	public function printResult($heading = '', $pre = true)
	{
		if ($pre) {
			print('<pre>'.$this->formatData($heading).'</pre>');
		} else {
			print($this->formatData($heading));
		}
		
		return $this;
	}

	/**
	 * Format data for loging/printing
	 *
	 * @param string $heading
	 * @return string
	 */
	function formatData($heading)
	{
		$memory = (memory_get_usage(true))/1024/1024;
		$data = "------------- Log Start -------------\n".date('r')." ".$heading."\n";
		$data .= "Result: ".$this->result()." sec\nMemory: ".$memory." MB (".memory_get_usage()." )\n------------- Log End -------------\n\n";
		return $data;
	}
}