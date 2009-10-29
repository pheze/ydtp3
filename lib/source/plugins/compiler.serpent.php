<?php

/*
 * Project: Serpent - the PHP compiling template engine
 * Copyright (C) 2009 Christoph Erdmann
 * 
 * This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; either version 2.1 of the License, or (at your option) any later version.
 * This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License for more details.
 * You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA
 */

class SerpentCompilerSerpent extends SerpentCompilerAbstract
    {
    protected $mappings = array();
		
	public function __construct()
		{
		$this->mappings = array(
			'render' => 'include $this->_render',
			'eval' => 'eval( "?>" . $this->compile',
			'extend' => '$this->_template_stack[] = $this->_render',
			'capture' => 'ob_start(); $this->_capture_stack[] = ',
			'endcapture' => '${array_pop($this->_capture_stack)} = ob_get_clean',
			'repeat' => 'ob_start(); $this->_repeat_stack[] = ',
			'endrepeat' => 'echo str_repeat(ob_get_clean(), array_pop($this->_repeat_stack)); time',
			'escape' => '$this->_escape',
			'unescape' => '$this->_unescape',
		);
		}
		
	// creates the compiled template
    public function compile($content)
        {
		// strip comments
		$content = preg_replace("=/\*.*?\*/\s+=is", '', $content);
		
		// replace escaped tilde
		$content = str_replace('\~', '<?php echo chr(126) ?>', $content);
		
		// process blocks
		$content = preg_replace_callback('=(~~|~)\[(/?)([a-z0-9 _-]+)\]~=Ui', array($this, '_callback_processTemplateBlocks'), $content);

		// replace tildes with php tags
		$content  = preg_replace_callback('=(~~?)(.*?)~=s', array($this, '_callback_processTildes'), $content);
		
		// tokenize code
		$php_block = false; // shows if we are in a php block
		$tokens = token_get_all($content);
		$content = '';
		foreach ($tokens as $token)
			{
			// get token name and token content
			$token_name = 'UNDEFINED';
			if (is_array($token))
				{
				$token_name = token_name($token[0]);
				$token = $token[1];
				}
			
			// process php blocks
			if ($token_name == 'T_OPEN_TAG')
				{
				$content .= '<?php ';
				$php_content = '';
				$php_block = true;
				}
			elseif ($token_name == 'T_OPEN_TAG_WITH_ECHO')
				{
				$content .= '<?php echo ';
				$php_content = '';
				$php_block = true;
				}
			elseif ($token_name == 'T_CLOSE_TAG')
				{
				$content .= $this->_callback_processPhpBlocks($php_content) . ' ' . $token;
				$php_block = false;
				}
			elseif (!$php_block)
				{
				$content .= $token;
				}
			elseif ($php_block)
				{
				$php_content .= $token;
				}
			}
		
		// return 
		return $content;
        }
    
	// callback to process the template blocks
	protected function _callback_processTemplateBlocks($matches)
		{
		$start_block = (empty($matches[2])) ? true : false;
		$var = $matches[3];
		
		if ($start_block)
			return '<?php if ($this->_block("'.$var.'")): ?>';
		else
			return '<?php endif; echo $this->_endblock("'.$var.'") ?>';
		}

	// callback to process the php blocks
	protected function _callback_processPhpBlocks($content)
		{
		// expand array syntax
		$content = preg_replace_callback('=(\$[a-z0-9_]+)((\.[a-z0-9_]+)+)=i', array($this, '_callback_expandArraySyntax'), $content);
		
		// extract mapped functions
		while ($this->_expandFunctionSyntax($content)) continue;

		return $content;
		}
	
	// callback to process tildes
	protected function _callback_processTildes($content)
		{
		$returner = '<?php ';
		if ($content[1] == '~~') $returner .= 'echo ';
		$returner .= $content[2] . '?>';
		return $returner;
		}


	// replace all mapped function calls
	protected function _expandFunctionSyntax(&$content)
		{
		// find all mapped function calls
		if (!preg_match('=(?<!:):([a-z0-9_]+)\s*(\()=i', $content, $match, PREG_OFFSET_CAPTURE)) return false;
		
		// check mappings
		if (!isset($this->mappings[ $match[1][0] ])) throw new Exception('mapping for function call "'.$match[1][0].'" does not exist.');
		$mapping = $this->mappings[ $match[1][0] ];
		
		// find end of mapped function (search for the last closing parenthesis)
		$i = $match[2][1]; // starting position of opening parenthesis
		$count = null;
		while ($count !== 0 and isset($content{$i}))
			{
			if ( $content{$i} == '(' ) $count++;
			if ( $content{$i} == ')' ) $count--;
			$i++;
			}
		
		// get parts
		$start = substr($content, 0, $match[0][1]);
		$parameters = substr($content, $match[2][1], $i-$match[2][1]);
		$paranthesis_add = str_repeat(')', substr_count($mapping, '(') - substr_count($mapping, ')') );
		$end = substr($content, $i);

		$content = $start . $mapping . $parameters . $paranthesis_add . $end;
		
		return true;
		}
	
	// callback to expand the dot syntax for arrays
	protected function _callback_expandArraySyntax($matches)
		{
		$parts = explode('.', $matches[2]);
		array_shift($parts);
		
		$returner = $matches[1];
		$returner .= "['".implode("']['", $parts)."']";
		return $returner;
		}
	}
