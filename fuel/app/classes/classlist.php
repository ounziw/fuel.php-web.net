<?php
/**
 *  GNU Lesser General Public License
 *  http://www.gnu.org/copyleft/lesser.html
 */

class Classlist {
protected $classlist = array(

"Agent",
"Arr",
"Asset",
"Autoloader",
"Cache_Storage_Memcached",
"Cache_Storage_File",
"Cache_Storage_Apc",
"Cache_Storage_Redis",
"Cache_Handler_String",
"Cache_Handler_Json",
"Cache_Handler_Serialized",
"Cache",
"Config_Yml",
"Config_Ini",
"Config_Php",
"Config_Json",
"Config",
"Cookie",
"Crypt",
"Database_Result_Cached",
"Database_Expression",
"Database_MySQL_Result",
"Database_Query_Builder_Delete",
"Database_Query_Builder_Select",
"Database_Query_Builder_Join",
"Database_Query_Builder_Update",
"Database_Query_Builder_Insert",
"Database_MySQLi_Result",
"Database_Query",
"Date",
"DB",
"DBUtil",
"Debug",
"Error",
"Event",
"Fieldset_Field",
"Fieldset",
"File_Area",
"File_Handler_Directory",
"File_Handler_File",
"File",
"Finder",
"Form",
"Format",
"Ftp",
"Fuel",
"Html",
"Image_Imagemagick",
"Image_Imagick",
"Image_Gd",
"Image",
"Inflector",
"Input",
"Lang",
"Log",
"Model_Crud",
"Mongo_Db",
"Num",
"Package",
"Pagination",
"Profiler",
"Redis",
"Request_Curl",
"Request_Soap",
"Request",
"Response",
"Route",
"Router",
"Security",
"Session_Db",
"Session_Memcached",
"Session_File",
"Session_Cookie",
"Session_Redis",
"Session",
"Str",
"Theme",
"Unzip",
"Upload",
"Uri",
"Validation_Error",
"Validation",
"View",
//"View_Dwoo",
//"View_Jade",
//"View_Haml",
"View_Markdown",
"View_Mustache",
"View_Phptal",
//"View_Smarty",
//"View_Twig",
"Cache_Storage_Driver",
"Config_File",
"Controller_Template",
"Controller_Rest",
"Controller",
"Database_Result",
"Database_Query_Builder",
"Database_Query_Builder_Where",
"Image_Driver",
"Request_Driver",
"Session_Driver",
"ViewModel",
);

public function getClassList() {
	return $this->classlist;
	}
}
