<?php

/*
 * Project: Serpent - the PHP compiling template engine
 * Copyright (C) 2009 Christoph Erdmann
 * 
 * This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; either version 2.1 of the License, or (at your option) any later version.
 * This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License for more details.
 * You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA
 */

// for CREOLE 1.0
/*
problems at the end
*/
 
class SerpentCompilerCreole extends SerpentCompilerAbstract
    {
	protected $writebacks;
	protected $level = 0;
	protected $rules;
	protected $_kill; // need this for list rendering
	
	public function __construct()
		{
		// the regular expressions should match as less newlines as possible
		
		$ws = "[\t ]*"; // leading whitespace
		$end = "(°|\n\n)"; // end tag for open block elements
		
		$this->regex_rules = array(
			// block elements
			'nowiki' => '=^\{\{\{(.*?)\n\}\}\}=sm',
			'placeholders' => '=<<<(.+?)>>>=',
			'tables' => "=^$ws(\|.+?)$end=sm",
			'headlines' => "/^$ws(={1,6})([^=\n]+)(=*)/m",
			'dividers' => '=^-{4,}\n=m',
			'lists' => "=^[ \t]*([\*#][^\*#].*?)$end=sm",
			'paragraphs' => "=(^|°\n)(.*?)($|°)=s",
			// inline elements
			'htmlspecialchars' => '=(.*)=s',
			'nowiki_inline' => '=\{\{\{(.*?)\}\}\}=s',
			'wikilinks' => '=\[\[(.+?)\]\]=',
			'images' => '=\{\{(.+?)\}\}=',
			'links' => '=([^\[~]|^)((https?|ftp)://[^\s]+)=i',
			'boldanditalics' => '=([^~]|^)(\*\*|//)(.+?[^~])(\2|$)=s',
			'linebreaks' => '=\\\\\\\\=',
			'escapes' => '=~(\S)=',
		);
		$this->inline_rules = array(
			'global' => array('nowiki', 'placeholders', 'tables', 'headlines', 'dividers', 'lists', 'paragraphs'),
			'tables' => array('nowiki_inline', 'htmlspecialchars', 'links', 'escapes', 'wikilinks', 'images', 'boldanditalics', 'linebreaks'),
			'lists' => array('nowiki_inline', 'htmlspecialchars', 'links', 'escapes', 'wikilinks', 'images', 'boldanditalics', 'linebreaks'),
			'paragraphs' => array('nowiki_inline', 'htmlspecialchars', 'links', 'escapes', 'wikilinks', 'images', 'boldanditalics', 'linebreaks'),
			'wikilinks' => array('nowiki_inline', 'htmlspecialchars', 'escapes', 'images', 'linebreaks'),
			'boldanditalics' => array('nowiki_inline', 'htmlspecialchars', 'links', 'escapes', 'wikilinks', 'images', 'boldanditalics', 'linebreaks'),
			'placeholders' => array('nowiki_inline', 'htmlspecialchars', 'links', 'escapes', 'wikilinks', 'images', 'boldanditalics', 'linebreaks'),
		);
		}
	
	// creates the compiled template
    public function compile($source)
        {		
		$this->writebacks = array();

		// clean up source
		$source = preg_replace("=^\s*?(\r\n|\r|\n)=m", "\n", $source);
		$source = "\n\n".$source."\n\n";
		
		// save degree signs
		$source = str_replace('°', '##DEGREES##', $source);
		
		$source = $this->_processing( $source, $this->inline_rules['global'] );
		$source = trim($source);

		// replace degree sign placeholders
		$source = str_replace('##DEGREES##', '°', $source);
		
		return $source;
		}
	
	protected function _processing($source, $rules)
		{
		$this->level++;
		$this->writebacks[ $this->level ] = array();
		
		foreach ($rules as $rule)
			{
			$source = preg_replace_callback( $this->regex_rules[$rule], array($this, '_'.$rule), $source );
			}

		$this->writebacks[ $this->level ] = array_reverse($this->writebacks[ $this->level ]);
		foreach ($this->writebacks[ $this->level ] as $key=>$value)
			{
			$source = $this->str_replace('°°'.$key.'°°', $value, $source, $count);
			}
			
		$this->level--;
		return $source;
		}
	
	// replacement for the original str_replace which also works with a scalar $search and an array as $replace
	protected function str_replace($search, $replace, $subject, &$count = 0)
		{
		if (is_string($search) && is_array($replace))
			{
			foreach ($replace as $replacement)
				{
				$subject = preg_replace('='.preg_quote($search).'=', $replacement, $subject, 1, $count);
				}
			return $subject;
			}
		else
			{
			return str_replace($search, $replace, $subject, $count);
			}
		}
		
	// ************************* indirect rewrites
	protected function _nowiki($match)
		{
		$this->writebacks[ $this->level ]['NOWIKI'][] = '<pre>'.$match[1]."\n".'</pre>';
		return '°°NOWIKI°°';
		}

	protected function _placeholders($match)
		{
		$var = trim($match[1]);
		$fallback = '<<<'.$match[1].'>>>';
		
		if (preg_match('=[^a-z0-9_-]=i', $var)) return $fallback;
		
		$this->writebacks[ $this->level ]['PLACEHOLDER'][] = '<?php echo isset($'.$var.') ? $'.$var.' : "'.$this->_processing($fallback, $this->inline_rules['placeholders'] ).'"; ?>';
		return '°°PLACEHOLDER°°';
		}

	protected function _tables($match)
		{
		$writeback = '<table cellpadding="0" cellspacing="0">';
		
		$rows = explode("\n", $match[1]);
		foreach ($rows as $row)
			{
			$writeback .= '<tr>';
			$fields = explode('|', $row);
			
			// skip the first empty field
			array_shift($fields);
			
			// take care of the optional pipe at the end of the line
			$last = end($fields);
			if (trim($last) == '') array_pop($fields);
			
			foreach ($fields as $field)
				{
				$tag = 'td';
				if ($field{0} == '=')
					{
					$tag = 'th';
					$field = substr($field, 1);
					}
				$writeback .= '<'.$tag.'>'.$this->_processing( $field, $this->inline_rules['tables'] ).'</'.$tag.'>';
				}
			
			$writeback .= '</tr>';
			}

		$writeback .= '</table>';

		
		$this->writebacks[ $this->level ]['TABLE'][] = $writeback;
		return '°°TABLE°°'."\n\n";
		}

	protected function _headlines($match)
		{
		$level = strlen( $match[1] );
		$this->writebacks[ $this->level ]['HEADLINE'][] = '<h'.$level.'>'.trim($match[2]).'</h'.$level.'>';
		return '°°HEADLINE°°';
		}

	protected function _dividers($match)
		{
		$this->writebacks[ $this->level ]['DIVIDER'][] = '<hr />';
		return '°°DIVIDER°°'."\n";
		}

	protected function _lists($match)
		{
		// clean entries
		$lines = explode("\n", $match[1]);
		$lines = array_map('trim', $lines);
		
		// combine multiline entries
		$items = array();
		foreach ($lines as $line)
			{
			if (!preg_match('=^[ \t]*([\*#]+)(.*)=', $line, $match))
				{
				// oh a multiline entry: belongs to previous entry
				$keys = array_keys($items);
				$last_key = end($keys);
				$items[ $last_key ]['text'] .= ' '.trim($line);
				continue;
				}

			$items[] = array
				(
				'text' => trim($match[2]),
				'level' => strlen($match[1]),
				'type' => ($match[1]{0} == '*') ? 'ul' : 'ol',
				);
			}
		
		// render tree array recursively
		$output = $this->_lists_render($items);
		$this->writebacks[ $this->level ]['LIST'][] = $output;
		return '°°LIST°°'."\n\n";
		}

	protected function _lists_render(&$items)
		{
		$items = array_values($items);

		$list_type = $items[0]['type'];
		$output = "<$list_type>";

		foreach ($items as $key=>$item)
			{
			unset($items[$key]);

			$output .= '<li>';
			$output .= $this->_processing($item['text'], $this->inline_rules['lists']);
						
			// create sublist
			if (isset($items[$key+1])) $next = $items[$key+1];
			if (isset($next) && $next['level'] > $item['level'])
				{
				$output .= $this->_lists_render($items);
				}
			
			$output .= '</li>';

			// next item has lower level, so skip further processing of this level
			if (isset($next) && $next['level'] < $item['level']) { $this->_kill = $item['level']-$next['level']; }
			if ($this->_kill > 0) { $this->_kill--; break; }
			}
		
		$output .= "</$list_type>";
		return $output;
		}
		
	protected function _paragraphs($match)
		{
		$source = trim($match[2]);
		if (empty($source)) return $match[1].$match[2].$match[3];

		$source = preg_split("=\n{2,}=", $source);
		
		foreach ($source as $key=>$part)
			{
			$source[$key] = '<p>'.$this->_processing($part, $this->inline_rules['paragraphs'] ).'</p>';
			}
		
		$source = $match[1].implode("\n\n", $source)."\n\n".$match[3];
		
		$this->writebacks[ $this->level ]['PARAGRAPH'][] = $source;
		return '°°PARAGRAPH°°';
		}

	protected function _nowiki_inline($match)
		{
		$this->writebacks[ $this->level ]['NOWIKI'][] = '<tt>'.$match[1].'</tt>';
		return '°°NOWIKI°°';
		}

	protected function _htmlspecialchars($match)
		{
		return htmlspecialchars($match[0]);
		}

	protected function _wikilinks($match)
		{
		$parts = explode('|', $match[1], 2);
		if (!isset($parts[1])) $parts[1] = $parts[0];
		
		$this->writebacks[ $this->level ]['WIKILINK'][] = '<a href="'.$parts[0].'">'.$this->_processing($parts[1], $this->inline_rules['wikilinks'] ).'</a>';
		return '°°WIKILINK°°';
		}

	protected function _images($match)
		{
		$parts = explode('|', $match[1]);
		if (!isset($parts[1])) $parts[1] = '';
		
		$this->writebacks[ $this->level ]['IMAGE'][] = '<img src="'.$parts[0].'" alt="'.$parts[1].'" />';
		return '°°IMAGE°°';
		}

	protected function _links($match)
		{
		// check the last char
		$add = '';
		$lastchar = substr($match[2], -1, 1);
		if (strpos(',.?!:;"\'', $lastchar) !== false)
			{
			$match[2] = substr($match[2], 0, -1);
			$add = $lastchar;
			}
		
		$this->writebacks[ $this->level ]['LINK'][] = $match[1].'<a href="'.$match[2].'">'.$match[2].'</a>'.$add;
		return '°°LINK°°';
		}

	protected function _boldAndItalics($match)
		{
		// specify tag
		$tag = ($match[2] == '**') ? 'strong' : 'em';
		
		// specify trailing whitespace
		$whitespace = (trim($match[4]) == '') ? $match[4] : '';
		
		$this->writebacks[ $this->level ]['BOLDANDITALIC'][] = $match[1] . '<'.$tag.'>'.$this->_processing($match[3], $this->inline_rules['boldanditalics'] ).'</'.$tag.'>'.$whitespace;
		return '°°BOLDANDITALIC°°';
		}

	protected function _linebreaks($match)
		{
		return '<br />';
		}

	protected function _escapes($match)
		{
		$this->writebacks[ $this->level ]['ESCAPES'][] = $match[1];
		return '°°ESCAPES°°';
		}
	}
