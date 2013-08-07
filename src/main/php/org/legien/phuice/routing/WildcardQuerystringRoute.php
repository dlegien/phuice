<?php

	namespace org\legien\phuice\routing;

	use org\legien\phuice\routing\Route;

	class WildcardQuerystringRoute extends Route
	{
		protected function regex($matches)
		{
			return '([a-zA-Z0-9_\+\-\=\.%&]+)';
		}
		
		public function matchWith($path)
		{
			$parameterNames = array();
			preg_match_all('@:([\w]+)@', $this->route, $parameterNames, PREG_PATTERN_ORDER);
			if(strpos($this->route, '*') !== FALSE)
			{
				$this->route = str_replace('*', '(.*)', $this->route);
			}
				
			$regex = preg_replace_callback('@:[\w]+@', array($this, 'regex'), $this->route);
			$regex .= '/?';
		
			if(preg_match('@^'.$regex.'$@', $path, $parameters))
			{
				foreach($parameterNames[0] as $index => $value)
				{
					$val = urldecode($parameters[$index+1]);
					
					if (strpos($val, "&") !== FALSE)
					{
						$split = explode('&', $val);
						foreach ($split as $param)
						{
							$paramInfo = explode('=', $param);
							$this->parameters[$paramInfo[0]] = urldecode($paramInfo[1]);
						}	
					}
					else
					{
						$this->parameters[substr($value,1)] = urldecode($parameters[$index+1]);
					}
				}
		
				foreach($this->target as $key => $value)
				{
					$this->parameters[$key] = $value;
				}
				$this->setMatched(TRUE);
			}
				
			$this->setProcessed(TRUE);
		}		
	}