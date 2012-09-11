/**
 * Abstract class
 * 
 * @param {integer}
 *            mode
 */
function StandardCampusguideDao(mode, controllerName) {
	this.mode = mode;
	this.foreignField = "id";
	this.list = false;
	this.ajax = new StandardCampusguideAjaxDao(controllerName, mode);
	this.listAll = false;
	this.listForeign = [];
}

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

StandardCampusguideDao.prototype.getFromList = function(id) {
	if (this.isList()) {
		return this.list[id];
	}
	return null;
};

/**
 * @param {Function}
 *            filterFunc Function(single) { return boolean; }
 * @returns {Object}
 */
StandardCampusguideDao.prototype.getFilteredList = function(filterFunc) {
	if (this.isList()) {
		var filteredList = {};
		for (id in this.list) {
			if (filterFunc(this.list[id])) {
				filteredList[id] = this.list[id];
			}
		}
		return filteredList;
	}
	return {};
};

/**
 * @param foreignId
 * @returns {Object}
 */
StandardCampusguideDao.prototype.getForeignList = function(foreignId) {
	var foreignField = this.foreignField;
	return this.getFilteredList(function(single) {
		return single[foreignField] == foreignId;
	});
};

// ... /GET

// ... ADD

StandardCampusguideDao.prototype.addSingleToList = function(single) {
	if (single != null) {
		if (this.isList()) {
			this.list = {};
		}
		this.list[single.id] = single;
	}
};

StandardCampusguideDao.prototype.addListToList = function(list) {
	if (list != null) {
		if (this.isList()) {
			this.list = {};
		}
		this.list = $.extend(list, this.list);
	}
};

// ... /ADD

// ... IS

StandardCampusguideDao.prototype.isList = function() {
	return jQuery.isPlainObject(this.list);
};

StandardCampusguideDao.prototype.isInList = function(id) {
	return this.getFromList(id) != null;
};

// ... /IS

// ... REMOVE

StandardCampusguideDao.prototype.removeFromList = function(id) {
	if (this.isInList(id)) {
		var single = this.list[id];
		delete this.list[id];
		return single;
	}
	return null;
};

// ... /REMOVE

// ... SET

StandardCampusguideDao.prototype.setList = function(list) {
	if (jQuery.isPlainObject(list)) {
		this.list = list;
	}
};

// ... /SET

/**
 * @param {integer}
 *            id
 * @param {function}
 *            callback
 * @param {boolean}
 *            forceAjax True if force REST
 * @return {Object}
 */
StandardCampusguideDao.prototype.get = function(id, callback, forceAjax) {
	if (!forceAjax && this.isInList(id)) {
		callback(this.getFromList(id));
	} else {
		var context = this;
		this.ajax.get(id, function(single) {
			context.addSingleToList(single);
			callback(single);
		});
	}
};

/**
 * @param {function}
 *            callback
 * @param {boolean}
 *            forceAjax True if force REST
 * @return {Object}
 */
StandardCampusguideDao.prototype.getAll = function(callback, forceAjax) {
	if (!forceAjax && this.isList() && this.listAll) {
		callback(this.list);
	} else {
		var context = this;
		this.ajax.getAll(function(list) {
			context.listAll = true;
			context.setList(list);
			callback(list);
		});
	}
};

/**
 * @param {Object}
 *            foreignId
 * @param {function}
 *            callback
 * @param {boolean}
 *            forceAjax True if force REST
 * @return {Object}
 */
StandardCampusguideDao.prototype.getForeign = function(foreignId, callback, forceAjax) {
	var context = this;
	if (!forceAjax && this.isList() && jQuery.inArray(foreignId, this.listForeign) > -1) {
		callback(this.getForeignList(foreignId));
	} else {
		this.ajax.getForeign(foreignId, function(list) {
			context.listForeign.push(foreignId);
			context.addListToList(list);
			callback(list);
		});
	}
};

/**
 * @param {integer}
 *            foreignId
 * @param {Object}
 *            object
 * @param {function}
 *            callback
 * @return {Object}
 */
StandardCampusguideDao.prototype.add = function(foreignId, object, callback) {
	var context = this;
	this.ajax.add(foreignId, object, function(single, list) {
		context.addSingleToList(single);
		callback(single, list);
	});
};

/**
 * @param {Number}
 *            id
 * @param {Object}
 *            object
 * @param {function}
 *            callback
 * @return {Object}
 */
StandardCampusguideDao.prototype.edit = function(id, object, callback) {
	var context = this;
	this.ajax.edit(id, object, function(single, list) {
		context.addSingleToList(single);
		callback(single, list);
	});
};

// /FUNCTIONS

