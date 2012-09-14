// CONSTRUCTOR
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype = new PageMainView();

function BuildingcreatorBuildingCmsCampusguidePageMainView(view) {
	PageMainView.apply(this, arguments);
	this.stage = null;
	this.layers = {
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
	this.elements = {};
	this.floors = null;
	this.floorSelected = false;
	this.floorMapShow = true;
	this.stageIsDragging = false;
	this.polygonsIsDraggable = false;
	this.selected = {
		type : null,
		element : null
	};
	this.selectedCopy = this.selected;
	this.scale = 1.0;
	this.stagePosition = {
		x : 0,
		y : 0
	};
	this.menu = BuildingcreatorBuildingCmsCampusguidePageMainView.MENU_FLOORS;
	this.toolbar = null;
	this.retrieved = 0;
};

// /CONSTRUCTOR

// VARIABLES

BuildingcreatorBuildingCmsCampusguidePageMainView.SCALE_SIZE = 0.05;

BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_STRAIGHT = "straight";
BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_QUAD = "quad";
BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_BEZIER = "bezier";

BuildingcreatorBuildingCmsCampusguidePageMainView.MENU_FLOORS = "floors";
BuildingcreatorBuildingCmsCampusguidePageMainView.MENU_ELEMENTS = "elements";
BuildingcreatorBuildingCmsCampusguidePageMainView.MENU_NAVIGATION = "navigation";

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
				data.push(Core.roundNumber(this.anchor.control.handleFirst.attrs.x + this.anchor.polygon.attrs.x));
				data.push(Core.roundNumber(this.anchor.control.handleFirst.attrs.y + this.anchor.polygon.attrs.y));
				break;
			case BuildingcreatorBuildingCmsCampusguidePageMainView.LINE_TYPE_BEZIER:
				data.push(Core.roundNumber(this.anchor.control.handleFirst.attrs.x + this.anchor.polygon.attrs.x));
				data.push(Core.roundNumber(this.anchor.control.handleFirst.attrs.y + this.anchor.polygon.attrs.y));
				data.push(Core.roundNumber(this.anchor.control.handleSecond.attrs.x + this.anchor.polygon.attrs.x));
				data.push(Core.roundNumber(this.anchor.control.handleSecond.attrs.y + this.anchor.polygon.attrs.y));
				break;
			}

			return data.join("%");
		},
		fromData : function(data) {
			data = data || "";
			var dataArray = data.split("%");

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

			data.push(Core.roundNumber(this.attrs.x + this.polygon.attrs.x));
			data.push(Core.roundNumber(this.attrs.y + this.polygon.attrs.y));

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
			data = data || "";
			var dataArray = data.split(",");

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
						this.polygon.context.getEventHandler().handle(new SelectEvent("polygon", this.polygon));
					else if (event.which == 3 && this.isSelected)
						this.polygon.context.getEventHandler().handle(new DeleteEvent());
				}
			});
		}
	});

	Polygon = Kinetic.Group.extend({
		init : function(config, context) {
			config = config || {};
			this._super($.extend({
				name : "polygon"
			}, config));
			this.context = context;

			this.isSelected = false;
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
			this.deleted = false;
			this.object = {
				type : null,
				element : null
			};

			this.add(this.shape);
			this.add(this.anchors);
			this.add(this.controls);

			this.on("mouseover", function() {
				this.setDraggable(this.context.polygonsIsDraggable);
				if (this.context.polygonsIsDraggable && $("body").css("cursor") != "pointer")
					$("body").css("cursor", "pointer");
			});
			this.on("mouseout", function() {
				this.setDraggable(false);
				if ($("body").css("cursor") != "default")
					$("body").css("cursor", "default");
			});
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
			if (this.object.element) {
				this.hide();
				this.deleted = true;
			} else {
				this.getParent().remove(this);
				delete this;
			}
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
				x : ((positionUser.x - this.getStage().attrs.x) / this.getStage().attrs.scale.x) - this.attrs.x,
				y : ((positionUser.y - this.getStage().attrs.y) / this.getStage().attrs.scale.y) - this.attrs.y
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
			data = data || "";
			var dataAnchor = data.split("|"), anchor;
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
		},
		copy : function(context) {
			var data = this.toData();
			var polygon = new Polygon({}, context);
			polygon.fromData(data);
			return polygon;
		},
		select : function(secondary) {
			this.shape.setShadow({
				color : 'black',
				blur : 10,
				offset : [ 10, 10 ],
				alpha : 0.3
			});
			this.isSelected = true;
		},
		deselect : function() {
			this.shape.setShadow(null);
			this.isSelected = false;
		},
		erase : function() {
			this.deletePolygon();
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

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getMaximizeElement = function() {
	return this.getRoot().find("#maximize");
};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getElementPolygon = function(elementId, floorId) {
	var elementPolygons = this.getPolygons(BuildingcreatorBuildingCmsCampusguidePageMainView.MENU_ELEMENTS, floorId);

	if (!elementPolygons)
		return null;

	for (var i = 0; i < elementPolygons.children.length; i++) {
		if (elementPolygons.children[i].object.type == "element" && elementPolygons.children[i].object.element.id == elementId)
			return elementPolygons.children[i];
	}

	return null;
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

/**
 * @return {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getSidebarElementsElement = function() {
	return this.getSidebarElement().find(".sidebar[data-sidebar=elements]");
};

/**
 * @return {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getSidebarElementsFloorsElement = function() {
	return this.getSidebarElement().find("table.elements tbody[data-floor]");
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

/**
 * @returns {Kinetic.Layer}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getLayers = function(type) {
	return this.layers[type];
};

/**
 * @returns {Kinetic.Layer}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getLayer = function(type, floorId) {
	return this.layers[type][floorId];
};

/**
 * @returns {Kinetic.Group}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getGroups = function(type) {
	return this.groups[type];
};

/**
 * @returns {Kinetic.Group}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getGroup = function(type, floorId) {
	return this.groups[type][floorId];
};

/**
 * @returns {Kinetic.Group}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getPolygons = function(type, floorId) {
	return this.polygons[type][floorId];
};

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
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getToolbarCopyElement = function() {
	return this.getToolbarElement().find("#copy");
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

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.setLayer = function(type, floorId, layer) {
	this.layers[type][floorId] = layer;
};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.setGroup = function(type, floorId, group) {
	this.groups[type][floorId] = group;
};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.setPolygons = function(type, floorId, group) {
	this.polygons[type][floorId] = group;
};

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
	this.getEventHandler().registerListener(EditEvent.TYPE,
	/**
	 * @param {EditEvent}
	 *            event
	 */
	function(event) {
		if (event.getEditType() == "floor") {
			context.getCanvasContentElement().hide();
			context.getCanvasLoaderStatusElement().text("Saving...");
			context.getCanvasLoaderElement().show();
		}
	});
	
	// Handle "Edited" event
	this.getEventHandler().registerListener(EditedEvent.TYPE,
			/**
			 * @param {EditedEvent}
			 *            event
			 */
			function(event) {
		if (event.getEditType() == "element") {
			context.doElementSaved(event.getEdit());
		}
	});

	// Handle "Menu" event
	this.getEventHandler().registerListener(MenuEvent.TYPE,
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
	var floorsTableEditRow = floorsTable.find("tbody.edit tr.floor");
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
	floorsTableEditRow.find(".order_edit .up, .order_edit .down").click(function(event) {
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
	});

	// ... /FLOORS

	// ... ELEMENTS

	var elementsTableRows = this.getSidebarElementsFloorsElement().find("tr");

	// Select element
	elementsTableRows.click(function(event) {
		if (!this.polygon)
			this.polygon = context.getElementPolygon($(this).attr("data-element"), $(this).parent().attr("data-floor"));
		if (this.polygon)
			context.getEventHandler().handle(new SelectEvent("polygon", this.polygon));
	});

	// Edit element
	elementsTableRows.dblclick(function(event) {
		context.doElementEdit(true, $(this));
	});

	// Save/cancel element
	elementsTableRows.keyup(function(event) {
		// Save
		if (event.keyCode == 13) {
			context.doElementSave($(this));
			context.doElementEdit(false, $(this));
		}
		// Cancel
		if (event.keyCode == 27) {
			context.doElementEdit(false, $(this));
		}
	}).keydown(function(event){
		// Next Element
		if (event.which == 9) {
			context.doElementSave($(this));
			context.doElementEdit(false, $(this));			
			var next = $(this).next();
			if (next) {
				event.preventDefault();
				next.click();
				context.doElementEdit(true, next);
			}
		}
	}).focusout(function(event) {
		// Cancel
		context.doElementEdit(false, $(this));
	});

	// ... /ELEMENTS

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
			context.doSave();
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
			context.doFitToScale();
	});

	this.getToolbarPolygonElement().click(function(event) {
		if (!$(this).isDisabled())
			context.doPolygonDraw(null);
	});

	this.getToolbarLineTypeElement().click(function(event) {
		if (!$(this).isDisabled()) {
			if (context.selected && context.selected.type == "polygon_anchor")
				context.doFloorPolygonLineType(context.selected.element, $(this).attr("data-line"));
		}
	});

	this.getToolbarCopyElement().click(function(event) {
		if (!$(this).isDisabled())
			context.handleSelectedCopy();
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

	// Maxmize
	this.getMaximizeElement().click(function() {
		if (!$(this).isDisabled())
			context.doMaximize();
	});

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
	if (!floorId || !this.menu)
		return false;

	// Select toolbar Floor
	var floorRows = this.getSidebarFloorsTableElement().find("tbody.show tr");
	floorRows.removeClass("selected");
	floorRows.filter("[data-floor=" + floorId + "]").addClass("selected");

	// Select sidebar Elements
	this.getSidebarElementsFloorsElement().addClass("hide");
	this.getSidebarElementsFloorsElement().filter("[data-floor=" + floorId + "]").removeClass("hide");

	// Show/hide Floors map
	var floorsMap = this.getGroups("floors_map");
	for (id in floorsMap) {
		if (id == floorId && this.floorMapShow) {
			floorsMap[id].show();
		} else {
			floorsMap[id].hide();
		}
	}

	// Show/hide Floors
	var floors = this.getGroups(BuildingcreatorBuildingCmsCampusguidePageMainView.MENU_FLOORS);
	for (id in floors) {
		if (this.menu == BuildingcreatorBuildingCmsCampusguidePageMainView.MENU_FLOORS && id == floorId) {
			floors[id].show();
		} else {
			floors[id].hide();
		}
	}

	// Show/hide Elements
	var elements = this.getGroups(BuildingcreatorBuildingCmsCampusguidePageMainView.MENU_ELEMENTS);
	for (id in elements) {
		if (this.menu == BuildingcreatorBuildingCmsCampusguidePageMainView.MENU_ELEMENTS && id == floorId) {
			elements[id].show();
		} else {
			elements[id].hide();
		}
	}

	this.floorSelected = floorId;

	// Enable toolbar buttons
	this.getToolbarToggleMapElement().enable();
	this.getToolbarLayerFitElement().enable();

	// De-select
	this.getEventHandler().handle(new SelectEvent());

	// Re-draw stage
	this.stage.draw();

};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.doFloorMapToggle = function() {
	if (!this.floorSelected)
		return;

	var floorMap = this.getGroup("floors_map", this.floorSelected);

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

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.doPolygonDraw = function(event) {
	if (!this.floorSelected || !this.menu)
		return;

	var polygons = this.getPolygons(this.menu, this.floorSelected);
	if (!polygons)
		return;

	// Create polygon
	var polygon = new Polygon({}, this);
	polygons.add(polygon);

	// Create polygon with mouse
	polygon.createPolygon();

	polygon.getLayer().draw();
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

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.doSave = function() {
	this.getEventHandler().handle(new EditEvent("building", this.polygons));
};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.doFitToScale = function() {
	if (!this.floorSelected)
		return false;

	var polygons = this.getPolygons(this.menu, this.floorSelected).getChildren();

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

	this.setScale(scaleNew);
	this.setStagePosition(positionNew);
	this.stage.setScale(this.scale);
	this.stage.setX(this.stagePosition.x);
	this.stage.setY(this.stagePosition.y);
	this.stage.draw();

};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.doMaximize = function() {
	var maxmized = !this.getRoot().hasClass("maximized");

	var canvas = this.getCanvasContentElement();
	if (maxmized) {
		this.getController().setLocalStorageVariable("maximized", "true");

		var widthMax = Math.round($(document).width() - 75);
		var widthMaxCanvas = Math.round($(document).width() - this.getSidebarElement().width() - 75);
		var heightMax = Math.round($(document).height() - this.getRoot().position().top);

		this.getRoot().css("width", widthMax);
		canvas.parent().css("width", widthMaxCanvas).css("height", heightMax);
		this.stage.resize();

		$(window).scrollTop(this.getRoot().position().top);
	} else {
		this.getController().removeLocalStorageVariable("scale");

		this.getRoot().css("width", "");
		canvas.parent().css("width", "").css("height", "");
		this.stage.resize();
	}

	if (maxmized)
		this.getRoot().addClass("maximized");
	else
		this.getRoot().removeClass("maximized");
};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.doElementEdit = function(edit, element) {
	if (!element)
		return;
	
	if (edit)
	{
		element.find(".show").addClass("hide");
		element.find(".edit").removeClass("hide").find("input").select();
	}
	else
	{
		element.find(".show").removeClass("hide");
		element.find(".edit").addClass("hide");
		var input = element.find(".edit input");
		if (input)
			input.val(input.attr("data-value") || "");
	}
};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.doElementSave = function(elementElement) {
	var elementId = elementElement.attr("data-element");
	var input = elementElement.find(".edit input");
	
	if (!input)
		return;
	
	if (input.val() == (input.attr("data-value") || ""))
		return;
	
	var element = this.elements[elementId];	
	if (!element)
		return;
	
	this.getEventHandler().handle(new EditEvent("element", { id : elementId, name : input.val() }));
};


BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.doElementSaved = function(element) {
	if (!element)
		return;
	
	var elementElement = this.getSidebarElementsFloorsElement().find(".element[data-element=" + element.id + "]");
	elementElement.find(".name.show").text(element.name);
	elementElement.find(".name.edit input").attr("data-name", element.name).val(element.name);
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

		// Select Floor
		var selectMainFloor = function(floors) {
			var floorMain = null;
			var i = 0;
			for (floorId in floors) {
				if (floors[floorId].main || i == 0)
					floorMain = floorId;
				i++;
			}
			return floorMain;
		};

		var floorSelect = this.floorSelected ? this.floorSelected : selectMainFloor(this.floors);
		this.doFloorSelect(floorSelect);
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
};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.handleElementsRetrieved = function(elements) {
	this.elements = elements;

	// Draw Elements
	for (elementId in elements) {
		if (!elements[elementId].deleted)
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
	this.getToolbarCopyElement().disable();
	this.getSidebarElementsFloorsElement().find("[data-element]").removeClass("selected");

	if (!type || !element) {
		if (this.selected.element)
			this.selected.element.getLayer().draw();
		this.selected = {};

		if (this.selectedCopy.element)
			this.getToolbarCopyElement().enable();
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
	case "polygon":
		this.getToolbarDeleteElement().enable();
		this.getToolbarCopyElement().enable();
		this.selected.element.getLayer().draw();
		
		if (element.object.type == "element" && element.object.element) {
			this.getSidebarElementsFloorsElement().find("[data-element=" + element.object.element.id + "]").addClass("selected");
		}
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

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.handleSelectedCopy = function() {

	// COPY

	if (this.selected.element) {
		if (this.selected.type != "polygon")
			return;

		this.selectedCopy = this.selected;
	}

	// /COPY

	// PASTE

	if (!this.selected.element) {
		if (this.selectedCopy.type != "polygon")
			return;

		var polygons = this.getPolygons(this.menu, this.floorSelected);
		if (polygons) {
			var polygon = this.selectedCopy.element.polygon.copy(this);
			polygons.add(polygon);
			if (this.selectedCopy.element.getLayer()._id == polygons.getLayer()._id)
				polygon.move(20, 20);
			polygon.getLayer().draw();
		}

	}

	// /PASTE

};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.handleSelectedDelete = function() {
	if (!this.selected.element)
		return false;

	var selected = this.selected;
	var layer = selected.element.getLayer();

	// Deselect
	this.getEventHandler().handle(new SelectEvent());

	// Delete selected
	selected.element.erase();

	layer.draw();
	
	// Delete Element from sidebar
	if (selected.type == "polygon" && selected.element.object.type == "element" && selected.element.object.element)
		this.getSidebarElementsFloorsElement().find(".element[data-element=" + selected.element.object.element.id + "]").remove();
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
		menu = "floors";
		submenuElements.filter("[data-menu=floors]").addClass("highlight");
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

	this.doFloorSelect(this.floorSelected);

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
		scale : this.scale
	});
	this.stage.setX(this.stagePosition.x);
	this.stage.setY(this.stagePosition.y);
	this.stage.resize = function() {
		this.setSize(canvas.parent().width(), canvas.parent().height());
		this.draw();
	};

	this.stage.on("click", function(event) {
		if (event.which == 3)
			context.getEventHandler().handle(new SelectEvent(null));
	});

	this.stage.on("dragend", function(event) {
		context.setStagePosition(this.getPosition());
	});

	// /CANVAS

	// Menu
	this.handleMenu(this.getController().getHash().menu);

	// Maxmimize
	if (this.getController().getLocalStorageVariable("maxmized")) {
		setTimeout(function() {
			context.getMaximizeElement().click();
		}, 200); // Because of the GUI i had to add an delay
	}

};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.drawFloor = function(floor) {
	var context = this;

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
		layer.width = imageObj.width;

		// Draw Floor layer
		context.drawFloorLayer(floor, layer.width, layer.height);

		// Draw layer
		layer.draw();

	};
	imageObj.src = Core.sprintf("image/%s/building/floor/%s_%s.png", this.getMode(), floor.buildingId, floor.id);

	// Set Floor layer
	this.setLayer("floors_map", floor.id, layer);

	// Set floor group
	this.setGroup("floors_map", floor.id, group);

	// Add group to layer
	layer.add(group);

	// Add layer to stage
	this.stage.add(layer);

};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.drawFloorLayer = function(floor, width, height) {

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

	// Create fill
	var fill = new Kinetic.Rect({
		name : "floor_fill",
		x : 0,
		y : 0,
		width : width,
		height : height,
		stroke : "#CCC",
		strokeWidth : 2,
	});
	group.add(fill);
	fill.setZIndex(5);

	// Create polygon group
	var polygons = new Kinetic.Group({
		name : "floor_polygons"
	});
	group.add(polygons);
	polygons.setZIndex(10);
	this.setPolygons(BuildingcreatorBuildingCmsCampusguidePageMainView.MENU_FLOORS, floor.id, polygons);

	// Create Floor polygon
	if (floor.coordinates) {
		var coordinates = floor.coordinates.split("$");
		for (i in coordinates) {
			var polygon = new Polygon({}, this);
			polygon.fromData(coordinates[i]);
			polygons.add(polygon);
		}
	}

	// Set Floor layer
	this.setLayer(BuildingcreatorBuildingCmsCampusguidePageMainView.MENU_FLOORS, floor.id, layer);

	// Set floor group
	this.setGroup(BuildingcreatorBuildingCmsCampusguidePageMainView.MENU_FLOORS, floor.id, group);

	// Add group to layer
	layer.add(group);

	// Add layer to stage
	this.stage.add(layer);

	// Draw Floor Element
	this.drawFloorElement(floor, width, height);

};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.drawFloorElement = function(floor, width, height) {

	// Initiate layer
	var layer = new Kinetic.Layer({
		name : "element_layer",
		id : floor.id
	});

	this.setLayer(BuildingcreatorBuildingCmsCampusguidePageMainView.MENU_ELEMENTS, floor.id, layer);
	this.stage.add(layer);

	// Initiate group
	var group = new Kinetic.Group({
		name : "element_group",
		id : floor.id,
		visible : false
	});

	this.setGroup(BuildingcreatorBuildingCmsCampusguidePageMainView.MENU_ELEMENTS, floor.id, group);
	layer.add(group);

	// Create fill
	var fill = new Kinetic.Rect({
		name : "floor_fill",
		x : 0,
		y : 0,
		width : width,
		height : height,
		stroke : "#CCC",
		strokeWidth : 2
	});
	group.add(fill);
	fill.setZIndex(5);

	// Initiate polygons
	var polygons = new Kinetic.Group({
		name : "element_polygons",
		id : floor.id,
	});

	this.setPolygons(BuildingcreatorBuildingCmsCampusguidePageMainView.MENU_ELEMENTS, floor.id, polygons);
	group.add(polygons);
	polygons.setZIndex(10);

};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.drawElement = function(element) {
	var polygons = this.getPolygons(BuildingcreatorBuildingCmsCampusguidePageMainView.MENU_ELEMENTS, element.floorId);

	// TODO Add these elements to an unnamed floor?
	if (!polygons)
		return;

	// Create polygon
	if (element.coordinates) {
		var coordinates = element.coordinates.split("$");
		for (i in coordinates) {
			var polygon = new Polygon({}, this);
			polygon.object = {
				type : "element",
				element : element
			};
			polygon.fromData(coordinates[i]);
			polygons.add(polygon);
		}
	}

};

// ... /DRAW

// /FUNCTIONS
