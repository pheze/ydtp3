<?php

/*
 * Project: Serpent - the PHP compiling template engine
 * Copyright (C) 2009 Christoph Erdmann
 * 
 * This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; either version 2.1 of the License, or (at your option) any later version.
 * This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License for more details.
 * You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA
 */

class SerpentResourceFile extends SerpentResourceAbstract
    {
	public $template_dir = 'templates/';
	public $suffix = '.tpl';
	public $language = 'en';
		
	public function getTemplateId($tpl)
		{
		return $tpl.'.'.$this->language;
		}
	
	public function getTemplate($tpl)
		{
		// check trailing slash in template_dir
		if (substr($this->template_dir, -1) != '/') $this->template_dir .= '/';

		$raw_tpl		= $this->template_dir . $tpl;

		// check for language dependent template file
		$tpl_lang = $raw_tpl . '.' . $this->language . $this->suffix;		
		if (file_exists( $tpl_lang )) $raw_tpl = $tpl_lang;
		else $raw_tpl = $raw_tpl . $this->suffix; // or fall back to standard template
		
		return file_get_contents( $raw_tpl );
		}

	public function getTimestamp($tpl)
		{
		// check trailing slash in template_dir
		if (substr($this->template_dir, -1) != '/') $this->template_dir .= '/';

		$raw_tpl		= $this->template_dir . $tpl;

		// check for language dependent template file
		$tpl_lang = $raw_tpl . '.' . $this->language . $this->suffix;		
		if (file_exists( $tpl_lang )) $raw_tpl = $tpl_lang;
		else $raw_tpl = $raw_tpl . $this->suffix; // or fall back to standard template

		// does the template exist
		if (!file_exists( $raw_tpl )) throw new Exception('template "'.$tpl.'" ('.$raw_tpl.') does not exist.');
		
		return filemtime( $raw_tpl );
		}
	}
