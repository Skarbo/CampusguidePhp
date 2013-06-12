// CONSTRUCTOR

function SearchHandler(eventHandler, mode, daoContainer) {
	this.eventHandler = eventHandler;
	this.mode = mode;
	this.daoContainer = daoContainer;
}

// /CONSTRUCTOR

// VARIABLES

SearchHandler.URI_SEARCH = "api_rest.php?/search/%s&mode=%s";
SearchHandler.URI_SEARCH_TYPE = "api_rest.php?/search/%s/%s/%s&mode=%s%s";

SearchHandler.TYPE_BUILDING = "building";

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {DaoContainer}
 */
SearchHandler.prototype.getDaoContainer = function() {
	return this.daoContainer;
};

/**
 * @return {Number}
 */
SearchHandler.prototype.getMode = function() {
	return this.mode;
};

/**
 * @return {EventHandler}
 */
SearchHandler.prototype.getEventHandler = function() {
	return this.eventHandler;
};

// ... /GET

// ... SEARCH

SearchHandler.prototype.search = function(search) {
	var context = this;

	// Generate url
	var url = Core.sprintf(SearchHandler.URI_SEARCH, encodeURI(search), this.getMode());

	// Do ajax
	$.ajax({
		url : url,
		dataType : "json",
		success : function(data) {
			context.handleSearchResult(data);
		},
		error : function(jqXHR, textStatus, errorThrown) {
			console.error(textStatus, errorThrown);
		}
	});

};

SearchHandler.prototype.searchBuilding = function(search, buildingId, simple) {
	simple = simple || false;
	var context = this;

	// Generate url
	var url = Core.sprintf(SearchHandler.URI_SEARCH_TYPE, encodeURI(search), SearchHandler.TYPE_BUILDING, buildingId, this.getMode(), simple ? "&simple=true" : "");

	// Do ajax
	$.ajax({
		url : url,
		dataType : "json",
		success : function(data) {
			context.handleSearchResult(data);
		},
		error : function(jqXHR, textStatus, errorThrown) {
			console.error(textStatus, errorThrown);
		}
	});

};

SearchHandler.prototype.handleSearchResult = function(data) {
	var context = this;
	var facilities = data.facilities || [];
	var buildings = data.buildings || [];
	var elements = data.elements || [];
	var isSimple = data.info ? data.info.simple : false;

	if (!isSimple) {
		this.getDaoContainer().getFacilityDao().addListToList(facilities);
		this.getDaoContainer().getBuildingDao().addListToList(buildings);
		this.getDaoContainer().getElementBuildingDao().addListToList(elements);

		this.getEventHandler().handle(new ResultSearchEvent({
			"facilities" : facilities,
			"buildings" : buildings,
			"elements" : elements
		}));
	} else {
		// TODO Woha.. ugly
		this.getDaoContainer().getFacilityDao().getList(facilities, function(list) {
			var facilitiesRetrieved = list;
			context.getDaoContainer().getBuildingDao().getList(buildings, function(list) {
				var buildingsRetrieved = list;
				context.getDaoContainer().getElementBuildingDao().getList(elements, function(list) {
					var elementsRetrieved = list;
					context.getEventHandler().handle(new ResultSearchEvent({
						"facilities" : facilitiesRetrieved,
						"buildings" : buildingsRetrieved,
						"elements" : elementsRetrieved
					}));
				});
			});
		});
	}
};

// ... /SEARCH

// FUNCTIONS
