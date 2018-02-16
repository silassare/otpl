<?php
	/**
	 * Copyright (c) Emile Silas Sare <emile.silas@gmail.com>
	 *
	 * This file is part of Otpl.
	 */

	final class OTplFeature_RootVar
	{
		// SILO:: root data alias $ replacement
		const REG_ROOT_KEY   = "#[$]([^\w.])#";
		const REG_JS_CHAIN_A = "#([$][a-zA-Z0-9_]*|\])\.(\w+)#";
		const REG_JS_CHAIN_B = "#([$])\[(.+?)\]#";
		const REG_AT_VAR     = "#(?!\w)@var(\s+[$][a-zA-Z_])#";
		// shouldn't match @import(
		const REG_AT_PLUGIN = "#(?!\w)@((?!import\()[a-zA-Z_][a-zA-Z0-9_]+)\(#";

		public static function root_key($in, OTpl $context)
		{
			return OTplUtils::OTPL_DATA_REF . $in[1];
		}

		public static function js_key_chain($in, OTpl $context)
		{
			$txt = "";
			@list($found, $start, $key_name) = $in;

			if (!empty($found)) {
				if (preg_match(OTplUtils::OTPL_STR_KEY_NAME_REG, $key_name)) {
					$key_name = "'$key_name'";
				}

				if ($start === '$') {
					// $.toto -> $otpl_data['toto']
					$txt .= OTplUtils::OTPL_DATA_REF . "[$key_name]";
				} elseif ($start === ']') {
					// ].toto -> ]['totot']
					$txt .= "][$key_name]";
				} else {
					// $papa.toto -> $papa['toto']

					$txt .= $start . "[$key_name]";
				}
			}

			return $txt;
		}

		public static function var_replace($in, OTpl $context)
		{
			return "if(1){}\n " . $in[1];
		}

		public static function plugin_replace($in, OTpl $context)
		{
			$pl_name = $in[1];

			return "OTplUtils::runPlugin('$pl_name',";
		}
	}

	OTplUtils::addReplacer(OTplFeature_RootVar::REG_ROOT_KEY, ['OTplFeature_RootVar', 'root_key']);
	OTplUtils::addReplacer(OTplFeature_RootVar::REG_JS_CHAIN_A, ['OTplFeature_RootVar', 'js_key_chain']);
	OTplUtils::addReplacer(OTplFeature_RootVar::REG_JS_CHAIN_B, ['OTplFeature_RootVar', 'js_key_chain']);

	OTplUtils::addCleaner(OTplFeature_RootVar::REG_AT_VAR, ['OTplFeature_RootVar', 'var_replace']);
	OTplUtils::addCleaner(OTplFeature_RootVar::REG_AT_PLUGIN, ['OTplFeature_RootVar', 'plugin_replace']);
