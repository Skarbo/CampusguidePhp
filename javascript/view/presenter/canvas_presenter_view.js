// CONSTRUCTOR
CanvasPresenterView.prototype = new AbstractPresenterView();

function CanvasPresenterView(view) {
	AbstractPresenterView.apply(this, arguments);

	this.stage = null;

	this.bound = {
		height : 0,
		width : 0
	};
	this.bounds = [];

	this.layers = {};
	this.groups = {};
	this.elements = {};

	this.mode = CanvasPresenterView.MODE_SHOW;
	this.levelSelected = null;
	this.levelAnimate = false;
};

// VARIABLES

CanvasPresenterView.SCALE_SIZE = 0.05;

CanvasPresenterView.MODE_SHOW = "show";
CanvasPresenterView.MODE_EDIT = "edit";

CanvasPresenterView.Z_INDEX_BOUND = 0;

CanvasPresenterView.LOCAL_VARIABLE_STAGE_SETTINGS = "stageSettings";

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {Object}
 */
CanvasPresenterView.prototype.getCanvasContentElement = function() {
	throw new Error("Get canvas content element must be overwritten");
};

CanvasPresenterView.prototype.getStageSettingsLocalVariable = function() {
	return CanvasPresenterView.LOCAL_VARIABLE_STAGE_SETTINGS;
};

CanvasPresenterView.prototype.getStageSettings = function() {
	var settings = this.getController().getLocalStorageVariable(this.getStageSettingsLocalVariable());
	if (typeof JSON == "object" && settings)
		return JSON.parse(settings);
	return {};
};

/**
 * @param levelFrom
 * @param levelTo
 * @returns {Number} 1 if direction is down, -1 up
 */
CanvasPresenterView.prototype.getLevelSwitchDirection = function(levelFrom, levelTo) {
	return 1;
};

// ... ... KINETIC

/**
 * @returns {Kinetic.Layer}
 */
CanvasPresenterView.prototype.getLayer = function(type, levelId) {
	if (!this.layers[type])
		return null;
	return this.layers[type][levelId];
};

/**
 * @returns {Kinetic.Layer}
 */
CanvasPresenterView.prototype.getLayers = function(type) {
	return this.layers[type];
};

/**
 * @param levelId
 * @returns {Object}
 */
CanvasPresenterView.prototype.getLayersAtLevel = function(levelId) {
	var layersForLevel = {};
	for ( var type in this.layers) {
		if (this.layers[type][levelId])
			layersForLevel[type] = this.layers[type][levelId];
	}
	return layersForLevel;
};

/**
 * @returns {Kinetic.Group}
 */
CanvasPresenterView.prototype.getGroup = function(type, levelId) {
	if (!this.groups[type])
		return null;
	return this.groups[type][levelId];
};

/**
 * @returns {Kinetic.Group}
 */
CanvasPresenterView.prototype.getGroups = function(type) {
	return this.groups[type];
};

/**
 * @returns {Kinetic.Group}
 */
CanvasPresenterView.prototype.getElements = function(type, levelId) {
	if (!this.elements[type])
		return null;
	return this.elements[type][levelId];
};

/**
 * @param levelId
 * @returns {Object}
 */
CanvasPresenterView.prototype.getElementsAtLevel = function(levelId) {
	var elementsForLevel = {};
	for ( var type in this.elements) {
		if (this.elements[type][levelId])
			elementsForLevel[type] = this.elements[type][levelId];
	}
	return elementsForLevel;
};

// ... ... /KINETIC

// ... /GET

// ... SET

// ... ... KINETIC

CanvasPresenterView.prototype.setLayer = function(type, levelId, layer) {
	if (!this.layers[type])
		this.layers[type] = {};
	this.layers[type][levelId] = layer;
};

CanvasPresenterView.prototype.setGroup = function(type, levelId, group) {
	if (!this.groups[type])
		this.groups[type] = {};
	this.groups[type][levelId] = group;
};

CanvasPresenterView.prototype.setElements = function(type, levelId, elements) {
	if (!this.elements[type])
		this.elements[type] = {};
	this.elements[type][levelId] = elements;
};

CanvasPresenterView.prototype.setBound = function(container, width, height) {
	if (!container)
		return console.error("CanvasPresenterView.setBound: Container is null", container, width, height);

	this.bound = {
		height : this.bound.height < height ? height : this.bound.height,
		width : this.bound.width < width ? width : this.bound.width
	};

	var rectBound = container.get(".rectBound");
	rectBound = rectBound.length > 0 ? rectBound[0] : null;

	if (!rectBound) {
		rectBound = new Kinetic.Rect({
			name : "rectBound",
			forContainer : container.attrs.name,
			x : 0,
			y : 0,
			width : this.bound.width,
			height : this.bound.height
		});
		container.add(rectBound);
		this.bounds.push(rectBound);
	}

	for ( var i in this.bounds) {
		this.bounds[i].setSize(this.bound.width, this.bound.height);
		this.bounds[i].moveToBottom();
	}
};

// ... ... /KINETIC

CanvasPresenterView.prototype.setStageSettings = function() {
	if (typeof JSON == "object") {
		var settings = {
			position : this.stage.getPosition(),
			scale : this.stage.getScale(),
			offset : this.stage.getOffset()
		};
		this.getController().setLocalStorageVariable(this.getStageSettingsLocalVariable(), JSON.stringify(settings));
	}
};

// ... /SET

// ... CREATE

/**
 * @return {Kineticj.Rect}
 */
CanvasPresenterView.prototype.createBoundRect = function(container, width, height) {
	this.bound = {
		height : this.bound.height < height ? height : this.bound.height,
		width : this.bound.width < width ? width : this.bound.width
	};

	var roundRect = container.get(".rectBound");
	rectBound = rectBound.length > 0 ? rectBound[0] : null;

	if (!roundRect) {
		roundRect = new Kinetic.Rect({
			"name" : "rectBound",
			"x" : 0,
			"y" : 0,
			"width" : this.bound.width,
			"height" : this.bound.height
		});
		container.add(roundRect);
		this.roundRects.push(roundRect);
	}

	return roundRect;
};

// ... /CREATE

// ... DO

CanvasPresenterView.prototype.doBindEventHandler = function() {
	AbstractPresenterView.prototype.doBindEventHandler.call(this);
	var context = this;

	// EVENTS

	// ... CANVAS

	// Scale event
	this.getView().getController().getEventHandler().registerListener(ScaleEvent.TYPE,
	/**
	 * @param {ScaleEvent}
	 *            event
	 */

	function(event) {
		context.handleScale(event);
	});

	// Fit to scale event
	this.getEventHandler().registerListener(FitToScaleEvent.TYPE,
	/**
	 * @param {FitToScaleEvent}
	 *            event
	 */

	function(event) {
		context.doFitToStage();
	});

	// ... /CANVAS

	// /EVENTS

	// CANVAS

	this.getCanvasContentElement().bind("contextmenu", function(e) {
		return false;
	});

	// ... MOUSE SCROLL

	// Get wrapper dom
	var canvasWrapper = document.getElementById(this.getCanvasContentElement().attr("id"));

	// Adding the event listerner for Mozilla
	if (window.addEventListener)
		canvasWrapper.addEventListener('DOMMouseScroll', function(event) {
			event.preventDefault();
			context.handleScroll(event);
		}, false);

	// for IE/OPERA etc
	canvasWrapper.onmousewheel = function(event) {
		event.preventDefault();
		context.handleScroll(event);
	};

	// ... /MOUSE SCROLL

	// /CANVAS

};

CanvasPresenterView.prototype.doLevelSelect = function(levelId) {
	if (!levelId)
		return console.error("CanvasPresenterView.doLevelSelect: Level id is null", levelId);

	if (this.levelAnimate) {
		var layersCurrent = this.getLayersAtLevel(this.levelSelected);
		var layersSelect = this.getLayersAtLevel(levelId);
		var switchDirection = this.getLevelSwitchDirection(this.levelSelected, levelId);
		var duration = 1;

		for ( var type in layersCurrent) {
			var layer = layersCurrent[type];
			// layer.transitionTo({
			// y : 100 * switchDirection,
			// duration : duration,
			// easing : 'strong-ease-out',
			// layer : layer,
			// opacity : 0,
			// callback : function() {
			// this.hide();
			// this.setY(0);
			// }
			// });

			var tween = new Kinetic.Tween({
				node : layer,
				duration : duration,
				y : 100 * switchDirection,
				opacity : 0,
				easing : Kinetic.Easings.StrongEaseOut,
				onFinish : function() {
					// console.log("On finish", this, event);
					this.node.hide();
					this.node.setY(0);
				}

			// y : 100 * switchDirection,
			// duration : duration,
			// easing : 'strong-ease-out',
			// opacity : 0,
			// onFinish : function() {
			// console.log("On finish", this, event);
			// // this.hide();
			// // this.setY(0);
			// }

			// node: rect,
			// duration: 1,
			// x: 400,
			// y: 30,
			// rotation: Math.PI * 2,
			// opacity: 1,
			// strokeWidth: 6,
			// scaleX: 1.5
			});
			tween.play();
		}

		for ( var type in layersSelect) {
			var layer = layersSelect[type];
			// layer.setY(-100 * switchDirection);
			// layer.show();
			// layer.setOpacity(0);
			// layer.transitionTo({
			// y : 0,
			// duration : duration,
			// easing : 'strong-ease-out',
			// layer : layer,
			// opacity : 1,
			// callback : function(event) {
			// this.setY(0);
			// }
			// });

			var tween = new Kinetic.Tween({
				node : layer,
				y : 0,
				duration : duration,
				easing : Kinetic.Easings.StrongEaseOut,
				opacity : 1,
				onFinish : function(event) {
					// console.log("On finish", this, event);
					this.node.setY(0);
				}

			// node : layer,
			// y : 0,
			// duration : duration,
			// easing : 'strong-ease-out',
			// opacity : 1,
			// onFinish : function(event) {
			// console.log("On finish", this, event);
			// //this.setY(0);
			// }
			});
			tween.play();
		}
	} else {
		// Show/hide layers
		for ( var type in this.layers) {
			for (id in this.layers[type]) {
				if (id == levelId) {
					this.layers[type][id].show();
				} else {
					this.layers[type][id].hide();
				}
				// if (this.layers[type][id].attrs.zindex) {
				// this.layers[type][id].setZIndex(this.layers[type][id].attrs.zindex);
				// }
			}
		}
	}

	this.levelSelected = levelId;
	this.stage.draw();

	var stageSettings = this.getStageSettings();
	if (!stageSettings || Core.countObject(stageSettings) == 0)
		this.doFitToStage();
};

// ... ... STAGE

CanvasPresenterView.prototype.doFitToStage = function(type, coordinates) {
	coordinates = coordinates || [];

	if (!this.levelSelected)
		return console.error("CanvasPresenterView.doFitToStage: Level is not selected");

	// COORDINATES

	if (coordinates.length == 0) {
		// Get Elements
		var elements = {};
		if (type) {
			elements[this.levelSelected] = this.getElements(type, this.levelSelected);
		} else {
			elements = this.getElementsAtLevel(this.levelSelected);
		}

		// Foreach Elements
		var element = null, children = [];
		for ( var levelId in elements) {
			element = elements[levelId];
			children = element.getChildren();
			// Foreach element children
			for ( var i = 0; i < children.length; i++) {
				console.log(children[i], typeof children[i]);
				coordinates = coordinates.concat(children[i].getCoordinates());
			}
		}

		// No coordinates, fit to bound
		if (coordinates.length == 0) {
			coordinates.push([ 0, 0 ]);
			coordinates.push([ 0, this.bound.y ]);
			coordinates.push([ this.bound.x, 0 ]);
			coordinates.push([ this.bound.x, this.bound.y ]);
		}
	}

	// /COORDINATES

	var positionNew = this.stage.getPosition();
	var scaleNew = this.stage.getScale().x;

	// Fit to coordinates
	var coordinatesMaxBounds = CanvasUtil.getMaxBounds(coordinates);
	var boundX = coordinatesMaxBounds[2] - coordinatesMaxBounds[0], boundY = coordinatesMaxBounds[3] - coordinatesMaxBounds[1];

	var stageX = this.stage.getWidth(), stageY = this.stage.getHeight();
	scaleNew = Core.roundNumber(Core.closestNumber(Math.min(stageX / boundX, stageY / boundY), CanvasPresenterView.SCALE_SIZE), 4);
	scaleNew -= CanvasPresenterView.SCALE_SIZE;
	var boundsNewX = boundX * scaleNew, boundsNewY = boundY * scaleNew;

	positionNew.x = ((stageX - boundsNewX) / 2) - (coordinatesMaxBounds[0] * scaleNew);
	positionNew.y = ((stageY - boundsNewY) / 2) - (coordinatesMaxBounds[1] * scaleNew);

	// Set stage settings
	this.stage.setOffset(0, 0);
	this.stage.setScale(scaleNew);
	this.stage.setPosition(positionNew);
	this.setStageSettings();
	this.stage.draw();

	return;
	if (polygons.length > 0) {
		var coordinates = [];
		for (i in polygons) {
			coordinates = coordinates.concat(polygons[i].getCoordinates());
		}

		var coordinatesMaxBounds = CanvasUtil.getMaxBounds(coordinates);
		var boundX = coordinatesMaxBounds[2] - coordinatesMaxBounds[0], boundY = coordinatesMaxBounds[3] - coordinatesMaxBounds[1];

		var stageX = this.stage.getWidth(), stageY = this.stage.getHeight();
		scaleNew = Core.roundNumber(Math.min(stageX / boundX, stageY / boundY), 4);
		var boundsNewX = boundX * scaleNew, boundsNewY = boundY * scaleNew;

		positionNew.x = ((stageX - boundsNewX) / 2) - (coordinatesMaxBounds[0] * scaleNew);
		positionNew.y = ((stageY - boundsNewY) / 2) - (coordinatesMaxBounds[1] * scaleNew);
	} else if (false) {
		// TODO Fit to scale floors map
		var layer = this.getLayer("floors_map", this.floorSelected);

		if (layer.height && layer.width) {
			var boundX = layer.width, boundY = layer.height;
			var stageX = this.stage.getWidth(), stageY = this.stage.getHeight();
			scaleNew = parseFloat((Math.floor(parseFloat(Math.min(stageX / boundX, stageY / boundY).toFixed(2)) * 20) / 20).toFixed(2));
			var boundsNewX = boundX * scaleNew, boundsNewY = boundY * scaleNew;

			positionNew.x = (stageX - boundsNewX) / 2;
			positionNew.y = (stageY - boundsNewY) / 2;
		}
	}
	// this.setStageScale(scaleNew);
	// this.setStagePosition(positionNew);
	// this.stage.setScale(this.stageScale);
	// this.stage.setX(this.stagePosition.x);
	// this.stage.setY(this.stagePosition.y);
	this.setStageSettings();
	this.stage.draw();

};

CanvasPresenterView.prototype.doPanStageTo = function(centerPoint) {
	// var viewport = KineticjsUtil.getViewport(this.stage);
	// var centerRelative = KineticjsUtil.getPointRelative(this.stage,
	// viewport.center);
	// console.log("CanvasPresenterView.doPanStageTo", centerPoint, viewport);
	// this.stage.setOffset(0, 0);
	// this.stage.setPosition({ x : centerRelative.x, y : centerRelative.y });
	// this.stage.draw();
};

CanvasPresenterView.prototype.doStageScale = function(scaleUp, isAnimate) {
	isAnimate = isAnimate || false;
	var userPosition = this.stage.getPointerPosition();
	if (!userPosition)
		userPosition = {
			x : this.stage.getWidth() / 2,
			y : this.stage.getHeight() / 2
		};
	var position = this.stage.getPosition();

	var scale = this.stage.getScale().x;
	var mx = userPosition.x - position.x, my = userPosition.y - position.y;
	var zoom = (1.1 - (!scaleUp ? 0.2 : 0));
	var newscale = scale * zoom;
	var offset = this.stage.getOffset();
	var origin = {
		x : offset.x,
		y : offset.y
	};
	var newOffset = {
		x : mx / scale + origin.x - mx / newscale,
		y : my / scale + origin.y - my / newscale
	};

	if (!isAnimate) {
		this.stage.setOffset(newOffset);
		this.stage.setScale(newscale);
		this.stage.draw();
		this.setStageSettings();
	} else {
//		this.stage.transitionTo({
//			scale : {
//				x : newscale,
//				y : newscale
//			},
//			offset : newOffset,
//			duration : 0.2
//		});

		var tween = new Kinetic.Tween({
			node : this.stage,
			scale : {
				x : newscale,
				y : newscale
			},
			offset : newOffset,
			duration : 0.2
		});
		tween.play();
	}

};

// ... ... /STAGE

// ... /DO

// ... HANDLE

/**
 * @param {ScaleCanvasEvent}
 *            event
 */
CanvasPresenterView.prototype.handleScale = function(event) {
	this.doStageScale(event.isScaleUp(), event.isAnimate());
	var scale = this.stage.getScale();
	this.getEventHandler().handle(new ScaledEvent(scale.x));
};

CanvasPresenterView.prototype.handleScroll = function(event) {
	var delta = 0;

	if (!event)
		event = window.event;

	// normalize the delta
	if (event.wheelDelta) {
		// IE and Opera
		delta = event.wheelDelta / 60;
	} else if (event.detail) {
		// W3C
		delta = -event.detail / 2;
	}

	// Send Scale event
	if (delta != 0) {
		this.getEventHandler().handle(new ScaleEvent(delta > 0));
	}
};

// ... /HANDLE

// ... DRAW

CanvasPresenterView.prototype.draw = function(root) {
	if (root.length == 0)
		throw new Error("CanvasPresenterView.draw: Root is empty (" + root.selector + ")");
	AbstractPresenterView.prototype.draw.call(this, root);
	var context = this;

	// STAGE

	// Initiate Kinetic Stage
	var canvas = this.getCanvasContentElement();
	this.stage = new Kinetic.Stage({
		container : canvas.attr("id"),
		width : canvas.parent().width(),
		height : canvas.parent().height(),
		clearBeforeDraw : true,
		x : 0,
		y : 0,
		draggable : true
	});

	this.stage.resize = function() {
		this.setSize(0, 0);
		this.setSize(canvas.parent().width(), canvas.parent().height());
		this.draw();
	};

	// Settings
	var stageSettings = this.getStageSettings();
	if (stageSettings.position)
		this.stage.setPosition(stageSettings.position);
	if (stageSettings.scale)
		this.stage.setScale(stageSettings.scale);
	if (stageSettings.offset)
		this.stage.setOffset(stageSettings.offset);

	this.bound.height = this.stage.getHeight();
	this.bound.width = this.stage.getWidth();

	// /STAGE

	// ON

	this.stage.on("dragend", function(event) {
		context.setStageSettings();
	});

	// this.stage.on("click", function(event) {
	// //var relPoint = KineticjsUtil.getPointRelative(this,
	// this.getPointerPosition());
	// //context.doPanStageTo(relPoint);
	// });

	// /ON

	this.stage.draw();

};

// ... /DRAW

// /FUNCTIONS
