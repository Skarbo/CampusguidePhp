/**
 * Util
 */
function Util() {
}

/**
 * @param {Array}
 *            coordinates Array[Object{x, y}]
 * @returns {Object} Left, right, up, down
 */
Util.getCoordinateBounderies = function(coordinates) {
	if (!coordinates || coordinates.length == 0) {
		return {
			'left' : 0,
			'right' : 0,
			'up' : 0,
			'down' : 0
		};
	}

	var bounderies = {
		'left' : coordinates[0].x,
		'right' : coordinates[0].x,
		'up' : coordinates[0].y,
		'down' : coordinates[0].y
	};

	for ( var i = 1; i < coordinates.length; i++) {
		if (coordinates[i].x < bounderies['left']) {
			bounderies['left'] = coordinates[i].x;
		}
		if (coordinates[i].x > bounderies['right']) {
			bounderies['right'] = coordinates[i].x;
		}
		if (coordinates[i].y < bounderies['up']) {
			bounderies['up'] = coordinates[i].y;
		}
		if (coordinates[i].y > bounderies['down']) {
			bounderies['down'] = coordinates[i].y;
		}
	}

	return bounderies;
};

/**
 * @param {Array}
 *            coordinates Array[Object{x, y}]
 * @returns {Object} x, y
 */
Util.getCoordinateWidthHeight = function(coordinates) {
	var bounceries = Util.getCoordinateBounderies(coordinates);

	return {
		'x' : Math.abs(bounceries['right'] - bounceries['left']),
		'y' : Math.abs(bounceries['down'] - bounceries['up'])
	};
};