//Ex: @import(url,data) --> OTplUtils.importExec(url,data)
OTplUtils.addReplacer({
	reg: /@import\([\s]*?(?:'|\")(.*?)(?:'|\")(?:[\s]*,[\s]*(.+?)[\s]*)?[\s]*\)/g,
	val: function(){
		var scope = this,
			url = arguments[1],
			data = arguments[2];

		if (/\.otpl$/.test(url)){
			var child = (new OTpl()).parse(url);

			scope.addDependancies(child.getDependancies());
			scope.addDependancies([url]);

			return	"OTplUtils.importExec('"+url+"',"+data+")";
		} else {
			return "OTplUtils.loadFile('"+url+"')";
		}
	}
});