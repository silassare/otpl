/*! OTpl {otpl_version} */
OTpl.register( {
	'version'      : "{otpl_version}",
	'version_name' : "{otpl_version_name}",
	'src_path'     : "{otpl_src_path}",
	'compile_time' : {otpl_compile_time},
	'func_name'    : "{otpl_func_name}"
}, function ( OTplUtils, data ) {
	'use strict';
	return (function ( __otpl_root ) {
		{otpl_file_content}
	})( { 'out' : [], 'data' : data } );
} );
