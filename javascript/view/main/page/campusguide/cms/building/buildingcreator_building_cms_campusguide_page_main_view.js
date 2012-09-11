// CONSTRUCTOR
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype = new PageMainView();

function BuildingcreatorBuildingCmsCampusguidePageMainView(view) {
	PageMainView.apply(this, arguments);
	this.stage = null;
	this.layers = {
		building : null,
		floors : {},
		floors_map : {},
		elements : {}
	};
	this.groups = {
		floors : {},
		floors_map : {},
		elements : {}
	};
	this.polygons = {
		floors : {},
		elements : {}
	};
	this.building = null;
	this.floors = null;
	this.floorSelected = false;
	this.floorMapShow = true;
	this.stageIsDragging = false;
	this.polygonsIsDraggable = false;
	this.selected = {
		type : null,
		element : null
	};
	this.scale = 1.0;
	this.stagePosition = {
		x : 0,
		y : 0
	};
	this.menu = null;
	this.toolbar = null;
	this.retrieved = 0;
};

// /CONSTRUCTOR

// VARIABLES

BuildingcreatorBuildingCmsCampusguidePageMainView.SCALE_SIZE = 0.05;

BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_STRAIGHT = "straight";
BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_QUAD = "quad";
BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_BEZIER = "bezier";

// /VARIABLES

// CLASS

var Polygon, PolygonShape, PolygonAnchor, PolygonAnchorControl, PolygonAnchorPoint, PolygonAnchorHandle;
$(function() {

	PolygonAnchorHandle = Kinetic.Circle.extend({
		init : function(config) {
			config = config || {};
			this._super($.extend({
				name : "anchor_handle",
				x : 0,
				y : 0,
				radius : 8,
				stroke : "#AAA",
				strokeWidth : 2,
				draggable : true
			}, config));

			this.on("dragstart", function(event) {
				this.moveToTop();
			});
			this.on("dragend", function(event) {
				this.moveToTop();
			});
			this.on("mouseover", function() {
				$("body").css("cursor", "pointer");
				this.setStrokeWidth(4);
				this.getLayer().draw();
			});
			this.on("mouseout", function() {
				$("body").css("cursor", "default");
				this.setStrokeWidth(2);
				this.getLayer().draw();
			});
		}
	});

	PolygonAnchorControl = Kinetic.Group.extend({
		init : function(config, anchor) {
			config = config || {};
			this._super($.extend({
				name : "anchor_control",
				visible : false
			}, config));
			this.anchor = anchor;

			this.handleFirst = new PolygonAnchorHandle();
			this.handleSecond = new PolygonAnchorHandle();
			this.line = new Kinetic.Line({
				name : "control_line",
				dashArray : [ 10, 10, 0, 10 ],
				strokeWidth : 3,
				stroke : "black",
				lineCap : "round",
				opacity : 0.3,
				points : [ this.anchor.attrs.x, this.anchor.attrs.y ],
				listening : false
			});
			this.line.control = this;

			this.line.setDrawFunc(function(context) {
				context.beginPath();

				if (this.control.anchor.prev && this.control.anchor.type != BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_LINE) {
					context.moveTo(this.control.anchor.prev.attrs.x, this.control.anchor.prev.attrs.y);

					switch (this.control.anchor.type) {
					case BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_QUAD:
						context.lineTo(this.control.handleFirst.attrs.x, this.control.handleFirst.attrs.y);
						break;

					case BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_BEZIER:
						context.lineTo(this.control.handleFirst.attrs.x, this.control.handleFirst.attrs.y);
						context.lineTo(this.control.handleSecond.attrs.x, this.control.handleSecond.attrs.y);
						break;
					}

					context.lineTo(this.control.anchor.attrs.x, this.control.anchor.attrs.y);
				}

				context.lineCap = "round";
				this.stroke(context);
			});

			this.isPositioned = false;

			this.add(this.handleFirst);
			this.add(this.handleSecond);
			this.add(this.line);
		},
		select : function() {
			if (!this.anchor.prev)
				return this.hide();

			if (!this.isPositioned)
				this.positionControl();

			switch (this.anchor.type) {
			case BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_QUAD:
				this.show();
				this.handleFirst.show();
				this.handleSecond.hide();
				this.line.show();
				this.moveToTop();
				break;

			case BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_BEZIER:
				this.show();
				this.handleFirst.show();
				this.handleSecond.show();
				this.line.show();
				this.moveToTop();
				break;

			default:
				this.hide();
				break;
			}
		},
		deselect : function() {
			this.hide();
		},
		positionControl : function() {
			if (!this.anchor.prev)
				return;

			var coor = {
				x : (this.anchor.attrs.x + this.anchor.prev.attrs.x) / 2,
				y : (this.anchor.attrs.y + this.anchor.prev.attrs.y) / 2
			};
			this.handleFirst.setX((this.anchor.prev.attrs.x + coor.x) / 2);
			this.handleFirst.setY((this.anchor.prev.attrs.y + coor.y) / 2);
			this.handleSecond.setX((this.anchor.attrs.x + coor.x) / 2);
			this.handleSecond.setY((this.anchor.attrs.y + coor.y) / 2);

			this.line.setPoints([ this.anchor.attrs.x, this.anchor.attrs.y, this.handleFirst.attrs.x, this.handleFirst.attrs.y, this.handleSecond.attrs.x,
					this.handleSecond.attrs.y, this.anchor.prev.attrs.x, this.anchor.prev.attrs.y ]);

			this.isPositioned = true;
		},
		removeControl : function() {
			this.getParent().remove(this);
		},
		toData : function() {
			var data = [];

			switch (this.anchor.type) {
			case BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_QUAD:
				data.push(this.anchor.control.handleFirst.attrs.x.toFixed(1));
				data.push(this.anchor.control.handleFirst.attrs.y.toFixed(1));
				break;
			case BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_BEZIER:
				data.push(this.anchor.control.handleFirst.attrs.x.toFixed(1));
				data.push(this.anchor.control.handleFirst.attrs.y.toFixed(1));
				data.push(this.anchor.control.handleSecond.attrs.x.toFixed(1));
				data.push(this.anchor.control.handleSecond.attrs.y.toFixed(1));
				break;
			}

			return data.join("%");
		},
		fromData : function(data) {
			data = data || [];
			var dataArray = jQuery.isArray(data) ? data : data.split("%");

			this.positionControl();

			switch (this.anchor.type) {
			case BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_QUAD:
				this.handleFirst.setX(parseFloat(dataArray[0]));
				this.handleFirst.setY(parseFloat(dataArray[1]));
				break;

			case BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_BEZIER:
				this.handleFirst.setX(parseFloat(dataArray[0]));
				this.handleFirst.setY(parseFloat(dataArray[1]));
				this.handleSecond.setX(parseFloat(dataArray[2]));
				this.handleSecond.setY(parseFloat(dataArray[3]));
				break;

			default:
				this.type = BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_STRAIGHT;
				break;
			}
		}
	});

	PolygonAnchor = PolygonAnchorHandle.extend({
		init : function(config) {
			config = config || {};
			this._super($.extend({
				name : "anchor",
				stroke : "#666"
			}, config));

			this.type = BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_STRAIGHT;
			this.next = null;
			this.prev = null;
			this.polygon = null;
			this.control = null;
			this.isSelected = false;

			this.on("click", function(event) {
				event.cancelBubble = true;
				if (!this.polygon.isCreating) {
					if (event.which == 1)
						this.polygon.context.getEventHandler().handle(new SelectEvent("polygon_anchor", this));
					else if (event.which == 3 && this.isSelected) {
						this.polygon.context.getEventHandler().handle(new SelectEvent());
						this.polygon.removeAnchor(this);
					}
				}
			});
			this.on("dblclick", function(event) {
				event.cancelBubble = true;
				if (!this.polygon.isCreating) {
					if (event.which == 1)
						this.polygon.createPolygon(null, this);
				}
			});
		},
		removeAnchor : function() {
			if (this.next && this.prev) {
				this.prev.next = this.next;
				this.next.prev = this.prev;
			} else if (this.prev) {
				this.prev.next = null;
			} else if (this.next) {
				this.next.prev = null;
			}
			if (this.control)
				this.control.removeControl();
			this.getParent().remove(this);
		},
		select : function(secondary) {
			this.setStroke("#FF0000");
			this.control.select();
			this.isSelected = true;
		},
		deselect : function() {
			this.setStroke("#666");
			this.control.deselect();
			this.isSelected = false;
		},
		erase : function() {
			this.polygon.removeAnchor(this);
		},
		toData : function() {
			var data = [];

			data.push(this.attrs.x.toFixed(1));
			data.push(this.attrs.y.toFixed(1));

			switch (this.type) {
			case BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_QUAD:
				data.push("Q");
				break;
			case BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_BEZIER:
				data.push("B");
				break;

			default:
				data.push("L");
				break;
			}

			data.push(this.control.toData());

			return data.join(",");
		},
		fromData : function(data) {
			data = data || [];
			var dataArray = jQuery.isArray(data) ? data : data.split(",");

			this.setX(parseFloat(dataArray[0]));
			this.setY(parseFloat(dataArray[1]));

			switch (dataArray[2]) {
			case "Q":
				this.type = BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_QUAD;
				break;

			case "B":
				this.type = BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_BEZIER;
				break;

			default:
				this.type = BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_STRAIGHT;
				break;
			}

			this.control.fromData(dataArray.length >= 3 ? dataArray[3] : "");
		},
		getCoordinates : function() {
			var coordinates = [];

			coordinates.push([ this.attrs.x, this.attrs.y ]);

			switch (this.type) {
			case BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_QUAD:
				coordinates.push([ this.control.handleFirst.attrs.x, this.control.handleFirst.attrs.y ]);
				break;

			case BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_BEZIER:
				coordinates.push([ this.control.handleFirst.attrs.x, this.control.handleFirst.attrs.y ]);
				coordinates.push([ this.control.handleSecond.attrs.x, this.control.handleSecond.attrs.y ]);
				break;
			}
			return coordinates;
		}
	});

	PolygonShape = Kinetic.Shape.extend({
		init : function(config, polygon) {
			config = config || {};
			this._super($.extend({
				name : "shape",
				stroke : "red",
				strokeWidth : 4,
				lineJoin : "round",
				fill : "#999",
				opacity : 0.7
			}, config));

			this.polygon = polygon;
			this.isSelected = false;

			this.setDrawFunc(function(context) {
				var shape = this;
				context.beginPath();

				if (this.polygon.anchorFirst) {
					context.moveTo(this.polygon.anchorFirst.attrs.x, this.polygon.anchorFirst.attrs.y);

					this.polygon.eachAnchor(function(anchor) {
						shape.drawLineFunc(context, anchor);
					});

					this.drawLineFunc(context, this.polygon.anchorFirst);
				}

				// context.closePath();
				context.lineCap = "round";
				this.fill(context);
				this.stroke(context);
			});
			this.drawLineFunc = function(context, anchor) {
				switch (anchor.type) {
				case BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_QUAD:
					context.quadraticCurveTo(anchor.control.handleFirst.attrs.x, anchor.control.handleFirst.attrs.y, anchor.attrs.x, anchor.attrs.y);
					break;

				case BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_BEZIER:
					context.bezierCurveTo(anchor.control.handleFirst.attrs.x, anchor.control.handleFirst.attrs.y, anchor.control.handleSecond.attrs.x,
							anchor.control.handleSecond.attrs.y, anchor.attrs.x, anchor.attrs.y);
					break;

				default:
					context.lineTo(anchor.attrs.x, anchor.attrs.y);
					break;
				}
			};

			this.on("click", function(event) {
				event.cancelBubble = true;
				if (!this.polygon.isCreating) {
					if (event.which == 1)
						this.polygon.context.getEventHandler().handle(new SelectEvent("polygon_shape", this));
					else if (event.which == 3 && this.isSelected)
						this.polygon.context.getEventHandler().handle(new DeleteEvent());
				}
			});
		},
		select : function(secondary) {
			this.setShadow({
				color : 'black',
				blur : 10,
				offset : [ 10, 10 ],
				alpha : 0.3
			});
			this.isSelected = true;
		},
		deselect : function() {
			this.setShadow(null);
			this.isSelected = false;
		},
		erase : function() {
			this.polygon.deletePolygon();
		}
	});

	Polygon = Kinetic.Group.extend({
		init : function(config, context) {
			config = config || {};
			this._super($.extend({
				name : "polygon"
			}, config));
			this.context = context;

			this.shape = new PolygonShape({}, this);

			this.anchors = new Kinetic.Group({
				name : "anchors"
			});
			this.controls = new Kinetic.Group({
				name : "controls"
			});

			this.anchorFirst = null;
			this.anchorLast = null;
			this.anchorDraw = null;
			this.isCreating = false;

			this.add(this.shape);
			this.add(this.anchors);
			this.add(this.controls);

			// this.on("mouseover", function() {
			// this.setDraggable(this.context.polygonsIsDraggable);
			// if (this.context.polygonsIsDraggable && $("body").css("cursor")
			// != "pointer")
			// $("body").css("cursor", "pointer");
			// });
			// this.on("mouseout", function() {
			// this.setDraggable(false);
			// if ($("body").css("cursor") != "default")
			// $("body").css("cursor", "default");
			// });
		},
		addAnchor : function(anchor) {
			if (!anchor)
				return;
			if (!this.anchorFirst) {
				this.anchorFirst = anchor;
				this.anchorLast = anchor;
			} else {
				anchor.prev = this.anchorLast;
				this.anchorLast.next = anchor;
				this.anchorLast = anchor;
				anchor.next = this.anchorFirst;
				this.anchorFirst.prev = anchor;
			}
			this.anchors.add(anchor);
			anchor.polygon = this;

			anchor.control = new PolygonAnchorControl({}, anchor);
			this.controls.add(anchor.control);
		},
		addAnchorAfter : function(anchor, anchorAfter) {
			if (!anchor)
				return;
			if (!anchorAfter || anchorAfter._id == this.anchorLast._id) {
				this.addAnchor(anchor);
				return;
			}
			if (anchorAfter.next) {
				anchorAfter.next.prev = anchor;
			}
			anchor.next = anchorAfter.next;
			anchor.prev = anchorAfter;
			anchorAfter.next = anchor;

			this.anchors.add(anchor);
			anchor.polygon = this;

			anchor.control = new PolygonAnchorControl({}, anchor);
			this.controls.add(anchor.control);
		},
		deletePolygon : function() {
			this.getParent().remove(this);
			delete this;
		},
		removeAnchor : function(anchor) {
			if (this.anchors.isAncestorOf(anchor)) {
				if (this.anchorFirst._id == anchor._id)
					this.anchorFirst = anchor.next;
				if (this.anchorLast._id == anchor._id)
					this.anchorLast = anchor.prev;
				anchor.removeAnchor();

				if (this.anchors.getChildren().length <= 1)
					this.deletePolygon();
			}
		},
		eachAnchor : function(callback) {
			if (!this.anchorFirst)
				return false;

			var anchor = this.anchorFirst;
			do {
				callback(anchor);
				anchor = anchor.next;
			} while (anchor && anchor._id != this.anchorFirst._id);
		},
		createPolygon : function(event, anchorResume) {
			var namespace = "mousemove.draw_polygon mouseup.draw_polygon";
			var positionUser = this.getStage().getUserPosition();
			var position = positionUser ? {
				x : (positionUser.x - this.getStage().attrs.x) / this.getStage().attrs.scale.x,
				y : (positionUser.y - this.getStage().attrs.y) / this.getStage().attrs.scale.y
			} : {
				x : 0,
				y : 0
			};

			// New anchor
			if (!event) {
				var context = this;
				this.isCreating = true;

				// Create anchor
				this.anchorDraw = new PolygonAnchor({
					x : position.x,
					y : position.y
				});
				if (anchorResume) {
					this.addAnchorAfter(this.anchorDraw, anchorResume);
				} else {
					this.addAnchor(this.anchorDraw);
					this.anchorDraw.hide();
				}

				// Bind events
				this.getLayer().off(namespace);
				this.getLayer().on(namespace, function(event) {
					context.createPolygon(event, anchorResume);
				});
			} else if (positionUser) {
				event.cancelBubble = true;

				// Move anchor
				if (event.type == "mousemove" && this.anchorDraw) {
					this.anchorDraw.show();
					this.anchorDraw.setX(position.x);
					this.anchorDraw.setY(position.y);

					this.getLayer().draw();
				}
				// Place anchor
				else if (event.type == "mouseup") {
					if (this.getStage().isDragging())
						return;

					// Cancel placing
					if (event.which == 3) {
						event.preventDefault();
						this.removeAnchor(this.anchorDraw);
						this.getLayer().off(namespace);
						this.anchorDraw = null;
						delete this.anchorDraw;
						this.isCreating = false;
						anchorResume = null;
						this.getLayer().draw();
						return;
					}

					// Create anchor
					anchorResume = this.anchorDraw;
					this.anchorDraw = new PolygonAnchor({
						x : position.x,
						y : position.y
					});
					if (anchorResume) {
						this.addAnchorAfter(this.anchorDraw, anchorResume);
					} else {
						this.addAnchor(this.anchorDraw);
					}
				}
			}
		},
		toData : function() {
			var data = [];
			this.eachAnchor(function(anchor) {
				data.push(anchor.toData());
			});
			return data.join("|");
		},
		fromData : function(data) {
			data = data || [];
			var dataAnchor = jQuery.isArray(data) ? data : data.split("|"), anchor;
			for (i in dataAnchor) {
				anchor = new PolygonAnchor();
				this.addAnchor(anchor);
				anchor.fromData(dataAnchor[i]);
			}
		},
		getCoordinates : function() {
			var coordinates = [];
			this.eachAnchor(function(anchor) {
				coordinates = coordinates.concat(anchor.getCoordinates());
			});
			return coordinates;
		}
	});

});

// /CLASS

// FUNCTIONS

// ... GET

/**
 * @return {BuildingsCmsCampusguideMainView}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getView = function() {
	return PageMainView.prototype.getView.call(this);
};

// ... ... SIDEBAR

/**
 * @return {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getSidebarElement = function() {
	return this.getRoot().find("#buildingcreator_planner_sidebar_wrapper .sidebar");
};

/**
 * @return {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getSidebarHeaderElement = function() {
	return this.getRoot().find("#buildingcreator_planner_sidebar_wrapper .sidebar .sidebar_header_wrapper");
};

/**
 * @return {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getSidebarFloorsElement = function() {
	return this.getRoot().find(".sidebar[data-sidebar=floors]");
};

/**
 * @return {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getSidebarFloorsTableElement = function() {
	return this.getSidebarFloorsElement().find("table.floors");
};

/**
 * @return {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getSidebarFloorsButtonsElement = function() {
	return this.getSidebarFloorsElement().find(".floor_buttons");
};

/**
 * @return {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getSidebarFloorsFormElement = function() {
	return this.getSidebarFloorsElement().find("form#floors_form");
};

/**
 * @return {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getSidebarFloorsErrorElement = function() {
	return this.getSidebarFloorsElement().find("#floors_error");
};

/**
 * @return {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getSidebarFloorsErrorElement = function() {
	return this.getSidebarFloorsElement().find("#show_map");
};

// ... ... /SIDEBAR

// ... ... CANVAS

/**
 * @return {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getCanvasWrapperElement = function() {
	return this.getRoot().find("#buildingcreator_planner_content_canvas_wrapper");
};

/**
 * @return {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getCanvasContentElement = function() {
	return this.getCanvasWrapperElement().find("#buildingcreator_planner_content_canvas_content_wrapper");
};

/**
 * @return {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getCanvasLoaderElement = function() {
	return this.getCanvasWrapperElement().find("#buildingcreator_planner_content_canvas_loader_wrapper");
};

/**
 * @return {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getCanvasLoaderStatusElement = function() {
	return this.getCanvasLoaderElement().find("#buildingcreator_planner_content_canvas_loader_status_wrapper");
};

// ... ... /CANVAS

// ... ... KINETIC

/**
 * @returns {Kinetic.Layer}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getBuildingLayer = function() {
	return this.layers["building"];
};

// ... ... ... FLOOR

/**
 * @returns {Kinetic.Layer}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getFloorLayer = function(floorId) {
	return this.layers["floors"][floorId];
};

/**
 * @returns {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getFloorLayers = function() {
	return this.layers["floors"];
};

/**
 * @returns {Kinetic.Group}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getFloorGroup = function(floorId) {
	return this.groups["floors"][floorId];
};

/**
 * @returns {Kinetic.Group}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getFloorGroups = function() {
	return this.groups["floors"];
};

/**
 * @returns {Kinetic.Group}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getFloorPolygons = function(floorId) {
	return this.polygons["floors"][floorId];
};

/**
 * @returns {Kinetic.Layer}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getFloorMapLayer = function(floorId) {
	return this.layers["floors_map"][floorId];
};

/**
 * @returns {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getFloorMapLayers = function() {
	return this.layers["floors_map"];
};

/**
 * @returns {Kinetic.Group}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getFloorMapGroup = function(floorId) {
	return this.groups["floors_map"][floorId];
};

/**
 * @returns {Kinetic.Group}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getFloorMapGroups = function() {
	return this.groups["floors_map"];
};

// ... ... ... /FLOOR

// ... ... ... ELEMENT

/**
 * @returns {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getElementLayers = function() {
	return this.layers["elements"];
};

/**
 * @returns {Kinetic.Layer}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getElementLayer = function(floorId) {
	return this.layers["elements"][floorId];
};

/**
 * @returns {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getElementsGroups = function() {
	return this.groups["elements"];
};

/**
 * @returns {Kinetic.Group}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getElementGroup = function(floorId) {
	return this.groups["elements"][floorId];
};

/**
 * @returns {Kinetic.Group}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getElementPolygons = function(floorId) {
	return this.polygons["elements"][floorId];
};

// ... ... ... /ELEMENT

// ... ... /KINETIC

// ... ... TOOLTIP

/**
 * @returns {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getToolbarElement = function() {
	return this.getRoot().find("#buildingcreator_planner_content_toolbar_wrapper");
};

/**
 * @returns {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getToolbarPolygonElement = function() {
	return this.getToolbarElement().find("#polygon");
};

/**
 * @returns {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getToolbarLineTypeElement = function() {
	return this.getToolbarElement().find(".line_type");
};

/**
 * @returns {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getToolbarDeleteElement = function() {
	return this.getToolbarElement().find("#delete");
};

/**
 * @returns {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getToolbarToggleMapElement = function() {
	return this.getToolbarElement().find("#toggle_map");
};

/**
 * @returns {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getToolbarLayerFitElement = function() {
	return this.getToolbarElement().find("#layer_fit");
};

// ... ... /TOOLTIP

// ... ... MENU

/**
 * @returns {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getMenuElement = function() {
	return this.getRoot().find("#buildingcreator_menu_wrapper");
};

/**
 * @returns {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getMenuSubElement = function() {
	return this.getMenuElement().find("[data-menu]");
};

/**
 * @returns {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getMenuSaveElement = function() {
	return this.getMenuElement().find("#save");
};

// ... ... /MENU

// ... /GET

// ... SET

// ... ... KINETIC

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.setScale = function(scale) {
	this.scale = scale;
	this.getController().setLocalStorageVariable("scale", this.scale);
};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.setStagePosition = function(position) {
	this.stagePosition = position;
	this.getController().setLocalStorageVariable("stagePosition", position.x + "," + position.y);
};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.setBuildingLayer = function(layer) {
	this.layers["building"] = layer;
};

// ... ... ... FLOOR

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.setFloorLayer = function(floorId, layer) {
	this.layers["floors"][floorId] = layer;
};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.setFloorGroup = function(floorId, group) {
	this.groups["floors"][floorId] = group;
};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.setFloorPolygons = function(floorId, group) {
	this.polygons["floors"][floorId] = group;
};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.setFloorMapLayer = function(floorId, layer) {
	this.layers["floors_map"][floorId] = layer;
};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.setFloorMapGroup = function(floorId, group) {
	this.groups["floors_map"][floorId] = group;
};

// ... ... ... /FLOOR

// ... ... ... ELEMENT

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.setElementLayer = function(floorId, layer) {
	this.layers["elements"][floorId] = layer;
};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.setElementGroup = function(floorId, group) {
	this.groups["elements"][floorId] = group;
};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.setElementPolygons = function(floorId, group) {
	this.polygons["elements"][floorId] = group;
};

// ... ... ... /ELEMENT

// ... ... /KINETIC

// ... /SET

// ... DO

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.doBindEventHandler = function() {
	var context = this;

	// EVENTS

	// Retrieve event
	this.getView().getController().getEventHandler().registerListener(RetrieveEvent.TYPE,
	/**
	 * @param {RetrieveEvent}
	 *            event
	 */
	function(event) {
		context.handleRetrieve(event.getRetrieveType());
	});

	// Retrieved event
	this.getView().getController().getEventHandler().registerListener(RetrievedEvent.TYPE,
	/**
	 * @param {RetrievedEvent}
	 *            event
	 */
	function(event) {
		switch (event.getRetrievedType()) {
		case "building":
			context.handleBuildingRetrieved(event.getRetrieved());
			break;

		case "building_floors":
			context.handleFloorsRetrieved(event.getRetrieved());
			break;

		case "building_elements":
			context.handleElementsRetrieved(event.getRetrieved());
			break;
		}

		context.handleRetrieved(event.getRetrievedType());
	});

	// Handle "Scale" event
	this.getView().getController().getEventHandler().registerListener(ScaleEvent.TYPE, function(event) {
		context.handleScale(event);
	});

	// Handle "SelectEvent" event
	this.getView().getController().getEventHandler().registerListener(SelectEvent.TYPE,
	/**
	 * @param {SelectEvent}
	 *            event
	 */
	function(event) {
		context.handleSelect(event.getSelectType(), event.getElement());
	});

	// Handle "DeleteEvent" event
	this.getView().getController().getEventHandler().registerListener(DeleteEvent.TYPE,
	/**
	 * @param {DeleteEvent}
	 *            event
	 */
	function(event) {
		context.handleSelectedDelete();
	});

	// Handle "Edit" event
	this.getView().getController().getEventHandler().registerListener(EditEvent.TYPE,
	/**
	 * @param {DeleteEvent}
	 *            event
	 */
	function(event) {
		if (event.getEditType() == "floor") {
			context.getCanvasContentElement().hide();
			context.getCanvasLoaderStatusElement().text("Saving...");
			context.getCanvasLoaderElement().show();
		}
	});

	// Handle "Menu" event
	this.getView().getController().getEventHandler().registerListener(MenuEvent.TYPE,
	/**
	 * @param {MenuEvent}
	 *            event
	 */
	function(event) {
		context.handleMenu(event.getMenu(), event.getSidebar());
	});

	// /EVENTS

	// SIDEBAR

	this.getSidebarHeaderElement().click(function() {
		// Update hash
		context.getView().getController().updateHash({
			"sidebar" : $(this).parent().attr("data-sidebar")
		});
	});

	// ... FLOORS

	var floorsTable = this.getSidebarFloorsTableElement();
	var floorsTableRow = floorsTable.find("tbody.show tr.floor");
	var floorsButtons = this.getSidebarFloorsButtonsElement();

	// Edit Floor
	floorsTableRow.dblclick({
		table : floorsTable
	}, function(event) {
		context.doFloorsEdit(true);
	});

	// Cancel Floor edit
	floorsButtons.find("#floors_cancel").click(function(event) {
		if (!$(this).isDisabled()) {
			context.doFloorsEdit(false);
		}
	});

	// Apply Floor edit
	floorsButtons.find("#floors_apply").click(function(event) {
		if (!$(this).isDisabled()) {
			context.doFloorsSave();
		}
	});

	// Order Floor
	floorsTableRow.find(".order_edit .up, .order_edit .down").click(function(event) {
		context.doFloorsOrder($(this).closest(".floor"), $(this).hasClass("up"));
	});

	// Select Floor
	floorsTableRow.click(function(event) {
		// Get Floor id
		var floorId = $(this).attr("data-floor");

		// Update hash
		context.getView().getController().updateHash({
			"floor" : floorId
		});

		// Send Floor Building event
		// context.getView().getController().getEventHandler().handle(new
		// FloorBuildingEvent(floorId));
	});

	// ... /FLOORS

	// /SIDEBAR

	// BUILDINGCREATOR

	// Floor Building event
	this.getView().getController().getEventHandler().registerListener(FloorBuildingEvent.TYPE,
	/**
	 * @param {FloorBuildingEvent}
	 *            event
	 */
	function(event) {
		context.doFloorSelect(event.getFloorId());
	});

	// /BUILDINGCREATOR

	// CANVAS

	$(window).keydown(function(event) {
		// Bind ctrl
		if (event.which == 17) {
			context.doStageDraggable(true);
		}
		// Bind shift
		if (event.which == 16) {
			context.polygonsIsDraggable = true;
		}
	}).keyup(function(event) {
		// Bind ctrl
		if (event.which == 17) {
			context.doStageDraggable(false);
		}
		// Bind shift
		if (event.which == 16) {
			context.polygonsIsDraggable = false;
		}
	});

	this.getCanvasContentElement().bind("contextmenu", function(e) {
		return false;
	});

	// /CANVAS

	// MOUSE SCROLL

	// Get wrapper dom
	var canvasWrapper = document.getElementById("buildingcreator_planner_content_canvas_content_wrapper");

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

	// /MOUSE SCROLL

	// MENU

	this.getMenuSaveElement().click(function(event) {
		if (!$(this).isDisabled())
			context.doFloorCoordinatesSave();
	});

	this.getMenuSubElement().click(function(event) {
		if (!$(this).isDisabled()) {
			// Update hash
			context.getView().getController().updateHash({
				"menu" : $(this).attr("data-menu")
			});
		}
	});

	// /MENU

	// TOOLBAR

	this.getToolbarLayerFitElement().click(function(event) {
		if (!$(this).isDisabled())
			context.doFloorFitToScale();
	});

	this.getToolbarPolygonElement().click(function(event) {
		if (!$(this).isDisabled())
			context.doFloorPolygonDraw(null);
	});

	this.getToolbarLineTypeElement().click(function(event) {
		if (!$(this).isDisabled()) {
			if (context.selected && context.selected.type == "polygon_anchor")
				context.doFloorPolygonLineType(context.selected.element, $(this).attr("data-line"));
		}
	});

	this.getToolbarDeleteElement().click(function(event) {
		if (!$(this).isDisabled())
			context.handleSelectedDelete();
	});

	this.getToolbarToggleMapElement().click(function(event) {
		if (!$(this).isDisabled())
			context.doFloorMapToggle();
	});

	// /TOOLBAR

};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.doFloorsEdit = function(edit) {
	var floorsTable = this.getSidebarFloorsTableElement();
	var floorsButtons = this.getSidebarFloorsButtonsElement();
	var floorsError = this.getSidebarFloorsErrorElement();

	if (edit) {
		// Set floors table
		floorsTable.addClass("edit");

		// Floors buttons
		floorsButtons.enable();
	} else {
		// Set floors table
		floorsTable.removeClass("edit");

		// Floors buttons
		floorsButtons.disable();

		// Hide floors error
		floorsError.hide();
	}

};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.doFloorsOrder = function(row, up) {
	// Get floor order
	var orderInput = row.find(".order_edit input");
	var order = orderInput.val();

	// Get move row
	varMove = up ? row.prev() : row.next();

	// Move row
	if (varMove.length > 0) {
		var orderNewInput = varMove.find(".order_edit input");
		orderInput.val(orderNewInput.val());
		orderNewInput.val(order);
		if (up) {
			row.insertBefore(varMove);
		} else {
			row.insertAfter(varMove);
		}
	}

};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.doFloorsSave = function() {
	var floorsTable = this.getSidebarFloorsTableElement();
	var floorsForm = this.getSidebarFloorsFormElement();
	var floorsError = this.getSidebarFloorsErrorElement();

	// Hide floors error
	floorsError.hide();

	// For each floor
	var floor, floorName, floorMap, floorOrder, floorMain, error = "";
	floorsTable.find(".floor.edit, .floor.new").each(function(i, element) {
		floor = $(element);

		floorId = floor.attr("data-floor");
		floorName = floor.find(".name_edit input").val();
		floorMap = floor.find(".map_edit input").val();
		floorOrder = floor.find(".order_edit input").val();
		floorMain = floor.find(".main_edit input").is(":checked");

		if (floorId == "new" ? (floorMap && !floorName) : !floorName) {
			error = "Floor name must be given";
		} else if (floorId == "new" ? (floorName ? !floorMap : floorMap) : false) {
			error = "Floor map must be given to new floor";
		}
		if (error) {
			return false;
		}
	});

	if (error) {
		floorsError.text(error);
		floorsError.show();
	} else {
		floorsForm.submit();
	}
};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.doFloorSelect = function(floorId) {
	if (!floorId)
		return false;

	// Select toolbar Floor
	var floorRows = this.getSidebarFloorsTableElement().find("tbody.show tr");
	floorRows.removeClass("selected");
	floorRows.filter("[data-floor=" + floorId + "]").addClass("selected");

	// Show/hide Floors map
	var floorsMap = this.getFloorMapGroups();
	for (id in floorsMap) {
		if (id == floorId && this.floorMapShow) {
			floorsMap[id].show();
		} else {
			floorsMap[id].hide();
		}
	}
	
	// Show/hide Floors
	var floors = this.getFloorGroups();
	for (id in floors) {
		if (this.menu == "building" && id == floorId) {
			floors[id].show();
		} else {
			floors[id].hide();
		}
	}
	
	// Show/hide Elements
	var elements = this.getElementsGroups();
	for (id in elements) {
		if (this.menu == "elements" && id == floorId) {
			elements[id].show();
		} else {
			elements[id].hide();
		}
	}

	this.floorSelected = floorId;

	// Enable toolbar buttons
	this.getToolbarToggleMapElement().enable();
	this.getToolbarLayerFitElement().enable();

	// Re-draw stage
	this.stage.draw();

};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.doFloorMapToggle = function() {
	if (!this.floorSelected)
		return;

	var floorMap = this.getFloorMapGroup(this.floorSelected);

	if (!floorMap)
		return;

	this.floorMapShow = !this.floorMapShow;

	if (this.floorMapShow)
		floorMap.show();
	else
		floorMap.hide();

	floorMap.getLayer().draw();
};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.doStageDraggable = function(draggable) {
	this.stage.setDraggable(draggable);
	this.stageIsDragging = draggable;
	this.getCanvasContentElement().css("cursor", draggable ? "move" : "default");
};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.doScale = function(scaleUp) {
	var position = this.stage.getUserPosition();

	// Set scale
	this.scale += BuildingcreatorBuildingCmsCampusguidePageMainView.SCALE_SIZE * (scaleUp ? 1 : -1);
	this.setScale(Math.max(this.scale, 0));
	this.stage.setScale(this.scale);

	// Re-draw stage
	this.stage.draw();

};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.doFloorPolygonDraw = function(event) {
	if (!this.floorSelected)
		return;

	var polygons = this.getFloorPolygons(this.floorSelected);

	// Create polygon
	var polygon = new Polygon({}, this);
	polygons.add(polygon);

	// Create polygon with mouse
	polygon.createPolygon();
};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.doFloorPolygonLineType = function(polygonAnchor, type) {

	if (!polygonAnchor || !type) {
		return;
	}
	var oldType = polygonAnchor.type;
	switch (type) {
	case BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_STRAIGHT:
	case BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_QUAD:
	case BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_BEZIER:
		polygonAnchor.type = type;
		break;
	}

	if (polygonAnchor.type != oldType) {
		polygonAnchor.select();
		polygonAnchor.getLayer().draw();
	}

};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.doFloorCoordinatesSave = function() {

	if (!this.floorSelected)
		return false;

	var floorPolygons = this.getFloorPolygons(this.floorSelected).getChildren();

	var coordinates = [];
	for (i in floorPolygons) {
		coordinates.push(floorPolygons[i].toData());
	}

	var floor = this.floors[this.floorSelected];

	if (!floor)
		return;

	floor.coordinates = coordinates.join("$");

	this.getEventHandler().handle(new EditEvent("floor", floor));

};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.doFloorFitToScale = function() {

	if (!this.floorSelected)
		return false;

	var polygons = this.getFloorPolygons(this.floorSelected).getChildren();

	var scaleNew = 1.0;
	var positionNew = {
		x : 0,
		y : 0
	};

	if (polygons.length > 0) {

		var coordinates = [];
		for (i in polygons) {
			coordinates = coordinates.concat(polygons[i].getCoordinates());
		}

		var coordinatesMaxBounds = CanvasUtil.getMaxBounds(coordinates);
		var boundX = coordinatesMaxBounds[2] - coordinatesMaxBounds[0], boundY = coordinatesMaxBounds[3] - coordinatesMaxBounds[1];

		var stageX = this.stage.getWidth(), stageY = this.stage.getHeight();
		scaleNew = parseFloat((Math.floor(parseFloat(Math.min(stageX / boundX, stageY / boundY).toFixed(2)) * 20) / 20).toFixed(2));
		var boundsNewX = boundX * scaleNew, boundsNewY = boundY * scaleNew;

		positionNew.x = ((stageX - boundsNewX) / 2) - (coordinatesMaxBounds[0] * scaleNew);
		positionNew.y = ((stageY - boundsNewY) / 2) - (coordinatesMaxBounds[1] * scaleNew);

	} else {

		var layer = this.getFloorMapLayer(this.floorSelected);

		if (layer.height && layer.width) {
			var boundX = layer.width, boundY = layer.height;
			var stageX = this.stage.getWidth(), stageY = this.stage.getHeight();
			scaleNew = parseFloat((Math.floor(parseFloat(Math.min(stageX / boundX, stageY / boundY).toFixed(2)) * 20) / 20).toFixed(2));
			var boundsNewX = boundX * scaleNew, boundsNewY = boundY * scaleNew;

			positionNew.x = (stageX - boundsNewX) / 2;
			positionNew.y = (stageY - boundsNewY) / 2;
		}

	}

	this.setScale(scaleNew);
	this.setStagePosition(positionNew);
	this.stage.setScale(this.scale);
	this.stage.setX(this.stagePosition.x);
	this.stage.setY(this.stagePosition.y);
	this.stage.draw();

};

// ... /DO

// ... HANDLE

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.handleRetrieve = function(type) {
	switch (type) {
	case "building":
		this.getCanvasLoaderStatusElement().find(".loading_building").show();
		break;

	case "building_floors":
		this.getCanvasLoaderStatusElement().find(".loading_floors").show();
		break;

	case "building_elements":
		this.getCanvasLoaderStatusElement().find(".loading_elements").show();
		break;
	}
};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.handleRetrieved = function(type) {
	switch (type) {
	case "building":
		this.getCanvasLoaderStatusElement().find(".loading_building").hide();
		this.retrieved++;
		break;

	case "building_floors":
		this.getCanvasLoaderStatusElement().find(".loading_floors").hide();
		this.retrieved++;
		break;

	case "building_elements":
		this.getCanvasLoaderStatusElement().find(".loading_elements").hide();
		this.retrieved++;
		break;
	}

	if (this.retrieved == 3) {
		this.getCanvasLoaderElement().hide();
		this.getCanvasContentElement().show();
	}
};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.handleBuildingRetrieved = function(building) {

	// Set building
	this.building = building;

};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.handleFloorsRetrieved = function(floors) {
	this.floors = floors;

	// Draw Floors
	for (floorId in floors) {
		this.drawFloor(floors[floorId]);
	}

	// Select Floor
	var selectMainFloor = function(floors) {
		var floorMain = null;
		var i = 0;
		for (floorId in floors) {
			if (floors[floorId].main || i == 0) {
				floorMain = floors[floorId];
			}
			i++;
		}
		return floorMain;
	};

	var floorSelect = selectMainFloor(floors);
	this.doFloorSelect(floorSelect ? floorSelect.id : null);

};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.handleElementsRetrieved = function(elements) {
	this.elements = elements;
	console.log("Elements retrieved", elements);
	// Draw Elements
	for (elementId in elements) {
		this.drawElement(elements[elementId]);
	}
};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.handleScroll = function(event) {
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

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.handleScale = function(event) {

	// Do scale
	this.doScale(event.isScaleUp());

	// Send Scaled event
	this.getEventHandler().handle(new ScaledEvent(this.scale));

};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.handleSelect = function(type, element) {
	// De-select
	if (this.selected.element) {
		this.selected.element.deselect();
	}
	this.getToolbarLineTypeElement().disable();
	this.getToolbarDeleteElement().disable();

	if (!type || !element) {
		if (this.selected.element)
			this.selected.element.getLayer().draw();
		this.selected = {};
		return;
	}

	this.selected = {};

	if (!element.isVisible())
		return;

	this.selected = {
		type : type,
		element : element
	};

	this.selected.element.select();

	switch (type) {
	case "polygon_shape":
		this.getToolbarDeleteElement().enable();
		this.selected.element.getLayer().draw();
		break;

	case "polygon_anchor":
		this.getToolbarDeleteElement().enable();
		this.getToolbarLineTypeElement().enable();
		this.getToolbarLineTypeElement().filter("[data-line=" + element.type + "]").click();
		break;

	default:
		this.selected = {};
	}

};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.handleSelectedDelete = function() {

	if (!this.selected.element)
		return false;

	var selectedElement = this.selected.element;
	var layer = selectedElement.getLayer();

	// Deselect
	this.getEventHandler().handle(new SelectEvent());

	// Delete selected
	selectedElement.erase();

	layer.draw();

};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.handleMenu = function(menu, sidebar) {
	var submenuElements = this.getMenuSubElement();
	var sidebarElements = this.getSidebarElement();

	// MENU

	submenuElements.removeClass("highlight");

	switch (menu) {
	case "elements":
	case "navigation":
		submenuElements.filter("[data-menu=" + menu + "]").addClass("highlight");
		break;

	default:
		menu = "building";
		submenuElements.filter("[data-menu=building]").addClass("highlight");
		break;
	}
	this.menu = menu;

	// /MENU

	// SIDEBAR

	sidebarElements.hide();

	var sidebarMenuElements = sidebarElements.filter("[data-sidebar-group~=" + this.menu + "]");
	sidebarMenuElements.show();
	sidebarMenuElements.find(".sidebar_header_wrapper.collapse").addClass("collapsed");
	var sidebarElement = sidebarMenuElements.filter("[data-sidebar=" + sidebar + "]");
	if (sidebarElement.length == 0)
		sidebarElement = sidebarMenuElements.filter("[data-sidebar]:first-child");
	if (sidebarElement.length > 0) {
		sidebarElement.find(".sidebar_header_wrapper.collapse").removeClass("collapsed");
		this.sidebar = sidebarElement.attr("data-sidebar");
	} else {
		this.sidebar = null;
	}

	// /SIDEBAR

};

// ... /HANDLE

// ... DRAW

/**
 * @param {Element}
 *            root
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.draw = function(root) {
	PageMainView.prototype.draw.call(this, root);
	var context = this;

	// Set variables from local storage
	var scale = this.getController().getLocalStorageVariable("scale");
	if (scale)
		this.scale = parseFloat(scale);
	var stagePosition = this.getController().getLocalStorageVariable("stagePosition");
	if (stagePosition) {
		stagePosition = stagePosition.split(",");
		this.stagePosition = {
			x : parseFloat(stagePosition[0]),
			y : parseFloat(stagePosition[1])
		};
	}

	// Bind
	this.doBindEventHandler();

	// CANVAS

	// Initiate Kinetic Stage
	var canvas = this.getCanvasContentElement();
	this.stage = new Kinetic.Stage({
		"container" : canvas.attr("id"),
		"width" : canvas.parent().width(),
		"height" : canvas.parent().height(),
		clearBeforeDraw : true,
		scale : this.scale,
	});
	this.stage.setX(this.stagePosition.x);
	this.stage.setY(this.stagePosition.y);

	this.stage.on("click", function(event) {
		if (event.which == 3)
			context.getEventHandler().handle(new SelectEvent(null));
	});

	this.stage.on("dragend", function(event) {
		context.setStagePosition(this.getPosition());
	});

	// /CANVAS

	// Menu
	this.handleMenu(this.getView().getController().getHash().menu);

};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.drawFloor = function(floor) {

	// Draw Floor map
	this.drawFloorMap(floor);
	
	// Initiate layer
	var layer = new Kinetic.Layer({
		name : "floor_layer",
		id : floor.id
	});

	// Initiate group
	var group = new Kinetic.Group({
		name : "floor_group",
		id : floor.id,
		visible : false
	});

	// Create polygon group
	var groupPolygons = new Kinetic.Group({
		name : "polygons"
	});
	group.add(groupPolygons);
	groupPolygons.setZIndex(10);
	this.setFloorPolygons(floor.id, groupPolygons);

	// Create Floor polygon
	if (floor.coordinates) {
		for (i in floor.coordinates) {
			var polygon = new Polygon({}, this);
			polygon.fromData(floor.coordinates[i]);
			groupPolygons.add(polygon);
		}
	}

	// Set Floor layer
	this.setFloorLayer(floor.id, layer);

	// Set floor group
	this.setFloorGroup(floor.id, group);

	// Add group to layer
	layer.add(group);

	// Add layer to stage
	this.stage.add(layer);

};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.drawFloorMap = function(floor) {

	// Initiate layer
	var layer = new Kinetic.Layer({
		name : "floor_map_layer",
		id : floor.id
	});

	// Initiate group
	var group = new Kinetic.Group({
		name : "floor_map_group",
		id : floor.id,
		visible : false
	});

	// Create image object
	var imageObj = new Image();
	imageObj.onload = function() {

		// Create image
		var image = new Kinetic.Image({
			name : "map",
			x : 0,
			y : 0,
			image : imageObj,
			height : imageObj.height,
			width : imageObj.width
		});

		// Add image to group
		group.add(image);
		image.setZIndex(0);
		layer.height = imageObj.height;
		layer.width = imageObj.width,

		// Draw layer
		layer.draw();

	};
	imageObj.src = Core.sprintf("image/%s/building/floor/%s_%s.png", this.getMode(), floor.buildingId, floor.id);
	
	// Set Floor layer
	this.setFloorMapLayer(floor.id, layer);

	// Set floor group
	this.setFloorMapGroup(floor.id, group);

	// Add group to layer
	layer.add(group);

	// Add layer to stage
	this.stage.add(layer);
	
};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.drawElement = function(element) {

	// Initiate layer
	var layer = this.getElementLayer(element.floorId);

	if (!layer) {
		layer = new Kinetic.Layer({
			name : "element_layer",
			id : element.floorId
		});

		this.setElementLayer(element.floorId, layer);
		this.stage.add(layer);
	}

	// Initiate group
	var group = this.getElementGroup(element.floorId);

	if (!group) {
		group = new Kinetic.Group({
			name : "element_group",
			id : element.floorId,
			visible : false
		});

		this.setElementGroup(element.floorId, group);
		layer.add(group);
	}

	// Initiate polygons
	var polygons = this.getElementPolygons(element.floorId);

	if (!polygons) {
		polygons = new Kinetic.Group({
			name : "element_polygons",
			id : element.floorId,
		});

		this.setElementPolygons(element.floorId, polygons);
		group.add(polygons);
		polygons.setZIndex(10);
	}

	// Create polygon
	if (element.coordinates) {
		for (i in element.coordinates) {
			var polygon = new Polygon({}, this);
			polygon.element = element;
			polygon.fromData(element.coordinates[i]);
			polygons.add(polygon);
		}
	}

};


// ... /DRAW

// /FUNCTIONS
