function TableSearch() {
}

TableSearch.DATA = "tableSearch";

TableSearch.createSearchRegexp = function(search, smart) {
	var asSearch, sRegExpString, regex;

	if (!search) {
		return null;
	}

	if (smart == undefined || smart == true) {
		/*
		 * Generate the regular expression to use. Something along the lines of:
		 * ^(?=.*?\bone\b)(?=.*?\btwo\b)(?=.*?\bthree\b).*$
		 */
		asSearch = search.split(' ');
		sRegExpString = '^(?=.*?' + asSearch.join(')(?=.*?') + ').*$';
		regex = new RegExp(sRegExpString, "i");
	} else {
		regex = RegExp(search, "i");
	}

	// Return RegExp
	return regex;
};

(function($) {

	var tableSearchMethods = {
		init : function(options) {

			return this.each(function() {

				var $this = $(this), data = $this.data(TableSearch.DATA);

				if (!data) {

					$(this).data(TableSearch.DATA, {
						target : $this,
						options : options
					});

				}

			});
		},
		destroy : function() {

			return this.each(function() {

				var $this = $(this), data = $this.data(TableSearch.DATA);

				// Namespacing FTW
				data.tableSearch.remove();
				$this.removeData(TableSearch.DATA);

			});

		},
		search : function(search) {
			var $this = $(this), data = $this.data(TableSearch.DATA);

			// Reset if no search given
			if (search == undefined || search == "") {
				$this.tableSearch("reset");
				return;
			}

			// Get display element
			var displayElement = data.target.find(data.options.display);

			// Get no result element
			var noresultElement = data.target.find(data.options.noresult);

			// Get search regex
			var searchRegExp = TableSearch.createSearchRegexp(search);

			// Foreach display element
			var display = null, text = null, result = 0;
			displayElement.each(function(i, element) {
				display = $(element);
				// Get text
				text = display.find(data.options.search).text();

				// Search text
				if (searchRegExp.test(text)) {
					display.removeClass("hide");
					result++;
				} else {
					display.addClass("hide");
				}

			});

			// No result
			if (result > 0) {
				noresultElement.addClass("hide");
			} else {
				noresultElement.removeClass("hide", result);
			}

		},
		reset : function() {
			var $this = $(this), data = $this.data(TableSearch.DATA);

			// Get display element
			var displayElement = data.target.find(data.options.display);

			// Get no result element
			var noresultElement = data.target.find(data.options.noresult);

			// Remove hide class
			displayElement.removeClass("hide");

			// Hide noresult element
			if (displayElement.length > 0) {
				noresultElement.addClass("hide");
			}
		}
	};

	$.fn.tableSearch = function(method) {

		if (tableSearchMethods[method]) {
			return tableSearchMethods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return tableSearchMethods.init.apply(this, arguments);
		} else {
			$.error('Method ' + method + ' does not exist on jQuery.tableSearch');
		}

	};

})(jQuery);