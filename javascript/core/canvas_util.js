function CanvasUtil() {
}

CanvasUtil.roundRect = function(ctx, x, y, width, height, radius) {
	if (typeof radius === "undefined") {
		radius = 5;
	}
	ctx.beginPath();
	ctx.moveTo(x + radius, y);
	ctx.lineTo(x + width - radius, y);
	ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
	ctx.lineTo(x + width, y + height - radius);
	ctx.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
	ctx.lineTo(x + radius, y + height);
	ctx.quadraticCurveTo(x, y + height, x, y + height - radius);
	ctx.lineTo(x, y + radius);
	ctx.quadraticCurveTo(x, y, x + radius, y);
	ctx.closePath();

};

/**
 * @param {array}
 *            coordinates
 * @return {array} [ [ Left ] , [ Top ], [ Right ], [ Bottom ] ]
 */
CanvasUtil.getMaxBounds = function(coordinates) {

	var boundLeft = boundTopRight = boundRight = boundBottom = 0;

	if (!coordinates || coordinates.length == 0) {
		return [ boundLeft, boundTopRight, boundRight, boundBottom ];
	}

	var coordinate = coordinates[0];
	boundLeft = boundRight = coordinate[0];
	boundTopRight = boundBottom = coordinate[1];

	for (i in coordinates) {
		coordinate = coordinates[i];

		// Left
		if (coordinate[0] < boundLeft) {
			boundLeft = coordinate[0];
		}
		// Top
		if (coordinate[1] < boundTopRight) {
			boundTopRight = coordinate[1];
		}
		// Right
		if (coordinate[0] > boundRight) {
			boundRight = coordinate[0];
		}
		// Bottom
		if (coordinate[1] > boundBottom) {
			boundBottom = coordinate[1];
		}

	}

	return [ boundLeft, boundTopRight, boundRight, boundBottom ];

};

/**
 * @param {array}
 *            coordinates
 * @return {array} [ [ Topleft ] , [ Topright ], [ Bottomright ], [ Bottomleft ] ]
 */
CanvasUtil.getOuterBounds = function(coordinates) {
	
	var boundLeft = boundTop = boundRight = boundBottom = [ 0, 0 ];

	if (!coordinates || coordinates.length == 0) {
		return [ boundLeft, boundTop, boundRight, boundBottom ];
	}

	var coordinate = coordinates[0];
	boundLeft = boundRight = boundTop = boundBottom = coordinate;

	for (i in coordinates) {
		coordinate = coordinates[i];

		// Left
		if (coordinate[0] < boundLeft[0]) {
			boundLeft = coordinate;
		}
		// Top
		if (coordinate[1] < boundTop[1]) {
			boundTop = coordinate;
		}
		// Right
		if (coordinate[0] > boundRight[0]) {
			boundRight = coordinate;
		}
		// Bottom
		if (coordinate[1] > boundBottom[1]) {
			boundBottom = coordinate;
		}

	}

	return [ boundLeft, boundTop, boundRight, boundBottom ];
	
};