/**
 * Abstract class
 * 
 * @param {string}
 *            uriControllerName
 * @param {integer}
 *            mode
 */
function StandardCampusguideAjaxDao(uriControllerName, mode) {
	this.uriControllerName = uriControllerName;
	this.mode = mode;
}

// VARIABLES

StandardCampusguideAjaxDao.URI_API = "api_rest.php?/%s/%s&mode=%s";
StandardCampusguideAjaxDao.URI_SPLITTER_ID = "_";
StandardCampusguideAjaxDao.URI_GET_LIST_GET = "get";
StandardCampusguideAjaxDao.URI_GET_SINGLE_GET = "get/%s";
StandardCampusguideAjaxDao.URI_GET_LIST_FOREIGN_GET = "foreign/%s";
StandardCampusguideAjaxDao.URI_POST_SINGLE_ADD = "add/%s";
StandardCampusguideAjaxDao.URI_POST_SINGLE_EDIT = "edit/%s";
StandardCampusguideAjaxDao.URI_GET_SINGLE_REMOVE = "remove/%s";

// /VARIABLES

// FUNCTIONS

// ... GET

StandardCampusguideAjaxDao.prototype.getUriControllerName = function() {
	return this.uriControllerName;
};

StandardCampusguideAjaxDao.prototype.getUriIds = function(id) {
	return jQuery.isArray(id) ? id.join(StandardCampusguideAjaxDao.URI_SPLITTER_ID) : id;
};

StandardCampusguideAjaxDao.prototype.getMode = function() {
	return this.mode;
};

StandardCampusguideAjaxDao.prototype.getUri = function(uri) {
	return Core.sprintf(StandardCampusguideAjaxDao.URI_API, this
			.getUriControllerName(), uri, this.getMode());
};

// ... /GET

/**
 * @param {integer}
 *            id
 * @param {function}
 *            callback
 * @return {Object}
 */
StandardCampusguideAjaxDao.prototype.get = function(id, callback) {
	// Generate url
	var url = Core.sprintf(this
			.getUri(StandardCampusguideAjaxDao.URI_GET_SINGLE_GET), id);

	// Do ajax
	$.ajax({
		url : url,
		dataType : "json",
		success : function(data) {
			callback(data["single"]);
		},
		error : function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);
		}
	});
};

/**
 * @param {function}
 *            callback
 * @return {Object}
 */
StandardCampusguideAjaxDao.prototype.getAll = function(callback) {
	// Generate url
	var url = this.getUri(StandardCampusguideAjaxDao.URI_GET_LIST_GET);

	// Do ajax
	$.ajax({
		url : url,
		dataType : "json",
		success : function(data) {
			callback(data["list"]);
		},
		error : function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);
		}
	});
};

/**
 * @param {integer}
 *            id
 * @param {function}
 *            callback
 * @return {Object}
 */
StandardCampusguideAjaxDao.prototype.getForeign = function(id, callback) {
	// Generate url
	var url = Core.sprintf(this
			.getUri(StandardCampusguideAjaxDao.URI_GET_LIST_FOREIGN_GET), this
			.getUriIds(id));

	// Do ajax
	$.ajax({
		url : url,
		dataType : "json",
		success : function(data) {
			callback(data["list"]);
		},
		error : function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);
		}
	});
};

/**
 * @param {integer}
 *            id
 * @param {function}
 *            callback
 * @return {Object}
 */
StandardCampusguideAjaxDao.prototype.getList = function(id, callback) {
	// Generate url
	var url = Core.sprintf(this
			.getUri(StandardCampusguideAjaxDao.URI_GET_SINGLE_GET), this
			.getUriIds(id));

	// Do ajax
	$.ajax({
		url : url,
		dataType : "json",
		success : function(data) {
			callback(data["list"]);
		},
		error : function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);
		}
	});
};

/**
 * @param {integer}
 *            foreignId
 * @param {Objecet}
 *            object
 * @param {function}
 *            callback
 * @return {Object}
 */
StandardCampusguideAjaxDao.prototype.add = function(foreignId, object, callback) {
	// Generate url
	var url = Core.sprintf(this
			.getUri(StandardCampusguideAjaxDao.URI_POST_SINGLE_ADD), foreignId ? foreignId : "");

	// Do ajax
	$.ajax({
		url : url,
		dataType : "json",
		type: "POST",
		data : { 'object' : object },
		success : function(data) {
			callback(data["single"], data["list"]);
		},
		error : function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);
		}
	});
};

/**
 * @param {integer}
 *            id
 * @param {function}
 *            callback
 * @return {Object}
 */
StandardCampusguideAjaxDao.prototype.edit = function(id, object, callback) {
	// Generate url
	var url = Core.sprintf(this
			.getUri(StandardCampusguideAjaxDao.URI_POST_SINGLE_EDIT), id);

	// Do ajax
	$.ajax({
		url : url,
		dataType : "json",
		type: "POST",
		data : { 'object' : object },
		success : function(data) {
			callback(data["single"], data["list"]);
		},
		error : function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);
		}
	});
};

/**
 * @param {integer}
 *            id
 * @return {Object}
 */
StandardCampusguideAjaxDao.prototype.remove = function(id, callback) {
	// Generate url
	var url = Core.sprintf(this
			.getUri(StandardCampusguideAjaxDao.URI_GET_SINGLE_REMOVE), id);

	// Do ajax
	$.ajax({
		url : url,
		dataType : "json",
		success : function(data) {
			callback(data["single"], data["list"]);
		},
		error : function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);
		}
	});
};

// /FUNCTIONS
