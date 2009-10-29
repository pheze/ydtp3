<?php

/*
 * Project: Serpent - the PHP compiling template engine
 * Copyright (C) 2009 Christoph Erdmann
 * 
 * This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; either version 2.1 of the License, or (at your option) any later version.
 * This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License for more details.
 * You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA
 */

include( dirname(__FILE__).'/serpentResourceAbstract.class.php' );
include( dirname(__FILE__).'/serpentCompilerAbstract.class.php' );

class Serpent
	{
	// main config
	public $compile_dir = '';
	public $plugins_dir = array();
	public $force_compile = false;
	public $default_compiler = 'serpent';
	public $default_resource = 'file';
	protected $_vars = array();
	protected $_charset = 'utf-8';

	// for captures
	protected $_capture_stack = array();

	// for repeats
	protected $_repeat_stack = array();
	
	// for inheritance
	protected $_template_stack = array();
	protected $_block_content = array();
	protected $_block_name = array();

	// holds the plugins and their config
	protected $_resource = array();
	protected $_compiler = null;
	protected $_plugin_config = array();

	public function __construct()
		{
		$this->compile_dir = 'templates_compiled/';
		$this->plugins_dir[] = dirname(__FILE__).'/plugins/';		
		}

	public function pass($vars)
		{
		$this->_vars = $vars;
		}
	
	// the main method to render a template
	public function render($tpl, $resource_handler = null, $compiler_handler = null)
		{
		// add trailing slash to compile_dir if not exists
		if (substr($this->compile_dir, -1) != '/') $this->compile_dir .= '/'; 
		
		// check if compile dir exists
		if (!file_exists($this->compile_dir)) throw new Exception('compile_dir "'.$this->compile_dir.'" does not exist.');
		if (!is_writeable($this->compile_dir)) throw new Exception('compile_dir "'.$this->compile_dir.'" is not writeable.');

		// add to template stack
		$this->_template_stack[] = $this->_render($tpl, $resource_handler, $compiler_handler);
		
		// render data 
		extract($this->_vars, EXTR_REFS);
		ob_start();
		
		// include the extended templates
		// foreach would not work here because an included template could fill the template stack
		// (and foreach just works with a copy of the array and would not recognize the new template)
		while (count($this->_template_stack) > 0)
			{
			include( array_shift($this->_template_stack) );
			
			// throw away the output of templates that only extend
			if ( count($this->_template_stack) != 0) ob_clean();
			}

		return ob_get_clean();
		}

	public function addPluginConfig($type, $name, $config)
		{
		$this->_plugin_config[$type][$name] = $config;
		}
	
	public function setCharset($_charset)
		{
		$this->_charset = $_charset;
		}
	
	// makes sure that a valid filename will be used for the compilation file
	protected function _cleanFilename($filename)
		{
		return preg_replace('=[^a-z0-9_-]=i', '%', $filename);
		}
	
	// load and init plugin
	protected function _loadPlugin($type, $name)
		{
		// iterate all plugin dirs
		foreach ($this->plugins_dir as $dir)
			{
			$file = $dir.'/'.$type.'.'.$name.'.php';
			if (!is_file($file)) continue;

			// load plugin file
			include_once($file);
			$class = 'Serpent'.$type.$name;
			$object = new $class($this);
			
			// set config
			if (isset($this->_plugin_config[$type][$name])) $object->setConfig($this->_plugin_config[$type][$name]);
			
			return $object;
			}
		throw new Exception($type.' handler "'.$name.'" does not exist.');
		}
	
	// checks if a template has to be compiled and returns the path to the compiled template
	protected function _render($tpl, $resource_handler = null, $compiler_handler = null)
		{
		// get resource
		if (is_null($resource_handler)) $resource_handler = $this->default_resource;
		if (!isset($this->_resource[$resource_handler])) $this->_resource[$resource_handler] = $this->_loadPlugin('resource', $resource_handler);
		$resource = $this->_resource[$resource_handler];

		// get compiler
		if (is_null($compiler_handler)) $compiler_handler = $this->default_compiler;
		
		// the name of the compiled template
		$compiled_tpl = $this->compile_dir . $this->_cleanFilename( $resource_handler.'_'.$compiler_handler ) . '/' . $this->_cleanFilename( $resource->getTemplateId($tpl) );
		
		// force compile
		if ($this->force_compile)
			{
			$this->_compileTemplate( $tpl, $resource, $compiled_tpl, $compiler_handler);
			return $compiled_tpl;
			}

		// check if a compiled template exists
		if (!file_exists( $compiled_tpl ))
			{
			$this->_compileTemplate( $tpl, $resource, $compiled_tpl, $compiler_handler);
			return $compiled_tpl;
			}
		
		// compare timestamp of tpl and compiled file
		$compiled_tpl_time	= filemtime( $compiled_tpl );
		$raw_tpl_mtime = $resource->getTimestamp( $tpl );
		if ($compiled_tpl_time != $raw_tpl_mtime)
			{
			$this->_compileTemplate( $tpl, $resource, $compiled_tpl, $compiler_handler);
			return $compiled_tpl;
			}
		
		return $compiled_tpl;
		}
		
	// creates the compiled template
	protected function _compileTemplate($tpl, $resource, $compiled_tpl, $compiler_handler)
		{
		$source		= $resource->getTemplate( $tpl );
		$timestamp	= $resource->getTimestamp( $tpl );
		
		// compile source
		$compiled = $this->compile($source, $compiler_handler);
		
		// if path to compiled template does not exist create it
		if (!file_exists( dirname($compiled_tpl) )) mkdir( dirname($compiled_tpl), 0777, true );

		// write compiled template
		file_put_contents($compiled_tpl, $compiled);
		
		// clean compiled template
		file_put_contents($compiled_tpl, php_strip_whitespace($compiled_tpl));
		
		// touch it to synch the mtime of the original and the compiled template
		touch($compiled_tpl, $timestamp);
		}

	public function compile($source, $compiler_handler = null)
		{
		// get compiler handler
		if (is_null($compiler_handler)) $compiler_handler = $this->default_compiler;
		
		// check if compiler was already loaded
		if (!isset($this->_compiler[$compiler_handler])) $this->_compiler[$compiler_handler] = $this->_loadPlugin('compiler', $compiler_handler);
		$compiler = $this->_compiler[$compiler_handler];

		// compile and trim the result to save space
		$compiled = trim($compiler->compile($source));
		
		return $compiled;
		}
		
	// used for the mapped function "block"
	protected function _block($name)
		{
		// put the actual top name on top to use it on endblock() as variable name
		$this->_block_name[] = $name;

		// return only the first value of this block ever
		if (!isset( $this->_block_content[$name] ))
			{
			ob_start();
			return true;
			}
		else return false;
		}

	// used for the mapped function "endblock"
	protected function _endblock()
		{
		// get the actual block name
		$name = array_pop($this->_block_name);
		
		// return only the first value of this block ever
		if ( !isset($this->_block_content[$name]) )
			{
			$this->_block_content[$name] = ob_get_clean();
			}
		
		return $this->_block_content[$name];
		}
			
	// used for the mapped function "escape"
	protected function _escape($var, $charset = null)
		{
		if (is_null($charset)) $charset = $this->_charset;

		if (is_array($var))
			{
			foreach ($var as $key=>$value)
				{
				$var[$key] = $this->_escape($value, $charset);
				}
			}
		else
			{
			if (is_string($var))
				$var = htmlspecialchars($var, ENT_QUOTES, $charset);
			}
		return $var;
		}

	// used for the mapped function "unescape"
	protected function _unescape($var)
		{
		if (is_array($var))
			{
			foreach ($var as $key=>$value)
				{
				$var[$key] = $this->_unescape($value);
				}
			}
		else
			{
			if (is_string($var))
				$var = htmlspecialchars_decode($var, ENT_QUOTES);
			}
		return $var;
		}
	}
