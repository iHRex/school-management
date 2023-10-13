<?php
/**
*	Google Chart
*
*	Google Chart API Generator
*
*	@author		Olaf Erlandsen C. [Olaf Erlandsen]
*
*	@package	GoogleCharts
*	@copyright	Copyright 2012, Olaf Erlandsen
*	@copyright	Dual licensed under the MIT or GPL Version 2 licenses.
*	@version	0.2
*
*/
class GoogleCharts
{
	private $chartsTypes = array(
		'area'			=>	'AreaChart',
		'bar'			=>	'BarChart',
		'bubble'		=>	'BubbleChart',
		'candlestick'	=>	'CandlestickChart',
		'column'		=>	'ColumnChart',
		'combo'			=>	'ComboChart',
		'gauge'			=>	'Gauge',
		'geo'			=>	'GeoChart',
		'line'			=>	'LineChart',
		'pie'			=>	'PieChart',
		'scatter'		=>	'ScatterChart',
		'stepped'		=>	'SteppedAreaChart',
		'steppedarea'	=>	'SteppedAreaChart',
		'table'			=>	'Table',
		'tree'			=>	'TreeMap'
	);
	protected	$useType;
	protected	$ArrayToDataTable	=	array();
	protected	$lastRow			=	0;
	protected	$useOptions			=	array();
	protected	$useFunction;
	protected	$useVarname			=	"GoogleChart";
	protected	$listener			=	array();
	protected	$firstRowAsData		=	false;
	protected	$userActions		=	array();
	/**
	*	Define Chart Type
	*
	*	@method	null	load( string $typeChart [ , string $getElementById ] )
	*	@param	string	$typeChart
	*	@param	string	$getElementById
	*/
	public function load( $chartType , $getElementById = null )
	{
		if( !empty( $chartType ) )
		{
			if( !empty( $getElementById ) )
			{
				$this->getElementById( $getElementById );
			}
			if(array_key_exists( strtolower( $chartType ) , $this->chartsTypes  ))
			{
				$this->useType =  $this->chartsTypes[strtolower( $chartType )];
			}else{
				if( in_array( $chartType , $this->chartsTypes ) )
				{
					 $this->useType = $chartType;
				}
			}
		}
		return $this;
	}
	/**
	*	Converter JSON to Array and set rows data
	*
	*	@method	null	jsonToDataTable( string $json [ , $merge = false ] )
	*	@param	string	$json
	*	@param	bool	$merge
	*/
	public function jsonToDataTable( $json , $merge = false )
	{
		if( !empty( $json ) )
		{
			$data = json_decode( $json , false );
			$this->arrayToDataTable( $data , $merge );
		}
	}
	/**
	*	Set rows data
	*
	*	@method	null	arrayToDataTable( string $data [ , $merge = false ] )
	*	@param	array	$data
	*	@param	bool	$merge
	*/
	public function arrayToDataTable( $data , $merge = false )
	{
		if( is_array( $data ) )
		{
			if( count( $data ) > 0 )
			{
				if( is_bool( $merge ) === true AND true === $merge )
				{
					$this->ArrayToDataTable = array_merge( $this->ArrayToDataTable , $data );
				}else{
					$this->ArrayToDataTable = $data;
				}
			}
		}
	}
	public function firstRowAsData()
	{
		$this->firstRowAsData = true;
	}
	/**
	*	Append row on data
	*
	*	@method	null	appendRow( array $columns )
	*	@param	array	$columns
	*/
	public function appendRow( $columns )
	{
		if( is_array( $columns ) )
		{
			 $this->ArrayToDataTable[] =$columns;
		}
	}
	/**
	*	Prepend row on data
	*
	*	@method	null	prependRow( array $columns )
	*	@param	array	$columns
	*/
	public function prependRow( $columns )
	{
		if( is_array( $columns ) )
		{
			array_unshift( $this->ArrayToDataTable ,$columns );
		}
	}
	/**
	*	Append column on row data
	*
	*	@method	null	appendColumn( int $row , mixed $column )
	*	@param	int		$row
	*	@param	mixed	$column
	*/
	public function appendColumn( $row , $column )
	{
		if( array_key_exists( $row , $this->ArrayToDataTable ) )
		{
			$this->ArrayToDataTable[ $row ] = array_merge( $this->ArrayToDataTable[ $row ] , array($column) );
		}
	}
	/**
	*	Prepend column on row data
	*
	*	@method	null	prependColumn( int $row , mixed $column )
	*	@param	int		$row
	*	@param	mixed	$column
	*/
	public function prependColumn( $row , $column )
	{
		if( array_key_exists( $row , $this->ArrayToDataTable ) )
		{
			$this->ArrayToDataTable[ $row ] = array_merge( array($column) , $this->ArrayToDataTable[ $row ] );
		}
	}
	/**
	*	Get column from row data
	*
	*	@method	mixed	getColumn( int $row , int $column )
	*	@param	int		$row
	*	@param	int		$column
	*/
	public function getColumn( $row , $column )
	{
		if( array_key_exists( $row , $this->ArrayToDataTable ) )
		{
			if( array_key_exists( $column , $this->ArrayToDataTable[$row] ) )
			{
				return $this->ArrayToDataTable[ $row ][ $column ];
			}
		}
	}
	/**
	*	Get row from data
	*
	*	@method	array	getRow( int $row )
	*	@param	int		$row
	*/
	public function getRow( $row )
	{
		if( array_key_exists( $row , $this->ArrayToDataTable ) )
		{
			return $this->ArrayToDataTable[ $row ];
		}
	}
	/**
	*	Update column from row data
	*
	*	@method	bool	updateColumn( int $row , int $column , mixed $value )
	*	@param	int		$data
	*	@param	int		$column
	*	@param	mixed	$value
	*/
	public function updateColumn( $row , $column , $value )
	{
		if( array_key_exists( $row , $this->ArrayToDataTable ) )
		{
			if( array_key_exists( $column , $this->ArrayToDataTable[$row] ) )
			{
				$this->ArrayToDataTable[$row][$column] = $value;
			}
		}
	}
	/**
	*	Update row from data
	*
	*	@method	bool	updateRow( int $row , int $columns )
	*	@param	int		$row
	*	@param	array	$columns
	*/
	public function updateRow( $row , $columns )
	{
		if( array_key_exists( $row , $this->ArrayToDataTable ) )
		{
			if( is_array( $columns ) )
			{
				$this->ArrayToDataTable[ $row ] = $columns;
			}
		}
	}
	/**
	*	Delete row from data
	*
	*	@method	bool	deleteRow( int $row )
	*	@param	int		$row
	*/
	public function deleteRow( $row )
	{
		if( array_key_exists( $row , $this->ArrayToDataTable ) )
		{
			unset( $this->ArrayToDataTable[ $row ] );
		}
	}
	/**
	*	Delete column from row data
	*
	*	@method	bool	deleteColumn( int $row , int $column )
	*	@param	int		$row
	*	@param	int		$column
	*/
	public function deleteColumn( $row , $column )
	{
		if( array_key_exists( $row , $this->ArrayToDataTable ) )
		{
			if( array_key_exists( $column , $this->ArrayToDataTable[ $row ] ) )
			{
				unset( $this->ArrayToDataTable[ $row ][ $column ] );
			}
		}
	}
	/**
	*	Truncate Chart Data
	*
	*	@method	null	truncate(  )
	*/
	public function truncate()
	{
		$this->ArrayToDataTable = array();
	}
	/**
	*	Fetch Chart Data
	*
	*	@method	array	fetchData(  )
	*/
	public function fetchData()
	{
		return $this->ArrayToDataTable;
	}
	/**
	*	Define options
	*
	*	@method	bool	options( array $options )
	*	@param	array	$options
	*/
	public function options( $options )
	{
		if( is_array($options) )
		{
			$this->useOptions = $options;
			return true;
		}
		return false;
	}
	/**
	*	Define a user function
	*
	*	@method	bool	use_function( string $name )
	*	@param	string	$name
	*/
	public function useFunction( $name )
	{
		if( !empty( $name ) )
		{
			if( preg_match( '/([^0-9]+[\$a-z0-9_]+)/i' , $name ) )
			{
				$this->useFunctionName = $name;
				return true;
			}
		}
		return false;
	}
	/**
	*	Define varname to use on chart
	*
	*	@method	bool	use_varname( string $name )
	*	@param	string	$name
	*/
	public function useVarname( $name )
	{
		if( !empty( $name ) )
		{
			if( preg_match( '/([^0-9]+[\$a-z0-9_]+)/i' , $name ) )
			{
				$this->useVarname = $name;
				return true;
			}
		}
		return false;
	}
	/**
	*	Define a anonymous listener
	*
	*	@method	object	anonymousListener( string $event , string $params , string $content )
	*	@param	string	$event
	*	@param	string	$params
	*	@param	string	$content
	*/
	public function anonymousListener( $event , $params , $content )
	{
		$this->listener[] = "google.visualization.events.addListener(". $this->useVarname .",'". $event ."',function( ". $params ." ){". $content ."});";
	}
	
	
	/**
	*	setAction
	*
	*	@method	object	setAction( [ array $data = array() ] )
	*	@param	array	$data
	*/
	public function setAction( array $data = array() )
	{
		if( count( $data ) > 0 )
		{
			$this->userActions[] = $data;
		}
	}
	/**
	*	Define a listener
	*
	*	@method	object	userListener( string $event , string $functionName )
	*	@param	string	$event
	*	@param	string	$functionName
	*/
	public function userListener( $event , $functionName )
	{
		if( preg_match( '/(([^0-9]+[a-z0-9\$\_]+)(\s*)(\(.*?\)))/i' , $functionName ) )
		{
			$this->listener[] = "google.visualization.events.addListener(". $this->useVarname .", '". $event ."',". $functionName .");";
		}
	}
	/**
	*	Define a ID HTML Element
	*
	*	@method	object	getElementById( string $id )
	*	@param	string	$id
	*/
	public function getElementById( $id )
	{
		if( preg_match( '/([^0-9]+[\$a-z0-9_]+)/i' , $id ) )
		{
			$this->getElementById = $id;
		}
		return $this;
	}
	
	/**
	*	Get GoogleChart
	*
	*	@method	string	get( [ array $data = null [ , array $options = null ]] )
	*	@param	array	$data
	*	@param	array	$options
	*/
	public function get( $data = null , $options = null )
	{
		/**
		*	SET DATA
		*/
		if( is_array( $data ) )
		{
			$this->arrayToDataTable( $data , true );
		}
		/**
		*	SET OPTIONS
		*/
		if( is_array( $options ) )
		{
			$this->options( $options );
		}
		/**
		*	VALIDATE CHART
		*/
		if(
				!empty( $this->getElementById )
			AND	!empty( $this->useType )
			AND	!empty( $this->useVarname )
			AND	count( $this->ArrayToDataTable ) > 0
		)
		{
			$output = "";
			/**
			*	SELECT PACKAGE
			*/
			switch( strtolower($this->useType) )
			{
				case 'geochart':
				case 'table':
				case 'treemap':
				case 'gauge':
					$output .= "google.load('visualization','1',{packages:['". strtolower($this->useType) ."']});";
				break;
				default:
					$output .= "google.load('visualization','1',{packages:['corechart']});";
				break;
			}
			/**
			*	USE A USER FUNCATION
			*/
			if( !empty( $this->useFunctionName ) )
			{
				$output .="google.setOnLoadCallback(" .$this->useFunctionName. ");";
				$output .= "function " . $this->useFunctionName. "(){";
			}
			/**
			*	USE A ANONYMOUS FUNCTION
			*/
			else
			{
				$output .="google.setOnLoadCallback(function(){";
			}
				$output	 .= "var ". $this->useVarname ."=new google.visualization.".$this->useType."(document.getElementById( '". $this->getElementById ."' ));";
				if( count( $this->userActions ) > 0 )
				{
					foreach( $this->userActions AS $data )
					{
						$output .= $this->useVarname . ".setAction(" . json_encode( $data , 0 ) . ");";
					}
				}
				$output	.= $this->useVarname . ".draw(";
				
					$output	.= "google.visualization.arrayToDataTable(". json_encode( $this->ArrayToDataTable );
					if( $this->firstRowAsData === true )
					{
						$output.=",true";
					}
					$output .= ")";
					
					/**
					*	SAVE CHART OPTIONS
					*/
					if( !empty( $this->useOptions ) )
					{
						$output .=",".json_encode( $this->useOptions );
					}
				$output	.= ");";
				/**
				*	SAVE LISTENER'S
				*/
				if( count( $this->listener ) )
				{
					foreach( $this->listener AS $listener )
					{
						$output .= $listener;
					}
				}
			/**
			*	CLOSE USER FUNCTION
			*/
			if( !empty( $this->useFunctionName ) )
			{
				$output .= "};";
			}
			/**
			*	CLOSE ANONYMOUS FUNCTION
			*/
			else
			{
				$output.= "});";
			}
			return $output;
		}
		return false;
	}
}
?>