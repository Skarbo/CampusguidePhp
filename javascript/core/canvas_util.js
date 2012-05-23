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

	var boundLeft = boundTop = boundRight = boundBottom = 0;

	if (!coordinates || coordinates.length == 0) {
		return [ boundLeft, boundTop, boundRight, boundBottom ];
	}

	var coordinate = coordinates[0];
	boundLeft = boundRight = coordinate[0];
	boundTop = boundBottom = coordinate[1];

	for (i in coordinates) {
		coordinate = coordinates[i];

		// Left
		if (coordinate[0] < boundLeft) {
			boundLeft = coordinate[0];
		}
		// Top
		if (coordinate[1] < boundTop) {
			boundTop = coordinate[1];
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

	return [ boundLeft, boundTop, boundRight, boundBottom ];

};