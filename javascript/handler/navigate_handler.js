// CONSTRUCTOR

function NavigateHandler(eventHandler, mode) {
	this.eventHandler = eventHandler;
	this.mode = mode;
}

// /CONSTRUCTOR

// VARIABLES

NavigateHandler.URI_NAVIGATE = "api_rest.php?/navigate/%s&mode=%s";

// VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {Number}
 */
NavigateHandler.prototype.getMode = function() {
	return this.mode;
};

/**
 * @return {EventHandler}
 */
NavigateHandler.prototype.getEventHandler = function() {
	return this.eventHandler;
};

// ... /GET

NavigateHandler.prototype.navigate = function(elementId, position, floorId, callback) {

	// Generate url
	var url = Core.sprintf(NavigateHandler.URI_NAVIGATE, elementId, this.getMode());

	// Do ajax
	$.ajax({
		url : url,
		type : "post",
		dataType : "json",
		data : {
			navigate : {
				position : {
					x : position.x,
					y : position.y,
					floorId : floorId
				}
			}
		},
		success : function(data) {
			if (callback.success)
				callback.success(data.navigate);
		},
		error : function(jqXHR, textStatus, errorThrown) {
			console.error(textStatus, errorThrown);
			if (callback.error)
				callback.error(textStatus);
		}
	});

};

// /FUNCTIONS
