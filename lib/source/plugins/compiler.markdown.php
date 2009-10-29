<?php

/*
 * Project: Serpent - the PHP compiling template engine
 * Copyright (C) 2009 Christoph Erdmann
 * 
 * This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; either version 2.1 of the License, or (at your option) any later version.
 * This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License for more details.
 * You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA
 */

class SerpentCompilerMarkdown extends SerpentCompilerAbstract
    {
    protected $path = '';
    protected $mappings = array();
    protected $config = array();
		
	// creates the compiled template
    public function compile($source)
        {
		require_once($this->path);
		$parser_class = MARKDOWN_PARSER_CLASS;
		$parser = new $parser_class;
		
		// process configuration
		foreach ($this->config as $key=>$value)
			{
			$parser->$key = $value;
			}
		
		// Transform text using parser.
		$source =  $parser->transform($source);
	
		// execute mappings
		foreach ($this->mappings as $key=>$value)
			{
			$source = preg_replace($key, $value, $source);
			}
		
		return $source;
		}
	}
